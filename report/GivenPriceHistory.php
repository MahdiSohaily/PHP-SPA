<?php
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
require_once('./app/Controllers/GivenPriceHistoryController.php');
function format_interval(DateInterval $interval)
{
    $result = "";
    if ($interval->y) {
        $result .= $interval->format("%y سال ");
    }
    if ($interval->m) {
        $result .= $interval->format("%m ماه ");
    }
    if ($interval->d) {
        $result .= $interval->format("%d روز ");
    }
    if ($interval->h) {
        $result .= $interval->format("%h ساعت ");
    }
    if ($interval->i) {
        $result .= $interval->format("%i دقیقه ");
    }
    if ($interval->s) {
        $result .= $interval->format("%s ثانیه ");
    }
    $result .= "قبل";
    return $result;
}
?>
<!-- START NEWLY ADDED SECTION BY MAHDI REZAEI -->
<div class="row px-2">
    <div class="rtl col-5  mb-5">
        <h2 class="text-xl py-2 bold">آخرین قیمت های داده شده</h2>
        <table class="min-w-full text-left text-sm bg-white custom-table mb-2 p-3">
            <thead class="font-medium bg-green-600">
                <tr>
                    <th scope="col" class="px-3 py-2 text-white text-right">
                        مشتری
                    </th>
                    <th scope="col" class="px-3 py-2 text-white text-right">
                        قیمت
                    </th>
                    <th scope="col" class="px-3 py-2 text-white text-right">
                        کد فنی
                    </th>
                    <th scope="col" class="px-3 py-2 text-white text-center">
                        قیمت دهنده
                    </th>
                    <th scope="col" class="px-3 py-2 text-white text-right">
                        زمان
                    </th>
                </tr>
            </thead>
            <tbody id="resultBox">
                <?php
                if (count($givenPrice) > 0) {
                ?>
                    <?php foreach ($givenPrice as $price) { ?>
                        <?php if ($price['price'] !== null) {
                        ?>
                            <tr class=" min-w-full mb-1 ?> odd:bg-gray-200">
                            <?php  } ?>
                            <td class="tiny-text bold px-1">
                                <p class="text-right bold text-gray-700 px-2 py-1">
                                    <?php echo $price['name'] . ' ' . $price['family'] ?>
                                </p>
                            </td>
                            <td class="tiny-text bold px-1">
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
                                    <img title="<?php echo $price['username'] ?>" class="userImage mx-auto" src="../../userimg/<?php echo $price['userID'] ?>.jpg" alt="userimage">
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
    <div class="rtl col-7  mb-5">
        <h2 class="text-xl py-2 bold">آخرین استعلام ها</h2>
        <div class="box-keeper">

            <table class="min-w-full bg-white">
                <thead class=" font-medium bg-green-600">
                    <tr>
                        <th scope="col" class="px-3 py-2 text-white text-right">
                            مشتری
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-right">
                            تلفن
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-right">
                            اطلاعات استعلام
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-center">
                            کاربر
                        </th>
                        <th scope="col" class="px-3 py-2 text-white text-right">
                            زمان
                        </th>
                    </tr>
                </thead>

                <?php

                $sql2 = "SELECT * FROM callcenter.record ORDER BY  time DESC LIMIT 350  ";
                $result2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        $time = $row2['time'];
                        $callinfo = $row2['callinfo'];
                        $user = $row2['user'];
                        $phone = $row2['phone'];

                        $sql = "SELECT * FROM callcenter.customer WHERE phone LIKE '" . $phone . "%'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $name = $row['name'];
                                $family = $row['family']; ?>
                                <tr class=" min-w-full mb-1 ?> odd:bg-gray-200">
                                    <td class="tiny-text bold"><a target="_blank" href="../main.php?phone=<?php echo $phone ?>"><?php echo ($name . " " . $family) ?></a></td>
                                    <td><a target="_blank" href="../main.php?phone=<?php echo $phone ?>"><?php echo $phone ?></a></td>
                                    <td class="tiny-text bold record-info"><?php echo nl2br($callinfo) ?></td>
                                    <td class="tiny-text bold record-user"><img class="userImage" src="../../userimg/<?php echo $user ?>.jpg" />
                                <?php
                            }
                        }

                        date_default_timezone_set('Asia/Tehran');
                        $now = new DateTime(); // current date time
                        $date_time = new DateTime($time); // date time from string
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

                        $text = "$text قبل";

                                ?>
                                    </td>

                                    <td class="tiny-text bold record-time"><?php echo $text; ?></td>
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
</div>
<script>
    const resultBox = document.getElementById('resultBox');
    setInterval(() => {
        var params = new URLSearchParams();
        params.append('historyAjax', 'historyAjax');

        axios.post("./app/Controllers/GivenPriceAjaxHistoryController.php", params)
            .then(function(response) {
                resultBox.innerHTML = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });
    }, 5000);
</script>

<?php
require_once('./views/Layouts/footer.php');
