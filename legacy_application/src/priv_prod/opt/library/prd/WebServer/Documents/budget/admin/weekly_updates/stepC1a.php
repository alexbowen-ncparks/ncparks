<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


/*
$query="truncate table exp_rev_dncr_temp1; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


$query0="truncate table exp_rev_dncr_temp2; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");
*/


$query1a="truncate table cab_dpr_temp; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query1a.  $query1a");


$query1b="truncate table bd725_dpr_temp; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1b) or die ("Couldn't execute query1b.  $query1b");


/*
$query1c="truncate table exp_rev_dncr_temp3; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1c) or die ("Couldn't execute query1c.  $query1c");


$query1d="truncate table exp_rev_dncr_temp4; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1d) or die ("Couldn't execute query1d.  $query1d");

*/


$query1e="truncate table bd725_dpr_temp_pre; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1e) or die ("Couldn't execute query1e.  $query1e");


$query1f="truncate table exp_rev_dncr_osc2; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1f) or die ("Couldn't execute query1f.  $query1f");


$query1g="truncate table exp_rev_dncr_osc3; ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1g) or die ("Couldn't execute query1g.  $query1g");




$query1="update project_steps_detail
         set status='pending'
         where project_category='xtnd' and project_name='dncr_down' ";

//echo "line 24: query=$query<br />"; exit;
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");







$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");





////mysql_close();



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

 ?>




















