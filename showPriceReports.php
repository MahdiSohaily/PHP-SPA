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

                    foreach ($existing_code as $index => $item) {
                        $partNumber = $index;
                        $information = $item['information'];
                        $relation = $item['relation'];
                        $exist =  $relation['existing'];
                        $givenPrice = array_key_exists("givenPrice", $item) ? $item['givenPrice'] : [];
                        $customer = $customer;
                        $completeCode = $completeCode;

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
