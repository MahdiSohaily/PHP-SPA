<?php
require_once('./views/Layouts/header.php');

if (isset($_GET['partNumber'])) {
    $sql = "SELECT * FROM rates ORDER BY amount ASC";
    $rates = $conn->query($sql);
    $pattern = $_GET['partNumber'];
    $good_sql = "SELECT * FROM yadakshop1402.nisha WHERE partnumber LIKE '" . $pattern . "%'";
    $good = mysqli_query($conn, $good_sql);
    $row = mysqli_fetch_array($good);

    $result = checkMobis($pattern, $row, $conn);
}

function get_http_response_code($url)
{
    ini_set('user_agent', 'Mozilla/5.0');
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

function checkMobis($mobis, $good, $conn)
{
    $context = stream_context_create(array("http" => array("header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36")));

    $item = [];

    if (get_http_response_code("https://partsmotors.com/products/$mobis") != "200") {
        $update_sql = "UPDATE yadakshop1402.nisha SET mobis = '-' WHERE partnumber ='$mobis'";
        $conn->query($update_sql);
        return $item;
    } else {
        require_once 'simple_html_dom.php'; // A php file which converts the response text to HTML DOM

        $html = file_get_contents("https://partsmotors.com/products/$mobis", false, $context);

        $html = str_get_html($html);
        $price = null;
        foreach ($html->find('meta[property=og:price:amount]') as $element) {
            $price = $element->content;
        }

        $price = str_replace(",", "", $price);
        // Updating the current item mobis
        $update_sql = "UPDATE yadakshop1402.nisha SET mobis = '$price' WHERE partnumber = '$mobis'";
        $conn->query($update_sql);

        $item = [
            'id' => $good['id'],
            'partNumber' => $good['partnumber'],
            'price' => $price,
            'avgPrice' => round($price * 100 / 243.5 * 1.1),
        ];
    }
    return $item;
}
?>
<div class="py-14">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-100 bg-opacity-25">
            <div class="max-w-7xl overflow-x-auto mx-auto">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="font-medium dark:border-neutral-500">
                        <tr class="bg-green-700">
                            <th scope="col" class="px-3 py-3 bg-black text-white w-52 text-center">
                                شماره فنی
                            </th>
                            <th scope="col" class="px-3 py-3 text-white">
                                دلار پایین
                            </th>
                            <th scope="col" class="px-3 py-3 text-white">
                                دلار میانگین
                            </th>
                            <th scope="col" class="px-3 py-3 text-white border-black border-r-2">
                                دلار بالا
                            </th>

                            <?php
                            if ($rates->num_rows > 0) {
                                // output data of each row
                                while ($rate = $rates->fetch_assoc()) {
                                    echo "<th class='" . $rate['status'] . " px-3 py-3 text-white text-center ' scope='col'>" . $rate['amount'] . "</th>";
                                }
                            }
                            ?>
                            <th scope="col" class="px-3 py-3 text-white w-32 text-center">
                                عملیات
                            </th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <?php
                        if (count($result)) {
                        ?>
                            <tr v-if="result.length > 0" class="transition duration-300 ease-in-out bg-neutral-300">
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    <?php echo $result["partNumber"] ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    <?php echo round($result["avgPrice"] / 1.1)
                                    ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center font-bold">
                                    <?php echo round($result["avgPrice"]) ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-center">
                                    <?php echo round($result["avgPrice"] * 1.1) ?>
                                </td>
                                <?php
                                $sql = "SELECT * FROM rates ORDER BY amount ASC";
                                $rates = $conn->query($sql);
                                if ($rates->num_rows > 0) {
                                    // output data of each row
                                    while ($rate = $rates->fetch_assoc()) {
                                        echo "<th class='b-" . $rate['status'] . " px-3 py-3 text-center ' scope='col'>" . round(
                                            $result["avgPrice"] *
                                                $rate['amount'] *
                                                1.25 *
                                                1.3
                                        ) . "</th>";
                                    }
                                }
                                ?>
                                <td class="whitespace-nowrap w-24">
                                    <div class="flex justify-center gap-1 items-center px-2">
                                        <a target="_blank" :href="
                                                    'https://www.google.com/search?tbm=isch&q=<?php echo $item['partNumber'] ?>">
                                            <img class="w-5 h-auto" src="../../public/img/google.png" alt="google" />
                                        </a>
                                        <a msg="partNumber">
                                            <img class="w-5 h-auto" src="../../public/img/tel.png" alt="part" />
                                        </a>
                                        <a target="_blank" :href="
                                                    'https://www.google.com/search?tbm=isch&q=<?php echo $item['partNumber'] ?>">
                                            <img class="w-5 h-auto" src="../../public/img/part.png" alt="part" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr v-else class="transition duration-300 ease-in-out bg-neutral-200">
                                <td colspan="14" class="whitespace-nowrap px-3 py-3 text-center text-red-500 font-bold">
                                    <i class="material-icons text-red-500">mood_bad</i>
                                    <br />
                                    !این قطعه فاقد موبیز می باشد
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let result = null;

    const search = (val) => {
        let pattern = val;
        let superMode = 0;
        const resultBox = document.getElementById("results");

        if (document.getElementById("mode").checked) {
            superMode = 1;
        }

        if (
            (pattern.length > 4 && superMode == 1) ||
            (pattern.length > 6 && superMode == 0)
        ) {
            pattern = pattern.replace(/\s/g, "");
            pattern = pattern.replace(/-/g, "");
            pattern = pattern.replace(/_/g, "");

            resultBox.innerHTML = `<tr class=''>
                <td colspan='14' class='py-10 text-center'> 
                    <img class=' block w-10 mx-auto h-auto' src='./public/img/loading.png' alt='loading'>
                    </td>
            </tr>`;
            var params = new URLSearchParams();
            params.append('pattern', pattern);
            params.append('superMode', superMode);

            axios.post("./app/Controllers/SearchController.php", params)
                .then(function(response) {
                    resultBox.innerHTML = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        } else {
            resultBox.innerHTML = "";
        }
    };
</script>
<?php
require_once('./views/Layouts/footer.php');
