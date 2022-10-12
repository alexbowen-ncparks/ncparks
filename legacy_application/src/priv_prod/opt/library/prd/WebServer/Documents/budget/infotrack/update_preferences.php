<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "bgcolor=$bgcolor";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
extract($_REQUEST);
//echo "bgcolor=$bgcolor<br />"; exit;
/*
$sql_1 = "select distinct body_bgcolor from infotrack_customformat";
$result_1=mysqli_query($connection, $sql_1) or die ("Couldn't execute query 12. $sql_1");
while($row=mysqli_fetch_assoc($result_1))
	{
	$bg_color[]=$row['body_bgcolor'];
	}

*/

$sed=date("Ymd");



$query12 = "insert ignore into infotrack_customformat(user_id)
            values('$tempid')";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");
/*
if(!in_array($bgcolor,$bg_color))
	{
	$bgcolor="Blue";
	}
	*/
$query13="update infotrack_customformat
          set body_bgcolor='$bgcolor',park='$concession_location',sed='$sed'
		  where user_id='$tempid'";
//echo "query13=$query13";echo "<br />";  exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

header("location: admin_colors.php");


?>