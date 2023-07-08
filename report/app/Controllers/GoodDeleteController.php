<?php
require_once('../../database/connect.php');

if (isset($_POST['Delete_Good'])) {

    $delete_id = $_POST['delete_id'];
    echo $delete_id;
    // sql to delete a record
    $sql = "DELETE FROM yadakshop1402.nisha WHERE id= $delete_id ";

    if ($conn->query($sql) === TRUE) {
        return TRUE;
    } else {
        return false;
    }
}

// Update rate

if (isset($_POST['update_selected_rate'])) {
    $id = $_POST['element_id'];
    $element_value = $_POST['element_value'] == 'true' ? 1 : 0;



    $sql = "UPDATE rates SET  selected = '$element_value' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        $errors = " ویرایش اطلاعات ناموفق بود";
    }
}

if (isset($_POST['Delete_rate'])) {

    $delete_id = $_POST['delete_id'];
    echo $delete_id;
    // sql to delete a record
    $sql = "DELETE FROM rates WHERE id= $delete_id ";

    if ($conn->query($sql) === TRUE) {
        return TRUE;
    } else {
        return false;
    }
}
