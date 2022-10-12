<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$query1="insert into crs_tdrr_division_history_parks SET";
for($j=0;$j<$num_lines;$j++){
$query2=$query1;
	$query2.=" payment_type='cash',";
	$query2.=" deposit_transaction='y',";
	$query2.=" source='manual',";
	$query2.=" adjustment='y',";
	$query2.=" fs_comments='refund issued',";
	$query2.=" center='$center[$j]',";	
	$query2.=" ncas_account='$account_number[$j]',";	
	$query2.=" deposit_id='$orms_deposit_id[$j]',";	
	$query2.=" transdate_new='$transdate_new[$j]',";	
	$query2.=" amount='$amount_adj[$j]'";	
			

$result2=mysql_query($query2) or die ("Couldn't execute query 2. $query2");
}

//echo "Query2 successful";//exit;



$query1a="insert into crs_tdrr_division_history_parks SET";
for($j=0;$j<$num_lines;$j++){
$query2a=$query1a;
	$query2a.=" payment_type='cash',";
	$query2a.=" deposit_transaction='y',";
	$query2a.=" source='manual',";
	$query2a.=" adjustment='y',";
	$query2a.=" fs_comments='refund issued',";
	$query2a.=" center='$center[$j]',";	
	$query2a.=" ncas_account='$account_number_adj[$j]',";	
	$query2a.=" deposit_id='$orms_deposit_id[$j]',";	
	$query2a.=" transdate_new='$transdate_new[$j]',";	
	$query2a.=" amount='$amount[$j]'";	
			

//echo "query2a=$query2a";exit;			
			
$result2a=mysql_query($query2a) or die ("Couldn't execute query 2a. $query2a");
}

//echo "Query2a successful";exit;



$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");



$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}





 
 ?>

