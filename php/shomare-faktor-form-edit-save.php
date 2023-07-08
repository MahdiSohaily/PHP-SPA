<?php
 
 require_once("function.php");

$value1 = $_GET['id'];
$value2 = $_GET['kharidar'];
$value3 = $_GET['user'];
 

 

 


$sql="UPDATE shomarefaktor SET kharidar='$value2',user='$value3' WHERE id = '".$value1."'";
$result = mysqli_query(dbconnect(),$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
    echo "تغییرات با موفقیت انجام شد.";


} 
 

?>
