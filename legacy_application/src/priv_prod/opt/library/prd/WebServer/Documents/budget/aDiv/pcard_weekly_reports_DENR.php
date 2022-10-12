<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//$dbTable="partf_payments";

$file="pcard_weekly_reports_DENR.php";
$fileMenu="pcard_weekly_reports_menu.php";
$varQuery=$_SERVER['QUERY_STRING'];// ECHO "v=$varQuery";//exit;

extract($_REQUEST);

if($admin_num){$parkcode=$admin_num;}
$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

$varQuery="report_date=$report_date";

// **************  Show Results ***************

if($rep=="excel"){
$forceText="pc-";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=DENR_pcard_weekly_report.xls');
}


// ******** Show Results ***********

if($rep==""){
$report="DENR";
include("$fileMenu");
if($varQuery){
echo "<a href='$file?$varQuery&rep=excel&xtnd_end=$xtnd_end'>Excel Export</a>";}
}

if($report_date){

include("../../../include/connectBUDGET.inc");

echo "<html><body>
<table border='1' cellpadding='3' align='center'>";

$query="update pcard_unreconciled,coa
set pcard_unreconciled.travel='y'
where pcard_unreconciled.ncasnum=coa.ncasnum
and coa.budget_group='travel'
and (pcard_unreconciled.ncasnum like '5327%' or pcard_unreconciled.ncasnum ='532930')";
$result = @mysqli_query($connection, $query,$connection);
if($showSQL){echo "<br /><br />";}


 $query = "select
admin_num as 'admin',
cardholder,
pcard_num as 'pcard_number',
location,
transid_new as 'transid',
transdate_new as 'transdate',
vendor_name,
amount,
xtnd_rundate_new as 'xtnd_date',
report_date
from pcard_unreconciled
where report_date='$report_date'
order by location,admin_num,cardholder,pcard_num
";
   $result = @mysqli_query($connection, $query,$connection);
   $num=mysqli_num_rows($result);
if($showSQL){echo "<br /><br />";}


$header="<tr><th colspan='10' align='center'><font color='red'>DPR PCARD Transactions Week Ending  $xtnd_end</font>
</th></tr><tr><th>admin #</th><th>cardholder</th><th>pcard number</th><th>location</th><th>transid</th><th>transdate</th><th>vendor name</th><th>amount</th><th>xtnd date</th><th>report date</th></tr>
";

echo "$header";

$j=0;
$s="sum";

while($row = mysqli_fetch_array($result)){
extract($row);

//if($location=="1656"){$sum1656+=$amount;}
//if($location=="1669"){$sum1669+=$amount;}

$l=$location;
$st=${$s.$l};
${$s.$l}+=$amount;
$sumTotal+=$amount;

if($j!=0 and $ck!=$location){
$subLoc=number_format(${$s.$ck},2);

$subTotal="<tr><th colspan='4' align='right'>$ck Total</th><th colspan='4' align='right'>$subLoc</th></tr>";
echo "$subTotal";}
$ck=$location;$j++;
echo "<tr>";
$pcard_number="'".$pcard_number;

echo "<td align='center'>$admin</td>
<td align='center'>$cardholder</td>
<td align='center'>$pcard_number</td>
<td align='center'>$location</td>
<td align='center'>$transid</td>
<td align='center'>$transdate</td>
<td align='center'>$vendor_name</td>
<td align='right'>$amount</td>
<td align='center'>$xtnd_date</td>
<td align='center'>$report_date</td>
";

echo "</tr>";
	}// end while
} // end if report_date
$sumTotal=number_format($sumTotal,2);

if($j==$num){
$subLoc=number_format(${$s.$location},2);
$subTotal="<tr><th colspan='4' align='right'>$ck Total</th><th colspan='4' align='right'>$subLoc</th></tr>";echo "$subTotal";}

echo "<tr>
<th colspan='4' align='right'>Grand Total</th>
<th colspan='4' align='right'>$sumTotal</th>
</tr>";
echo "</div></body></html>";

?>