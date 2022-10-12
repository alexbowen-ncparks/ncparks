<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);
$todays_date=date("Y-m-d");
//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

/*
$query2="SELECT min(date) as 'upload_date',hid
          from mission_headlines
		  where undeposited_message='n'
		  and date >= '20140816'
		  and date <= '$todays_date' ";
//echo "query2=$query2<br />";//exit;		  
 $result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2 ");

$row2=mysql_fetch_array($result2);
extract($row2);
*/

header("location: cash_summary_update.php");



?>



