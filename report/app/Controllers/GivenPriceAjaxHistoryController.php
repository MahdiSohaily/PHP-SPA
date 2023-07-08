<?php
require_once('../../database/connect.php');

if (isset($_POST['historyAjax'])) {
    $givenPrice = givenPrice($conn);

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

    <?php

}
function givenPrice($conn)
{
    $sql = "SELECT 
    prices.price, prices.partnumber, users.username,customer.id AS customerID, users.id as userID, prices.created_at, customer.name, customer.family
    FROM ((shop.prices 
    INNER JOIN callcenter.customer ON customer.id = prices.customer_id )
    INNER JOIN yadakshop1402.users ON users.id = prices.user_id)
    ORDER BY prices.created_at DESC LIMIT 200";
    $result = mysqli_query($conn, $sql);


    $givenPrices = [];
    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            array_push($givenPrices, $item);
        }
    }
    return  $givenPrices;
}
