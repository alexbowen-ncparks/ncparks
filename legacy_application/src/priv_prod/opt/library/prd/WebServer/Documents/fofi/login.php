<?php
ini_set('display_errors',1);
$test=$_SERVER['QUERY_STRING'];
if(strpos($test,"../")){exit;}

include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,"budget");
$sql = "SELECT new_rcc from center where parkCode='FOFI' and new_rcc!=''";
$result=mysqli_query($connection,$sql) or die("Can't execute query $sql.");
$row=mysqli_fetch_assoc($result);
$parkRCC=$row['new_rcc'];

$fpassword=$_POST['fpassword'];

// $parkRCC="515"; // just for testing

 if(!$fpassword=="" and $fpassword==$parkRCC)
	{ // password is correct
		mysqli_select_db($connection,"fofi");
		date_default_timezone_set('America/New_York');
			   $today = date("Y-m-d H:i:s");
			   $userAddress = $_SERVER['REMOTE_ADDR'];
			   $sql = "INSERT INTO login (loginTime,userAdd)
					   VALUES ('$today','$userAddress')";
			   mysqli_query($connection,$sql) or die("Can't execute query $sql.");
session_start();
$park="FOFI";
	$_SESSION['parkG'] = $park;
	$pG=$park;
	$_SESSION['loginS'] = 'OKed';
	$_SESSION[$pG]['padpermit'] = "";
		//header("Location: main.php");exit; 
	 }

//echo "$parkRCC $fpassword<pre>";print_r($_SESSION); print_r($_POST); 
//echo "</pre>"; exit;

header("Location: menu.php"); exit;

?>
