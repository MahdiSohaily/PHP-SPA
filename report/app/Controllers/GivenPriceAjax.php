<?php
session_start();
require_once('../../database/connect.php');
if (isset($_POST['store_price'])) {
    $partnumber = $_POST['partNumber'];
    $price = $_POST['price'];
    $customer_id = $_POST['customer_id'];
    $notification_id = $_POST['notification_id'];
    store($conn, $partnumber, $price, $customer_id, $notification_id);

    $sql = "SELECT id, partnumber FROM yadakshop1402.nisha WHERE partnumber = '$partnumber'";
    $result = mysqli_query($conn, $sql);
    $good = $result->fetch_assoc();

    $relation_exist = isInRelation($conn, $good['id']);

    $givenPrice = givenPrice($conn, $partnumber, $relation_exist);

    if ($givenPrice !== null) {
        foreach ($givenPrice as $price) {
            if ($price['price'] !== null && $price['price'] !== '') {
                if (array_key_exists("ordered", $price) || $price['customerID'] == 1) { ?>
                    <tr class="min-w-full mb-1  bg-red-400 hover:cursor-pointer" onclick="setPrice(this)" data-price="<?php echo $price['price'] ?>" data-part="<?php echo $partNumber ?>">
                    <?php } else { ?>
                    <tr class="min-w-full mb-1  bg-indigo-200 ?>" data-price="<?php echo $price['price'] ?>">
                    <?php  } ?>
                    <td scope="col" class="text-gray-800 px-2 py-1 <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                        <?php echo $price['price'] === null ? 'ندارد' : $price['price']  ?>
                    </td>
                    <td scope="col" class="text-gray-800 px-2 py-1 rtl <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                        <?php if (array_key_exists("ordered", $price)) {
                            echo 'قیمت دستوری';
                        } else {
                            echo $price['name'] . ' ' . $price['family'];
                        }
                        ?>
                    </td>
                    <td scope="col" class="text-gray-800 px-2 py-1 rtl <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                        <?php if (!array_key_exists("ordered", $price)) {
                        ?>
                            <img class="userImage" src="../../userimg/<?php echo $price['userID'] ?>.jpg" alt="userimage">
                        <?php
                        }
                        ?>
                    </td>
                    </tr>
                    <tr class="min-w-full mb-1 border-b-2 <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'bg-red-500' : 'bg-indigo-300' ?>" data-price='<?php echo $price['price'] ?>'>
                        <td></td>
                        <td class="<?php echo array_key_exists("ordered", $price) ? 'text-white' : '' ?> text-gray-800 px-2 tiny-text" colspan="2" scope="col">
                            <div class="rtl flex items-center w-full <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : 'text-gray-800' ?>">
                                <i class="px-1 material-icons tiny-text <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : 'text-gray-800' ?>">access_time</i>
                                <?php
                                $create = date($price['created_at']);


                                $now = new DateTime(); // current date time
                                $date_time = new DateTime($create); // date time from string
                                $interval = $now->diff($date_time); // difference between two date times
                                $days = $interval->format('%a'); // difference in days
                                $hours = $interval->format('%h'); // difference in hours
                                $minutes = $interval->format('%i'); // difference in minutes
                                $seconds = $interval->format('%s'); // difference in seconds

                                $text = '';

                                if ($days) {
                                    $text .= " $days روز و ";
                                }

                                if ($hours) {
                                    $text .= "$hours ساعت ";
                                }

                                if ($minutes) {
                                    $text .= "$minutes دقیقه ";
                                }

                                if ($seconds) {
                                    $text .= "$seconds ثانیه ";
                                }

                                echo "$text قبل";
                                ?>
                            </div>
                        </td>
                    </tr>
            <?php }
        } ?>
        <?php } else { ?>
            <tr class="min-w-full mb-4 border-b-2 border-white">
                <td colspan="3" scope="col" class="text-gray-800 py-2 text-center bg-indigo-300">
                    !! موردی برای نمایش وجود ندارد
                </td>
            </tr>
        <?php } ?>
    <?php

}
function isInRelation($conn, $id)
{
    $sql = "SELECT pattern_id FROM similars WHERE nisha_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            return $item['pattern_id'];
        }
    }
    return false;
}

function givenPrice($conn, $code, $relation_exist = null)
{
    $code = strtolower($code);
    $ordared_price = [];


    if ($relation_exist) {
        $out_sql = "SELECT patterns.price, patterns.created_at FROM patterns WHERE id = '" . $relation_exist . "'";
        $out_result = mysqli_query($conn, $out_sql);

        if (mysqli_num_rows($out_result) > 0) {
            $ordared_price = mysqli_fetch_assoc($out_result);
        }
        $ordared_price['ordered'] = true;
    }

    $sql = "SELECT prices.price, prices.partnumber, customer.name, customer.id AS customerID, customer.family ,users.id as userID, prices.created_at
    FROM ((prices 
    INNER JOIN callcenter.customer ON customer.id = prices.customer_id )
    INNER JOIN yadakshop1402.users ON users.id = prices.user_id)
    WHERE partnumber LIKE '" . $code . "' ORDER BY created_at DESC LIMIT 7";
    $result = mysqli_query($conn, $sql);


    $givenPrices = [];
    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            array_push($givenPrices, $item);
        }
    }

    $unsortedData = [];
    foreach ($givenPrices as $item) {
        array_push($unsortedData, $item);
    }

    array_push($unsortedData, $ordared_price);

    if ($relation_exist) {
        usort($unsortedData, function ($a, $b) {
            return $a['created_at'] < $b['created_at'];
        });
    }
    $final_data = $relation_exist ? $unsortedData : $givenPrices;

    return  $final_data;
}



if (isset($_POST['askPrice'])) {
    $partnumber = $_POST['partNumber'];
    $customer_id = $_POST['customer_id'];
    $user_id = $_POST['user_id'];
    date_default_timezone_set("Asia/Tehran");
    $created_at = date("Y-m-d H:i:s");

    askPrice($conn, $partnumber, $customer_id, $user_id, $created_at);
}

function store($conn, $partnumber, $price, $customer_id, $notification_id)
{
    date_default_timezone_set("Asia/Tehran");
    $created_at = date("Y-m-d H:i:s");
    $pattern_sql = "INSERT INTO prices (partnumber, price, user_id, customer_id, created_at, updated_at)
            VALUES ('" . $partnumber . "', '" . $price . "','" . $_SESSION["id"] . "' ,'" . $customer_id . "', '" . $created_at . "', '" . $created_at . "')";
    $conn->query($pattern_sql);
    if ($notification_id) {
        $sql = "UPDATE ask_price SET status= 'done' , notify = 'received', price = '$price' WHERE id = '$notification_id'";
        $conn->query($sql);
    }
}


function askPrice($conn, $partnumber, $customer_id, $user_id, $created_at)
{
    $pattern_sql = "INSERT INTO ask_price (customer_id, user_id, code, status, notify, created_at)
            VALUES ('" . $customer_id . "', '" . $user_id . "', '" . $partnumber . "', 'pending', 'send' , '" . $created_at . "')";

    if ($conn->query($pattern_sql) === TRUE) {
        echo 'true';
    }
}
