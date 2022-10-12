<?php

session_start();

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$fyear='2021';
$todays_date=date("Y-m-d");

$query2="SELECT min(date) as 'upload_date',hid
          from mission_headlines
		  where undeposited_message='n'
		  and date >= '20140816'
		  and date <= '$todays_date' ";
		  
echo "query2=$query2<br />";//exit;	
	  
 $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2 ");

$row2=mysqli_fetch_array($result2);
extract($row2);
/*
$date=date_create("$upload_date");
date_sub($date,date_interval_create_from_date_string("1 days"));
$date2=date_format($date,"Ymd");
echo "<br />date2=$date2<br />";
*/


//$upload_date=str_replace("-","",$upload_date);

$upload_date=str_replace("-","",$upload_date);


$yesterday=date_create("$upload_date");
date_sub($yesterday,date_interval_create_from_date_string("1 days"));
$yesterday2=date_format($yesterday,"Ymd");




$day_before_yesterday=date_create("$upload_date");
date_sub($day_before_yesterday,date_interval_create_from_date_string("2 days"));
$day_before_yesterday2=date_format($day_before_yesterday,"Ymd");



echo "<br />upload_date=$upload_date<br />";
echo "<br />yesterday2=$yesterday2<br />";
echo "<br />day_before_yesterday2=$day_before_yesterday2<br />";



$todays_date=str_replace("-","",$todays_date);
$today=str_replace("-","",$upload_date);
$yesterday=$yesterday2;
$dayb4yesterday=$day_before_yesterday2;

$upload_date=str_replace("-","",$upload_date);



echo "<br />Line 76: todays_date=$todays_date<br />";
echo "Line 77: today=$today<br />";
echo "Line 78: yesterday=$yesterday<br />";
echo "Line 79: dayb4yesterday=$dayb4yesterday<br />";	



echo "Line 83: upload_date=$upload_date<br />";	







exit;

	  
  

 ?>