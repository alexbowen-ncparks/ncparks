<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
include("../../budget/menu1314.php");
include ("energy_report_menu_v2.php");
include ("energy_widget1_v2.php");
//include ("park_posted_deposits_monthly_distmenu_v2.php");
//include ("park_posted_deposits_fyear_header.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


if($egroup=='electricity' and $report=='cdcs'){include ("electricity_cdcs.php"); }
if($egroup=='electricity' and $report=='accounts'){include ("electricity_accounts.php"); }
if($egroup=='electricity' and $report=='cost'){include ("electricity_cost.php"); }
if($egroup=='electricity' and $report=='usage'){include ("electricity_usage.php"); }
if($egroup=='electricity' and $report=='rate'){include ("electricity_rate.php"); }

if($egroup=='water' and $report=='cdcs'){include ("water_cdcs.php"); }
if($egroup=='water' and $report=='accounts'){include ("water_accounts.php"); }
if($egroup=='water' and $report=='cost'){include ("water_cost.php"); }
if($egroup=='water' and $report=='usage'){include ("water_usage.php"); }
if($egroup=='water' and $report=='rate'){include ("water_rate.php"); }

if($egroup=='natgas_propane' and $report=='cdcs'){include ("natgas_propane_cdcs.php"); }
if($egroup=='natgas_propane' and $report=='accounts'){include ("natgas_propane_accounts.php"); }
if($egroup=='natgas_propane' and $report=='cost'){include ("natgas_propane_cost.php"); }
if($egroup=='natgas_propane' and $report=='usage'){include ("natgas_propane_usage.php"); }
if($egroup=='natgas_propane' and $report=='rate'){include ("natgas_propane_rate.php"); }








?>


 


























	














