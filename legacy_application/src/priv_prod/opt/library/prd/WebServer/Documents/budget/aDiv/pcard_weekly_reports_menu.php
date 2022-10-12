<?php
//These are placed outside of the webserver directory for security
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$m="pcard";
//include("../menu.php");
//include("../../budget/menus2.php");
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;
//Allow Level>1 to have correct park show in input box
if($level==1){$admin_num=$_SESSION['budget']['select'];}

// Make f_year
//include("../~f_year.php");
include("../menu_js.php");
$menu_new='weekly_reports';
//echo "<br />menu_new=$menu_new<br />";
include ("../../budget/menu1415_v1.php");



echo "<br />";

include("../../budget/acs/pcard_new_menu1.php");
echo "<div align='center'><br>";
//echo "PCARD Reconciliation for PARKS";
echo "<hr>";

echo "<table><form><tr>";

// Menu 1 - get report date (year) list for drop-down
$sql = "SELECT distinct(report_date) as rd
from pcard_report_dates
where 1 and active='y'
order by report_date desc";
$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());
if($level>4){echo "$sql";}//exit;

if($report=="DENR"){$FILE="pcard_weekly_reports_DENR.php";}else{$FILE="pcard_weekly_reports.php";}

while($row = mysqli_fetch_array($total_result)){
$menuArray[]=$row[rd];}
//print_r($menuArray);exit;
echo "<td align='center'>Report Date<br><select name=\"report_date\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($report_date==$menuArray[$n]){$s="selected";}else{$s="value";}
$con="/budget/aDiv/$FILE?report_date=$menuArray[$n]";
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select>";
if($new_rep_add != 'y'){echo "<br /><br /><a href='pcard_weekly_reset.php?new_rep_add=y'>Add New Report</a>";}
if($new_rep_add == 'y')
{echo "<br /><br /><table>";
echo "<tr><td><td></td><font color='red'>New Report ADD</font></td></tr>";
//echo "<tr><td>(A) Open XTND Report named: <u>pc_unreconciled_trans</u></td></tr>";
//echo "<tr><td>(B) Open XTND Format named: <u>pcard</u></td></tr>";
//echo "<tr><td>(C) Save XTND Report to desktop as CSV File named: <u>pcard.csv</u></td></tr>";
//echo "<tr><td>(D) Upload CSV File. Click <a href='/budget/test_upload_cs2.php' target='_blank'><u>here</u></a></td></tr>";
echo "</table>";
/*
echo "(A) Open XTND Report named: <u>pc_unreconciled_trans</u><br />
(B) Open XTND Format named: <u>pcard</u><br />
(C) Save XTND Report to desktop as CSV File named: <u>pcard.csv</u><br />
(D) Upload CSV File. Click <a href='/budget/test_upload_cs2.php' target='_blank'><u>here</u></a>";
*/
echo "<b>(1)</b> Login to NCX-Cloud & go to Navigation Panel (top left corner)<br />";
echo "<b>(2)</b> Under TOOLS, Click LINK named: Scripts. (This brings back ALL your Scripts)<br />";
echo "<b>(3)</b> Locate SCRIPT named:  pc_unreconciled_trans_v2_parks  (click on the BOX with the arrow) in the first column<br />";
echo "<b>(4)</b> Move MOUSE over text named:  Run Script<br />";
echo "<b>(5)</b> Click on text named:  Allow Saving in Script Results<br />";
echo "<b>(6)</b> Click on <b>Close</b> at the top right of the screen<br />";
echo "<b>(7)</b> Click on <b>Save</b> at the bottom of the screen<br />";
echo "<b>(8)</b> Step 5 downloads the CSV File to your Computer  (most likely to your DOWNLOADS Folder)<br />";
echo "<b>(9)</b> Locate CSV File in your Downloads Folder. Re-Name the CSV File as: pcard.csv<br />";
echo "<b>(10)</b> Drag \"pcard.csv\" into \"PCARD Downloads Folder\"</u> on Desktop. This will replace File from last Week<br />";
echo "<b>(11)</b> Upload CSV File. Click <a href='/budget/test_upload_cs2.php' target='_blank'><u>here</u></a></td></tr>";
/*

5)	Locate SCRIPT named:  pc_unreconciled_trans_v2_parks  (click on the BOX with the arrow) in the first column
6)	Move MOUSE over text named:  Run Script
7)	Click on text named:  Allow Saving in Script Results
8)	Step 7 downloads the CSV File to your Desktop  (most likely in your DOWNLOADS Folder)
9)	You’ll probably want to created a Folder named: “PCARD Downloads” on your Desktop and move the CSV File to that Folder 
10)	Once the CSV File is in your “PCARD Downloads” Folder, you need to RENAME the CSV File to:  pcard.csv
11)	Now you are ready to UPLOAD the file named:  pcard.csv  INTO  MoneyCounts   
12)	Go to PCARD Module in MoneyCounts and Click on LINK named:  Weekly Reports
13)	Click LINK named:  Add New Report
14)	UPLOAD CSV File named: pcard.csv

*/


}
   echo "</td>";
   //echo "</select><br /><a href='/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e' target='_blank'>Add New Report</a></td>";

if($report_date){
// Menu 2
if($ci_fund_status=='y')
{
$ci_change="update pcard_report_dates set fund_ci='n' where report_date='$report_date' "; 
$ci_change_result = @mysqli_query($connection, $ci_change) or die("Error #1". mysql_errno() . ": " . mysqli_error());
echo "<br />ci_change=$ci_change<br />";
}

if($ci_fund_status=='n')
{
$ci_change="update pcard_report_dates set fund_ci='y' where report_date='$report_date' "; 
$ci_change_result = @mysqli_query($connection, $ci_change) or die("Error #1". mysql_errno() . ": " . mysqli_error());
echo "<br />ci_change=$ci_change<br />";
}


$sql = "SELECT xtnd_start,xtnd_end,fund_1680,fund_ci
from pcard_report_dates
where report_date='$report_date'";
$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());
//echo "$sql";exit;

$row = mysqli_fetch_array($total_result);
extract($row);
if($fund_ci=='y'){$ci_fund_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fund_ci=='n'){$ci_fund_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";}
echo "<td align='center'>Xtnd Start: <input type='text' name='xtnd_start' value='$xtnd_start' size='12'></td>";

echo "<td align='center'>Xtnd End: <input type='text' name='xtnd_end' value='$xtnd_end' size='12'></td>";
if($beacnum=='60032781' or $beacnum=='60032997' or $beacnum=='60032793')
{
echo "<td align='center'>CI Funds permitted: <a href='pcard_weekly_reports.php?report_date=$report_date&ci_fund_status=$fund_ci'><font class='cartRow'>$ci_fund_sigmark $fund_ci </font></a></td>";
}

echo "</form></td>";
}
//echo "<td>Hello World</td>";
echo "</tr></table>";
//echo "<table><tr><th>Hello World</th></tr></table>";

echo "<hr>";
?>