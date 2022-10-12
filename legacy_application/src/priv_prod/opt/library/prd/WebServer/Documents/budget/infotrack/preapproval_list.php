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
//if($level <3){$admin_num=$concession_location;}
$admin_num=$concession_location;
//echo "admin_num=$admin_num<br />";
if($admin_num=='ADM'){$admin_num="ADMN";}

extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo $system_entry_date;//exit;
//print_r($_SESSION);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$query="select
location,	
purchase_description,	
requested_amount,	
ordered_amount,	
ncas_account,
account_description,	
f_year,	
pa_number,	
purchase_type,	
report_date
from purchase_request_3
where location='$concession_location'
and f_year='$f_year' " ;

echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
$num=mysqli_num_rows($result);

/*

$query_total="select sum(amount) as 'total_dollars'
              from pcard_unreconciled
			  where admin_num='$admin_num'
			  and transdate_new >= '$range_start'
              and transdate_new <= '$range_end' ";


$result_total = mysqli_query($connection, $query_total) or die ("Couldn't execute query total.  $query_total");

$row_total=mysqli_fetch_array($result_total);
extract($row_total);

//echo "total_dollars=$total_dollars<br />";
$total_dollars2=number_format($total_dollars,2);

*/

echo "<html><body>";
/*
echo "<style>";
echo "td{text-align:center; font-size: 20px;}";
echo "th{text-align:center; font-size: 20px; color: brown;}";
echo "input{text-align:center; font-size: 20px;}";
echo "</style>";
*/
include ("../../budget/menu1415_v1.php");
echo "<br />";

echo "<table><tr><td><font color='brown' size='5'>Records: $num</font></td></tr></table><br />";
/*
echo "<table><tr><td><a href='/budget/infotrack/date_range_module.php?admin_num=$admin_num&range_start=$range_start&range_end=$range_end&rep=excel' target='_blank'>Excel</a></td></tr></table>";
*/
//echo "$spreadsheet_icon<br />";
echo "<table>";



echo "<tr>";
echo "<th>location</th>";

//echo "<th>admin_num</th>";

echo "<th>purchase_description</th>";
echo "<th>requested_amount</th>";
echo "<th>ordered_amount</th>";
echo "<th>ncas_account</th>";
echo "<th>account_description</th>";
//echo "<th>address</th>";

//echo "<th>xtnd_rundate</th>";
//echo "<th>parkcode</th>";

echo "<th>f_year</th>";
echo "<th>pa_number</th>";
echo "<th>purchase_type</th>";
echo "<th>report_date</th>";



echo "</tr>";

while ($row=mysqli_fetch_array($result)){


extract($row);

if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


echo 

"<tr$t>";
echo "<td>$location</td>";
echo "<td>$purchase_description</td>";
echo "<td>'$requested_amount'</td>";
echo "<td>$ordered_amount</td>";
//echo "<td>$admin_num</td>";
echo "<td>$ncas_account</td>";
echo "<td>$account_description</td>";
//echo "<td>$address</td>";

//echo "<td>$xtnd_rundate</td>";
//echo "<td>$parkcode</td>";

echo "<td>$f_year</td>";
echo "<td>$pa_number</td>";
echo "<td>$purchase_type</td>";
echo "<td>$report_type</td>";


echo "</tr>";
}
echo "</table>";



echo "</body></html>";






?>

