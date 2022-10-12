<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>

</head>";
echo "<H2><font color=red>Are you sure you want to delete record $cid ?</font></H2>";

echo "<table border=1>";
echo "<tr>";
echo "<td>";
echo "<form method=post action=step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&report_type=form>";

echo "<input type='submit' name='submit' value='NO-Return Home'>";
	 
echo "<input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>";    

echo "</form>";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo "<form method=post action=edit_record_delete.php>";
   
echo "<input type='submit' name='submit' value='YES-DELETE Record $cid'>";

echo "<input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>"; 

echo "</form>";
echo "</td>";
echo "</tr>";

echo "</table>";
echo "</html>";
?>