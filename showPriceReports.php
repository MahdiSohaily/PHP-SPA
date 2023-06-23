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
        <div class="accordion mt-12">
            <?php
            foreach ($explodedCodes as $code_index => $code) {
            ?>
                <input type="checkbox" checked="true" name="panel" id="<?php echo $code_index ?>" class="hidden">
                <label for="<?php echo $code_index ?>" class="relative flex items-center bg-gray-700 text-white p-4 shadow border-b border-grey hover:cursor-pointer">
                    <?php echo $code ?>
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <?php
                    $code = $code;
                    $existing_code = $existing[$code];

                    foreach ($existing[$code] as $index => $item) {
                        $information = $existing[$code][$index]['information'];
                        $partNumber = $index;
                        //$existing[$code][$index]['relation']['goods'] = $existing[$code][$index]['relation']['goods'];
                        $exist = $existing[$code][$index]['relation']['existing'];
                        $givenPrice = array_key_exists("givenPrice", $existing[$code][$index]) ? $existing[$code][$index]['givenPrice'] : null;
                    ?>
                        <div class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">

                            <!-- Start the code info section -->
                            <div class="bg-white rounded-lg">
                                <div id="search_result" class="rtl p-3">
                                    <p class="text-center bg-gray-600 text-white p-2 my-3 rounded-md">
                                        <?php echo $partNumber; ?>
                                    </p>
                                    <?php if ($information) { ?>
                                        <div v-if="relationInfo">
                                            <p class="my-2">قطعه: <?php echo $information['relationInfo']['name'] ?></p>
                                            <p class="my-2">وضعیت: <?php echo array_key_exists("status_name", $information['relationInfo']) ? $information['relationInfo']['status_name'] : '' ?></p>
                                            <ul>
                                                <!-- <li class="" v-for="elem in relationCars">
                                                {{ elem.name }}
                                            </li> -->
                                            </ul>
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


                            <!-- Start of relations Details section -->
                            <div class="bg-white rounded-lg col-span-5 overflow-auto">
                                <div id="search_result" class="p-3">
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
                                            foreach ($existing[$code][$index]['relation']['sorted'] as $key => $element) {

                                            ?>
                                                <tr class="relative" v-for="element, key of props.relation.sorted">
                                                    <td class=" px-1">
                                                        <p class="text-center bold bg-gray-600 text-white px-2 py-3">
                                                            <?php echo$existing[$code][$index]['relation']['goods'][$key]['partnumber'] ?>
                                                        </p>

                                                    </td>
                                                    <td class="px-1 pt-2">
                                                        <table class="min-w-full text-sm font-light p-2">
                                                            <thead class="font-medium">
                                                                <tr>
                                                                    <?php
                                                                    foreach ($existing[$code][$index]['relation']['existing'][$key] as $index => $goodAmount) {
                                                                    ?>
                                                                        <th scope="col" class="<?php echo $index == 'GEN' || $index == 'MOB' ? $index : 'brand-default' ?> text-white text-center py-2 relative hover:cursor-pointer" data-key="<?php echo $key ?>" data-brand="<?php echo $index ?>" onmouseover="seekExist" onmouseleave="closeSeekExist">
                                                                            <?php echo $index ?>
                                                                            <div class="custome-tooltip" id="<?php echo $key + '-' + $index ?>">
                                                                                <?php
                                                                                foreach ($existing[$code][$index]['relation']['goods']['stockInfo'][$key][$index] as $iterator => $item) {
                                                                                ?>
                                                                                    <div>
                                                                                        <p v-if="item > 0"> <?php echo $iterator . ':' . $item ?></p>
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </th>
                                                                    <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="py-3">
                                                                    <?php foreach ($existing[$code][$index]['relation']['existing'][$key] as $index => $goodAmount) { ?>
                                                                        <td class="<?php echo $index == 'GEN' || $index == 'MOB' ? $index : 'brand-default' ?> whitespace-nowrap text-white px-3 py-2 text-center">
                                                                            <?php echo $goodAmount ?>
                                                                        </td>
                                                                    <?php } ?>
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
                                                                    ?>
                                                                        <td class="text-bold whitespace-nowrap px-3 py-2 text-center hover:cursor-pointer <?php echo $rate['status'] !== 'N' ? $rate['status'] : 'bg-gray-100' ?>" v-for="rate in rates" @click="$emit('setPrice', calculateRegular(props.relation.goods[key].price, rate.amount))">
                                                                            <?php echo round(
                                                                                round(($existing[$code][$index]['relation']['goods']['goods'][$key]['price'] * 110) / 243.5) *
                                                                                    $rate['amount'] *
                                                                                    1.2 *
                                                                                    1.2 *
                                                                                    1.3
                                                                            ) ?>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php
                                                                if ($existing[$code][$index]['relation'][$key]['mobis'] > 0 && $existing[$code][$index]['relation']['goods']['goods'][$key]['mobis'] !== '-') {
                                                                ?>
                                                                    <tr class="bg-neutral-400" v-if="">
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                        ?>
                                                                            <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" @click="$emit('setPrice', calculateMobies(props.relation.goods[key].price, rate.amount))">
                                                                                <?php echo round(
                                                                                    round(($existing[$code][$index]['relation']['goods']['goods'][$key]['price'] * 110) / 243.5) *
                                                                                        $rate['amount'] *
                                                                                        1.25 *
                                                                                        1.3
                                                                                ) ?>

                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                <?php }

                                                                if ($existing[$code][$index]['relation']['goods']['goods'][$key]['korea'] > 0) {
                                                                ?>
                                                                    <tr class="bg-amber-600">
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                        ?>
                                                                            <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" @click="$emit('setPrice', calculateMobies(props.relation.goods[key].price, rate.amount))">
                                                                                <?php echo round(
                                                                                    round(($existing[$code][$index]['relation']['goods']['goods'][$key]['price'] * 110) / 243.5) *
                                                                                        $rate['amount'] *
                                                                                        1.25 *
                                                                                        1.3
                                                                                ) ?> </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php
            }
            ?>
        </div>
<?php
    }
} else {
    echo 'Customer is not valid';
}

require_once('./views/Layouts/footer.php');
