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
            for ($code_index = 0; $code_index < count($explodedCodes); $code_index++) {
            ?>
                <input type="checkbox" checked="true" name="panel" id="<?php echo $code_index ?>" class="hidden">
                <label for="<?php echo $code_index ?>" class="relative flex items-center bg-gray-700 text-white p-4 shadow border-b border-grey hover:cursor-pointer">
                    <?php echo $explodedCodes[$code_index] ?>
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    hello
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
