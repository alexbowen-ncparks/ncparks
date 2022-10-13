<?php
$user="thoward";
$password="r3s3t!T";

/* 2022-05-13: CCooper - host changed to point to Dev Server
 $host="10.35.80.181";  */
$host="10.35.152.9";  
// 2022-05-13: End CCooper

 /* 2022-07-22: ccooper - adding port numbers to test Maria 10 db connection BUT 3309 fails. Added 'port' option to mysqli_connect command (below):  */
  
   //$port="3306";   // Maria 5 port 3306
   $port="3309";  // Maria 10 port 3309
  /* 2022-07-22: End ccooper */

  //created to eventually help with the hardcoding of the production server address in the PHP files

  // CCOOPER - in the future I hope that these 2 lines will switch based on the environment
  // $main_page_loc = "10.35.152.9";  // PRODUCTION
  // $main_page_loc = "10.35.152.9";  // PRODUCTION
   $main_page_loc = "10.35.152.9";  // DEVELOPMENT

if(!empty($db)){$database=$db;}
//echo "db=$db   database=$database"; exit;

// 2022-07-22: ccooper - added $port option to mysqli_connect command
//$connection = mysqli_connect($host,$user,$password,$database);
$connection = mysqli_connect($host,$user,$password,$database,$port);
// 2022-07-22: End ccooper

// CCOOPER  print_r ($connection); exit;

 if (!$connection)
  {
  //die('Could not connect: ' . mysqli_error($connection));
    die('Could not connect: ' . mysqli_connect_error($connection));
  }
// include("/opt/Library/WebServer/Documents/no_inject_i.php");
include("/opt/library/prd/WebServer/Documents/no_inject_i.php");

//echo "end of iConnect.inc"; exit;
?>