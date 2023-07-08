<?php
 require_once("function.php");
$sql="SELECT * FROM users";
$result = mysqli_query(dbconnect2(),$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      
    $val = $row['id'];
    $name =  $row['name'];
    $family =  $row['family'];
    $password =  $row['password'];
 
   if(strlen($password) > 1 && strlen($name) > 1 ){
        echo ' <option value="'.$val.'">'.$name.' '.$family.'</option>';
 }
    }
}
