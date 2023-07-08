<?php

require_once("db.php"); 

$value1 = $_GET['kharidar'];
$value2 =  $_SESSION["id"];
 

 
 
 
       
       
 
 $sql2="SELECT MAX(shomare) AS invnum FROM shomarefaktor;";
       
    $result2 = mysqli_query($con,$sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
        $invnum = $row2['invnum'] + 1;
    }
    
    




$sql="INSERT INTO shomarefaktor (kharidar,user,shomare) VALUES ('$value1', '$value2','$invnum');";
$result = mysqli_query($con,$sql);
 





 if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
echo 'شماره فاکتور <div onClick="copyToClipboard('.$invnum.')" class="shomare-faktor-copy"><i class="fas fa-paste"></i> '.$invnum.'</div> با موفقیت برای <strong  class="shomare-faktor-name">'.$value1.'</strong> ثبت شد'     ;

} 


 
