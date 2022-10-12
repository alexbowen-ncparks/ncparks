<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

if($submit=='mark_complete')
{

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


//{header("location: step_group.php?project_category=fms&project_name=weekly_updates&step_group=C");}
{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
}



$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

include("../../../budget/menu1314.php");



echo "<html>";
echo "<head>";
echo "<style>";

echo "</style>";
echo "<br /><br /><br />";



if($submit=='')
{
echo "<table border='1' align='center'>";
echo "<tr><th>Weekly Updates:Step $step_group$step_num<br />$step<br /><br />Exp Rev Download/XTND Reconciliation(Fund 1680)</th></tr>";
echo "<form method='post' action='stepC1t.php'>";
echo "<tr>";
echo "<td>XTND Appropriation (Fund1680): <input type='text' size='10' name='xtnd_approp' value='$xtnd_approp'></td>";
echo "</tr>";
echo "<tr>";
echo "<td align='center'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='step_group' value='$step_group'>";
echo "<input type='hidden' name='step_num' value='$step_num'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='start_date' value='$start_date'>";
echo "<input type='hidden' name='end_date' value='$end_date'>";




echo "<input type='submit' name='submit'>";
echo "</td>";
echo "</tr>";
echo "</table>";
}

if($submit=='Submit')
{
$xtnd_approp2=number_format($xtnd_approp,2);

$query2="select sum(debit-credit) as 'mc_approp' from exp_rev_dncr_temp_part2_dpr 
         where 1
		 and center like '1680%' and valid_account_dpr='y' and valid_dpr_center='y' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);//brings back max (end_date) as $end_date		 
		 
$mc_approp2=number_format($mc_approp,2);	

$oob=$xtnd_approp-$mc_approp;
$oob2=number_format($oob,2);	 
	
if($oob2==0.00)
{
$graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
}
else
{
$graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";
}	

	
echo "<table border='1' align='center'>";
echo "<tr><th>Form Results</th><th>Amount</th></tr>";
echo "<tr>";
echo "<td>XTND Appropriation (CAB Fund1680)</td><td align='center'>$xtnd_approp2</td>";
echo "</tr>";
echo "<tr>";
echo "<td>MC Appropriation (EXP REV1680)</td><td align='center'>$mc_approp2</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Out of Balance</td><td align='center'>$oob2<br />$graphic</td>";
echo "</tr>";
echo "<tr>";
echo "<td></td>";
echo "<td align='center'>";
echo "<form method='post' action='stepC1t.php'>"; 
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='step_group' value='$step_group'>";
echo "<input type='hidden' name='step_num' value='$step_num'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='start_date' value='$start_date'>";
echo "<input type='hidden' name='end_date' value='$end_date'>";
echo "<input type='submit' name='submit' value='mark_complete'>";
echo "</td>";
echo "</tr>";


echo "</table>";	
	
}


//exit;
/*
if($submit=='mark_complete')
{


$query23a="update budget.project_steps_detail set status='complete' where project_category='fms'
         and project_name='weekly_updates' and step_group='C' and step_num='1t' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=fms&project_name=weekly_updates&step_group=C_");}

}

*/



?>