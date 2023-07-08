<?php

require_once './layout/heroHeader.php';
?>
<?php
$date = "time >= CURDATE()";
if (!empty($_GET['date'])) {
    $date =  $_GET['date'];
}
?>

<style>
    @media print {

        .shomare-faktor-box,
        .top-bar {
            display: none;
        }

        .shomare-faktor-list-show table.customer-list.jadval-shomare {
            width: 90%;
            margin: auto;
            float: none;
        }

        table.customer-list.jadval-shomare tr th:nth-child(4n),
        table.customer-list.jadval-shomare tr td:nth-child(4n) {
            display: none;
        }

        .jadval-shomare-blue {

            background: white;
            color: black;
            border: none;
            box-shadow: none;
            font-size: 12px;
            padding: 0;
        }

        .jadval-shomare-kharidar {
            font-size: 13px;
        }

        img.user-img {
            width: 30px;
            height: 30px;

        }

        table.customer-list td {
            padding: 0;
        }

        .shomare-faktor-date {

            font-size: 11px;

            background: none;
            padding: 4px;

        }

        html {
            margin: 0
        }

        table.customer-list th {
            height: auto;
        }

        .today-faktor-statistics {
            display: none;
        }
    }
</style>

<div class="shomare-faktor-date">
    <?php echo jdate('Y/m/d')  ?> -
    <?php echo jdate('l J F'); ?>
</div>

<div class="shomare-faktor-box">

    <a class="print-button" onClick="window.print()">چاپ <i class="fas fa-print"></i></a>


    <form>
        <label for="invoice_time">زمان فاکتور</label>
        <input value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
        <span id="span_invoice_time"></span>
    </form>



    <script type="text/javascript">
        $(function() {
            $("#invoice_time, #span_invoice_time").persianDatepicker({
                cellWidth: 50,
                cellHeight: 20,
                fontSize: 14,
                formatDate: "YYYY/0M/0D"

            });
        });
    </script>





    <form class="shomare-faktor-form" action="php/shomare-faktor-form-save.php" method="get" autocomplete="off">

        <input class="kharidar" name="kharidar" type="text" placeholder="نام خریدار را وارد کنید ...">
        <input class="save-shomare-faktor-form" type="submit" value=" گرفتن شماره فاکتور">
    </form>

    <div class="shomare-faktor-result">



    </div>
</div>
<div class="shomare-faktor-list-show">




    <div class="today-faktor-statistics">

        <div class="today-faktor">

            <?php

            $sql = "SELECT COUNT(*) as count_shomare FROM shomarefaktor WHERE time >= CURDATE()";
            $result = mysqli_query(dbconnect(), $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

            ?>

                    <div>
                        <p class="today-faktor-total">تعداد کل</p>

                        <span>
                            <?php

                            echo $row['count_shomare'];


                            ?>
                        </span>
                    </div>
            <?php
                }
            }





            ?>
        </div>
        <div class="today-faktor">


            <p class="today-faktor-plus">+</p>


            <?php




            $sql = "SELECT COUNT(shomare) as count_shomare,user FROM shomarefaktor WHERE time >= CURDATE() GROUP BY user ORDER BY count_shomare DESC ";
            $result = mysqli_query(dbconnect(), $sql);
            if (mysqli_num_rows($result) > 0) {
                $n = 1;
                while ($row = mysqli_fetch_assoc($result)) {

            ?>
                    <div>
                        <span><?php echo $row['count_shomare']; ?></span>
                        <img src="../userimg/<?php echo $row['user']; ?>.jpg" />
                        <?php if ($n == 1) {
                            echo '<i class="fas fa-star gold-star"></i>';
                        }
                        $n = $n + 1; ?>
                        <?php if ($n == 2) {
                            echo '<i class="fas fa-star silver-star"></i>';
                        }
                        $n = $n + 1; ?>
                        <?php if ($n == 3) {
                            echo '<i class="fas fa-thumbs-up shast-star"></i>';
                        }
                        $n = $n + 1; ?>
                    </div>
            <?php
                }
            }





            ?>
        </div>
    </div>






    <table class="customer-list jadval-shomare">
        <tr>
            <th>شماره فاکتور</th>
            <th>خریدار</th>
            <th>کاربر</th>
            <th>ویرایش</th>

        </tr>


        <?php






        $sql = "SELECT * FROM shomarefaktor WHERE $date ORDER BY shomare DESC";
        $result = mysqli_query(dbconnect(), $sql);
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

                    <td><a id="<?php echo $row["id"] ?>" class="edit-shomare-faktor-btn">ویرایش<i class="fas fa-edit"></i></a></td>

                </tr>
        <?php

            }
        }

        ?>


    </table>

</div>




<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>
            <iframe width="100%" height="470px" src=""></iframe>
        </p>
    </div>
</div>



<?php require_once './layout/heroFooter.php';
