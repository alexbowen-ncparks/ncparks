<?php
//These are placed outside of the webserver directory for security
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$m="pcard";
include("../menu.php");
//include("../../budget/menus2.php");
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;
//Allow Level>1 to have correct park show in input box
if($level==1){$admin_num=$_SESSION['budget']['select'];}

// Make f_year
//include("../~f_year.php");


echo "<div align='center'><br>PCARD Reconciliation for PARKS<hr>";

echo "<table><form><tr>";

// Menu 1
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
if($new_rep_add != 'y'){echo "<br /><br /><a href='pcard_weekly_reports.php?new_rep_add=y'>Add New Report</a>";}
if($new_rep_add == 'y')
{echo "<br /><br /><table>";
echo "<tr><td><td></td><font color='red'>New Report ADD</font></td></tr>";
echo "<tr><td>(A) Open XTND Report named: <u>pc_unreconciled_trans</u></td></tr>";
echo "<tr><td>(B) Open XTND Format named: <u>pcard</u></td></tr>";
echo "<tr><td>(C) Save XTND Report to desktop as CSV File named: <u>pcard.csv</u></td></tr>";
echo "<tr><td>(D) Upload CSV File. Click <a href='/budget/test_upload_cs2.php' target='_blank'>here</a></td></tr>";
echo "</table>";

}
   echo "</td>";
   //echo "</select><br /><a href='/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e' target='_blank'>Add New Report</a></td>";

if($report_date){
// Menu 2
$sql = "SELECT xtnd_start,xtnd_end
from pcard_report_dates
where report_date='$report_date'";
$total_result = @mysqli_query($connection, $sql) or die("Error #1". mysql_errno() . ": " . mysqli_error());
//echo "$sql";exit;

$row = mysqli_fetch_array($total_result);
extract($row);

echo "<td align='center'>Xtnd Start: <input type='text' name='xtnd_start' value='$xtnd_start' size='12'></td>";

echo "<td align='center'>Xtnd End: <input type='text' name='xtnd_end' value='$xtnd_end' size='12'></td>";

echo "</form></td>";
}
//echo "<td>Hello World</td>";
echo "</tr></table>";
//echo "<table><tr><th>Hello World</th></tr></table>";

echo "<hr>";
?>