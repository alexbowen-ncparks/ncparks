<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid1=substr($tempid,0,-2);



extract($_REQUEST);
$database="budget";
$db="budget";

if(empty($connection))
	{
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
    }



mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//if(!$_SESSION["budget"]["tempID"]){
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
//}

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>MoneyTracker</title>
	<?php
	if($beacnum!='60032793')
	{
	//echo "<link rel='stylesheet' type='text/css' href='/budget/menu1314.css' />";
	include ("menu1314_tony.html");
	}
	if($beacnum=='60032793')
	{
	include ("menu1314_tony.html");
	}
	?>	
		
    <link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
<?php include ("menu1314_js.php"); ?>
  </head> 
  <body id="home">
 <?php
//include ("header_logo.php");
include ("header_logo_apple2.php");
//include ("games_js.php");
?>
		

<br />	


  
  
  
  
  
  