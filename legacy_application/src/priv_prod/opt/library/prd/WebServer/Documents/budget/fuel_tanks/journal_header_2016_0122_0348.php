<?php
//echo "controllers_deposit_id=$controllers_deposit_id<br />";
//echo "bank_deposit_date=$bank_deposit_date<br />";
//echo "cashier=$cashier<br />";
//echo "manager=$manager<br />";
/*
$database="divper";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$cashier'";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$row=mysql_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
*/

if($bank_deposit_date2=='0000-00-00'){$bank_deposit_date2='';}
$budcode='14800';
$calyear1='20'.substr($fyear,0,2);
$calyear2='20'.substr($fyear,2,2);
//echo "calyear1=$calyear1<br /><br />";
//echo "calyear2=$calyear2<br /><br />";

if($cash_month=='july' or $cash_month=='august' or $cash_month=='september' or $cash_month=='october' or $cash_month=='november' or $cash_month=='december') {$calyear=$calyear1;}
if($cash_month=='january' or $cash_month=='february' or $cash_month=='march' or $cash_month=='april' or $cash_month=='may' or $cash_month=='june') {$calyear=$calyear2;}

$cash_month_year=$cash_month.' '.$calyear ;
//echo "$cash_month_year<br />";

echo "<h2 align='center'><font color='blue'>Department of Natural and Cultural Resources</font></h2>";



echo "<h2 align='center'>Journal Adjustment Code Sheet</h2>";
//echo "<h5 align='right'>Page ___of___</h5>";
/*
echo "<table><tr><td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'>
CRJ</a></td></tr></table>";
*/

echo "<form>
<table align='center' cellspacing='15' style='font-size:25pt';>";
//echo "<tr><td colspan='10' align='right'>Page__of__</td></tr>";
echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Page__of__</td></tr>";
echo "<tr>
<td>Division</td> <td><u>Parks & Recreation</u></td>
<td>GL Effective Date:</td> <td><input type='text' name='gleffect' value='$cash_month_year' size='11' readonly='readonly'></td>
<td>Budget Code:</td> <td><input type='text' name='budcode' value='$budcode' size='9' readonly='readonly'></td></tr>";
//echo "<tr><td></td><td></td><td></td><td></td><td>Total Debits</td><td><input type='text' name='total_debits' value='' size='11' readonly='readonly'></td></tr>";
echo "<tr><td></td><td></td><td></td><td></td><td>Total Credits</td><td><input type='text' name='total_credits' value='$var_total_refund' size='11' readonly='readonly'></td></tr>";


echo "</table>";
?>