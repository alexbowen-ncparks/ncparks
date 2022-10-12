<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;



extract($_REQUEST);





$file="pcard_split.php";
$fileMenu="pcard_recon_menu.php";
if(!isset($m)){$m="";}
$varQuery=$_SERVER['QUERY_STRING']."&m=$m";
// ECHO "v=$varQuery";//exit;
// ECHO "$_SERVER[QUERY_STRING]";//exit;
//$reportHeader=explode("&",$_SERVER[QUERY_STRING]);
//print_r($reportHeader);

if($admin_num){$parkcode=$admin_num;}// *************

$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

// **************  Show Results ***************
if(!isset($rep)){$rep="";}

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=pcard_reconcile.xls');
$reportHeader=explode("&",$_SERVER['QUERY_STRING']);
$showReportHeader="<tr><td>&nbsp;</td><td>$reportHeader[0]</td><td>$reportHeader[1]</td><td>$reportHeader[2]</td><td>$reportHeader[3]</td></tr>";
}

// ******** Show Results ***********

if($rep=="")
	{
	$varQuery=$_SERVER['QUERY_STRING'];
	include("$fileMenu");
	}


//Added-Start 2022-07-20 TBASS-TIC399  Queried start and end of fiscal year associated with $report_date. 
// This insures that we ONLY Query the current fiscal year to determine if the Transaction has already been Split.
//echo "report_date=$report_date";

$query_fyear_split="select start_date,end_date from fiscal_year where '$report_date' >= start_date and '$report_date' <= end_date ";
//echo "query_fyear_split=$query_fyear_split";

$result_fyear_split=mysqli_query($connection, $query_fyear_split) or die ("Couldn't execute query. $query_fyear_split");

$row_fyear_split=mysqli_fetch_array($result_fyear_split);

extract($row_fyear_split);



//echo " Line 71: fyear_split=$fyear_split";



 $query = "SELECT pcard_unreconciled.admin_num,
pcard_unreconciled.cardholder,
pcard_unreconciled.pcard_num,
pcard_unreconciled.location,
pcard_unreconciled.transid_new AS 'transid',
pcard_unreconciled.transdate_new AS 'transdate',
pcard_unreconciled.vendor_name,
pcard_unreconciled.amount,
pcard_unreconciled.id as pc_id
FROM pcard_unreconciled
WHERE transid_new='$transid' 
and transdate_new >= '$start_date' and transdate_new <= '$end_date';
 ";

//Added-End 2022-07-20 TBASS-TIC399

//echo "<br />query=$query<br />"; //exit;

   $result = @mysqli_query($connection, $query);
//echo "$query<br>";

$num=mysqli_num_rows($result);
if($num>1){echo "<font color='red'>Record has already been Split</font>. Can not be Split again. Please Email Administrator for Help.<br><br>Click your <font color='blue'>browser's Back button</font> to return to the Reconciliation Form.";exit;}

if(isset($split)){

echo "<table border='1'>";

echo "</form><form action='pcard_split_update.php' name='pcardSplitForm' method='POST'>";

if($m==1){echo "<tr><td colspan='16' align='center'><blink><font color='magenta'>An incorrect Center was entered. Please make the correction.</font></blink></td></tr>";}


if($level<3){$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid</th><th>&nbsp;&nbsp;transdate&nbsp;</th>
<th>vendor&nbsp;name</th><th>amount</th></tr>";

if(!isset($numHeader)){$numHeader="";}
echo "$numHeader $header";
//echo "<form action='pcard_split_update.php'>";
include("pcard_split_L1.php");}

if($level>2){$header="<tr><th>admin #s</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid</th><th>&nbsp;&nbsp;transdate&nbsp;</th>
<th>vendor&nbsp;name</th><th>amount</th></tr>";
echo "$numHeader $header";
include("pcard_split_L3.php");}
}
else
{
echo "Enter the number of records needed for split: 
<form><input type='text' name='split' value=''>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='transid' value='$transid'>
<input type='hidden' name='varQuery' value='$varQuery'>
<input type='submit' name='submit' value='Split'></form>";}

echo "</body></html>";

?>