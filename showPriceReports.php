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
                <input type="checkbox" checked="true" name="panel" id="<?php echo $code ?>" class="hidden">
                <label for="<?php echo $code ?>" class="relative flex items-center bg-gray-700 text-white p-4 shadow border-b border-grey hover:cursor-pointer">
                    <?php echo $code ?>
                </label>
                <div class="accordion__content overflow-hidden bg-grey-lighter">
                    <?php
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
                        <div class="grid grid-cols-1 md:grid-cols-10 gap-6 lg:gap-2 lg:p-2">

                            <!-- Start the code info section -->
                            <div class="bg-white rounded-lg">
                                <div id="search_result" class="rtl p-3">
                                    <p class="text-center text-sm bg-gray-600 text-white p-2 my-3 rounded-md">
                                        <?php echo $index; ?>
                                    </p>
                                    <?php if ($information) { ?>
                                        <div>
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
                            <div class="bg-white rounded-lg col-span-5 overflow-auto">
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
                                                <tr class="relative">
                                                    <td class=" px-1">
                                                        <p class="text-center bold bg-gray-600 text-white px-2 py-3">
                                                            <?php echo $goods[$index]['partnumber'] ?>
                                                        </p>
                                                    </td>
                                                    <td class="px-1 pt-2">
                                                        <table class="min-w-full text-sm font-light p-2">
                                                            <thead class="font-medium">
                                                                <tr>
                                                                    <?php foreach ($exist[$index] as $brand => $amount) {
                                                                    ?>
                                                                        <th scope="col" class="<?php echo $brand == 'GEN' || $brand == 'MOB' ? $brand : 'brand-default' ?> text-white text-center py-2 relative hover:cursor-pointer" data-key="<?php echo $index ?>" data-brand="<?php echo $brand ?>" onmouseover="seekExist(this)" onmouseleave="closeSeekExist(this)">
                                                                            <?php echo $brand ?>
                                                                            <div class="custome-tooltip" id="<?php echo $index . '-' . $brand ?>">
                                                                                <?php
                                                                                foreach ($stockInfo[$index][$brand] as $iterator => $item) {
                                                                                ?>
                                                                                    <div>
                                                                                        <?php if ($item !== 0) { ?>
                                                                                            <p><?php echo $iterator . ' : ' . $item ?></p>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </th>
                                                                    <?php } ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="py-3">
                                                                    <?php foreach ($exist[$index] as $brand => $amount) {
                                                                        $total = 0;
                                                                        foreach ($stockInfo[$index][$brand] as $iterator => $item) {
                                                                            $total += $item;
                                                                        } ?>
                                                                        <td class="<?php echo $brand == 'GEN' || $brand == 'MOB' ? $brand : 'brand-default' ?> whitespace-nowrap text-white px-3 py-2 text-center">
                                                                            <?php echo $total;
                                                                            ?>
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
                                                                        <td class="text-bold whitespace-nowrap px-3 py-2 text-center hover:cursor-pointer <?php echo $rate['status'] !== 'N' ? $rate['status'] : 'bg-gray-100' ?>" @click="$emit('setPrice', calculateRegular(props.relation.goods[key].price, rate.amount))">
                                                                            <?php
                                                                            $avgPrice = round(($goods[$index]['price'] * 110) / 243.5);

                                                                            echo round(
                                                                                $avgPrice * $rate['amount'] * 1.2 * 1.2 * 1.3
                                                                            ) ?>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php if ($goods[$index]['mobis'] > 0 && $goods[$index]['mobis'] !== '-') { ?>
                                                                    <tr class="bg-neutral-400">
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                        ?>
                                                                            <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" @click="$emit('setPrice', calculateMobies(props.relation.goods[key].price, rate.amount))">
                                                                                <?php
                                                                                echo round(
                                                                                    round(($goods[$index]['price'] * 110) / 243.5) *
                                                                                        $rate['amount'] *
                                                                                        1.25 *
                                                                                        1.3
                                                                                ) ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php if ($goods[$index]['korea'] > 0 && $goods[$index]['mobis'] !== '-') { ?>
                                                                    <tr class="bg-amber-600" v-if="props.relation.goods[key].korea > 0">
                                                                        <?php
                                                                        foreach ($rates as $rate) {
                                                                        ?>
                                                                            <td class="text-bold whitespace-nowrap px-3 text-center py-2 hover:cursor-pointer" v-for="rate in rates" @click="$emit('setPrice', calculateMobies(props.relation.goods[key].price, rate.amount))">

                                                                                <?php
                                                                                $avgPrice = round(($goods[$index]['price'] * 110) / 243.5);

                                                                                echo round(
                                                                                    $avgPrice * $rate['amount'] * 1.25 * 1.3
                                                                                ) ?>
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
                            <div class="bg-white rounded-lg shadow-md col-span-2 overflow-auto">
                                <div id="search_result" class="p-3">
                                    <table class=" min-w-full text-sm font-light">
                                        <thead>
                                            <tr class="min-w-full bg-green-600">
                                                <td class="text-white bold py-2 px-2 w-28">قیمت</td>
                                                <td class="text-white bold py-2 px-2 rtl">مشتری</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($givenPrice[0] !== null) {
                                            ?>
                                                <?php foreach ($givenPrice as $price) { ?>
                                                    <?php if ($price['price']) { ?>
                                                        <tr class="min-w-full mb-1  <?php echo array_key_exists("ordered", $price) ? 'bg-red-400 hover:cursor-pointer' : 'bg-indigo-200' ?>" data-price='<?php echo $price['price'] ?>' onclick="price.ordered && $emit('setPrice', price.price)">

                                                            <td scope="col" class="text-gray-800 px-2 py-1 <?php echo array_key_exists("ordered", $price) ? 'text-white' : '' ?>">
                                                                <?php echo $price['price'] === null ? 'ندارد' : $price['price']  ?>
                                                            </td>
                                                            <td scope="col" class="text-gray-800 px-2 py-1 rtl <?php echo array_key_exists("ordered", $price) && 'text-white' ? 'text-white' : '' ?>">
                                                                <?php if (array_key_exists("ordered", $price)) {
                                                                    echo 'قیمت دستوری';
                                                                } else {
                                                                    echo $price['name'];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="min-w-full mb-1 border-b-2 <?php echo array_key_exists("ordered", $price) ? 'bg-red-500' : 'bg-indigo-300' ?>" data-price='<?php echo $price['price'] ?>'>
                                                            <td class="<?php array_key_exists("ordered", $price) ? 'text-white' : '' ?> text-gray-800 px-2 tiny-text" colspan="3" scope="col">
                                                                <div class="rtl flex items-center w-full <?php echo array_key_exists("ordered", $price) ? 'text-white' : 'text-gray-800' ?>">
                                                                    <i class="px-1 material-icons tiny-text <?php echo array_key_exists("ordered", $price) ? 'text-white' : 'text-gray-800' ?>">access_time</i>
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
                                        <input type="text" hidden id="<? echo $partNumber ?>-store_price" name="store_price" value="store_price">
                                        <input type="text" hidden id="<? echo $partNumber ?>-partNumber" name="partNumber" value="<?php echo $partNumber ?>">
                                        <input type="text" hidden id="customer_id" name="customer_id" value="<?php echo $customer ?>">
                                        <div class="rtl col-span-6 sm:col-span-4">
                                            <label class="block font-medium text-sm text-gray-700">
                                                قیمت
                                            </label>
                                            <input required onkeyup="update_price(this)" name="price" class="ltr mt-1 block w-full border-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2" id="price" type="text" />
                                            <p class="mt-2"></p>
                                        </div>


                                        <div class="rtl">
                                            <button onclick="createRelation(this)" data-part="<?php echo $partNumber ?>" type="submit" class="tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                ثبت
                                            </button>
                                            <button onclick="createRelation(this)" data-part="<?php echo $partNumber ?>" type="submit" class="tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                نداریم !!!
                                            </button>
                                            <button onclick="createRelation(this)" data-part="<?php echo $partNumber ?>" type="submit" class="tiny-txt inline-flex items-center bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 px-2 py-2">
                                                ارسال به نیایش
                                            </button>
                                            <p id="form_success" class="px-3 tiny-text text-green-500 hidden">
                                                موفقانه در پایگاه داده ثبت شد!
                                            </p>
                                            <p id="form_error" class="px-3 tiny-text text-red-500 hidden">
                                                ذخیره سازی اطلاعات ناموفق بود!
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- END GIVEN PRICE SECTION -->
                            <div class="bg-white rounded-lg shadow-md col-span-2">
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
                    <?php } ?>
                </div>
            <?php
            }
            ?>
        </div>
        <script>
            const form_success = document.getElementById('form_success');
            const form_error = document.getElementById('form_error');
            let price = null;

            function update_price(element) {
                price = element.value;
            }

            // A function to create the relationship
            function createRelation(e) {
                // Accessing the form fields to get thier value for an ajax store operation
                const partNumber = e.getAttribute('data-part');
                const customer_id = document.getElementById('customer_id').value;

                // Defining a params instance to be attached to the axios request
                const params = new URLSearchParams();
                params.append('store_price', 'store_price');
                params.append('partNumber', partNumber);
                params.append('customer_id', customer_id);
                params.append('price', price);

                axios.post("./app/Controllers/GivenPriceAjax.php", params)
                    .then(function(response) {
                        console.log(response.data);
                        if (response.data == true) {
                            form_success.classList.remove('hidden');
                            setTimeout(() => {
                                form_success.classList.add('hidden');
                                location.reload();
                            }, 2000)
                        } else {
                            form_error.classList.remove('hidden');
                            setTimeout(() => {
                                form_error.classList.add('hidden');
                                location.reload();
                            }, 2000)
                        }
                    })
                    .catch(function(error) {

                    });
            }
        </script>
<?php
    }
} else {
    echo 'Customer is not valid';
}


require_once('./views/Layouts/footer.php');