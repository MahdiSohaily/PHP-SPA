<?php
if (isset($_POST['givenPrice'])) {
    $customer = $_POST['customer'];
    $code = $_POST['code'];

    echo $customer, $code;
}
