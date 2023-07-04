<?php
require_once './database/connect.php';
require_once('./views/Layouts/header.php');
require_once('./app/Controllers/GivenPriceHistoryController.php');
?>
<div class="rtl col-6 mx-auto">
    <table class="min-w-full text-left text-sm font-light custom-table mb-2">
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
            <tr class="relative">
                <td class=" px-1">
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

<?php
require_once('./views/Layouts/footer.php');
