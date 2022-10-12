<?php
$database="divper";
// include("../../include/auth_i.inc"); // used to authenticate users
include("../../include/auth.inc"); // used to authenticate users
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;

include("../../include/iConnect.inc"); // used to authenticate users
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');
$tempID=$_GET['tempID'];
$today = date("Y-m-d H:i:s");
           $userAddress = $_SERVER['REMOTE_ADDR'];
           $sql = "INSERT INTO divper.login (loginName,loginTime,userAddress,level)
                   VALUES ('$tempID','$today','$userAddress','$level')";
           mysqli_query($connection,$sql) or die("Can't execute query 3.");

/*           
if($_SESSION['divper']['level']<5)
	{
	include("menu_position_desc.php");
	}
else
	{
*/
	include("menu.php");
//	}
?>
