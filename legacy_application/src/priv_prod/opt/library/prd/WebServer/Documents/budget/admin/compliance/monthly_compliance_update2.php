<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$query="update cash_imprest_count_scoring
        set start_date='$start_date',end_date='$end_date',start_date2='$start_date2',
		end_date2='$end_date2',start_date3='$start_date3',end_date3='$end_date3' where id='$id' ";
		
//echo "<br />query=$query<br />";
		
//exit;	
	
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");				

header("location: monthly_compliance_admin.php?compliance_fyear=$compliance_fyear&compliance_month=$compliance_month");


 
 ?>