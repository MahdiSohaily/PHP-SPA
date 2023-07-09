<?php

require_once './layout/heroHeader.php';
?>
<?php
$date = "time >= CURDATE()";
if (!empty($_GET['date'])) {
    $date =  $_GET['date'];
}
?>
<div class="shomare-faktor-date">
    <?php echo jdate('Y/m/d')  ?> -
    <?php echo jdate('l J F'); ?>
</div>

<div class="shomare-faktor-box">
    <a class="print-button" onClick="window.print()">چاپ <i class="fas fa-print"></i></a>
    <form>
        <label for="invoice_time">زمان فاکتور</label>
        <input data-gdate="<?php echo date('Y/m/d') ?>" value="<?php echo (jdate("Y/m/d", time(), "", "Asia/Tehran", "en")) ?>" type="text" name="invoice_time" id="invoice_time">
        <span id="span_invoice_time"></span>
    </form>


    <form class="shomare-faktor-form" action="php/shomare-faktor-form-save.php" method="get" autocomplete="off">

        <input class="kharidar" name="kharidar" type="text" placeholder="نام خریدار را وارد کنید ...">
        <input class="save-shomare-faktor-form" type="submit" value=" گرفتن شماره فاکتور">
    </form>

    <div class="shomare-faktor-result">
    </div>
</div>
<div class="shomare-faktor-list-show">
    <div class="today-faktor-statistics">
        <div class="">
            <?php
            $sql = "SELECT COUNT(*) as count_shomare FROM shomarefaktor WHERE time >= CURDATE()";
            $result = mysqli_query(dbconnect(), $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="ranking mb-2">
                        <p class="text-white px-2">تعداد کل</p>
                        <span class="counter">
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

        <div class="">
            <p class="today-faktor-plus">+</p>
            <?php
            $sql = "SELECT COUNT(shomare) as count_shomare,user FROM shomarefaktor WHERE time >= CURDATE() GROUP BY user ORDER BY count_shomare DESC ";
            $result = mysqli_query(dbconnect(), $sql);
            if (mysqli_num_rows($result) > 0) {
                $n = 1;
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="ranking mb-2">
                        <img src="../userimg/<?php echo $row['user']; ?>.jpg" />
                        <?php if ($n == 1) {
                            echo '<i class="fas ranking-icon fa-star golden"></i>';
                        }

                        if ($n == 2) {
                            echo '<i class="fas ranking-icon fa-star silver"></i>';
                        }

                        if ($n == 3) {
                            echo '<i class="fas ranking-icon fa-thumbs-up lucky"></i>';
                        }
                        $n = $n + 1; ?>
                        <span class="counter"><?php echo $row['count_shomare']; ?></span>
                    </div>

            <?php
                }
            }





            ?>
        </div>
    </div>
    <div id="resultBox">
        <table class="customer-list jadval-shomare">
            <tr>
                <th>شماره فاکتور</th>
                <th>خریدار</th>
                <th>کاربر</th>
                <th>ویرایش</th>
            </tr>
            <tbody>
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
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>
            <iframe width="100%" height="470px" src=""></iframe>
        </p>
    </div>
</div>
<script type="text/javascript">
    const resultBox = document.getElementById('resultBox');
    $(function() {
        $("#invoice_time").persianDatepicker({
            months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
            dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
            shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
            showGregorianDate: !1,
            persianNumbers: !0,
            formatDate: "YYYY/MM/DD",
            selectedBefore: !1,
            selectedDate: null,
            startDate: null,
            endDate: null,
            prevArrow: '\u25c4',
            nextArrow: '\u25ba',
            theme: 'default',
            alwaysShow: !1,
            selectableYears: null,
            selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            cellWidth: 25, // by px
            cellHeight: 20, // by px
            fontSize: 13, // by px
            isRTL: !1,
            calendarPosition: {
                x: 0,
                y: 0,
            },
            onShow: function() {},
            onHide: function() {},
            onSelect: function() {
                const date = ($("#invoice_time").attr("data-jdate"));

                console.log(date);

                var params = new URLSearchParams();
                params.append('getFactor', 'getFactor');
                params.append('date', date);
                axios.post("./factorAjax.php", params)
                    .then(function(response) {
                        console.log(response.data);
                        resultBox.innerHTML = response.data;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
            onRender: function() {}
        });
    });
    const element = document.getElementById('invoice_time');
</script>



<?php require_once './layout/heroFooter.php';
