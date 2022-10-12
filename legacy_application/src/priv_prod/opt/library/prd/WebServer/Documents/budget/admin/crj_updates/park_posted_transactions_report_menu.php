<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$database2="budget";
////mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");
//echo "Budget Database";

/*
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/

$query5="SELECT distinct report_date as 'report_date'
FROM crj_report_dates
where 1
order by report_date desc";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
while ($row5=mysqli_fetch_array($result5))
	{
	$tnArray[]=$row5['report_date'];
	}

//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";
echo "<table><form action='report_view.php' method='post' target='_blank'>";
echo "<tr>";
// Menu 000
echo "<td>Report: <select name=\"report_date\">"; 
echo "<option selected></option>";
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
if($report_date==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$tnArray[$n]\n";
       }
   echo "</select></td>";   
  echo "<td><input type='submit' name='submit' value='Submit'></td>";
  echo "</tr>";
  echo "<input type='hidden' name='ck_budS' value='$ck_budS'>"; 
  
  
  echo "</form>"; 
 
echo "</table>"; 

?>