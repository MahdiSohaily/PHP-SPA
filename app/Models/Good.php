<?php

namespace App\Models;

class Good
{
    public function search($pattern)
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


        $sql = "SELECT * FROM nisha WHERE partnumber LIKE '" . $pattern . "%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $partnumber = $row['partnumber'];
                $price = $row['price'];
                $mobis = $row['mobis'];
            }
        } else {
            echo '<tr id="error">
                <td colspan="15 fa">کد فنی اشتباه یا ناقص می باشد</td>
            </tr>';
        }

        $conn->close();
    }
}
