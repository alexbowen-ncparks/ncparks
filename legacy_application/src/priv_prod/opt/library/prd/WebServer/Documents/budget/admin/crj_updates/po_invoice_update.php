<?php

echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

echo "<html>";

include("head1.php");
include ("../../budget/menu1415_v1_new.php");
//$scid='294';

echo "<br /><br />";
$menu_sc='po_invoice_update';
include("service_contracts_menu.php");
echo "<br />";


echo "<table align='center'><tr><th><font color='red'>Step2-Cashier (verify payment)</font></th></tr></table>";
//$eid=2;

$query3="SELECT         
		 t1.`scid`,
		 t1.`invoice_num`,
		 t1.`invoice_date`,
		 t1.`invoice_amount`,
		 t1.`ncas_account`,
		 t1.`park`,
		 t1.`center`,
		 t1.`company`,
		 t1.`service_period`,
		 t1.`remit_address`,
		 t1.`document_location`,
		 t2.`purpose`,
         t2.`contract_administrator`,
		 t2.`vendor`,
		 t2.`po_num`		 
		 from `budget_service_contracts`.`invoices` as t1 left join `budget_service_contracts`.`contracts` as t2 on t1.`scid`=t2.`id`
		 where t1.`id`='$eid' ";
		 
		 
//	 echo "where t1.`id`='$eid' ";
				
echo "query3=$query3<br />";
echo "<br /><br />";


$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
extract($row3);

echo "<form enctype='multipart/form-data' method='post' action='po_invoice_update2.php'>";
echo "<table align='center' border=1>"; 

echo "<tr><th align='center'><font color='brown'>Park</font></th><td><font color='brown'>$park</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><font color='brown'>$vendor</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><font color='brown'>$remit_address</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><font color='brown'>$po_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Invoice#</font></th><td><input type='text' name='invoice_num' size='10' autocomplete='off' value='$invoice_num'></td></tr>";            
echo "<tr><th align='center'><font color='brown'>Invoice Date</font></th><td><input name='invoice_date' size='10' type='text' value='$invoice_date' id='datepicker' ></td></tr>";   
echo "<tr><th align='center'><font color='brown'>Invoice Amount</font></th><td><input type='text' name='invoice_amount' size='10' autocomplete='off' value='$invoice_amount'></td></tr>";
 
echo "<tr>";
echo "<th align='center'><font color='brown'>PayLine Amounts</font></th>";
echo "<td>";include("payline_paid.php");echo "</td>";
echo "</tr>"; 

       
echo "<tr><th align='center'><font color='brown'>Invoice Service Period<br />(Example: December 2015)</font></th><td><input type='text' name='service_period' size='20' autocomplete='off' value='$service_period'></td></tr>";  

echo "<tr>";
//echo "<th><table><tr><td><a href='$document_location' target='_blank'>VIEW Invoice</a></td><td><a href='service_contract_invoice_add.php?source_id=$eid' target='_blank'>ReLoad Invoice</a></td></tr></table></th>";
//echo "<th><table><tr><td><a href='$document_location' target='_blank'>VIEW Invoice</a></td></tr></table></th>";
echo "<th></th><th>Invoice (<font color='red'>PDF Format</font>)<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /></th>";
echo "</tr>";
        
echo "<tr>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<th colspan='2'><input type=submit name=submit value=Update></th>";
echo "<th>line_overdrawn:$line_overdrawn<br />payline_check=$payline_check</th>";
echo "</tr>";

echo "</table>";

echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='company' value='$company'>";
echo "<input type='hidden' name='ncas_account' value='$ncas_account'>";
echo "<input type='hidden' name='remit_address' value='$remit_address'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='eid' value='$eid'>";
echo "<input type='hidden' name='payline_count' value='$payline_count'>";

echo "</form>";
echo "</body>";
echo "</html>";

?>