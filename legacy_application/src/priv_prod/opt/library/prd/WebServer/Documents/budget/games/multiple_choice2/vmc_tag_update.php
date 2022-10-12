<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update vmc_posted7_v2 SET";
for($j=0;$j<$num5;$j++)
	{	
	if($tag_num[$j] ==""){continue;}
	$query2=$query1;
		$query2.=" license_tag='$tag_num[$j]',";
		$query2.=" vmc_comments='$vmc_comments[$j]'";	
		$query2.=" where id='$id[$j]'";
			
	
	$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
	}	


{header("location: vm_costs_center_daily.php?f_year=$f_year&park=$park&center=$center");}

 
 ?>




















