<?php
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

/*
$query2="SELECT xtnd_day from pcard_report_days where id='5' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
*/


$query2="update project_substeps_detail
         set fiscal_year='',status='pending',start_date='',end_date=''
		 where project_category='fms' and project_name='pcard_updates' and step_group='L' and step_num='3e'
		 ";

//echo "query2=$query2<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query2a1="SELECT min(id) as 'week_id' from pcard_report_dates where active='n'";


//echo "query2a1=$query2a1<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a1 = mysqli_query($connection, $query2a1) or die ("Couldn't execute query 2a1.  $query2a1");

$row2a1=mysqli_fetch_array($result2a1);
extract($row2a1);

//echo "week_id=$week_id<br />";

$query2a2="SELECT xtnd_start as 'start_date',xtnd_end as 'end_date',f_year as 'fiscal_year' 
           from pcard_report_dates where id='$week_id' ";


//echo "query2a2=$query2a2<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a2 = mysqli_query($connection, $query2a2) or die ("Couldn't execute query 2a2.  $query2a2");

$row2a2=mysqli_fetch_array($result2a2);
extract($row2a2);
//echo "start_date=$start_date<br />";
//echo "end_date=$end_date<br />";
//echo "fiscal_year=$fiscal_year<br />";


$query2a="update project_substeps_detail
          set fiscal_year='$fiscal_year',start_date='$start_date',end_date='$end_date',status='pending'
		  where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
	

//echo "query2a=$query2a<br />";
	

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");


$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}

?>

























