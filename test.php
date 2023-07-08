<?php
 global $con;
$con = mysqli_connect('localhost','root','','callcenter');

if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con, "utf8");
 


 
$user = $_GET['user'];    
$callid = $_GET['callid'];    
 


$sql="INSERT INTO test (testbox,user) VALUES ('$callid', '$user');";
$result = mysqli_query($con,$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
  echo "done";
 
} 
    


?>
