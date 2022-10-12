<?php
//echo "controllers_deposit_id=$controllers_deposit_id<br />";
//echo "bank_deposit_date=$bank_deposit_date<br />";
//echo "cashier=$cashier<br />";
//echo "manager=$manager<br />";
/*
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$cashier'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
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

$query_head_total="select 
fuel_tank_usage.reimbursement_gallons,
fuel_tank_usage.reimbursement_rate,
sum(fuel_tank_usage.reimbursement_gallons*.12) as 'admin_fee',
sum(fuel_tank_usage.reimbursement_gallons*fuel_tank_usage.reimbursement_rate) as 'reimbursement_amount'
from fuel_tank_usage
where fyear='$fyear' and cash_month='$cash_month'
group by fuel_tank_usage.center;";

//echo "query_head_total=$query_head_total<br />";

$result_head_total = mysqli_query($connection, $query_head_total) or die ("Couldn't execute query head total.  $query_head_total ");
//$num12=mysqli_num_rows($result12);

$var_head_total="";

while ($head_total=mysqli_fetch_array($result_head_total))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($head_total);

$reimbursement_amount=number_format($reimbursement_amount,2);
$admin_fee=number_format($admin_fee,2);
$total_refund=$reimbursement_amount+$admin_fee;
//$total_refund2=number_format($total_refund,2);
//$var_total_refund+=$total_refund;
//$ncas_account='533310';
//$company='4601';
//$line_description='MFM Gas '.$cash_month_year;   //$cash_month_year comes from include file: journal_header.php

/*	
if($reimbursement_amount != '0.00')
		{
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}		
		
		@$rank=$rank+1;
		echo 

		"<tr$t> 
					<td>$rank</td>
					<td>$parkcode</td>			
					<td>$company</td>
					<td>$ncas_account</td>
					<td>$center</td>
					<td>$total_refund2</td>
					<td>CR</td>
					<td>$line_description</td>
					<td></td>             
		   
		</tr>";
      }
*/	  
	  
$var_total_refund+=$total_refund;
		}
$var_total_refund2=number_format($var_total_refund,2);
//echo "var_total_refund2=$var_total_refund2<br />";

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
echo "<tr><td></td><td></td><td></td><td></td><td>Total Credits</td><td><input type='text' name='total_credits' value='$var_total_refund2' size='11' readonly='readonly'></td></tr>";


echo "</table>";
?>