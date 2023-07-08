<?php
require_once './layout/heroHeader.php';
global  $repeatkeeper;

$sql = "SELECT * FROM incoming ORDER BY  time DESC LIMIT 100";
$result = mysqli_query(dbconnect(), $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $phone = $row['phone'];
        $status = $row['status'];
        $date = $row["time"];
        $callid = $row["callid"];
        $internal = $row["user"];
        $interval = nishatimedef($repeatkeeper, $row["time"]);



        $capsoltimesecond =   $interval->s;
        $capsoltimeminute =   $interval->i;

        if ($capsoltimesecond > 1 or $capsoltimeminute > 0) {
            echo '</div></div>';

            $repeatkeeper = $row["time"];
        } else {
?>
            <img <?php if ($status == 1) {
                        echo 'class="this-user-answer"';
                    } ?> src=".././userimg/<?php echo getidbyinternal($internal) ?>.jpg" />

            <?php

            continue;
        }


        $array = explode(' ', $date);
        list($year, $month, $day) = explode('-', $array[0]);
        list($hour, $minute, $second) = explode(':', $array[1]);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);


        $jalali_time = jdate("H:i", $timestamp, "", "Asia/Tehran", "en");
        $jalali_date = jdate("Y/m/d", $timestamp, "", "Asia/Tehran", "en");



        $sql2 = "SELECT * FROM customer WHERE phone LIKE '" . $phone . "%'";
        $result2 = mysqli_query($con, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $name = $row2['name'];
                $family = $row2['family'];
                $userlabel = $row2['user'];
                $taglabel = $row2['label'];


            ?>

                <div class="call-capsol">


                    <div class="call-capsol-phone"><a href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></div>
                    <div class="call-capsol-name"><?php echo $name ?> <?php echo $family ?></div>
                    <div class="call-capsol-extra-info"></div>
                    <div class="call-capsol-extra-info"></div>
                    <div class="call-capsol-extra-info"><?php echo $callid ?></div>
                    <div class="call-capsol-time-info"><?php echo $jalali_time ?></div>
                    <div class="call-capsol-taglabel"> <?php taglabelshow($taglabel)  ?></div>
                    <div class="call-capsol-userlabel"> <?php userlabelshow($userlabel)  ?></div>
                    <div class="call-capsol-user-img"><img <?php if ($status == 1) {
                                                                echo 'class="this-user-answer"';
                                                            } ?> src=".././userimg/<?php echo getidbyinternal($internal) ?>.jpg" />






                    <?php
                    if ($repeatkeeper != $row["time"]) {

                        echo '</div></div>';
                    }
                }
            } else {

                    ?>

                    <div class="call-capsol">




                        <div class="call-capsol-phone"><a href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></div>
                        <div class="call-capsol-name no-save">این شماره ذخیره نشده است</div>
                        <div class="call-capsol-extra-info"></div>
                        <div class="call-capsol-extra-info"></div>
                        <div class="call-capsol-extra-info"><?php echo $callid ?></div>
                        <div class="call-capsol-time-info"><?php echo $jalali_time ?></div>
                        <div class="call-capsol-user-img"><img <?php if ($status == 1) {
                                                                    echo 'class="this-user-answer"';
                                                                } ?> src=".././userimg/<?php echo getidbyinternal($internal) ?>.jpg" />





                <?php
                if ($repeatkeeper != $row["time"]) {

                    echo '</div></div>';
                }
            }
        }
    } // end while


    else {
        echo 'هیچ اطلاعاتی موجود نیست';
    }
    require_once './layout/heroFooter.php';
