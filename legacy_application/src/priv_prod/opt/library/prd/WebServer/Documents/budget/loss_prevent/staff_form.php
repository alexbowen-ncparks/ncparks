<?php
ini_set('display_errors',1);
session_start();

if(!$_SESSION['budget']['tempID'])
	{
	echo "access denied";exit;
	//header("location: /login_form.php?db=budget");
	}



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database// database connection parameters
include("../../../include/activity.php");

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

$level=$_SESSION['budget']['level'];
//$parkList=$_SESSION['budget']['accessPark'];
$file=explode("/",$_SERVER['PHP_SELF']);
//echo "<pre>"; print_r($_SERVER['PHP_SELF']);echo "</pre>";
//echo "<pre>"; print_r($file); echo "</pre>";

if($level==1)
	{$park=$_SESSION['budget']['select'];}
	else
	{
	@$park=$_GET['park'];
	}
		
if($level>1)
	{
	mysqli_select_db($connection, "divper"); // database// database connection parameters
	// Get list of units from positions
	$sql = "SELECT distinct park FROM `position` WHERE 1 order by park";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$park_menu[]=$row['park'];
		}
//	echo "<pre>"; print_r($park_menu); echo "</pre>"; // exit;
	}		
		

?>