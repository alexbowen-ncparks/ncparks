<?php


$query1="update `budget_service_contracts`.`invoices`,`budget`.`center`
         set `budget_service_contracts`.`invoices`.`center_description`=`budget`.`center`.`center_desc`
		 where `budget_service_contracts`.`invoices`.`park`=`budget`.`center`.`parkcode`
		 and `budget`.`center`.`new_fund`='1680' and `budget`.`center`.`actcenteryn`='y'
         and `budget_service_contracts`.`invoices`.`center_description`=''		 ";
		 
		 
//echo "<br />query1=$query1<br />";		 
		 
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

/*
$query_head="select 
             service_contracts_invoices.invoice_num,service_contracts_invoices.invoice_date,
			 service_contracts_invoices.ncas_account,service_contracts_invoices.park,
             service_contracts_invoices.center_description,service_contracts_invoices.center,
       		 service_contracts_invoices.company,service_contracts_invoices.service_period,
             service_contracts_invoices.cashier,service_contracts_invoices.cashier_date,
             service_contracts_invoices.manager,service_contracts_invoices.manager_date,
             service_contracts_invoices.puof,service_contracts_invoices.puof_date,
             service_contracts_invoices.buof,service_contracts_invoices.buof_date,
             service_contracts_invoices.contract_administrator,service_contracts_invoices.contract_administrator_date,
			 service_contracts_invoices.park_approved,service_contracts_invoices.scid,
			 service_contracts.purpose,service_contracts.contract_num,service_contracts.contract_administrator,
			 service_contracts.po_num,service_contracts.line_num,service_contracts.vendor,service_contracts_invoices.remit_address,
			 service_contracts.buy_entity,service_contracts.fid_num,service_contracts.group_num
			 from service_contracts_invoices
			 left join service_contracts on service_contracts_invoices.scid=service_contracts.id
			 where service_contracts_invoices.id='$id' ";
			 
			 */
			 
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
			 `budget_service_contracts`.`invoices`.`remit_name`,
			 `budget_service_contracts`.`invoices`.`remit_address`,
			 `budget_service_contracts`.`contracts`.`buy_entity`,
			 `budget_service_contracts`.`contracts`.`fid_num`,
			 `budget_service_contracts`.`contracts`.`group_num`
			 from `budget_service_contracts`.`invoices`
			 left join `budget_service_contracts`.`contracts` on `budget_service_contracts`.`invoices`.`scid`=`budget_service_contracts`.`contracts`.`id`
			 where `budget_service_contracts`.`invoices`.`id`='$id' ";		 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
			 
//$result_head=mysqli_query($connection, $query_head) or die ("Couldn't execute query head. $query_head");
$result_head=mysqli_query($connection,$query_head) or die ("Couldn't execute query head. $query_head");
//$row_head=mysqli_fetch_array($result_head);
$row_head=mysqli_fetch_array($result_head);

extract($row_head);
//echo "contract_administrator=$contract_administrator<br />";
if($contract_administrator_date=='0000-00-00'){$contract_administrator_date2='';} else {$contract_administrator_date2=date('m/d/y', strtotime($contract_administrator_date));}
if($cashier_date=='0000-00-00'){$cashier_date2='';} else {$cashier_date2=date('m/d/y', strtotime($cashier_date));}
if($manager_date=='0000-00-00'){$manager_date2='';} else {$manager_date2=date('m/d/y', strtotime($manager_date));}


echo "<h4 align='center'>N.C. Department of Natural and Cultural Resources</font></h3>";
echo "<h3 align='center'>PARKS & RECREATION SERVICE AND GRANT CONTRACT EXPENDITURE PAYMENT FORM</h2>";
echo "<h4 align='center'>(DO NOT USE the Cash Disbursements Code Sheet for Service or Grant Contract Payments)</h3>";


echo "<table border=0 align='center'>";
echo "<tr>";
//Left Side Table Begins
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>";
echo "Month of Service<br />(example Dec 2015)";
echo "</th>";
echo "<td>";
//echo "December 2015";
echo "$service_period";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "DPR Park or Section";
echo "</th>";
echo "<td>";
//echo "Morrow Mountain State Park";
echo "$center_description";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "Contract Number";
echo "</th>";
echo "<td>";
//echo "6529";
echo "$contract_num";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "Contractor";
echo "</th>";
echo "<td>";
//echo "Perfection First Service";
echo "$vendor";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "FID# and Group#";
echo "</th>";
echo "<td>";
//echo "<table border='1' align='center'><tr><td>562247297</td><td>A</td></tr></table>";
echo "<table border='1' align='center'><tr><td>$fid_num</td><td></td><td>$group_num</td></tr></table>";
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<th>";
echo "Remit to Name";
echo "</th>";
echo "<td>";
//echo "PO Box 391 Marion, NC 28752-0391";
echo "$remit_name";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<th>";
echo "Remit to Address";
echo "</th>";
echo "<td>";
//echo "PO Box 391 Marion, NC 28752-0391";
echo "$remit_address";
echo "</td>";
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
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>";
echo "Purchase Order Number";
echo "</th>";
echo "<td>";
//echo "NC10263639";
echo "$po_num";
echo "</td>";
echo "</tr>";
/*
echo "<tr>";
echo "<td>";
echo "PO Line Number<br />(Lines funds are on to support cost)";
echo "</td>";
echo "<th>";
//echo "1";
echo "$line_num";
echo "</th>";
echo "</tr>";
*/
echo "<tr>";
echo "<th>";
echo "Buy Entity (46ES or 46EG)";
echo "</th>";
echo "<td>";
//echo "46ES";
echo "$buy_entity";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "Total Current Expenditures<br />(auto populates)";
echo "</th>";
echo "<td>";
echo "$invoice_amount";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>";
echo "Grants Only<br />(NC Grant ID# if Non-Gov Agency)";
echo "</th>";
echo "<td>";
echo "";
echo "</td>";
echo "</tr>";


echo "</table>";


echo "</td>";
echo "</tr>";

//echo "<tr><td colspan='2'><table border='1'><tr><td>Purpose: Janitorial Services for Morrow Mountain State Park vacation cabins</td></tr></table></td></tr>";

echo "<tr><td colspan='2'><table border='1'><tr><th>Purpose: $purpose</th></tr></table></td></tr>";


echo "</table>";

?>