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
