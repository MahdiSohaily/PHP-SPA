<?php
require_once('../../database/connect.php');
if (isset($_POST['store_price'])) {
    $partnumber = $_POST['partNumber'];
    $price = $_POST['price'];
    $customer_id = $_POST['customer_id'];
    store($conn, $partnumber, $price, $customer_id);
}

function store($conn, $partnumber, $price, $customer_id)
{
    date_default_timezone_set("Asia/Tehran");
    $created_at = date("Y-m-d H:i:s");
    $pattern_sql = "INSERT INTO prices (partnumber, price, customer_id, created_at, updated_at)
            VALUES ('" . $partnumber . "', '" . $price . "', '" . $customer_id . "', '" . $created_at . "', '" . $created_at . "')";

    if ($conn->query($pattern_sql) === TRUE) {
        echo 'true';
    }
}
