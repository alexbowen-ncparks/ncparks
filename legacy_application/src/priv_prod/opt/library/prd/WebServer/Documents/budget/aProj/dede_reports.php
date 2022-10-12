<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//$dbTable="partf_payments";

$varQuery=$_SERVER[QUERY_STRING];// ECHO "v=$varQuery";//exit;

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

// **************  Show Results ***************

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=year2year_comparison.xls');
echo "<html><body>";
echo "<table border='1' cellpadding='3' align='center'>";

}

echo "<table border='1' cellpadding='3' align='center'>";

// ******** Show Results ***********

//$showSQL=1;

if($rep==""){
//include("../menu.php");
include("../~f_year.php");

include("../../budget/menus_0322.php");
//echo "<tr><td><a href='$file?rep=excel'>Excel Export</a></td></tr><hr><table align='center' border='1'>";


$color='purple';
$f1="<font color='$color'>"; $f2="</font>";

// Menu 1
if($report_level=="category"){
	$file="report_category.php";
	$ckCat="checked";}
if($report_level=="project"){
	$file="report_projects.php";
	$ckPro="checked";}

if($report_period=="all"){
	$ckAll="checked";
	$rep_p="All Fiscal Years starting with Fiscal Year 9394";
	//$other_period="";
	}
if($report_period=="current"){
	$ckCur="checked";
	$rep_p="Current Fiscal Year: $f_year";
	//$other_period="";
	}
if($other_period!=""){$ckAll="";$ckCur="";}

if($showSQL==1){$p="method='POST'";}

echo "<table border='1' cellpadding='3' align='center'>";
echo "<form action='dede_reports.php' $p>";

echo "<tr><td align='center'>$f1 Report Level$f2 <br />(choose 1)</td>
<td><input type='radio' name='report_level' value='category'$ckCat> Category<br />
<input type='radio' name='report_level' value='project'$ckPro> Project
</td>
<td align='center'>$f1 Report Period$f2 <br />(choose 1)</td>
<td><input type='radio' name='report_period' value='all'$ckAll> All Fiscal Years starting with Fiscal Year 9394<br />
<input type='radio' name='report_period' value='current'$ckCur> Current Fiscal Year: $f_year<br />
Other Fiscal Year - Enter Fiscal Year (e.g., 0506) =><input type='text' name='other_period' value='$other_period' size='5'> </td></tr><tr>
<td align='center' colspan='4'><input type='submit' name='submit' value='Submit'></form></td>
<td><a href='dede_reports.php'>RESET</a></td></form>
</tr></table>";

}

if($report_level.$report_period.$other_period==""){exit;}

include("$file");
echo "</table></body></html>";

?>