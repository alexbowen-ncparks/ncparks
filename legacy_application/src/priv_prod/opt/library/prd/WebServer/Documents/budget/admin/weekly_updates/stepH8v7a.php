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
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

if($mark_complete != 'y')
{
include("table1_backup.php");// report_budget_history_multiyear2
include("table2_backup.php");// report_budget_history_inc_stmt_by_fyear
include("table3_backup.php");// report_budget_history_inc_stmt_by_fyear_pfr
include("table4_backup.php");// report_budget_history_inc_stmt_by_fyear_receipts1
include("table5_backup.php");// report_budget_history_inc_stmt_by_fyear_net1
include("table6_backup.php");// report_budget_history_inc_stmt_by_fyear_net




echo "<table align='center' border='1'><tr><td><font color='red'>Table Backups Successful</font></td></tr></table>";
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>Database</font></td><td align='center'><font color='brown'>TABLE</font></td><td align='center'><font color='brown'>RECORDS</font></td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta1$ct</td><td>$record_count1</td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta2$ct</td><td>$record_count2</td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta3$ct</td><td>$record_count3</td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta4$ct</td><td>$record_count4</td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta5$ct</td><td>$record_count5</td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta6$ct</td><td>$record_count6</td></tr>";
echo "</table>";

echo "<table align='center' border='1'>";
echo "<tr><td><a href='stepH8v7a.php?mark_complete=y&project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date'>Mark Complete</a></td></tr>";

echo "</table>";


exit;
}


if($mark_complete=='y')
{

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

//echo "<br />query23a=$query23a<br />"; exit;

echo "<br />";
echo "<table align='center' border='1'><tr><td><a href='step_group.php?fyear=&report_type=form&reset=y'>Return to Monthly Compliance Updates</a></td></tr></table>";



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

}


 ?>