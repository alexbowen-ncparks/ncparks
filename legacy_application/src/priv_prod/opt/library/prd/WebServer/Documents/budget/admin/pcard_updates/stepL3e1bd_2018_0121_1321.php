<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



if($status != 'complete')
{
	
include("../../../budget/menu1314.php");	



echo "<html>";
echo "<head>";


echo "</head>";


$table1="pcard_report_dates_compliance";
$table2="pcard_unreconciled";
$table3="pcard_unreconciled_xtnd_temp2_perm";
$table4="pcard_unreconciled_xtnd_temp2_perm_unique";
$table5="pcard_users";


$report1="budget.$table1";
$report1_backup="budget_pcard_backup.$sed$table1";
$report2="budget.$table2";
$report2_backup="budget_pcard_backup.$sed$table2";
$report3="budget.$table3";
$report3_backup="budget_pcard_backup.$sed$table3";
$report4="budget.$table4";
$report4_backup="budget_pcard_backup.$sed$table4";
$report5="budget.$table5";
$report5_backup="budget_pcard_backup.$sed$table5";

echo "<br />report1=$report1<br />";
echo "<br />report1_backup=$report1_backup<br />";
echo "<br />report2=$report2<br />";
echo "<br />report2_backup=$report2_backup<br />";
echo "<br />report3=$report3<br />";
echo "<br />report3_backup=$report3_backup<br />";
echo "<br />report4=$report4<br />";
echo "<br />report4_backup=$report4_backup<br />";
echo "<br />report5=$report5<br />";
echo "<br />report5_backup=$report5_backup<br />";



echo "<br /><br />";
echo "<table align='center'><tr><th><i>DNCR Cards with Division=Blank</i></th></tr></table>";

echo "<br />";



echo "<br /><br />";
echo "<table align='center'>";
echo "<tr><th><font color='red'>WARNING! ONLY Click Submit when \"DPR Employee Status\" of each Cardholder has been MARKED with Checkmark or Xmark</font></th></tr>";
echo "</table>";
echo "<br /><br />";
//echo "<table align='center'>";
echo "<form action='stepL3e1bd.php' align='center'><input type='submit' name='submit' value='Submit'><input type='hidden' name='dpr_update' value='y'></form>";
//echo "</table>";

echo "</body></html>";


}


if($status=='complete')
{




	
$query23a="update budget.project_substeps_detail set status='complete' where project_category='FMS'
         and project_name='pcard_updates' and step_group='L' and step_num='3e' and substep_num='1bd' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e ");}



}



?>