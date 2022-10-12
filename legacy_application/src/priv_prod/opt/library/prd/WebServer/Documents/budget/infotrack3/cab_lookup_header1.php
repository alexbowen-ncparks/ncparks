<?php
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

include("../../budget/menu1314.php");


if($f_year=='1415'){$shade_1415="class=cartRow";}
if($calmonth=='jul'){$shade_jul="class=cartRow";}
if($calmonth=='aug'){$shade_aug="class=cartRow";}
if($calmonth=='sep'){$shade_sep="class=cartRow";}
if($calmonth=='oct'){$shade_oct="class=cartRow";}
if($calmonth=='nov'){$shade_nov="class=cartRow";}
if($calmonth=='dec'){$shade_dec="class=cartRow";}
if($calmonth=='jan'){$shade_jan="class=cartRow";}
if($calmonth=='feb'){$shade_feb="class=cartRow";}
if($calmonth=='mar'){$shade_mar="class=cartRow";}
if($calmonth=='apr'){$shade_apr="class=cartRow";}
if($calmonth=='may'){$shade_may="class=cartRow";}
if($calmonth=='jun'){$shade_jun="class=cartRow";}
echo "<h3><font color=brown>Certfied Authorized Budget Report-Fund 1280 (Month-End Reports)</font></h3>";

echo "<br />";
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal Year</font></td>";


echo "<td><a href='cab_lookup_header1.php?f_year=1415'><font  $shade_1415>1415</font></a></td>";


echo "</tr>";

echo "</table>";
echo "<br />";

/*
echo "<table border='1'>";
echo "<tr>";
echo "<td><a href='cab_fund/cab_fund_1415_jul.xlsx'><font  $shade_jul>Jul</td>";
echo "<td><a href='cab_fund/cab_fund_1415_aug.xlsx'><font  $shade_aug>Aug</td>";
echo "<td><a href='cab_fund/cab_fund_1415_sep.xlsx'><font  $shade_sep>Sep</td>";
echo "<td><a href='cab_fund/cab_fund_1415_oct.xlsx'><font  $shade_oct>Oct</td>";
echo "<td><a href='cab_fund/cab_fund_1415_nov.xlsx'><font  $shade_nov>Nov</td>";
echo "<td><a href='cab_fund/cab_fund_1415_dec.xlsx'><font  $shade_dec>Dec</td>";
echo "<td><a href='cab_fund/cab_fund_1415_jan.xlsx'><font  $shade_jan>Jan</td>";
echo "<td><a href='cab_fund/cab_fund_1415_feb.xlsx'><font  $shade_feb>Feb</td>";
echo "<td><a href='cab_fund/cab_fund_1415_mar.xlsx'><font  $shade_mar>Mar</td>";
echo "<td><a href='cab_fund/cab_fund_1415_apr.xlsx'><font  $shade_apr>Apr</td>";
echo "<td><a href='cab_fund/cab_fund_1415_may.xlsx'><font  $shade_may>May</td>";
echo "<td><a href='cab_fund/cab_fund_1415_jun.xlsx'><font  $shade_jun>Jun</td>";

echo "</table>";
*/

echo "<table border='1'>";
echo "<tr>";
/*
echo "<td><a href='cab_fund/cab_fund_1415_jul.xlsx'><font  $shade_jul>Jul</td>";
echo "<td><a href='cab_fund/cab_fund_1415_aug.xlsx'><font  $shade_aug>Aug</td>";
echo "<td><a href='cab_fund/cab_fund_1415_sep.xlsx'><font  $shade_sep>Sep</td>";
echo "<td><a href='cab_fund/cab_fund_1415_oct.xlsx'><font  $shade_oct>Oct</td>";
echo "<td><a href='cab_fund/cab_fund_1415_nov.xlsx'><font  $shade_nov>Nov</td>";
echo "<td><a href='cab_fund/cab_fund_1415_dec.xlsx'><font  $shade_dec>Dec</td>";
echo "<td><a href='cab_fund/cab_fund_1415_jan.xlsx'><font  $shade_jan>Jan</td>";
echo "<td><a href='cab_fund/cab_fund_1415_feb.xlsx'><font  $shade_feb>Feb</td>";
*/
echo "<td><a href='cab_fund/cab_fund_1415_mar.xlsx'><font  $shade_mar>Mar</td>";

echo "<td><a href='cab_fund/cab_fund_1415_apr.xlsx'><font  $shade_apr>Apr</td>";
echo "<td><a href='cab_fund/cab_fund_1415_may.xlsx'><font  $shade_may>May</td>";
echo "<td><a href='cab_fund/cab_fund_1415_june(tentative).xlsx'><font  $shade_june>June</td>";
/*
echo "<td><a href='cab_fund/cab_fund_1415_may.xlsx'><font  $shade_may>May</td>";
echo "<td><a href='cab_fund/cab_fund_1415_jun.xlsx'><font  $shade_jun>Jun</td>";
*/
echo "</table>";


?>







