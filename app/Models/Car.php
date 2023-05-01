<?php

namespace App\Models;

class Good
{
    public function all()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM cars";
        $result = $conn->query($sql)->fetch_assoc();
    }
}
