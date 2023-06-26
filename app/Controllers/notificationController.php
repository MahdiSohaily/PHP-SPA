<?php

require_once './database/connect.php';
$notifications = getNotification($conn, $_SESSION['user_id']);

print_r(json_encode($notifications));

function getNotification($conn, $id)
{

    $similar_sql = "SELECT roll, name FROM yadakshop1402.users WHERE id = ' $id' ";

    $similar = mysqli_query($conn, $similar_sql);

    if ($similar->num_rows > 0) {
        $data = mysqli_fetch_array($similar);
    }

    $adminNotification = [];

    if ($data['name'] === 'نیایش') {
        $sql = "SELECT ask_price.*, users.id AS user_id, customer.id AS customer_id, customer.name AS customer_name, users.name AS user_name 
        FROM ((ask_price 
        INNER JOIN yadakshop1402.users ON users.id = ask_price.user_id)
        INNER JOIN callcenter.customer ON customer.id = ask_price.customer_id )
        WHERE status = 'pending'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($adminNotification, $row);
            }
        }
    }

    $answeredNotifications = [];
    $sql = "SELECT ask_price.*, users.id AS user_id, customer.id AS customer_id, customer.name AS customer_name, users.name AS user_name 
        FROM ((ask_price 
        INNER JOIN yadakshop1402.users ON users.id = ask_price.user_id)
        INNER JOIN callcenter.customer ON customer.id = ask_price.customer_id )
        WHERE notify = 'received'
        AND user_id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($answeredNotifications, $row);
        }
    }

    $previousNotifications = [];
    $sql = "SELECT ask_price.*, users.id AS user_id, customer.id AS customer_id, customer.name AS customer_name, users.name AS user_name 
        FROM(( ask_price 
        INNER JOIN yadakshop1402.users ON users.id = ask_price.user_id)
        INNER JOIN callcenter.customer ON customer.id = ask_price.customer_id )
        WHERE notify = 'done'
        AND user_id = '$id'
        LIMIT 10";

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($previousNotifications, $row);
        }
    }

    return  [
        'answeredNotifications' => $answeredNotifications,
        'adminNotification' => $adminNotification,
        'previousNotifications' => $previousNotifications,
        'admin' => $data['name'] === 'نیایش' ? true : false,
    ];
}
