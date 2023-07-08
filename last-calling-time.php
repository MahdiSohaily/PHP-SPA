<?php
require_once './layout/heroHeader.php';
?>

<div class="box">
    <h2 class="title">آخرین مکالمات</h2>
    <div class="box-keeper">

        <table class="customer-list">
            <tr>
                <th>مشتری</th>
                <th>تلفن</th>
                <th>کاربر</th>
                <th>زمان مکالمه</th>


            </tr>
            <?php
            $sql = "SELECT * FROM incoming WHERE starttime IS NOT NULL AND time >= CURDATE() ORDER BY  time DESC";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $user = $row['user'];
                    $phone = $row['phone'];
                    $starttime = $row['starttime'];
                    $endtime = $row['endtime'];
                    $xxx =   nishatimedef($starttime, $endtime);


                    $sql2 = "SELECT * FROM customer WHERE phone LIKE '" . $phone . "%'";
                    $result2 = mysqli_query($con, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            $name = $row2['name'];
                            $family = $row2['family'];


            ?>

                            <tr>
                                <td><?php echo ($name . " " . $family) ?></td>
                                <td><a target="_blank" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                <td><?php echo getnamebyinternal($user) ?></td>
                                <td class="record-time"><?php echo format_calling_time($xxx)  ?></td>
                            </tr>

            <?php

                        }
                    } // end while


                }
            } // end while

            ?>


        </table>



    </div>
</div>

<?php
require_once './layout/heroFooter.php';
