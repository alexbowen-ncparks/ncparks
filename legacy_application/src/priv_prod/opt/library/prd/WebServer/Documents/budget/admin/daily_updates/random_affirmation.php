<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

$query1="SELECT min(id) as 'first_id' from mission_icon_success where 1 ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$query2="SELECT max(id) as 'last_id' from mission_icon_success where 1 ";
		 
//echo "query1=$query1<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);

echo "<br />first_id=$first_id<br />";
echo "<br />last_id=$last_id<br />";
$random_id=rand($first_id,$last_id);
echo "<br />random_id=$random_id<br />";

$query3="select photo_location from mission_icon_success where id='$random_id' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);

$photo_location2="<img src='$photo_location' height='50' width='50'>";


//echo "<table><tr><td><img src='$photo_location' height='50' width='50'></td></tr></table>";










?>