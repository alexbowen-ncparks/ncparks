<?php
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<br />connection=$connection<br />";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "start_date=$start_date | end_date=$end_date"; exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);

// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here!  ex. $today_date=20220614;
$today_date=date("Ymd");


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//include("/opt/library/prd/WebServer/include/activity.php"); // connection parameters

$query0="truncate table budget.pcard; ";
mysqli_query($connection, $query0) or die ("Couldn't execute query 0. $query0");


$query1="truncate table budget.pcard_unreconciled_xtnd;";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query1a="truncate table budget.pcard_unreconciled_xtnd_temp;";
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$query1b="truncate table budget.pcard_unreconciled_xtnd_temp2;";
mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b. $query1b");

$query2="update project_substeps_detail
         set fiscal_year='',status='pending',start_date='',end_date=''
		 where project_category='fms' and project_name='pcard_updates' and step_group='L' and step_num='3e'
		 ";

//echo "query2=$query2<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="delete from pcard_report_dates where active='n' ";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


//echo "<br />Line 48<br />"; 
//exit;

/* 6/15/21
$query20="select report_date as 'report_date1',id as 'id1' 
          FROM `pcard_report_dates`
		  WHERE 1 and active='y'
		  order by id desc 
		  limit 1	 ";

//echo "query20=$query20<br />";


$result20 = mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");

$row20=mysqli_fetch_array($result20);
extract($row20);
*/

// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here!  ex. $system_entry_date="20220614";
$system_entry_date=date("Ymd");

$query20a="select date as 'report_date1'
          FROM `mission_headlines`
		  WHERE date < '$system_entry_date' and weekend='n'
		  order by date desc 
		  limit 1	 ";

// 06/16/21 echo "query20a=$query20a<br />";


$result20a = mysqli_query($connection, $query20a) or die ("Couldn't execute query 20a.  $query20a");

$row20a=mysqli_fetch_array($result20a);
extract($row20a);


// 06/16/21 
echo "<br />system_entry_date=$system_entry_date<br />";
// 06/16/21
// 07/09/21 
echo "<br />report_date1=$report_date1<br />";

//exit;

//$report_date2=str_replace("-","",$report_date1);

/*
$report_date3=strtotime("$report_date2");
$report_date4=($report_date3+60*60*24*7);
$report_date4a=($report_date3+60*60*24*1);
$report_date5=date("Ymd", $report_date4);
$report_date5a=date("Ymd", $report_date4a);
*/


/* 6/15/21
$report_date2=date_create("$report_date1");
date_sub($report_date2,date_interval_create_from_date_string("-1 days"));
$report_date5a=date_format($report_date2,"Ymd");

$report_date3=date_create("$report_date1");
date_sub($report_date3,date_interval_create_from_date_string("-7 days"));
$report_date5=date_format($report_date3,"Ymd");

*/

$report_date5=str_replace("-","",$report_date1);
// 06/16/21 
echo "<br />report_date5=$report_date5<br />";
//exit;
//$report_date5a='20201105';
//$report_date5='20201112';


//echo "<br />report_date5a=$report_date5a<br />";
//echo "<br />report_date5=$report_date5<br />";

//exit;


$report_month_number=substr($report_date5,4,2);
$report_day_number=substr($report_date5,6,2);

if($report_month_number=='01'){$report_month_name='January';}
if($report_month_number=='02'){$report_month_name='February';}
if($report_month_number=='03'){$report_month_name='March';}
if($report_month_number=='04'){$report_month_name='April';}
if($report_month_number=='05'){$report_month_name='May';}
if($report_month_number=='06'){$report_month_name='June';}
if($report_month_number=='07'){$report_month_name='July';}
if($report_month_number=='08'){$report_month_name='August';}
if($report_month_number=='09'){$report_month_name='September';}
if($report_month_number=='10'){$report_month_name='October';}
if($report_month_number=='11'){$report_month_name='November';}
if($report_month_number=='12'){$report_month_name='December';}


$pcard_message='PCARD Reconcilement is available for Report Date: '.$report_month_name.' '.$report_day_number;

$query20a="select report_year as 'report_year1'
           from fiscal_year 
		   where start_date <= '$report_date5' and end_date >= '$report_date5' ";

// 06/16/21 echo "<br />query20a=$query20a<br />";


$result20a = mysqli_query($connection, $query20a) or die ("Couldn't execute query 20a.  $query20a");

$row20a=mysqli_fetch_array($result20a);
extract($row20a);

// 07/09/21echo "<br />report_year1=$report_year1 <br />";

/* 6/15/21
$query20b="insert ignore into pcard_report_dates set report_date='$report_date5',xtnd_start='$report_date5a',xtnd_end='$report_date5',f_year='$report_year1',pcard_message='$pcard_message'";
*/

$query20b="insert ignore into pcard_report_dates set report_date='$report_date5',xtnd_start='$report_date5',xtnd_end='$report_date5',f_year='$report_year1',pcard_message='$pcard_message'";





// 07/09/21 
//echo "<br />query20b=$query20b<br />";

//exit;




$result20b = mysqli_query($connection, $query20b) or die ("Couldn't execute query 20b.  $query20b");




//exit;





$query2a1="SELECT min(id) as 'week_id' from pcard_report_dates where active='n'";


//echo "query2a1=$query2a1<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a1 = mysqli_query($connection, $query2a1) or die ("Couldn't execute query 2a1.  $query2a1");

$row2a1=mysqli_fetch_array($result2a1);
extract($row2a1);
var_dump($row2a1);

//echo "week_id=$week_id<br />";

$query2a2="SELECT xtnd_start as 'start_date',xtnd_end as 'end_date',f_year as 'fiscal_year' 
           from pcard_report_dates where id='$week_id' ";


// 06/16/21 echo "query2a2=$query2a2<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a2 = mysqli_query($connection, $query2a2) or die ("Couldn't execute query 2a2.  $query2a2");

$row2a2=mysqli_fetch_array($result2a2);
extract($row2a2);
// 06/16/21 
// 07/09/21 echo "start_date=$start_date<br />";
// 06/16/21
// 07/09/21  echo "end_date=$end_date<br />";
// 06/16/21 
// 07/09/21 echo "fiscal_year=$fiscal_year<br />";

// 06/16/21 
//exit;


$query2a="update project_substeps_detail
          set fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date',status='pending'
		  where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
	

//echo "query2a=$query2a<br />";
	

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

//echo "<br />Line 228<br />"; 
//exit;

include("pcard_backup_tables.php");




?>
