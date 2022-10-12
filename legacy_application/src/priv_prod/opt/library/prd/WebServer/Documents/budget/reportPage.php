<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

//print_r($_SESSION);//exit;
extract($_REQUEST);
include("menu.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");
$sql="Select DATE_FORMAT(max(datenew),'<font color=\'red\'>%Y-%m-%e') as maxDate from partf_payments";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);extract($row);

$year=date("Y");
$month=date("m")-1;// get previous month
if($month<1){// deal with Jan of a new year
$month=12;$year=$year-1;}

$fullMonth=date("F", mktime(0,0,0,$month,1,$year));
$month=str_pad($month,2,"0",STR_PAD_LEFT);
$startMonthDay=$month."01";

$cont="true";$test=27;// get last day of month
while(($test<=32)&&($cont)){
$cont=checkdate($month,$test,$year);
if(!$cont){$lastday=$test-1;} 
$test++;}

$endMonthDay=$year.$month.$lastday;

if($f==1){
echo "<hr>
<div align='center'><form action='ReportPARTF.php'><table><tr>";
if($allRecords=="all"){$ck1="checked";}else{$ck2="checked";}
echo "
<td><input type='radio' name='allRecords' value='all' $ck1><b>All Records</b></td>
<td><input type='radio' name='allRecords' value='partf' $ck2><b>PARTF Report</b>&nbsp;&nbsp;</td></tr>
<tr><td>Start Date (yyyymmdd): <input type='text' name='start' size='10' value='$year$startMonthDay'></td>

<td>End Date (yyyymmdd): <input type='text' name='end' size='10' value='$endMonthDay'></td>
<td>Project Balances Available thru: $maxDate</font><br>Current Report Month: <input type='text' name='reportMonth' size='20' value='$fullMonth $year'>
<input type='submit' name='submit' value='Find'></form></td></tr></table>
<form></div>";}

if($f==2){
echo "<hr>
<div align='center'><form action='ReportPARTFx.php'><table><tr>";
if($allRecords=="all"){$ck1="checked";}else{$ck2="checked";}
echo "
<td><input type='radio' name='allRecords' value='all' $ck1><b>All Records</b></td>
<td><input type='radio' name='allRecords' value='partf' $ck2><b>PARTF Report</b>&nbsp;&nbsp;</td>
<td>Start Date (yyyymmdd): <input type='text' name='start' size='10' value='$year$startMonthDay'></td>

<td>End Date (yyyymmdd): <input type='text' name='end' size='10' value='$endMonthDay'></td>
<td>Current Report Month: <input type='text' name='reportMonth' size='10' value='$fullMonth $year'>
<input type='submit' name='submit' value='Find'></form></td></tr></table>
<form></div>";}

  ?>
</body>
</html>
