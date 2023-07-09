<?php
require_once './php/function.php';
require_once './php/jdf.php';
require_once './config/database.php';
if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    $user  = getinternal($_SESSION["id"]);
}
?>
<script>
    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            /* IE11 */
            document.msExitFullscreen();
        }
    }
</script>
<div class="bg-white">
    <i onclick="openFullscreen()" class="large material-icons">aspect_ratio</i>
    <i onclick="closeFullscreen()" class="large material-icons">border_clear</i>
    <div class="d-grid">
        <div class="div1">
            <h2 class="title">تماس های ورودی</h2>
            <table class="">
                <thead>
                    <tr>
                        <th class="bg-violet-800 text-white text-sm px-5 py-2">شماره</th>
                        <th class="bg-violet-800 text-white text-sm px-2 py-2">مشخصات</th>
                        <th class="bg-violet-800 text-white text-sm px-2 py-2">نیایش</th>
                        <th class="bg-violet-800 text-white text-sm px-2 py-2">محک</th>
                        <th class="bg-violet-800 text-white text-sm px-2 py-2">داخلی</th>
                        <th class="bg-violet-800 text-white text-sm px-2 py-2">زمان</th>
                        <!-- <th>تاریخ</th> -->
                    </tr>
                </thead>
                <?php
                global  $repeat;
                $sql = "SELECT * FROM incoming WHERE user = $user ORDER BY  time DESC LIMIT 20";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $phone = $row['phone'];
                        $user = $row['user'];
                        $status = $row['status'];
                        $date = $row["time"];
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
                ?>
                                <tbody>
                                    <tr class="odd:bg-gray-200 hover:bg-gray-200 hover:cursor-pointer">
                                        <td class="py-2 px-5"><a class="bg-red-600 text-white p-1 rounded-md hover:bg-red-700 hover:text-gray-100" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                        <td class="p-2"><?php echo $name ?> <?php echo $family ?></td>
                                        <td class="p-2">
                                            <?php
                                            $gphone = substr($phone, 1);
                                            $sql3 = "SELECT * FROM google WHERE mob1 LIKE '%" . $gphone . "%' OR mob2 LIKE '%" . $gphone . "%' OR mob3 LIKE '%" . $gphone . "%'  ";
                                            $result3 = mysqli_query($con, $sql3);
                                            if (mysqli_num_rows($result3) > 0) {
                                                $n = 1;
                                                while ($row3 = mysqli_fetch_assoc($result3)) {
                                                    $gname1 = $row3['name1'];
                                                    $gname2 = $row3['name2'];
                                                    $gname3 = $row3['name3'];
                                                    if (strlen($phone) < 5) {
                                                        break;
                                                    }
                                                    if ($n > 1) {
                                                        echo ("<br>");
                                                    }
                                                    echo $gname1 . " " . $gname2 . " " . $gname3;
                                                    $n++;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="p-2">
                                            <?php
                                            $gphone = substr($phone, 1);
                                            $sql4 = "SELECT * FROM mahak WHERE mob1 LIKE '%" . $gphone . "%' OR mob2 LIKE '%" . $gphone . "%'   ";
                                            $result4 = mysqli_query($con, $sql4);
                                            if (mysqli_num_rows($result4) > 0) {
                                                $n = 1;
                                                while ($row4 = mysqli_fetch_assoc($result4)) {
                                                    $mname1 = $row4['name1'];
                                                    $mname2 = $row4['name2'];

                                                    if (strlen($phone) < 5) {
                                                        break;
                                                    }

                                                    if ($n > 1) {
                                                        echo ("<br>");
                                                    }
                                                    echo $mname1 . " " . $mname2;
                                                    $n++;
                                                }
                                            }
                                            ?></td>
                                        <td class="p-2"><?php echo $user ?></td>
                                        <td class="p-2"><?php echo $jalali_time ?></td>
                                        <!-- <td class="date-info"><?php echo $jalali_date ?></td> -->
                                    </tr>
                                </tbody>
                            <?php

                            }
                        } else {
                            ?>
                            <tbody>
                                <tr class="hover:bg-gray-200 hover:cursor-pointer">
                                    <td class="py-2 px-5"><a class="bg-red-600 text-white p-1 rounded-md hover:bg-red-700 hover:text-gray-100" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                    <td class="w-30"><span class="tiny-text text-red-500 bold">این شماره ذخیره نشده است.</span></td>
                                    <td class="p-2">
                                        <?php
                                        $gphone = substr($phone, 1);
                                        $sql3 = "SELECT * FROM google WHERE mob1 LIKE '%" . $gphone . "%' OR mob2 LIKE '%" . $gphone . "%' OR mob3 LIKE '%" . $gphone . "%'  ";
                                        $result3 = mysqli_query($con, $sql3);
                                        if (mysqli_num_rows($result3) > 0) {
                                            $n = 1;
                                            while ($row3 = mysqli_fetch_assoc($result3)) {
                                                $gname1 = $row3['name1'];
                                                $gname2 = $row3['name2'];
                                                $gname3 = $row3['name3'];
                                                if (strlen($phone) < 5) {
                                                    break;
                                                }
                                                if ($n > 1) {
                                                    echo ("<br>");
                                                }
                                                echo $gname1 . " " . $gname2 . " " . $gname3;
                                                $n++;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="p-2">
                                        <?php
                                        $gphone = substr($phone, 1);
                                        $sql4 = "SELECT * FROM mahak WHERE mob1 LIKE '%" . $gphone . "%' OR mob2 LIKE '%" . $gphone . "%'   ";
                                        $result4 = mysqli_query($con, $sql4);
                                        if (mysqli_num_rows($result4) > 0) {
                                            $n = 1;
                                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                                $mname1 = $row4['name1'];
                                                $mname2 = $row4['name2'];

                                                if (strlen($phone) < 5) {
                                                    break;
                                                }

                                                if ($n > 1) {
                                                    echo ("<br>");
                                                }
                                                echo $mname1 . " " . $mname2;
                                                $n++;
                                            }
                                        }
                                        ?>
                                    </td>

                                    <td class="p-2"><?php echo $user ?></td>
                                    <td class="p-2"><?php echo $jalali_time ?></td>
                                    <!-- <td class="date-info"><?php echo $jalali_date ?></td> -->
                                </tr>
                            </tbody>
                <?php
                        }
                    }
                } // end while
                else {
                    echo 'هیچ اطلاعاتی موجود نیست';
                }
                ?>
            </table>
        </div>
        <div class="div2">
            <h2 class="title">آخرین قیمت های داده شده</h2>
            <table class="border text-sm bg-white custom-table mb-2 p-3">
                <thead class="font-medium bg-green-600">
                    <tr>
                        <th style="width: 300px;" scope="col" class="px-3 py-2 text-white text-right">
                            مشتری
                        </th>
                        <th style="width: 80px !important" scope="col" class="px-3 py-2 text-white text-right">
                            قیمت
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-right">
                            کد فنی
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-center">
                            کاربر
                        </th>
                        <th style="width: 300px;" scope="col" class="px-3 py-2 text-white text-right">
                            زمان
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $givenPrice = givenPrice($con);
                    function givenPrice($con)
                    {
                        $sql = "SELECT 
                         prices.price, prices.partnumber, users.username,customer.id AS customerID, users.id as userID, prices.created_at, customer.name, customer.family
                         FROM ((shop.prices 
                         INNER JOIN callcenter.customer ON customer.id = prices.customer_id )
                         INNER JOIN yadakshop1402.users ON users.id = prices.user_id)
                         ORDER BY prices.created_at DESC LIMIT 200";
                        $result = mysqli_query($con, $sql);


                        $givenPrices = [];
                        if (mysqli_num_rows($result) > 0) {
                            while ($item = mysqli_fetch_assoc($result)) {
                                array_push($givenPrices, $item);
                            }
                        }
                        return  $givenPrices;
                    }

                    if (count($givenPrice) > 0) {
                    ?>
                        <?php foreach ($givenPrice as $price) { ?>
                            <?php if ($price['price'] !== null) {
                            ?>
                                <tr class="mb-1 ?> odd:bg-gray-200">
                                <?php  } ?>
                                <td class="tiny-text bold px-1">
                                    <p class="text-right bold text-gray-700 px-2 py-1">
                                        <?php echo $price['name'] . ' ' . $price['family'] ?>
                                    </p>
                                </td>
                                <td style="width: 100px;" class="tiny-text bold px-1">
                                    <p class="text-right bold text-gray-700 px-2 py-1">
                                        <?php echo $price['price'] === null ? 'ندارد' : $price['price']  ?>
                                    </p>
                                </td>
                                <td class="tiny-text bold px-1">
                                    <p class="text-right bold text-gray-700 px-2 py-1">
                                        <?php echo $price['partnumber']; ?>
                                    </p>
                                </td>
                                <td style="width:120px;">
                                    <p class="text-center bold text-gray-700 px-2 py-1">
                                        <img title="<?php echo $price['username'] ?>" class="userImage mx-auto" src="../userimg/<?php echo $price['userID'] ?>.jpg" alt="userimage">
                                    </p>
                                </td>
                                <td class="tiny-text bold time">
                                    <p class="text-right bold text-gray-700 px-2 py-1">
                                        <?php
                                        date_default_timezone_set("Asia/Tehran");
                                        $create = date($price['created_at']);

                                        $now = new DateTime(); // current date time
                                        $date_time = new DateTime($create); // date time from string
                                        $interval = $now->diff($date_time); // difference between two date times
                                        $days = $interval->format('%a'); // difference in days
                                        $hours = $interval->format('%h'); // difference in hours
                                        $minutes = $interval->format('%i'); // difference in minutes
                                        $seconds = $interval->format('%s'); // difference in seconds

                                        $text = '';

                                        if ($days) {
                                            $text .= " $days روز و ";
                                        }

                                        if ($hours) {
                                            $text .= "$hours ساعت ";
                                        }

                                        if (!$days && $minutes) {
                                            $text .= "$minutes دقیقه ";
                                        }

                                        if (!$days && !$hours && $seconds) {
                                            $text .= "$seconds ثانیه ";
                                        }

                                        echo "$text قبل";
                                        ?>
                                    </p>
                                </td>
                                </tr>
                            <?php
                        } ?>
                        <?php } else { ?>
                            <tr class="">
                                <td colspan="4" scope="col" class="not-exist">
                                    موردی برای نمایش وجود ندارد !!
                                </td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="div3">
            <h2 class="title">آخرین استعلام ها</h2>
            <div class="">

                <table class="border text-sm bg-white custom-table mb-2 p-3 ">
                    <thead>
                        <tr class="tiny-text bg-violet-800 text-white">
                            <th class="p-2">مشتری</th>
                            <th class="p-2">تلفن</th>
                            <th class="p-2">اطلاعات استعلام</th>
                            <th class="p-2">کاربر</th>
                            <th class="p-2">زمان</th>
                            <!-- <th class="p-2">تاریخ</th> -->
                        </tr>
                    </thead>

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
                                    <tbody>
                                        <tr>
                                            <td class="tiny-text p-2"><?php echo ($name . " " . $family) ?></td>
                                            <td class="tiny-text p-2"><a target="_blank" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                            <td class="tiny-text p-2"><?php echo nl2br($callinfo) ?></td>
                                            <td style="width: 50px;" class="tiny-text p-2"><img class="userImage mx-auto" src="../userimg/<?php echo $user ?>.jpg" />
                                        <?php
                                    }
                                }

                                date_default_timezone_set('Asia/Tehran');

                                $datetime1 = new DateTime();
                                $datetime2 = new DateTime($time);
                                $interval = $datetime1->diff($datetime2);
                                        ?>
                                            </td>

                                            <td style="width: 100px;" class="tiny-text p-2">
                                                <?php
                                                $create = date($time);

                                                $now = new DateTime(); // current date time
                                                $date_time = new DateTime($create); // date time from string
                                                $interval = $now->diff($date_time); // difference between two date times
                                                $days = $interval->format('%a'); // difference in days
                                                $hours = $interval->format('%h'); // difference in hours
                                                $minutes = $interval->format('%i'); // difference in minutes
                                                $seconds = $interval->format('%s'); // difference in seconds

                                                $text = '';

                                                if ($days) {
                                                    $text .= " $days روز و ";
                                                }

                                                if ($hours) {
                                                    $text .= "$hours ساعت ";
                                                }

                                                if (!$days && $minutes) {
                                                    $text .= "$minutes دقیقه ";
                                                }

                                                if (!$days && !$hours && $seconds) {
                                                    $text .= "$seconds ثانیه ";
                                                }
                                                echo "$text قبل";
                                                ?>
                                            </td>
                                            <!-- <td class="record-date"><?php echo $time ?></td> -->
                                        </tr>
                                    </tbody>
                            <?php

                        }
                    } else {
                        echo '<td colspan="4">هیچ اطلاعاتی موجود نیست</td>';
                    }
                            ?>
                </table>
            </div>
        </div>
        <div class="div4">
            <h2 class="title">آخرین قیمت های گرفته شده از بازار</h2>
            <div class="">

                <table class="border text-sm bg-white custom-table mb-2 p-3">
                    <thead>
                        <tr class="tiny-text bg-violet-800 text-white">
                            <th class="p-2">کد فنی</th>
                            <th class="p-2">فروشنده</th>
                            <th class="p-2">قیمت</th>
                            <th class="p-2">کاربر</th>
                            <th class="p-2">زمان</th>
                        </tr>
                    </thead>
                    <?php
                    $sql2 = "SELECT * FROM estelam ORDER BY  time DESC LIMIT 250  ";
                    $result2 = mysqli_query($con, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {

                            $code = $row2['codename'];
                            $seller = $row2['seller'];
                            $price = $row2['price'];
                            $user = $row2['user'];
                            $time = $row2['time'];
                            $sql = "SELECT * FROM users WHERE id=$user";
                            $result = mysqli_query(dbconnect2(), $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $family = $row['family'];
                                    $sql3 = "SELECT * FROM seller WHERE id=$seller";
                                    $result3 = mysqli_query(dbconnect2(), $sql3);
                                    if (mysqli_num_rows($result3) > 0) {
                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                            $sellername = $row3['name'];
                    ?>
                                            <tbody>
                                                <tr class="tiny-text">
                                                    <td class="p-2"><?php echo $code ?></td>
                                                    <td class="p-2"><?php echo $sellername ?></td>
                                                    <td class="p-2"><?php echo $price ?></td>
                                                    <td style="width: 50px;" class="tiny-text p-2"><img class="userImage mx-auto" src="../userimg/<?php echo $user ?>.jpg" />
                                                    <td class="p-2"><?php echo date('Y-m-d', strtotime($time)) ?></td>
                                                </tr>
                                            </tbody>
                    <?php
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    /* Get the element you want displayed in fullscreen mode (a video in this example): */
    var elem = document.getElementById("fullpage");

    /* When the openFullscreen() function is executed, open the video in fullscreen.
    Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE11 */
            elem.msRequestFullscreen();
        }
    }
</script>