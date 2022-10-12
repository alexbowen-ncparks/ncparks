<?php
//echo "hello connect";exit;
$user="thoward";
// $host="";
$host="10.35.152.9";
$port='3309';  // 2022-08-05: ccooper Maria10
$password="r3s3t!T";

// $host="";  // Production MySQL
// $host="";  // Test MySQL
// $password="";

// 2022-08-05: CCOOPER $connection = mysql_connect($host,$user,$password);
$connection = mysqli_connect($host,$user,$password,$database,$port);

 if (!$connection)
  {
  die('Could not connect: ' . mysql_error());
  }
  
// include("/opt/Library/WebServer/Documents/no_inject.php");
include("/opt/library/prd/WebServer/Documents/no_inject.php");
?>