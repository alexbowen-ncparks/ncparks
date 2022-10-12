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
/*
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
*/

$query1="update `budget_service_contracts`.`invoices`,`budget`.`center`
         set `budget_service_contracts`.`invoices`.`center_description`=`budget`.`center`.`center_desc`
		 where `budget_service_contracts`.`invoices`.`park`=`budget`.`center`.`parkcode`
		 and `budget`.`center`.`new_fund`='1680' and `budget`.`center`.`actcenteryn`='y' ";
		 
//$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);


//$row1=mysqli_fetch_array($result1);

extract($row1);

//echo "<br />Journal header form Line 47: Update Successful<br />";  exit;






$query_head="select 
             `budget_service_contracts`.`invoices`.`invoice_num`,
			 `budget_service_contracts`.`invoices`.`invoice_date`,
			 `budget_service_contracts`.`invoices`.`invoice_amount`,
			 `budget_service_contracts`.`invoices`.`ncas_account`,
			 `budget_service_contracts`.`invoices`.`park`,
             `budget_service_contracts`.`invoices`.`center_description`,
			 `budget_service_contracts`.`invoices`.`center`,
       		 `budget_service_contracts`.`invoices`.`company`,
			 `budget_service_contracts`.`invoices`.`service_period`,
             `budget_service_contracts`.`invoices`.`cashier`,
			 `budget_service_contracts`.`invoices`.`cashier_date`,
             `budget_service_contracts`.`invoices`.`manager`,
			 `budget_service_contracts`.`invoices`.`manager_date`,
             `budget_service_contracts`.`invoices`.`puof`,
			 `budget_service_contracts`.`invoices`.`puof_date`,
             `budget_service_contracts`.`invoices`.`buof`,
			 `budget_service_contracts`.`invoices`.`buof_date`,
             `budget_service_contracts`.`invoices`.`contract_administrator`,
			 `budget_service_contracts`.`invoices`.`contract_administrator_date`,
			 `budget_service_contracts`.`invoices`.`park_approved`,
			 `budget_service_contracts`.`invoices`.`scid`,
			 `budget_service_contracts`.`invoices`.`document_location`,
			 `budget_service_contracts`.`contracts`.`purpose`,
			 `budget_service_contracts`.`contracts`.`contract_num`,
			 `budget_service_contracts`.`contracts`.`contract_administrator`,
			 `budget_service_contracts`.`contracts`.`po_num`,
			 `budget_service_contracts`.`contracts`.`line_num`,
			 `budget_service_contracts`.`contracts`.`vendor`,
			 `budget_service_contracts`.`invoices`.`remit_address`,
			 `budget_service_contracts`.`contracts`.`buy_entity`,
			 `budget_service_contracts`.`contracts`.`fid_num`,
			 `budget_service_contracts`.`contracts`.`group_num`
			 from `budget_service_contracts`.`invoices`
			 left join `budget_service_contracts`.`contracts` on `budget_service_contracts`.`invoices`.`scid`=`budget_service_contracts`.`contracts`.`id`
			 where `budget_service_contracts`.`invoices`.`id`='$id' ";
//$result_head=mysqli_query($connection, $query_head) or die ("Couldn't execute query head. $query_head");
$result_head=mysqli_query($connection,$query_head) or die ("Couldn't execute query head. $query_head");
$row_head=mysqli_fetch_array($result_head);


//$row_head=mysqli_fetch_array($result_head);

extract($row_head);
//echo "query_head_total=$query_head_total<br />";

echo "<br />Journal header form Line 101: query_head=$query_head<br />"; // exit;

//echo "<h4 align='center'>N.C. Department of Natural and Cultural Resources</font></h3>";
echo "<h3 align='center'><font color='brown'>PARKS & RECREATION SERVICE AND GRANT CONTRACT EXPENDITURE PAYMENT FORM</font></h2>";
//echo "<h4 align='center'>(DO NOT USE the Cash Disbursements Code Sheet for Service or Grant Contract Payments)</h3>";


echo "<table border=0 align='center'>";
echo "<tr>";
//Left Side Table Begins
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<td>";
echo "Month of Service<br />(example Dec 2015)";
echo "</td>";
echo "<th>";
//echo "December 2015";
echo "$service_period";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "DPR Park or Section";
echo "</td>";
echo "<th>";
//echo "Morrow Mountain State Park";
echo "$center_description";
echo "</th>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Contractor";
echo "</td>";
echo "<th>";
//echo "Perfection First Service";
echo "$vendor";
echo "</th>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Contract Number";
echo "</td>";
echo "<th>";
//echo "6529";
echo "$contract_num";
echo "</th>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "Purchase Order Number";
echo "</td>";
echo "<th>";
//echo "NC10263639";
echo "$po_num";
echo "</th>";
echo "</tr>";
/*
echo "<tr>";
echo "<td>";
echo "PO Line Number";
//echo "<br />(Lines funds are on to support cost)";
echo "</td>";
echo "<th>";
//echo "1";
echo "$line_num";
echo "</th>";
echo "</tr>";
*/












echo "<tr>";
echo "<td>";
echo "FID# and Group#";
echo "</td>";
echo "<th>";
//echo "<table border='1' align='center'><tr><td>562247297</td><td>A</td></tr></table>";
echo "<table border='1' align='center'><tr><th>$fid_num</th><th>$group_num</th></tr></table>";
echo "</th>";
echo "</tr>";

/*
echo "<tr>";
echo "<td>";
echo "Buy Entity (46ES or 46EG)";
echo "</td>";
echo "<th>";
//echo "46ES";
echo "$buy_entity";
echo "</th>";
echo "</tr>";
*/






echo "<tr>";
echo "<td>";
echo "Remit to Name";
echo "</td>";
echo "<th>";
//echo "PO Box 391 Marion, NC 28752-0391";
echo "$vendor";
echo "</th>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo "Remit to Address";
echo "</td>";
echo "<th>";
//echo "PO Box 391 Marion, NC 28752-0391";
echo "$remit_address";
echo "</th>";
echo "</tr>";












/*
echo "<tr>";
echo "<td>";
echo "Purpose";
echo "</td>";
echo "<td colspan='2'>";
echo "Janitorial Services";
echo "</td>";
echo "</tr>";
*/
echo "</table>";
echo "</td>";
//Left Side Table Ends
// extra spaces between 2 Tables
//echo "<td></td><td></td>";
//Right Side Table Begins

/*
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<td>";
echo "Purchase Order Number";
echo "</td>";
echo "<th>";
//echo "NC10263639";
echo "$po_num";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "PO Line Number<br />(Lines funds are on to support cost)";
echo "</td>";
echo "<th>";
//echo "1";
echo "$line_num";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Buy Entity (46ES or 46EG)";
echo "</td>";
echo "<th>";
//echo "46ES";
echo "$buy_entity";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Total Current Expenditures<br />(auto populates)";
echo "</td>";
echo "<th>";
echo "$invoice_amount";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Grants Only<br />(NC Grant ID# if Non-Gov Agency)";
echo "</td>";
echo "<td>";
echo "";
echo "</td>";
echo "</tr>";


echo "</table>";
echo "</td>";
*/


echo "</tr>";

//echo "<tr><td colspan='2'><table border='1'><tr><td>Purpose: Janitorial Services for Morrow Mountain State Park vacation cabins</td></tr></table></td></tr>";

echo "<tr><td colspan='2'><table border='1'><tr><th>Purpose: $purpose</th></tr></table></td></tr>";


echo "</table>";
// Previous Line: Master Table Ends  (includes Left Table and Right Table)
 




















//echo "<h5 align='right'>Page ___of___</h5>";
/*
echo "<table><tr><td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'>
CRJ</a></td></tr></table>";
*/
/*
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
*/
?>