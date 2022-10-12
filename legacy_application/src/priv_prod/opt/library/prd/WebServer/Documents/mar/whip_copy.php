<?php
ini_set('display_errors',1);
extract($_REQUEST);
date_default_timezone_set('America/New_York');

$db="war";
$database="war";
include_once("_base_top_war.php");// includes session_start();
include("../../include/connect_i_ROOT.inc"); // database connection parameters
include("../../include/get_parkcodes_i.php"); // database connection parameters

$today=date("Y-m-d");
$last_week=date("Y-m-d",strtotime('1 week ago'));
$next_week=date("Y-m-d",strtotime('next week'));
$last_week=$today;
$next_week=$today;
//echo "$last $today $next";

echo "<table><tr><td><h2>Weekly Activity Report - $today</h2></td></tr></table>";
// Calendar of Events

include("coe.php");

// PR-63
echo "<table><tr><td>PR_63: ";
include("pr63.php");
echo "</td></tr></table>";



echo "</body></html>";

?>