<?php
ini_set('display_errors',1);
extract($_REQUEST);
date_default_timezone_set('America/New_York');

$db="mar";
$database="mar";
	session_start();
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>";
if(empty($to_word))
	{
	if(empty($pass_where))
		{
		include_once("_base_top_mar.php");// includes session_start();
		}
	}
	else
	{
	include("nav.php");
	}
if(empty($_SESSION[$db]['level']))
	{
	echo "Your session is not active. You will need to login."; exit;
	}

$level=$_SESSION[$db]['level'];
//JGC20220113 - Ops asked for this to be turned back on after over a month of being off, without any complaints to db group about it not being accessible.
//Echo "This app has been removed. If you have questions, get up with database.support@ncparks.gov";
//exit;

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if(!empty($_SESSION[$db]['accessPark']))
	{
	$accessPark_array=explode(",",$_SESSION[$db]['accessPark']);
	}

include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); // database connection parameters

// $district['STWD']="STWD";

$today=date("Y-m-d");
$last_week=date("Y-m-d",strtotime('1 week ago'));
$prev_2_week=date("Y-m-d",strtotime('-2 week'));
$prev_month=date("Y-m-d",strtotime('-4 week'));
$next_week=date("Y-m-d",strtotime('next week'));
$next_35=date("Y-m-d",strtotime('+5 week'));
//echo "$last $today $next";

$today_formated=date("l, jS \of F Y");

if(empty($to_word))
	{
	echo "<div align='center'><table border='1'><tr><td colspan='6' align='center' bgcolor='#E0FFF5'><h2>&nbsp;&nbsp;Monthly Activity Report - $today_formated &nbsp;</h2></td></tr>";

	echo "<tr>";
	echo "<td align='center'><button style=\"background-color:#0047B2\" style=\"font-size:20px\" onclick=\"toggleDisplay('enter');\" href=\"javascript:void('')\">MAR Posts</a></button></td>";

	echo "<td align='center'><button style=\"background-color:#ff7733\" style=\"font-size:20px\" onclick=\"toggleDisplay('tips');\" href=\"javascript:void('')\">Style Tips</a></button></td>";
// 
// 
// 	if($level>0)
// 		{
// 		echo "<td align='center'><button style=\"background-color:#007A29\" onclick=\"window.location.href='main.php?to_word=1';\">Draft Word Doc</a></button></td>";
// 		}
// 	
// 	echo "<td align='center'><button style=\"background-color:#CCCC00\" onclick=\"toggleDisplay('MAR');\" href=\"javascript:void('')\">Monthly Activity Report</a></button></td>";


	echo "</tr>";
	echo "</table></div>";

	// State Park
	include("enter.php");

	// // Style Tips
	include("tips.php");

	// // Training Cal
	// include("train_cal.php");
	// 
	// // Safety Inspect
	// include("safety.php");

	// MAR
	include("mar_reg.php");


	echo "</body></html>";
	}
	else
	{
	include("enter.php");
	}


?>