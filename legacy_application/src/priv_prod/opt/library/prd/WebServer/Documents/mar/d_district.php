<?php
ini_set('display_errors',1);
extract($_REQUEST);
date_default_timezone_set('America/New_York');

include("../../include/get_parkcodes_i.php"); // arrays - parkCode, district, parkCodeName, parkCounty, arrayDIST, all_parks

$db="war";
$database="war";
include_once("_base_top_dashboard.php");// includes session_start();
include("../../include/connect_i_ROOT.inc"); // database connection parameters

$today=date("Y-m-d");
$last_week=date("Y-m-d",strtotime('1 week ago'));
$prev_2_week=date("Y-m-d",strtotime('-2 week'));
$next_week=date("Y-m-d",strtotime('next week'));
$next_35=date("Y-m-d",strtotime('+5 week'));
//echo "$last $today $next";

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$today_formated=date("l, jS \of F Y");
$d_dist="";
if($level==2)
	{
	$d_dist=$_SESSION['war']['select'];
	}
echo "<div><table border='1'><tr><td colspan='6' align='center' bgcolor='#E0FFF5'><h2>NC State Park Dashboard $d_dist - $today_formated</h2></td></tr>";

echo "<tr>
<td><button style=\"background-color:#0047B2\" style=\"font-size:20px\" onclick=\"toggleDisplay('family');\" href=\"javascript:void('')\">Surplus</a></button></td>";

/*
echo "<td><button style=\"background-color:#007A29\" style=\"font-size:20px\" onclick=\"toggleDisplay('coe_prev');\" href=\"javascript:void('')\">Events - Prev 7 Days</a></button></td>
<td><button style=\"background-color:#007A29\" onclick=\"toggleDisplay('coe_next');\" href=\"javascript:void('')\">Events - Next 7 Days</a></button></td>

<td><button style=\"background-color:#5C2E00\" onclick=\"toggleDisplay('pr63_prev');\" href=\"javascript:void('')\">PR63 - Prev 7 Days</a></button></td>

<td><button style=\"background-color:#7A007A\" onclick=\"toggleDisplay('train');\" href=\"javascript:void('')\">Training CAL - Next 35 Days</a></button></td>

<td><button style=\"background-color:#CC7A00\" onclick=\"toggleDisplay('safety');\" href=\"javascript:void('')\">Safety Inspect. - Prev 7 Days</a></button></td>
*/

echo "</tr>";
echo "</table></div>";

// State Park Family
include("d_surplus.php");

/*
// Calendar of Events
include("coe_prev.php");
include("coe_next.php");

// PR-63
include("pr63.php");

// Training Cal
include("train_cal.php");

// Safety Inspect
include("safety.php");

*/

echo "</body></html>";

?>