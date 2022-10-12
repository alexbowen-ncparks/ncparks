
<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "tempid=$tempid<br />";

/*
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;
*/

echo "<br />database=$database<br />";
$database="budget_service_contracts";
$db="budget_service_contracts";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters

$query="SHOW TABLE STATUS FROM budget_service_contracts" ;

$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$num=mysqli_num_rows($result);\
echo "<table align='center'><tr><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr></table>";
echo "<table align='center' border='1'><tr><td>Database</td></tr><tr><td>budget</td></tr><tr><td>budget_service_contracts</td></tr></table>";

echo "<table align='center' border=1>";
 
echo 

"<tr>";

echo "<td align='center'><font color='brown'>Name</font></td>";
echo "<td align='center'><font color='brown'>Records</font></td>";


echo "</tr>";

while ($row=mysqli_fetch_array($result))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row);
	//$rank=$rank+1;
	


if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}
	
echo "<tr$t>";
echo "<td><a href='table_backup_results.php?table_name=$Name' style='text-decoration:none' target='_blank' >$Name</a></td>";
echo "<td>$Rows</td>";
echo "</tr>";
	
	
	
	}

echo "</table>";






?>