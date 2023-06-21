<?php
require_once('../../database/connect.php');
if (isset($_POST['search_goods_for_relation'])) {
    $pattern = $_POST['pattern'];
    $sql = "SELECT * FROM yadakshop1402.nisha WHERE partnumber LIKE '" . $pattern . "%'";
    $result = mysqli_query($conn, $sql);

    $searched_ids = [];
    $nisha = [];

    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            array_push($searched_ids, $item['id']);
            array_push($nisha, $item);
        }
        $similar_sql = "SELECT nisha_id, pattern_id FROM similars WHERE nisha_id IN (" . implode(',', $searched_ids) . ")";

        $similar = mysqli_query($conn, $similar_sql);

        $similar_ids = [];

        if (mysqli_num_rows($similar) > 0) {
            while ($item = mysqli_fetch_assoc($similar)) {
                array_push($similar_ids, ['pattern_id' => $item['pattern_id'], 'nisha_id' => $item['nisha_id']]);
            }
        }

        $final_result = [];

        foreach ($nisha as $key => $value) {
            $id = $value['id'];

            $get_nisha = null;

            foreach ($similar_ids as $item) {
                if ($item['nisha_id'] == $id) {
                    $get_nisha = $item['pattern_id'];
                }
            }
            array_push($final_result, ['id' => $id, 'partNumber' => $value['partnumber'], 'pattern' => $get_nisha]);
        }




        if (count($final_result) > 0) {
            foreach ($final_result as $item) {
                if ($item['pattern']) {
?>
                    <div class="w-full flex justify-between items-center shadow-md hover:shadow-lg 
                rounded-md px-4 py-3 mb-2 border-1 border-gray-300" id="search-<?php echo  $item['id'] ?>">
                        <p class=' text-sm font-semibold text-gray-600'><?php echo $item['partNumber'] ?></p>
                        <i data-id="<?php echo $item['id'] ?>" data-pattern="<?php echo $item['pattern'] ?>" data-partNumber="<?php echo $item['partNumber'] ?>" class=' load_element material-icons add text-blue-600 cursor-pointer rounded-circle hover:bg-gray-200'>cloud_download
                        </i>
                    </div>
                <?php
                } else {
                ?>
                    <div class='w-full flex justify-between items-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300' id="search-<?php echo $item['id'] ?>">
                        <p class=' text-sm font-semibold text-gray-600'><?php echo $item['partNumber'] ?></p>
                        <i data-id="<?php echo $item['id'] ?>" data-partNumber="<?php echo $item['partNumber'] ?>" class="add_element material-icons add text-green-600 cursor-pointer rounded-circle hover:bg-gray-200" onclick="add(this)">add_circle_outline
                        </i>
                    </div>
                <?php
                }
                ?>
        <?php }
        }
    } else {
        ?>
        <div class='w-full text-center shadow-md hover:shadow-lg rounded-md px-4 py-3 mb-2 border-1 border-gray-300''>
                <i class=' material-icons text-red-500'>error</i>
            <br />
            <p class='text-sm font-semibold text-gray-600 text-red-500'>کد وارد شده در سیستم موجود نمی باشد</p>
        </div>
<?php

    }
}

if (isset($_POST['store_relation'])) {

    $relation_name = $_POST['relation_name'];
    $price = $_POST['price'];
    $cars = json_decode($_POST['cars']);
    $status = $_POST['status'];
    $mode = $_POST['mode'];
    $pattern_id = $_POST['pattern_id'];
    $selected_goods = json_decode($_POST['selected_goods']);
    $serial = $_POST['serial'];

    $selected_index = extract_id($selected_goods);

    try {
        $selectedCars = $cars;
        $created_at = time();
        // create the pattern record
        $pattern_sql = "INSERT INTO patterns (name, price, serial, status_id, created_at)
        VALUES ('" . $relation_name . "', '" . $price . "', '" . $serial . "', '" . $status . "', '" . $created_at . "')";

        if ($conn->query($pattern_sql) === TRUE) {
            $last_id = $conn->insert_id;

            foreach ($selected_index as $value) {
                $similar_sql = "INSERT INTO similars (pattern_id, nisha_id) VALUES ('" . $last_id . "', '" . $value . "')";
                $conn->query($similar_sql);
            }

            foreach ($selectedCars as $car) {
                $car_sql = "INSERT INTO patterncars (pattern_id, car_id) VALUES ('" . $last_id . "', '" . $car . "')";
                $conn->query($car_sql);
            }
        } else {
            $errors = "ذخیره سازی اطلاعات ناموفق بود";
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

function extract_id($array)
{
    $selected_index = [];
    foreach ($array as $value) {
        array_push($selected_index, $value->id);
    }
    $selected_index = array_unique($selected_index);
    return $selected_index;
}

function toBeAdded($existing, $newComer)
{
    $result = [];
    foreach ($newComer as $item) {
        if (!in_array($item, $existing)) {
            array_push($result, $item);
        }
    }
    return $result;
}
function toBeDeleted($existing, $newComer)
{
    $result = [];
    foreach ($existing as $item) {
        if (!in_array($item, $newComer)) {
            array_push($result, $item);
        }
    }
    return $result;
}