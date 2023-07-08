 <?php

    require_once './layout/heroHeader.php';



    if (isset($_GET['user'])) {
        $user = $_GET['user'];
    } else {

        $user  = getinternal($_SESSION["id"]);
    }

    ?>

 <div class="your-user">





     <div class="your-interval">داخلی شما</div>
     <div class="your-interval-select">
         <a href="?user=<?php echo $user ?>"><?php echo $user ?></a>
         <a href="?user=1 or 1=1">همه</a>
     </div>
 </div>


 <div class="box-mother">
     <div class="box-incoming">

         <h2 class="title">تماس های ورودی</h2>
         <table class="customer-list">
             <tr>
                 <th>شماره</th>
                 <th>مشخصات</th>
                 <th class="extra-info-header">نیایش</th>
                 <th class="extra-info-header">محک</th>
                 <th>داخلی</th>

                 <th>زمان</th>
                 <th>تاریخ</th>
             </tr>


             <?php



                global  $repeat;
                $sql = "SELECT * FROM incoming WHERE user = $user ORDER BY  time DESC LIMIT 20
";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $phone = $row['phone'];
                        $user = $row['user'];
                        $status = $row['status'];
                        /* if ( $repeat == $row["time"]){$repeat = $row["time"]; continue;}
$repeat = $row["time"];    */
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

                             <tr>


                                 <td class="phone-link"><a href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>

                                 <td class="phone-name"><?php echo $name ?> <?php echo $family ?></td>
                                 <td class="extra-info"><?php




                                                        $gphone =       substr($phone, 1);


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
                                                        ?></td>


                                 <td class="extra-info"><?php




                                                        $gphone =       substr($phone, 1);


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


                                 <td class="phone-user-info"><?php echo $user ?></td>
                                 <td class="time-info"><?php echo $jalali_time ?></td>
                                 <td class="date-info"><?php echo $jalali_date ?></td>


                             </tr>



                         <?php

                            }
                        } else {

                            ?>

                         <tr>


                             <td class="phone-link"><a href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>


                             <td><span class="no-save-phone">این شماره ذخیره نشده است.</span></td>

                             <td class="extra-info"><?php




                                                    $gphone =       substr($phone, 1);


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
                                                    ?></td>




                             <td class="extra-info"><?php




                                                    $gphone =       substr($phone, 1);


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

                             <td class="phone-user-info"><?php echo $user ?></td>
                             <td class="time-info"><?php echo $jalali_time ?></td>
                             <td class="date-info"><?php echo $jalali_date ?></td>



                         </tr>

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

     <div class="tv-inquery">

         <?php require_once 'inquery-list.php';



            ?>

     </div>


 </div>

 <script>
     setTimeout(function() {
         window.location.reload();
     }, 7000);
 </script>

 <?php
    require_once './layout/heroFooter.php';
