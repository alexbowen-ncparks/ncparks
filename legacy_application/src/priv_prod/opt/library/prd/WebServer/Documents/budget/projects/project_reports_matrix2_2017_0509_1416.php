<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
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
/*
if($level=='5' and $tempID !='Dodd3454')

{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
*/
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//echo "f_year=$f_year";


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


$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/

//echo "active_file=$active_file";
$query11="SELECT filegroup
from projects_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Projects</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget1.php");
echo "<br />";
//echo "hello world";
include ("report_header2.php");
echo "<br />";

if($report == 'project'){include ("form_header_checkboxes1.php");}
if($report == 'center'){include ("form_header_checkboxes2.php");}
//if($submit != 'Find'){exit;}
//echo "py2=$py2";
//exit;

if($submit == 'Find' and $report == 'project'){include ("report1.php");}
if($submit == 'Find' and $report == 'center'){include ("report2.php");}



//include("report_header4.php");
//include("report_header3.php");
//include("report_header1.php");
//include("project_report1.php");
//if($report_type=='center'){include("center_report1.php");}
//include("project_balances_div.php");
//include("project_balances_fund_div.php");
//include ("report_header2.php");


//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
/*
if($period== 'fyear'){$table="report_budget_history_multiyear2";}
if($period== 'cyear'){$table="report_budget_history_multiyear_calyear3";}


 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";





//if($fyearhist=='10yr'){include "/ten_yr_history.php";}

if($section != 'all'){$where_section= " and section='$section' ";}

if($accounts != 'all' and $accounts != 'gmp')
{$where_accounts= " and cash_type='$accounts' ";}

if($accounts != 'all' and $accounts == 'gmp')
{$where_accounts= " and gmp='y' ";}

if($district != 'all' and $district != ''){$where_district= " and district='$district' ";}


if($report=='cent')
{

if($history=='10yr'){include("center_ten_yr_history.php");}
if($history=='5yr'){include("center_five_yr_history.php");}
if($history=='3yr'){include("center_three_yr_history.php");}
if($history=='1yr'){include("center_one_yr_history.php");}

}

if($report=='budg')
{

if($history=='10yr' and $report=='budg'){include("budget_group_ten_yr_history.php");}
if($history=='5yr' and $report=='budg'){include("budget_group_five_yr_history.php");}
if($history=='3yr' and $report=='budg'){include("budget_group_three_yr_history.php");}
if($history=='1yr' and $report=='budg'){include("budget_group_one_yr_history.php");}

}

*/


?>





















	














