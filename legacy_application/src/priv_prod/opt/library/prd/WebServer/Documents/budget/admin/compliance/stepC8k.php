<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
/* 2022-07-01: cooper - comment out for FYR rollover
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit; */
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters


		
	$query0a="update report_budget_history_multiyear2 set py19_amount=py18_amount where 1 "; $result0a=mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a. $query0a");	
	$query0b="update report_budget_history_multiyear2 set py18_amount=py17_amount where 1 "; $result0b=mysqli_query($connection, $query0b) or die ("Couldn't execute query 0b. $query0b");	
	$query0c="update report_budget_history_multiyear2 set py17_amount=py16_amount where 1 "; $result0c=mysqli_query($connection, $query0c) or die ("Couldn't execute query 0c. $query0c");	
	$query0d="update report_budget_history_multiyear2 set py16_amount=py15_amount where 1 "; $result0d=mysqli_query($connection, $query0d) or die ("Couldn't execute query 0d. $query0d");		
	$query1="update report_budget_history_multiyear2 set py15_amount=py14_amount where 1 "; $result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");	
	$query2="update report_budget_history_multiyear2 set py14_amount=py13_amount where 1 "; $result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");	
	$query3="update report_budget_history_multiyear2 set py13_amount=py12_amount where 1 "; $result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");	
	$query4="update report_budget_history_multiyear2 set py12_amount=py11_amount where 1 "; $result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");	
	$query5="update report_budget_history_multiyear2 set py11_amount=py10_amount where 1 "; $result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");	
	$query6="update report_budget_history_multiyear2 set py10_amount=py9_amount where 1 "; $result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");	
	$query7="update report_budget_history_multiyear2 set py9_amount=py8_amount where 1 "; $result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");	
	$query8="update report_budget_history_multiyear2 set py8_amount=py7_amount where 1 "; $result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");	
	$query9="update report_budget_history_multiyear2 set py7_amount=py6_amount where 1 "; $result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");	
	$query10="update report_budget_history_multiyear2 set py6_amount=py5_amount where 1 "; $result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");	
	$query11="update report_budget_history_multiyear2 set py5_amount=py4_amount where 1 "; $result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");	
	$query12="update report_budget_history_multiyear2 set py4_amount=py3_amount where 1 "; $result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");	
	$query13="update report_budget_history_multiyear2 set py3_amount=py2_amount where 1 "; $result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");	
	$query14="update report_budget_history_multiyear2 set py2_amount=py1_amount where 1 "; $result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");	
	$query15="update report_budget_history_multiyear2 set py1_amount=cy_amount where 1 "; $result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");	
	$query16="update report_budget_history_multiyear2 set cy_amount='0.00' where 1 "; $result16=mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");	
	



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=yearly_reset");}

?>