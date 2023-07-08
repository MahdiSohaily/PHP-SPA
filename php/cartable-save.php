<?php
 
require_once("db.php"); 

$value1 = $_GET['cartable-pos'];
$value2 = $_GET['phone']; 

 $instructor ="";
 $instructor2 ="";


if (isset($_GET['label']) || !empty($_GET['label']))
{
   foreach ($_GET['label'] as $value3) {
            $instructor.= $value3.",";
        }
}
else {
    
    $instructor = NULL;
}



if (isset($_GET['userselector']) || !empty($_GET['userselector']))
{
   foreach ($_GET['userselector'] as $value4) {
            $instructor2.= $value4.",";
        }
}
else {
    
    $instructor2 = NULL;
}



 

$sql="UPDATE customer SET cartable='$value1',label='$instructor',user='$instructor2' WHERE phone LIKE '$value2' ";

 
$result = mysqli_query($con,$sql);
if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
echo 'تغیرات برای مشتری با شماره  '.$value2.' با موفقیت انجام شد'; 
} 








 
 
mysqli_close($con);
?>
