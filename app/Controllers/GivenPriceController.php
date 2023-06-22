<?php
$isValidCustomer = false;
$finalResult = null;

if (isset($_POST['givenPrice'])) {
    $customer = $_POST['customer'];
    $code = $_POST['code'];

    $customer_sql = "SELECT * FROM callcenter.customer WHERE id = '" . $customer . "%'";
    $result = mysqli_query($conn, $customer_sql);
    if (mysqli_num_rows($result) > 0) {

        $isValidCustomer = true;
    }
}
