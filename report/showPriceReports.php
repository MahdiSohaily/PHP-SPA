<?php
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
require_once('./app/Controllers/GivenPriceController.php');


if ($isValidCustomer) {
    if ($finalResult) {
        $explodedCodes = $finalResult['explodedCodes'];
        $not_exist = $finalResult['not_exist'];
        $existing = $finalResult['existing'];
        $customer = $finalResult['customer'];
        $completeCode = $finalResult['completeCode'];
        $notification = $finalResult['notification'];
        $rates = $finalResult['rates'];
?>
        <div class="grid grid-cols-6">
            <div class="m-2 p-3 col-span-2 bg-gray-500 relative">
                <table class="min-w-full text-sm font-light p-2">
                    <thead class="font-medium">
                        <tr>
                            <th class="text-left px-3 py-2">کد فنی</th>
                            <th class="text-left px-3 py-2">قیمت</th>
                            <th class="text-right  py-2">
                                <i title="کاپی کردن مقادیر" onclick="copyPrice(this)" class="text-sm material-icons hover:cursor-pointer">content_copy</i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="priceReport">
                        <?php
                        foreach ($explodedCodes as $code) { ?>
                            <tr class="odd:bg-gray-400">
                                <td class="px-3 py-2 text-left text-white"><?php echo $code ?></td>
                                <td class="px-3 py-2 text-left text-white" colspan="2" id="<?php echo $code . '-append' ?>"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="rtl col-span-4 flext justify-end">
                <table class="mx-auto col-6 text-sm font-light custom-table mb-2">
                    <thead class="font-medium bg-green-600">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                نام
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                نام خانوادگی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                شماره تماس
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                ماشین
                            </th>
                            <th scope="col" class="px-3 py-3 text-white text-center">
                                آدرس
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="odd:bg-gray-500relative">
                            <td class="px-1">
                                <p class="text-center bold text-gray-700 px-2 py-3">
                                    <?php echo $customer_info['name'] ?>
                                </p>
                            </td>
                            <td class=" px-1">
                                <p class="text-center bold text-gray-700 px-2 py-3">
                                    <?php echo $customer_info['family'] ?>
                                </p>
                            </td>
                            <td class=" px-1">
                                <p class="text-center bold text-gray-700 px-2 py-3">
                                    <?php echo $customer_info['phone'] ?>
                                </p>
                            </td>
                            <td class=" px-1">
                                <p class="text-center bold text-gray-700 px-2 py-3">
                                    <?php echo $customer_info['car'] ?>
                                </p>
                            </td>
                            <td class=" px-1">
                                <p class="text-center bold text-gray-700 px-2 py-3">
                                    <?php echo $customer_info['address'] ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="accordion">
            <?php
            foreach ($explodedCodes as $code_index => $code) {
            ?>
                <input type="checkbox" checked="true" name="panel" id="<?php echo $code ?>" class="hidden">
                <label for="<?php echo $code ?>" class="relative flex items-center bg-gray-700 text-white p-4 shadow border-b border-grey hover:cursor-pointer">
                    <?php echo $code ?>
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <?php
                    if (array_key_exists($code, $existing)) {
                        foreach ($existing[$code] as $index => $item) {
                            $partNumber = $index;
                            $information = $item['information'];
                            $relation = $item['relation'];
                            $goods =  $relation['goods'];
                            $exist =  $relation['existing'];
                            $sorted =  $relation['sorted'];
                            $stockInfo =  $relation['stockInfo'];
                            $givenPrice =  $item['givenPrice'];
                            $estelam = $item['estelam'];
                            $customer = $customer;
                            $completeCode = $completeCode;
                    ?>
                            <div class="grid grid-cols-1 grid-cols-1 lg:grid-cols-10 gap-6 lg:gap-2 lg:p-2 overflow-auto">

                                <!-- Start the code info section -->
                                <div class="min-w-full bg-white rounded-lg col-span-1 overflow-auto shadow-md mt-2">
                                    <div class="rtl p-3">
                                        <p style="font-size: 0.8rem;" class="text-left bg-gray-600 text-white p-2 my-3 rounded-md">
                                            <?php echo $index; ?>
                                        </p>
                                        <?php if ($information) { ?>
                                            <div>
                                                <p class="my-2">قطعه: <?php echo $information['relationInfo']['name'] ?></p>
                                                <?php if (array_key_exists("status_name", $information['relationInfo'])) { ?>
                                                    <p class="my-2">وضعیت: <?php echo  $information['relationInfo']['status_name'] ?></p>
                                                <?php } ?>
                                                <ul>
                                                    <?php foreach ($information['cars'] as $item) {
                                                    ?>
                                                        <li class="" v-for="elem in relationCars">
                                                            <?php echo $item ?>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <?php if ($information['relationInfo']['description'] !== '' && $information['relationInfo']['description'] !== null) { ?>
                                                    <p>توضیحات:</p>
                                                    <p class="bg-red-500 text-white rounded-md p-2 shake">
                                                        <?php echo $information['relationInfo']['description'] ?>
                                                    </p>
                                                <?php } ?>
                                            </div>
                                        <?php } else {
                                        ?>
                                            <p v-else>
                                                رابطه ای پیدا نشد
                                            </p>
                                        <?php } ?>

                                    </div>
                                </div>

                                <!-- ENd the code info section -->
                                <div class="min-w-full bg-white rounded-lg col-span-5 overflow-auto shadow-md">
                                    <div class="p-3">
                                        <table class="min-w-full text-left text-sm font-light custom-table">
                                            <thead class="font-medium bg-green-600">
                                                <tr>
                                                    <th scope="col" class="px-3 py-3 text-white text-center">
                                                        شماره فنی
                                                    </th>
                                                    <th scope="col" class="px-3 py-3 text-white text-center">
                                                        مقدار موجودی
                                                    </th>
                                                    <th scope="col" class="px-3 py-3 text-white text-center">
                                                        قیمت به اساس نرخ ارز
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($sorted as $index => $element) {
                                                ?>
                                                    <tr>
                                                        <td class="relative px-1 hover:cursor-pointer" data-part="<?php echo $goods[$index]['partnumber'] ?>" onmouseleave="hideToolTip(this)" onmouseover="showToolTip(this)">
                                                            <p class="text-center bold bg-gray-600 text-white px-2 py-3">
                                                                <?php echo $goods[$index]['partnumber'] ?>
                                                            </p>
                                                            <div class="custome-tooltip-2" id="<?php echo $goods[$index]['partnumber'] . '-google' ?>">
                                                                <a target='_blank' href='https://www.google.com/search?tbm=isch&q=<?php echo $goods[$index]['partnumber'] ?>'>
                                                                    <img class="w-5 h-auto" src="./public/img/google.png" alt="google">
                                                                </a>
                                                                <a target='_blank' href='https://partsouq.com/en/search/all?q=<?php echo $goods[$index]['partnumber'] ?>'>
                                                                    <img class="w-5 h-auto" src="./public/img/part.png" alt="part">
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="px-1 pt-2">
                                                            <table class="min-w-full text-sm font-light p-2">
                                                                <thead class="font-medium">
                                                                    <tr>
                                                                        <?php
                                                                        if (array_sum($exist[$index]) > 0) {
                                                                            foreach ($exist[$index] as $brand => $amount) {
                                                                                if ($amount > 0) { ?>
                                                                                    <th scope="col" class="<?php echo $brand == 'GEN' || $brand == 'MOB' ? $brand : 'brand-default' ?> text-white text-center py-2 relative hover:cursor-pointer" data-key="<?php echo $index ?>" data-brand="<?php echo $brand ?>" onmouseover="seekExist(this)" onmouseleave="closeSeekExist(this)">
                                                                                        <?php echo $brand ?>
                                                                                        <div class="custome-tooltip" id="<?php echo $index . '-' . $brand ?>">
                                                                                            <table class="min-w-full text-sm font-light p-2">
                                                                                                <thead class="font-medium bg-violet-800">
                                                                                                    <tr>
                                                                                                        <th class="text-right px-3 py-2 tiny-text">فروشنده</th>
                                                                                                        <th class="text-right px-3 py-2 tiny-text">مقدار موجود</th>
                                                                                                        <th class="text-right px-3 py-2 tiny-text">تاریخ</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <?php
                                                                                                    foreach ($stockInfo[$index][$brand] as $iterator => $item) {
                                                                                                    ?>
                                                                                                        <?php if ($item !== 0) { ?>
                                                                                                            <tr class="odd:bg-gray-500 bg-gray-600">
                                                                                                                <td class="px-3 py-2 tiny-text text-right"><?php echo $iterator ?></td>
                                                                                                                <td class="px-3 py-2 tiny-text text-right"><?php echo $item ?></td>
                                                                                                                <td class="px-3 py-2 tiny-text text-right"><?php echo date('Y-m-d') ?></td>
                                                                                                            </tr>
                                                                                                        <?php } ?>
                                                                                                    <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </th>
                                                                        <?php }
                                                                            }
                                                                        } else {
                                                                            echo '<p class="text-red-400 text-center bold"> در حال حاضر موجود نیست </p>';
                                                                        } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="py-3">
                                                                        <?php foreach ($exist[$index] as $brand => $amount) {
                                                                            if ($amount > 0) {
                                                                                $total = 0;
                                                                                foreach ($stockInfo[$index][$brand] as $iterator => $item) {
                                                                                    $total += $item;
                                                                                } ?>
                                                                                <td class="<?php echo $brand == 'GEN' || $brand == 'MOB' ? $brand : 'brand-default' ?> whitespace-nowrap text-white px-3 py-2 text-center">
                                                                                    <?php echo $total;
                                                                                    ?>
                                                                                </td>
                                                                        <?php }
                                                                        } ?>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td class="px-1 pt-2">
                                                            <table class="min-w-full text-left text-sm font-light">
                                                                <thead class="font-medium">
                                                                    <tr>
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                        ?>
                                                                            <th v-for="rate in rates" scope="col" class="text-gray-800 text-center py-2 <?php echo $rate['status'] !== 'N' ? $rate['status'] : 'bg-green-700' ?>">
                                                                                <?php echo $rate['amount'] ?>
                                                                            </th>
                                                                        <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr class="py-3">
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                            $price = doubleval($goods[$index]['price']);
                                                                            $price = str_replace(",", "", $price);
                                                                            $avgPrice = round(($price * 110) / 243.5);
                                                                            $finalPrice = round($avgPrice * $rate['amount'] * 1.2 * 1.2 * 1.3);
                                                                        ?>
                                                                            <td class="text-bold whitespace-nowrap px-3 py-2 text-center hover:cursor-pointer <?php echo $rate['status'] !== 'N' ? $rate['status'] : 'bg-gray-100' ?>" onclick="setPrice(this)" data-code="<?php echo $code ?>" data-price="<?php echo $finalPrice ?>" data-part="<?php echo $partNumber ?>">
                                                                                <?php echo $finalPrice ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php if ($goods[$index]['mobis'] > 0 && $goods[$index]['mobis'] !== '-') { ?>
                                                                        <tr class="bg-neutral-400">
                                                                            <?php
                                                                            foreach ($rates as $rate) {
                                                                                $price = doubleval($goods[$index]['mobis']);
                                                                                $price = str_replace(",", "", $price);
                                                                                $avgPrice = round(($price * 110) / 243.5);
                                                                                $finalPrice = round($avgPrice * $rate['amount'] * 1.25 * 1.3)

                                                                            ?>
                                                                                <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" onclick="setPrice(this)" data-code="<?php echo $code ?>" data-price="<?php echo $finalPrice ?>" data-part="<?php echo $partNumber ?>">

                                                                                    <?php echo  $finalPrice ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($goods[$index]['korea'] > 0 && $goods[$index]['mobis'] !== '-') { ?>
                                                                        <tr class="bg-amber-600" v-if="props.relation.goods[key].korea > 0">
                                                                            <?php
                                                                            foreach ($rates as $rate) {
                                                                                $price = doubleval($goods[$index]['korea']);
                                                                                $price = str_replace(",", "", $price);
                                                                                $avgPrice = round(($price * 110) / 243.5);
                                                                                $finalPrice = round($avgPrice * $rate['amount'] * 1.25 * 1.3)

                                                                            ?>
                                                                                <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" onclick="setPrice(this)" data-code="<?php echo $code ?>" data-price="<?php echo $finalPrice ?>" data-part="<?php echo $partNumber ?>">

                                                                                    <?php echo  $finalPrice ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Given Price section -->
                                <div class="min-w-full bg-white rounded-lg col-span-2 overflow-auto shadow-md">
                                    <div class="p-3">
                                        <table class=" min-w-full text-sm font-light">
                                            <thead>
                                                <tr class="min-w-full bg-green-600">
                                                    <td class="text-white bold text-center py-2 px-2 w-28">قیمت</td>
                                                    <td class="text-white bold text-center py-2 px-2 rtl">مشتری</td>
                                                    <td class="text-white bold text-center py-2 px-2 rtl">کد فنی</td>
                                                    <td class="text-white bold text-center py-2 px-2 rtl">کاربر</td>
                                                </tr>
                                            </thead>
                                            <tbody id="price-<?php echo $partNumber ?>">
                                                <?php if ($givenPrice !== null) {
                                                ?>
                                                    <?php foreach ($givenPrice as $price) { ?>
                                                        <?php if ($price['price'] !== null && $price['price'] !== '') {
                                                            if (array_key_exists("ordered", $price) || $price['customerID'] == 1) { ?>
                                                                <tr class="min-w-full mb-1  bg-red-400 hover:cursor-pointer" onclick="setPrice(this)" data-code="<?php echo $code ?>" data-price="<?php echo $price['price'] ?>" data-part="<?php echo $partNumber ?>">
                                                                <?php } else { ?>
                                                                <tr class="min-w-full mb-1  bg-indigo-200 hover:cursor-pointer" onclick="setPrice(this)" data-code="<?php echo $code ?>" data-price="<?php echo $price['price'] ?>" data-part="<?php echo $partNumber ?>">
                                                                <?php  } ?>
                                                                <td scope="col" class="text-center text-gray-800 px-2 py-1 <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                                                                    <?php echo $price['price'] === null ? 'ندارد' : $price['price']  ?>
                                                                </td>
                                                                <td scope="col" class="text-center text-gray-800 px-2 py-1 rtl <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                                                                    <?php if (array_key_exists("ordered", $price)) {
                                                                        echo 'قیمت دستوری';
                                                                    } else {
                                                                        echo $price['name'] . ' ' . $price['family'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="bold <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?> ">
                                                                    <?php echo array_key_exists("partnumber", $price) ? $price['partnumber'] : '' ?>
                                                                </td>
                                                                <td scope="col" class="text-center text-gray-800 px-2 py-1 rtl <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : '' ?>">
                                                                    <?php if (!array_key_exists("ordered", $price)) {
                                                                    ?>
                                                                        <img class="userImage" src="../../userimg/<?php echo $price['userID'] ?>.jpg" alt="userimage">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                                </tr>
                                                                <tr class="min-w-full mb-1 border-b-2 <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'bg-red-500' : 'bg-indigo-300' ?>" data-price='<?php echo $price['price'] ?>'>
                                                                    <td></td>
                                                                    <td class="<?php array_key_exists("ordered", $price) ? 'text-white' : '' ?> text-gray-800 px-2 tiny-text" colspan="3" scope="col">
                                                                        <div class="rtl flex items-center w-full <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : 'text-gray-800' ?>">
                                                                            <i class="px-1 material-icons tiny-text <?php echo array_key_exists("ordered", $price) || $price['customerID'] == 1 ? 'text-white' : 'text-gray-800' ?>">access_time</i>
                                                                            <?php
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
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                        <?php }
                                                    } ?>
                                                    <?php } else { ?>
                                                        <tr class="min-w-full mb-4 border-b-2 border-white">
                                                            <td colspan="3" scope="col" class="text-gray-800 py-2 text-center bg-indigo-300">
                                                                !! موردی برای نمایش وجود ندارد
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                            </tbody>
                                        </table>
                                        <br>
                                        <form action="" method="post" onsubmit="event.preventDefault()">

                                            <?php
                                            date_default_timezone_set("Asia/Tehran"); ?>
                                            <input type="text" hidden name="store_price" value="store_price">
                                            <input type="text" hidden name="partNumber" value="<?php echo $partNumber ?>">
                                            <input type="text" hidden id="customer_id" name="customer_id" value="<?php echo $customer ?>">
                                            <input type="text" hidden id="notification_id" name="notification_id" value="<?php echo $notification_id ?>">
                                            <div class="rtl col-span-6 sm:col-span-4">
                                                <label class="block font-medium text-sm text-gray-700">
                                                    قیمت
                                                </label>
                                                <input onkeyup="update_price(this)" name="price" class="ltr price-input-custome mt-1 block w-full border-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="<?php echo $partNumber ?>-price" data-code="<?php echo $code ?>" type="text" />
                                                <p class="mt-2"></p>
                                            </div>


                                            <div class="rtl">
                                                <button onclick="createRelation(this)" data-part="<?php echo $partNumber ?>" type="submit" class="disabled:cursor-not-allowed  disabled:bg-gray-500 tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                    ثبت قیمت
                                                </button>
                                                <button onclick="donotHave(this)" data-code="<?php echo $code ?>" data-part="<?php echo $partNumber ?>" type="submit" class="disabled:cursor-not-allowed  disabled:bg-gray-500 tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                    موجود نیست
                                                </button>
                                                <button onclick="askPrice(this)" data-user="<?php echo $_SESSION['user_id'] ?>" data-part="<?php echo $partNumber ?>" type="button" class="disabled:cursor-not-allowed  disabled:bg-gray-500 tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                    ارسال به نیایش
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- END GIVEN PRICE SECTION -->
                                <div class="min-w-full bg-white rounded-lg col-span-2 overflow-auto shadow-md">
                                    <div class="p-3">
                                        <table class=" min-w-full text-sm font-light">
                                            <thead>
                                                <tr class="min-w-full bg-green-600">
                                                    <td class="text-white bold py-2 px-2 w-28">قیمت</td>
                                                    <td class="text-white bold py-2 px-2 rtl">مشتری</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($estelam) > 0) {

                                                    foreach ($estelam as $price) {
                                                        if ($price['price']) { ?>
                                                            <tr class="min-w-full mb-1 hover:cursor-pointer bg-indigo-200" data-price="<?php echo $price['price'] ?>">

                                                                <td scope="col" class="text-gray-800 px-2 py-1">
                                                                    <?php echo $price['price'] === null ? 'ندارد' : $price['price'] ?>
                                                                </td>
                                                                <td scope="col" class="text-gray-800 px-2 py-1 rtl">
                                                                    <?php echo $price['name']  ?>
                                                                </td>
                                                            </tr>
                                                            <tr class="min-w-full mb-1 hover:cursor-pointer border-b-2 bg-indigo-300" data-price="<?php echo $price['price'] ?>">
                                                                <td colspan="3" scope="col" class="text-gray-800 px-2 tiny-text ">
                                                                    <div class="rtl flex items-center w-full">
                                                                        <i class="px-1 material-icons tiny-text ">access_time</i>
                                                                        <?php
                                                                        $create = date($price['time']);

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
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    }
                                                } else { ?>
                                                    <tr class="min-w-full mb-4 border-b-2 border-white">
                                                        <td colspan="3" scope="col" class="text-white py-2 text-center bg-indigo-300">
                                                            !! موردی برای نمایش وجود ندارد
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="bg-white rounded-lg overflow-auto mb-3 py-4">
                            <p class="text-center">کد مد نظر در سیستم موجود نیست</p>
                        </div>
                    <?php } ?>
                </div>
            <?php
            }
            ?>
            <p id="form_success" class="custome-alert success px-3 tiny-text">
                ! موفقانه در پایگاه داده ثبت شد
            </p>
            <p id="form_error" class=" custome-alert error px-3 tiny-text">
                ! ذخیره سازی اطلاعات ناموفق بود
            </p>
        </div>
        <script>
            // Global controllers for operations messages
            const form_success = document.getElementById('form_success');
            const form_error = document.getElementById('form_error');
            // Global price variable
            let price = null;

            // A function to update the global price while typing in the input feild
            function update_price(element) {
                price = element.value;
                const partNumber = element.getAttribute('data-code').split('-')[0];
                const target = document.getElementById(partNumber + '-append');

                target.innerHTML = price;
            }

            // A function to set the price to we don't have
            function donotHave(element) {
                element.disabled = true;
                element.innerHTML = 'ثبت شد';

                setTimeout(() => {
                    element.disabled = false;
                    element.innerHTML = 'موجود نیست';
                }, 5000);

                price = 'موجود نیست';
                part = element.getAttribute('data-part');
                const input = document.getElementById(part + '-price');
                input.value = price;
                const partNumber = element.getAttribute('data-code').split('-')[0];
                const target = document.getElementById(partNumber + '-append');
                target.innerHTML = price;
                createRelation(element);
                input.value = null;
            }

            // A function to send a request in order to ask the price for specific code
            function askPrice(element) {

                element.disabled = true;
                element.innerHTML = 'ارسال شد';

                setTimeout(() => {
                    element.disabled = false;
                    element.innerHTML = 'ارسال به نیایش';
                }, 5000);

                // Accessing the form fields to get thier value for an ajax store operation
                const partNumber = element.getAttribute('data-part');
                const user_id = element.getAttribute('data-user');
                const customer_id = document.getElementById('customer_id').value;

                const params = new URLSearchParams();
                params.append('askPrice', 'askPrice');
                params.append('partNumber', partNumber);
                params.append('customer_id', customer_id);
                params.append('user_id', user_id);

                axios.post("./app/Controllers/GivenPriceAjax.php", params)
                    .then(function(response) {
                        if (response.data == true) {
                            form_success.style.bottom = '10px';
                            setTimeout(() => {
                                form_success.style.bottom = '-300px';
                            }, 2000)
                        } else {
                            form_error.style.bottom = '10px';
                            setTimeout(() => {
                                form_error.style.bottom = '-300px';
                            }, 2000)
                        }
                    })
                    .catch(function(error) {});
            }

            // A function to create the relationship
            function createRelation(e) {

                e.disabled = true;

                setTimeout(() => {
                    e.disabled = false;
                }, 5000);

                // Accessing the form fields to get thier value for an ajax store operation
                const partNumber = e.getAttribute('data-part');
                const customer_id = document.getElementById('customer_id').value;
                const notification_id = document.getElementById('notification_id').value;

                const goodPrice = document.getElementById(partNumber + '-price').value;
                const resultBox = document.getElementById('price-' + partNumber);

                // Defining a params instance to be attached to the axios request
                const params = new URLSearchParams();
                params.append('store_price', 'store_price');
                params.append('partNumber', partNumber);
                params.append('customer_id', customer_id);
                params.append('notification_id', notification_id);
                params.append('price', goodPrice);

                axios.post("./app/Controllers/GivenPriceAjax.php", params)
                    .then(function(response) {
                        if (response.data) {
                            form_success.style.bottom = '10px';
                            goodPrice.value = null;
                            setTimeout(() => {
                                form_success.style.bottom = '-300px';
                                resultBox.innerHTML = (response.data);
                            }, 2000)
                        } else {
                            form_error.style.bottom = '10px';
                            setTimeout(() => {
                                form_error.style.bottom = '-300px';
                                location.reload();
                            }, 2000)
                        }
                    })
                    .catch(function(error) {

                    });
            }

            // A function to set the price while cliking on the prices table
            function setPrice(element) {
                newPrice = element.getAttribute('data-price');
                part = element.getAttribute('data-part');
                const input = document.getElementById(part + '-price');
                input.value = newPrice;
                price = newPrice;


                const partNumber = element.getAttribute('data-code').split('-')[0];
                const target = document.getElementById(partNumber + '-append');
                target.innerHTML = price;
            }

            // A function to copy content to cliboard
            function copyPrice(elem) {
                // Get the text field
                let parentElement = document.getElementById("priceReport");

                let tdElements = parentElement.getElementsByTagName('td');
                let tdTextContent = [];

                for (let i = 0; i < tdElements.length; i++) {

                    let text = tdElements[i].textContent;
                    tdTextContent.push(text);
                }

                const chunkSize = 2;

                let finalResult = []
                for (let i = 0; i < tdTextContent.length; i += chunkSize) {
                    finalResult.push(tdTextContent.slice(i, i + chunkSize));
                }

                // Copy the text inside the text field

                let text = '';
                for (let item of finalResult) {
                    text += item.join(' : ');
                    text += '\n';
                }
                copyToClipboard(text);

                // Alert the copied text
                elem.innerHTML = `done`;
                setTimeout(() => {
                    elem.innerHTML = `content_copy`;
                }, 1500);

            }
        </script>
<?php
    }
} else {
    echo "<p class='rtl col-6 mx-auto flex items-center justify-center h-full'>کاربر درخواست دهنده و یا مشتری مشخص شده معتبر نمی باشد</p>";
}

require_once('./views/Layouts/footer.php');
