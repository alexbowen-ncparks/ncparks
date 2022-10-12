<?php

//echo "PHP File table1_backup.php";  //exit;

//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;

//echo "<br />database_name=$database_name<br />";
//echo "<br />table_name=$table_name<br />";

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//$table_name='wex_detail';

$database=$database_name;
//$database="budget";
//$db="budget";
$db=$database;
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";



$db="$today_date";
//$ta1="crs_tdrr_division_deposits";
$ta1=$table_name;

// character count for "create table"=12
$len1=strlen("create table");

//table character count (counts Table name + 4 spaces) //  (4 spaces represent the DASH and SPACE on Left and Right Side of Table name) 
$len2=strlen($ta1)+4;

$len3=$len1+$len2;

////echo "<br /><br />len1=$len1<br /><br />";
////echo "<br /><br />len2=$len2<br /><br />";
////echo "<br /><br />len3=$len3<br /><br />";


$ct=date("His");

$query1="show create table $ta1";
////echo "<br />query1=$query1<br /><br />";

//exit;
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
//print_r($row1[1]);  exit;
////echo "<br /><br />";
$table_create=$row1[1];
$len1_output=substr($table_create,0,$len1);
////echo "<br /><br />len1_output=$len1_output<br /><br />";

$table_create2=substr($table_create,$len3);
$table_create3b = substr($table_create2, 0, strpos($table_create2, "ENGINE"));
$table_create3a = "CREATE TABLE "."`"."budget_daily_backup"."`"."."."`".$db.$ta1.$ct."`"." ";
$table_create3c = " ENGINE=MyISAM DEFAULT CHARSET=latin1";
$table_create3 = $table_create3a.$table_create3b.$table_create3c;



$query2="$table_create3";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//echo "<br />Line 73: Update Successful<br />";

$query2=" INSERT INTO `budget_daily_backup`.`$db$ta1$ct`
SELECT *
FROM `$database`.`$ta1` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query2a="select count(*) as 'record_count' from `budget_daily_backup`.`$db$ta1$ct` ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a ");
$row2a=mysqli_fetch_array($result2a);


extract($row2a);//brings back max (end_date) as $end_date

echo "<table border='1' align='center'>";
echo "<tr><td><font size='8'>budget_daily_backup</font></td></tr>
<tr><td><font size='8'>$db$ta1$ct</font></td></tr><tr><td><font size='8'>$record_count</font><br /><a href='/budget/infotrack3/table_view.php?database=$database&table=$table_name'>TABLE=$table_name</a></td></tr>";

echo "</table>";



//exit;




?>