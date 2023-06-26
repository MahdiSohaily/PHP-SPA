<?php
session_start();
require_once('../../database/connect.php');
if (isset($_POST['check_notification'])) {

    $user_id = $_SESSION['user_id'];

    echo index($conn, $user_id);
}

function index($conn, $id)
{
    $similar_sql = "SELECT roll FROM yadakshop1402.users WHERE id = ' $id' ";

    $similar = mysqli_query($conn, $similar_sql);

    if ($similar->num_rows > 0) {
        $data = mysqli_fetch_array($similar);
    }


    $adminNotification = [];
    if ($data['roll'] == 1) {
        $similar_sql = "SELECT * FROM ask_price WHERE status = 'pending' ";
        $similar = mysqli_query($conn, $similar_sql);
        if ($similar->num_rows > 0) {
            while ($row = mysqli_fetch_array($similar)) {
                array_push($adminNotification, $row);
            }
        }
    }

    $hasNotification = [];

    $similar_sql = "SELECT * FROM ask_price WHERE user_id = '" . $id . "'  AND notify='received'";
    $similar = mysqli_query($conn, $similar_sql);
    if ($similar->num_rows > 0) {
        while ($row = mysqli_fetch_array($similar)) {
            array_push($hasNotification, $row);
        }
    }

    return count([...$hasNotification, ...$adminNotification]);
}


if (isset($_POST['weDontHave'])) {

    $id = $_SESSION['id'];
    $code = $_SESSION['code'];
    $customer = $_SESSION['customer'];

    echo clearNotification($conn, $id, $code, $customer);
}

function clearNotification($conn, $id, $code, $customer)
{

    if ($id) {
        DB::table('ask_price')
            ->where('id', $id)
            ->update(['status' => 'done', 'notify' => 'received', 'price' => 'نداریم']);
    }

    if ($customer) {
        $created_at = date("Y-m-d H:i:s");
        $pattern_sql = "INSERT INTO prices (partnumber, price, customer_id, created_at, updated_at)
            VALUES ('" . $code . "', 'نداریم', '" .  $customer . "','" . $created_at . "','" . $created_at . "')";

        if ($conn->query($pattern_sql) === TRUE) {
            echo 'true';
        }
    }
}
