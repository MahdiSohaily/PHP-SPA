<?php
require_once './config/database.php';


if (isset($_POST['getFactor'])) {
    $startDate = date_create($_POST['date']);

    $date = date_create($_POST['date']);
    $date->modify('+1 day');

    $start = date_format($date, "Y-m-d h:i:s");
    $end = date_format($startDate, "Y-m-d h:i:s");

    // $sql = "SELECT * FROM shomarefaktor WHERE time < '$start' AND time >= '$end' ORDER BY shomare DESC";
    $sql = "SELECT * FROM shomarefaktor WHERE time < '2023-05-10 12:00:00' AND time >= '2023-05-09 12:00:00' ORDER BY shomare DESC";
    $result = mysqli_query($con, $sql);


?>

    <table class="customer-list jadval-shomare">
        <tr>
            <th>شماره فاکتور</th>
            <th>خریدار</th>
            <th>کاربر</th>
        </tr>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $shomare = $row['shomare'];
                    $kharidar = $row['kharidar'];
                    $user = $row['user'];
            ?>
                    <tr>
                        <td>
                            <div class="jadval-shomare-blue"><?php echo $shomare ?></div>
                        </td>
                        <td>
                            <div class="jadval-shomare-kharidar"><?php echo $kharidar ?></div>
                        </td>
                        <td><img class="user-img" src="../userimg/<?php echo $user ?>.jpg" /></td>
                    </tr>
            <?php

                }
            }

            ?>
        </tbody>
    </table>
<?php
}
