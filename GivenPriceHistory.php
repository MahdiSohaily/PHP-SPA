<?php
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
require_once('./app/Controllers/GivenPriceHistoryController.php');
?>
<!-- START NEWLY ADDED SECTION BY MAHDI REZAEI -->
<div id="child_three">
    <div class="rtl col-8 mx-auto">
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
            <tbody>
                <?php
                if (count($givenPrice) > 0) {
                ?>
                    <?php foreach ($givenPrice as $price) { ?>
                        <?php if ($price['price'] !== null) {
                        ?>
                            <tr class=" min-w-full mb-1 ?> odd:bg-gray-200">
                            <?php  } ?>
                            <td class="px-1">
                                <p class="text-right bold text-gray-700 px-2 py-1">
                                    <?php echo $price['name'] . ' ' . $price['family'] ?>
                                </p>
                            </td>
                            <td class="px-1">
                                <p class="text-right bold text-gray-700 px-2 py-1">
                                    <?php echo $price['price'] === null ? 'ندارد' : $price['price']  ?>
                                </p>
                            </td>
                            <td class="px-1">
                                <p class="text-right bold text-gray-700 px-2 py-1">
                                    <?php echo $price['partnumber']; ?>
                                </p>
                            </td>
                            <td style="width:120px;">
                                <p class="text-center bold text-gray-700 px-2 py-1">
                                    <img title="<?php echo $price['username'] ?>" class="userImage mx-auto" src="../../userimg/<?php echo $price['userID'] ?>.jpg" alt="userimage">
                                </p>
                            </td>
                            <td class="time">
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

                                    if ($minutes) {
                                        $text .= "$minutes دقیقه ";
                                    }

                                    if ($seconds) {
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
</div>
<script>
    setInterval(() => {
        var params = new URLSearchParams();
        params.append('search_goods_for_relation', 'search_goods_for_relation');
        params.append('pattern', pattern);

        if (pattern.length > 6) {
            axios.post("./app/Controllers/RelationshipAjaxController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "کد فنی وارد شده فاقد اعتبار است";
        }
    }, 5000);
</script>

<?php
require_once('./views/Layouts/footer.php');
