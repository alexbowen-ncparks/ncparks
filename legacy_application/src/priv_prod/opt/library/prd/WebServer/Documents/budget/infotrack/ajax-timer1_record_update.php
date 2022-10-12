<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

$query="update mission_bright_ideas set time_end=unix_timestamp(now()) where cid='$cid' ";	  
			  
			  
	//Execute query
$qry_result = mysqli_query($connection, $query) or die(mysqli_error());


$query2="update mission_bright_ideas set time_elapsed_sec=time_end-time_start
         where cid='$cid' ";
		 
$query2_result = mysqli_query($connection, $query2) or die(mysqli_error());


$query2a="update mission_bright_ideas set time_elapsed_min=time_elapsed_sec/60
         where cid='$cid' ";
		 
$query2a_result = mysqli_query($connection, $query2a) or die(mysqli_error());






$query3="insert into mission_bright_ideas_history(cid,gid,time_start,time_end,time_elapsed_sec,message)
         select cid,gid,time_start,time_end,time_elapsed_sec,'$message' from mission_bright_ideas
		 where cid='$cid'";
		 
$query3_result = mysqli_query($connection, $query3) or die(mysqli_error());

$query4="update mission_bright_ideas set time_start=unix_timestamp(now()) where cid='$cid' ";	
				 
$query4_result = mysqli_query($connection, $query4) or die(mysqli_error());


$query5="update mission_bright_ideas set time_end='',time_elapsed_sec='' where cid='$cid' ";	
				 
$query5_result = mysqli_query($connection, $query5) or die(mysqli_error());




?>
