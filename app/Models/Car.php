<?php

namespace App\Models;

class Car
{
    public function all()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM cars";

        $result = mysqli_query($conn, $sql);

        while ($r = mysqli_fetch_assoc( $result)){
            $product_array[] = $r;
        }
        return $product_array;
    }
    
    public function search($pattern)
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $sql = "SELECT * FROM cars WHERE name LIKE '%$pattern%'";

        $result = mysqli_query($conn, $sql);

        while ($r = mysqli_fetch_assoc( $result)){
            $product_array[] = $r;
        }
        return $product_array;
    }
}
