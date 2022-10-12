<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);

$query1="insert ignore into pcard_unreconciled_xtnd_temp2
         (cardholder,division,post_date,trans_date,amount,merchant_name,city_state,trans_id,card_number)
         select cardholder,division,post_date,trans_date,amount,merchant_name,city_state,trans_id,card_number
         from pcard_unreconciled_xtnd_temp
         where 1		 
		 ";
		  
		  
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query2e="update pcard_unreconciled_xtnd_temp2
          set xtnd_report_date='$end_date2'
		  where 1 ";
		  
		  
mysql_query($query2e) or die ("Couldn't execute query 2e.  $query2e");

$query1="update pcard_unreconciled_xtnd_temp2
         set card_number2=substring(card_number,-4)
         where 1		 ";
		  
		  
mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query0="update pcard_unreconciled_xtnd_temp2
         set dpr='y' where (division='park' or division='capi') ";
		  
echo "<br />query0=$query0<br />";	
mysql_query($query0) or die ("Couldn't execute query 0.  $query0");


$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}

 
 ?>




















