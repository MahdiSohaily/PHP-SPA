 <?php
    require_once './layout/heroHeader.php';




    $phone = $_GET['phone'];




    $sql = "SELECT * FROM customer WHERE phone LIKE '" . $phone . "%'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $family = $row['family'];
            $phone = $row['phone'];
            $vin = $row['vin'];
            $des = $row['des'];
            $address = $row['address'];
            $car = $row['car'];
            $kind = $row['kind'];
            $label = $row['label'];
            $userselect = $row['user'];


            echo '<div class="phone-status">شماره <span>' . $phone . '</span> با نام <span>' . $name . '</span> <span>' . $family . '</span> در سیستم ثبت می باشد .</div>';
            $isold = 1;
        }
    } // end while

    else {
        echo '<div class="phone-status no-save">شماره <span>' . $phone . '</span> در سیستم ثبت نمی باشد .</div>';
        $isold = 0;
    }

    ?>








 <div class="box">
     <h2 class="title">مشخصات مشتری</h2>



     <form class="save-contact form" action="php/save.php" method="get" autocomplete="off">

         <div class="form-keeper">
             <div>
                 <p>

                     شماره تماس



                 </p>

                 <input id="phone" name="phone" type="text" value="<?php echo $phone ?>" readonly>
             </div>


             <div>
                 <p>نام</p> <input id="name" name="name" type="text" value="<?php if (!empty($name)) {
                                                                                echo $name;
                                                                            } ?>">
             </div>

             <div>

                 <p>نام خانوادگی</p>
                 <input id="last_name" name="family" type="text" value="<?php if (!empty($family)) {
                                                                            echo $family;
                                                                        } ?>">
             </div>
             <div>
                 <p>شماره شاسی</p>


                 <input name="vin" type="text" value="<?php if (!empty($vin)) {
                                                            echo $vin;
                                                        } ?>">
             </div>

             <div>
                 <p>ماشین</p>


                 <input name="car" type="text" value="<?php if (!empty($car)) {
                                                            echo $car;
                                                        } ?>">
             </div>

             <div>
                 <p>نوع</p>


                 <input name="kind" type="text" value="<?php if (!empty($kind)) {
                                                            echo $kind;
                                                        } ?>">
             </div>
             <div>
                 <p>آدرس</p>


                 <textarea name="address"><?php if (!empty($address)) {
                                                echo $address;
                                            } ?></textarea>
             </div>

             <div>
                 <p>توضیحات مشتری</p>



                 <textarea name="des"><?php if (!empty($des)) {
                                            echo $des;
                                        } ?></textarea>
             </div>
             <input name="isold" id="isold" type="hidden" value="<?php echo ($isold) ?>">



             <div class="callinfobox">

                 <p> درج اطلاعات استعلام</p>
                 <textarea class="callinfo" name="callinfo"></textarea>

                 <div class="callinfobox-option">
                     <div>درخواست بارنامه</div>
                     <div>درخواست شماره کارت</div>
                     <div>پیگیری پیک</div>
                     <div>پیگیری روند فاکتور</div>
                     <div>درخواست ثبت فاکتور</div>
                     <div>ارجاع به واتساپ</div>
                     <div>درخواست شماره واتساپ</div>
                     <div>اطلاعات واریز وجه</div>

                 </div>
             </div>

         </div>





         <div class="bottom-bar">
             <input class="customer-info-save" type="submit" value="ذخیره" id="sabt">
             <div class="error">
             </div>
         </div>










     </form>

 </div>
 <div class="box">
     <a class="click-to-call" href="#">تماس با مشتری</a>
     <a class="click-to-cancell" href="#">قطع تماس جاری</a>
     <a id="mySizeChart" class="click-to-sms" href="#">ارسال پیامک</a>
     <a target="_blank" class="click-to-whatsapp" href="https://web.whatsapp.com/send/?phone=98<?php echo $phone ?>&text=با عرض سلام و وقت بخیر
%0a
از واحد فروش مجموعه یدک شاپ خدمتتون پیام ارسال شده است
%0a
اگر نیاز به مشاوره یا استعلام قیمت قطعات دارید می توانید برای ما پیام ارسال کنید ، کارشناسان فروش ما در سریع ترین حالت ممکن پاسخگوی شما هستند.
%0a
کارشناس شما : <?php echo getfamilybyid($_SESSION["id"]); ?>

&type=phone_number&app_absent=0">ارسال واتساپ</a>

     <form class="cartable-save-form " action="php/cartable-save.php" method="get" autocomplete="off">








         <div class="cartable-form-2 qmain">
             <div class="qtagselect isw360">
                 <select class="qtagselect__select" name="label[]" id="label" multiple>


                     <?php taglabellist() ?>

                 </select>





                 <script>
                     <?php



                        $myString =     substr($label, 0, -1);


                        $myArray = explode(',', $myString);




                        foreach ($myArray as $ttt) {
                            $ttt = $ttt - 1;
                            echo "$('#label option:eq($ttt)').attr('selected', 'selected');";
                        }


                        ?>
                 </script>

             </div>

         </div>
         <div class="cartable-form-3 qmain2">






             <input name="phone" type="text" value="<?php echo $phone ?>" hidden>




             <div class="quserselect isw360">
                 <select class="quserselect__select" name="userselector[]" id="userselector" multiple>


                     <?php userlabellist() ?>

                 </select>




                 <script>
                     <?php



                        $myString =     substr($userselect, 0, -1);


                        $myArray = explode(',', $myString);




                        foreach ($myArray as $ttt) {
                            $ttt = $ttt - 1;
                            echo "$('#userselector option:eq($ttt)').attr('selected', 'selected');";
                        }


                        ?>
                 </script>





             </div>









         </div>




         <div class="cartable-form-1">
             <select name="cartable-pos" id="cartable-pos">
                 <option value="0">لنتخاب کارتابل</option>
                 <option value="1">نیاز به پیگیری</option>
                 <option value="2">نیاز به قفلی</option>

                 <option value="3">داستان شده</option>
                 <option value="0">حذف از کارتابل</option>

             </select>

         </div>

         <input type="submit" value="ذخیره لیبل">

         <div style="clear:both"></div>
     </form>
 </div>
 <div class="box">
     <div class="customer-level">
         <div>شاسی</div>
         <div>کد</div>
         <div>گرفتن قیمت</div>
         <div>دادن قیمت</div>
         <div>نیاز به فاکتور</div>
         <div>انجام پیش فاکتور</div>
         <div>انتظار واریز</div>
         <div>ارسال جنس</div>
         <div>پیگیری 1</div>
         <div>پیگیری 2</div>
         <div>عدم پیگیری</div>
     </div>
 </div>


 <div class="box-right">
     <h2 class="title">استعلام های قبلی</h2>

     <div class="box-keeper">



         <table class="customer-list">
             <tr>
                 <th>اطلاعات</th>
                 <th>کاربر ثبت کننده</th>
                 <th>زمان</th>
                 <th>تاریخ</th>

             </tr>


             <?php

                $sql2 = "SELECT * FROM record WHERE phone LIKE '" . $phone . "%' ORDER BY  time DESC LIMIT 300";
                $result2 = mysqli_query($con, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $time = $row2['time'];
                        $callinfo = $row2['callinfo'];
                        $user = $row2['user'];
                ?>
                     <tr>


                         <td class="record-info"><?php echo nl2br($callinfo) ?></td>
                         <td class="record-user"><?php





                                                    $con2 = mysqli_connect('localhost', 'root', '', 'yadakshop1401');

                                                    if (!$con2) {
                                                        die('Could not connect: ' . mysqli_error($con2));
                                                    }
                                                    mysqli_set_charset($con2, "utf8");
                                                    $sql3 = "SELECT * FROM users WHERE id=$user";
                                                    $result3 = mysqli_query($con2, $sql3);
                                                    if (mysqli_num_rows($result3) > 0) {
                                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                                            $name = $row3['name'];
                                                            $family = $row3['family'];
                                                            echo ($name . " " . $family);
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
                } // end while


                else {
                    echo '<td colspan="4">هیچ اطلاعاتی موجود نیست</td>';
                }

                ?>



         </table>


     </div>
 </div>










 <div class="box-left">
     <h2 class="title">تماس های قبلی</h2>

     <div class="box-keeper">



         <table class="customer-list">
             <tr>

                 <th>پاسخ دهنده</th>
                 <th>زمان</th>
                 <th>تاریخ</th>
                 <th>ایدی</th>

             </tr>


             <?php


                $pretime = "";

                $sql30 = "SELECT * FROM incoming WHERE phone LIKE '" . $phone . "%' ORDER BY  time DESC  LIMIT 200";
                $result30 = mysqli_query($con, $sql30);
                if (mysqli_num_rows($result30) > 0) {
                    while ($row30 = mysqli_fetch_assoc($result30)) {
                        $time = $row30['time'];
                        $user = $row30['user'];
                        $id = $row30['callid'];
                        $status = $row30['status'];
                        $start = $row30['starttime'];
                        $end = $row30['endtime'];




                        $interval1 =    nishatimedef(date('Y/m/d H:i:s'), $time);
                        $interval2 =    nishatimedef($start, $end);




                        if ($status == 0 and $pretime == $time) {
                            $pretime = $time;

                            continue;
                        }

                        $pretime = $time;


                ?>
                     <tr>


                         <td class="record-info"><?php

                                                    if ($status == 0) {
                                                        echo ("<div class='answer-x'>X</div>");
                                                    } else {
                                                        echo (getnamebyinternal($user) . "<div class='answer-tik'>&#10004;</div><div class='call-duration'>" . format_calling_time($interval2) . "</div>");
                                                    }


                                                    ?></td>


                         <td class="record-time"><?php echo format_interval($interval1); ?></td>
                         <td class="record-date"><?php echo $time ?></td>
                         <td class="record-date"><?php echo $id ?></td>


                     </tr>






             <?php

                    }
                } // end while


                else {
                    echo '<td colspan="4">هیچ اطلاعاتی موجود نیست</td>';
                }

                ?>



         </table>


     </div>
 </div>










 <div class="space"></div>
 <script>
     $('.qtagselect__select').tagselect();
     $('.quserselect__select').userselect();
 </script>
 <script>
     $(document).ready(function() {
         $(".click-to-call").click(function() {



             window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=number=<?php echo $phone ?>&outgoing_uri=@192.168.9.10', 'برقراری تماس', 'width=400,height=400')


         });

         $(".click-to-cancell").click(function() {



             window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=CALLEND', 'برقراری تماس', 'width=400,height=400')


         });
     });
 </script>



 <div id="mySizeChartModal" class="ebcf_modal">

     <div class="ebcf_modal-content">
         <span class="ebcf_close">&times;</span>
         <div class="message_container">
             <div class="messageBox">
                 <form action="#" method="post" onsubmit="event.preventDefault(); validate()">
                     <label for="messageBox">متن پیامک</label>
                     <br>
                     <textarea name="message" id="messageBox" cols="60" rows="10"></textarea>
                     <br>
                     <div class="submit_box">
                         <input class="submit" value="ارسال پیام" type="submit">
                         <div id="error_box"></div>
                     </div>
                 </form>
             </div>
             <div class="messages">
                 <ul>
                     <li class="message_item" id="hello" onclick="appendMessage(this.innerHTML)"></li>
                     <li class="message_item" id="hello" onclick="appendMessage(this.innerHTML)">الان میام</li>
                     <li class="message_item" id="hello" onclick="appendMessage(this.innerHTML)">لطفا منتظر باشید</li>
                     <li class="message_item" id="hello" onclick="appendMessage(this.innerHTML)">بسته شما رسید</li>
                     <li class="message_item" id="hello" onclick="appendMessage(this.innerHTML)">روزتان خوش</li>
                 </ul>
             </div>
         </div>
     </div>

 </div>
 <script>
     const phone = document.getElementById('phone');
     const name = document.getElementById('name');
     const last_name = document.getElementById('last_name');

     // Get the modal
     const ebModal = document.getElementById('mySizeChartModal');

     // Get the button that opens the modal
     const ebBtn = document.getElementById("mySizeChart");

     // Get the <span> element that closes the modal
     const ebSpan = document.getElementsByClassName("ebcf_close")[0];

     // When the user clicks the button, open the modal 
     ebBtn.onclick = function() {
         ebModal.style.display = "block";

         const hello = document.getElementById('hello');
         hello.innerHTML = ` با سلام جناب آقای ${name.value} ${last_name.value}`
     }

     // When the user clicks on <span> (x), close the modal
     ebSpan.onclick = function() {
         ebModal.style.display = "none";
     }

     // When the user clicks anywhere outside of the modal, close it
     window.onclick = function(event) {
         if (event.target == ebModal) {
             ebModal.style.display = "none";
         }
     }

     const messageBox = document.getElementById('messageBox')
     const error_box = document.getElementById('error_box')

     function appendMessage(value) {
         messageBox.innerHTML += ` ${value} `;
     }

     function validate() {
         const code = phone.value.slice(0, 2);
         if ('09' === code) {
             const validated = phone.value.replace(/\D+/g, '');
             const destination = `98` + validated.slice(1);
             const content = messageBox.innerHTML.trim();
             console.log(destination, content);

             var request = new XMLHttpRequest();

             // Instantiating the request object
             request.open("GET", `http://192.168.9.16/cgi/WebCGI?1500101=account=test&password=test1028&port=1&destination=${destination}&content=${content}`);

             // Defining event listener for readystatechange event
             request.onreadystatechange = function() {
                 // Check if the request is compete and was successful
                 if (this.readyState === 4 && this.status === 200) {
                     error_box.innerHTML = `<p class='response'>${this.responseText}</p>`;

                 }
             };

             // Sending the request to the server
             request.send();

         } else {
             error_box.innerHTML = `<p class="error">ارسال پیام به شماره ${phone.value} امکان پذیر نمی باشد.</p>`
         }
     }
 </script>
 <?php
    require_once './layout/heroFooter.php';
