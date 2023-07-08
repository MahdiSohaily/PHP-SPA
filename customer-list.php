<?php
require_once './layout/heroHeader.php';
?>

<div class="box">
    <h2 class="title">لیست مشتریان</h2>
    <div class="box-keeper">

        <table class="customer-list">
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>فامیلی</th>
                <th>تلفن</th>
                <th>شماره شاسی</th>
                <th>ماشین</th>
                <th>نوع</th>
                <th>آدرس</th>
                <th>توضیحات</th>

            </tr>


            <?php

            $sql3 = "SELECT * FROM customer";

            global $shakhes;
            $shakhes = 1;


            $result3 = mysqli_query($con, $sql3);
            if (mysqli_num_rows($result3) > 0) {
                while ($row3 = mysqli_fetch_assoc($result3)) {
                    $name = $row3['name'];
                    $family = $row3['family'];
                    $phone = $row3['phone'];
                    $vin = $row3['vin'];
                    $des = $row3['des'];
                    $address = $row3['address'];
                    $car = $row3['car'];
                    $kind = $row3['kind'];

            ?>


                    <tr>
                        <td><?php echo $shakhes ?></td>

                        <td><?php echo $name ?></td>
                        <td><?php echo $family ?></td>
                        <td><a target="_blank" href="main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                        <td><?php echo $vin ?></td>
                        <td><?php echo $car ?></td>
                        <td><?php echo $kind ?></td>
                        <td><?php echo $address ?></td>

                        <td><?php echo $des ?></td>


                    </tr>






            <?php
                    $shakhes = $shakhes + 1;
                }
            } // end while


            else {
                echo '<div class="phone-status no-save">شماره <span>' . $phone . '</span> در سیستم ثبت نمی باشد .</div>';
            }
            mysqli_close($con);
            ?>



        </table>



    </div>
</div>
<?php
require_once './layout/heroFooter.php';
