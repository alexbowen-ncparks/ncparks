<?php

//session_start();

//if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}




//extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



//$database="budget";
//$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database 

$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
$k=array_rand($array);
$photo_location=$array[$k];

echo "photo_location=$photo_location";










?>