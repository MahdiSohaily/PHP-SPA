<?php
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
require_once('./app/Controllers/GivenPriceController.php');

if (!$isValidCustomer) {
} else {
    echo 'Customer is not valid';
}

require_once('./views/Layouts/footer.php');
