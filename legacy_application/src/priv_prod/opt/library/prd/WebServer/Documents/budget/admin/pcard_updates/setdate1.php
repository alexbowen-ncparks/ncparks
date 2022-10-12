<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);


$fiscal_year=$_POST['fiscal_year'];
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];

//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$table="weekly_updates";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="insert ignore into weekly_updates(fiscal_year,start_date,end_date) 
values ('$fiscal_year','$start_date','$end_date')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update weekly_updates_steps
         set fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date'
		 where 1";
		
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="insert ignore into weekly_updates_steps_status
         (fiscal_year,start_date,end_date,project_category,project_name,step_group,step,link,weblink,note_number)
		 select fiscal_year,start_date,end_date,project_category,project_name,step_group,step,link,weblink,note_number
		 from weekly_updates_steps where 1";
		 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");		 
		 

/*$query3="update weekly_updates_steps_status
         set fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date'
		 where 1 and fiscal_year='' and start_date='' and end_date='' ";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
*/

header("location: main.php?project_category=fms&project_name=weekly_updates");


?>
