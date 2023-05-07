<?php

namespace App\Models;

class Status
{
    public function all()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM status";
        $result = $conn->query($sql);
        return $result;
    }
}
