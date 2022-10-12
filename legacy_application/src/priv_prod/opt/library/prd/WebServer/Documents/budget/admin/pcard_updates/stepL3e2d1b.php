<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<br />end_date=$end_date<br />";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters



$query1="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date='$end_date',
		     pcard_unreconciled_xtnd_temp2_perm.report_date='$end_date',			 
		     pcard_unreconciled_xtnd_temp2_perm.division='DPR_MANUAL',
		     pcard_unreconciled_xtnd_temp2_perm.backdate='y',			 
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')
             and pcard_unreconciled_xtnd_temp2_perm.dpr='n'	
             and pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date >= '20170831'			 ";


//echo "<br />query1=$query1<br />";	//exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query11="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where xtnd_report_date='$end_date' and dpr='y' and backdate='y' ";


//echo "<br />query11=$query11<br />";	

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

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
//////mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}



	



?>