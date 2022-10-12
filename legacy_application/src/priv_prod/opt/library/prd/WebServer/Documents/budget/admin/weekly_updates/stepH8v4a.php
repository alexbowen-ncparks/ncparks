<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;

/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database c
*/

$query0="select max(calyear) as 'current_calyear' from report_budget_history_calyear where 1";
//echo "<br />query0=$query0<br />";
$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);

$previous_calyear=$current_calyear-1;
$previous_calyear2=$current_calyear-2;

//echo "<br />current_calyear=$current_calyear<br />"; 
//echo "<br />previous_calyear=$previous_calyear<br />"; 


$query1="select sum(amount) as 'table1_total_check' from report_budget_history_calyear where calyear='$previous_calyear2' ";
//echo "<br />query1=$query1<br />";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

$query2="select sum(py2_amount) as 'table2_total_check' from report_budget_history_multiyear_calyear3 where 1 ";
//echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);


//echo "<br />table1_total_check=$table1_total_check<br />";
//echo "<br />table2_total_check=$table2_total_check<br />";

if($table1_total_check==$table2_total_check){$scroll_required='no';}
if($table1_total_check!=$table2_total_check){$scroll_required='yes';}

//echo "<br />scroll_required=$scroll_required<br />";

if($scroll_required=='yes')
{
	
$query2a="update report_budget_history_multiyear_calyear3
          set py18_amount=py17_amount,
              py17_amount=py16_amount,
              py16_amount=py15_amount,
              py15_amount=py14_amount,
              py14_amount=py13_amount,
              py13_amount=py12_amount,
              py12_amount=py11_amount,
              py11_amount=py10_amount,
              py10_amount=py9_amount,
              py9_amount=py8_amount,
              py8_amount=py7_amount,
              py7_amount=py6_amount,
              py6_amount=py5_amount,
              py5_amount=py4_amount,
              py4_amount=py3_amount,
              py3_amount=py2_amount,
              py2_amount=py1_amount
			  where 1 ";
			 
echo "<br />query2a=$query2a<br />";
$result2a=mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
	
}

//echo "<br />Line 86<br />";

//exit;

/* 
 $query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/
  
 ?>