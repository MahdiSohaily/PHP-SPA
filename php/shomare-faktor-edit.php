<?php require_once '../header.php';



$q = $_GET['q'];


$sql="SELECT * FROM shomarefaktor WHERE id=$q";

$result = mysqli_query(dbconnect(),$sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$shomare = $row['shomare'];
$kharidar = $row['kharidar'];
$user = $row['user'];





?>
<table class="customer-list jadval-shomare">
    <tr>
        <th>شماره فاکتور</th>
        <th>خریدار</th>
        <th>کاربر</th>

    </tr>

    <tr>

        <td>
            <div class="jadval-shomare-blue"><?php echo $shomare ?></div>
        </td>
        <td>
            <div class="jadval-shomare-kharidar"><?php echo $kharidar ?></div>
        </td>
        <td><img class="user-img" src="../../userimg/<?php echo $user ?>.jpg" /></td>


    </tr>


</table><?php
            
}}

?>
