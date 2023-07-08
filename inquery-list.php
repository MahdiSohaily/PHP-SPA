<?php
require_once './layout/heroHeader.php';
?>

<div class="box">
    <h2 class="title">آخرین استعلام ها</h2>
    <div class="box-keeper">

        <table class="customer-list">
            <tr>
                <th>مشتری</th>
                <th>تلفن</th>

                <th>اطلاعات استعلام</th>
                <th>کاربر ثبت کننده</th>
                <th>زمان</th>
                <th>تاریخ</th>
            </tr>

            <?php

            $sql2 = "SELECT * FROM record ORDER BY  time DESC LIMIT 350  ";
            $result2 = mysqli_query($con, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $time = $row2['time'];
                    $callinfo = $row2['callinfo'];
                    $user = $row2['user'];
                    $phone = $row2['phone'];

                    $sql = "SELECT * FROM customer WHERE phone LIKE '" . $phone . "%'";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $name = $row['name'];
                            $family = $row['family'];
            ?>
                            <tr>

                                <td><?php echo ($name . " " . $family) ?></td>
                                <td><a target="_blank" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                <td class="record-info"><?php echo nl2br($callinfo) ?></td>
                                <td class="record-user"><img class="user-img" src="../userimg/<?php echo $user ?>.jpg" />
                            <?php
                        }
                    }

                    date_default_timezone_set('Asia/Tehran');

                    $datetime1 = new DateTime();
                    $datetime2 = new DateTime($time);
                    $interval = $datetime1->diff($datetime2);
                            ?></td>

                                <td class="record-time"><?php echo format_interval($interval); ?></td>
                                <td class="record-date"><?php echo $time ?></td>
                            </tr>
                    <?php

                }
            } else {
                echo '<td colspan="4">هیچ اطلاعاتی موجود نیست</td>';
            }
                    ?>
        </table>
    </div>
</div>
<?php
require_once './layout/heroFooter.php';
