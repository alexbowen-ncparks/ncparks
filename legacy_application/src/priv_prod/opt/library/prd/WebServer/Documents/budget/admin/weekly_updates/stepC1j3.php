<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
//include("../../../include/activity_new.php");// database connection parameters
//$status='complete';

$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j3';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);




$query="truncate table bd725_dpr_temp";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");		  
		  

$query="insert into bd725_dpr_temp(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
        select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr
		from bd725_dpr_temp_pre4
		where 1 and account != ''
        order by id	";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");			  
		  

$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	




{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}




 
 ?>