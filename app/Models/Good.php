<?php

namespace App\Models;

class Good
{
    public function search($pattern)
    {

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM nisha WHERE partnumber LIKE '" . $pattern . "%'";
        $result = $conn->query($sql);


        $pattern = "SELECT id FROM patterns WHERE serial LIKE '" . $pattern . "%'";
        $pattern_result = $conn->query($pattern);
        $pattern_ids = [];

        if ($pattern_result->num_rows > 0) {
            while ($row = $pattern_result->fetch_assoc()) {
                array_push($pattern_ids, $row['id']);
            }
        }

        $similar = "SELECT nisha_id, pattern_id FROM similars WHERE pattern_id IN (1,2)";
        $similar_result = $conn->query($similar);
        $similar_ids = [];

        if ($similar_result->num_rows > 0) {
            while ($row = $similar_result->fetch_assoc()) {
                array_push($similar_ids, ['nisha_id' => $row['nisha_id'], 'pattern_id' => $row['pattern_id']]);
            }
        }

        $template = '';

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $partnumber = $row['partnumber'];
                $price = $row['price'];
                $mobis = $row['mobis'];

                $get_nisha = null;

                foreach ($similar_ids as $item) {
                    if ($item['nisha_id'] == $id) {
                        $get_nisha = $item['pattern_id'];
                    }
                }

                if ($get_nisha) {
                    $template .= "<div class='matched-item' id='$id'>
                    <i onclick='load(event,$get_nisha)'  
                    data-id='" . $id . "'  
                    class='material-icons load'>filter_drama</i>
                    <p>$partnumber</p>
                </div>";
                } else {
                    $template .= "<div class='matched-item' id='$id'>
                    <i onclick='add(event)'  
                    data-id='" . $id . "' 
                    data-partnumber='" . $partnumber . "' 
                    data-price='" . $price . "' 
                    data-mobis='" . $mobis . "' 
                    class='material-icons add'>add_circle_outline</i>
                    <p>$partnumber</p>
                </div>";
                }
            }
        } else {
            $template = "<div class='matched-item'> <p>کد مشابه برای الگوی وارد شده دریافت نشد.</p> </div>";
        }
        $conn->close();
        return $template;
    }

    public function load($pattern)
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT pattern_id  FROM similars WHERE nisha_id  = '" . $pattern . "%'";
        $result = $conn->query($sql)->fetch_assoc();
        $pattern_id = $result['pattern_id'];

        $all_similars = "SELECT nisha_id FROM similars WHERE pattern_id = '" . $pattern_id . "%'";
        $similars_result = $conn->query($all_similars);

        $template = [];

        if ($similars_result->num_rows > 0) {
            while ($row = $similars_result->fetch_assoc()) {
                $item_id = $row['nisha_id'];

                $good_sql = "SELECT * FROM nisha WHERE id = '" . $item_id . "%'";
                $good_result = $conn->query($good_sql)->fetch_assoc();

                array_push($template, ['id' => $good_result['id'], 'partnumber' => $good_result['partnumber']]);
            }
        }

        $conn->close();
        return $template;
    }

    public function description($pattern)
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "SELECT pattern_id  FROM similars WHERE nisha_id  = '" . $pattern . "%'";
        $result = $conn->query($sql)->fetch_assoc();
        $pattern_id = $result['pattern_id'];

        $patter_sql = "SELECT patterns.*, cars.id as car, status.id as status
        FROM (( patterns
        INNER JOIN cars ON patterns.car_id  = cars.id)
        INNER JOIN status ON patterns.status_id = status.id)
        WHERE patterns.id = '" . $pattern_id . "'";
        $pattern_result = $conn->query($patter_sql)->fetch_assoc();

        return $pattern_result;
    }

    public function create($data) {

    }
}
