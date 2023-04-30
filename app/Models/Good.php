<?php

namespace App\Models;

class Good
{
    public function search($key, $mode, $rates)
    {
        $servername = "localhost";
        $username = "yadakcenter2";
        $password = "vZun$2*04Bo]";
        $dbname = "yadakcenter2_yadakinfo_price";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if ($mode) {
            $sql = "SELECT * FROM nisha WHERE partnumber LIKE '" . $key . "%'";
        } else {
            $sql = "SELECT * FROM nisha WHERE partnumber LIKE '" . $key . "%'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $partnumber = $row['partnumber'];
                $price = $row['price'];
                $Weight =  round($row['weight'], 2);
                $avgprice = round($price * 110 / 243.5);
                $mobis = $row['mobis'];

                if ($mobis == "0.00") {
                    $status = "NO-Price";
                } elseif ($mobis == "-") {
                    $status = "NO-Mobis";
                } elseif ($mobis == NULL) {
                    $status = "Requset";
                } else {
                    $status = "YES-Mobis";
                }
                $template = "<tr>
                <td class='blue part bold'> <div class='fix'>";
                if ($status == "Requset") {
                    $template .= " <a class='link-s Requset' target='_blank' href='" . URL_ROOT . URL_SUBFOLDER . '/mobis/' . $partnumber . "'>?</a>";
                } elseif ($status == "NO-Price") {
                    $template .= " <a class='link-s NO-Price' target='_blank' href='" . URL_ROOT . URL_SUBFOLDER . '/mobis/' . $partnumber . "'>!</a>";
                } elseif ($status == "NO-Mobis") {
                    $template .= " <a class='link-s NO-Mobis' target='_blank' href='" . URL_ROOT . URL_SUBFOLDER . '/mobis/' . $partnumber . "'>x</a>";
                } elseif ($status == "YES-Mobis") {
                    $template .= " <div class='empty'></div>";
                }

                $template .= "<span class='big'>$partnumber</span></div></td>
                <td >" . round($avgprice * 1.1) . "</td>
                <td class='orange' >" . round($avgprice * 1.2) . "</td>";

                $template .= $this->getPrice($avgprice, $rates);
                $template .= "
                <td class='action'>
                    <a target='_self' href='https://www.google.com/search?tbm=isch&q=$partnumber'>
                    <img class='social' src='./public/img/google.png' alt='google'>
                    </a>
                    <a msg='$partnumber'>
                    <img class='social' src='./public/img/tel.png' alt='part'>
                    </a>
                    <a target='_self' href='https://partsouq.com/en/search/all?q=$partnumber'>
                    <img class='social' src='./public/img/part.png' alt='part'>
                    </a>
                </td>
                <td class='kg'>
                    <div class='weight'>$Weight KG</div>
                </td>
            </tr> ";

                if ($status == "YES-Mobis") {
                    $price = $row['mobis'];
                    $price = str_replace(",", "", $price);
                    $avgprice = round($price * 110 / 243.5);
                    $template .= "<tr class='mobis'>
                <td class='part text-white bold'><span class='left'> $partnumber-M</span</td>
                <td class='bold'>" . round($avgprice) . "</td>
                <td>" . round($avgprice * 1.1) . "</td>
                ";
                    $template .= $this->getPriceMobis($avgprice, $rates);
                    $template .= "
                <td></td>
                <td></td>
            </tr>";
                }

                echo $template;
            }
        } else {
            echo '<tr id="error">
                <td colspan="15 fa">کد فنی اشتباه یا ناقص می باشد</td>
            </tr>';
        }

        $conn->close();
    }
}