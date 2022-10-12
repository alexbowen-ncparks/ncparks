<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
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
//mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
echo "<html>";
include("head1.php");
include ("../../budget/menu1415_v1_new.php");

echo "<br />";
//$menu_sc='SC4';
//include("service_contracts_menu.php");
echo "<br />";

$menu_sc='po_invoice';
include("service_contracts_menu.php");
echo "<br />";

//$query2a="select count(id) as 'unapproved_count' from service_contracts_invoices where scid='$id' and park_approved='n'  ";	
$query2a="select count(`id`) as 'unapproved_count' from `budget_service_contracts`.`invoices` where `scid`='$id' and `park_approved`='n'  ";	
//echo "query2a=$query2a<br />";//exit;
$result2a=mysqli_query($connection,$query2a) or die ("Couldn't execute query 2a. $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);

/*
$query2b="select sum(invoice_amount) as 'line_num_previous_paid' from service_contracts_invoices where scid='$id' and park_approved='y'  ";	
echo "LINE 90: query2b=$query2b<br />";//exit;
$result2b=mysqli_query($connection,$query2b) or die ("Couldn't execute query 2b. $query2b");
$row2b=mysqli_fetch_array($result2b);
extract($row2b);

$query2b1="select park as 'contract_park',vendor as 'contract_vendor',po_num as 'contract_ponum' from service_contracts where id='$id' ";
echo "LINE 115: query2b1=$query2b1<br />";//exit;
$result2b1=mysqli_query($connection,$query2b1) or die ("Couldn't execute query 2b1. $query2b1");
$row2b1=mysqli_fetch_array($result2b1);
extract($row2b1);
echo "<br />";
*/
/*
if($unapproved_count > 0){echo "<table align='center'><tr><td><font color='brown'><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img>Previous Invoice still Pending Approval from Park Cashier OR Park Manager.<br /> Click <a href='all_invoices.php'>here</a> to approve previous Invoice</font></td></tr></table>"; exit;} 
*/
echo "<br />";
//echo "<table align='center'><tr><th><font color='red'>Step1-Cashier (enter payment)</font></th><th><a href='po_invoice_update.php' target='_blank'>Step2-Cashier (verify payment)</a></th></tr></table>";
echo "<table align='center'><tr><th><font color='red'>Pre-DB Payments</font></th></tr></table>";


//$query3="SELECT park,center,company,purpose,contract_administrator,po_num,line_num,ncas_account,fyear,vendor,id as 'scid',remit_address from service_contracts where id='$id' ";
$query3="SELECT `park`,`center`,`company`,`purpose`,`contract_administrator`,`po_num`,`line_num`,`ncas_account`,`fyear`,`vendor`,`id` as 'scid',`remit_address`
         from `budget_service_contracts`.`contracts` where `id`='$id' ";

//echo "query3=$query3<br />";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
extract($row3);

echo "<form enctype='multipart/form-data' method='post' action='po_invoice_preDB_add2.php'>";
echo "<table align='center'>";


//echo "<tr><td><font color='brown'>$park</font></td></tr>";
//echo "<tr><td><font color='brown'>$vendor</font></td></tr>";
//echo "<tr><td><font color='brown'>$po_num</font></td></tr>";
echo "<tr><td><font color='brown'>$vendor($park)</font></td><td><font>PO#</font><font color='red'> $po_num</font></td></tr>";


//echo "<tr>";
echo "</table>";
//echo "<th></th>";
echo "<table align='center'>";
echo "<tr>";
echo "<td>";
include("payline_amounts_preDB.php"); 
echo "</td>";
echo "</tr>"; 
/*        
 echo "<tr><th align='center'><font color='brown'>Invoice Service Period<br />(Example: December 2015)</font></th><td><input type='text' name='service_period' size='45' autocomplete='off' value='$service_period'></td></tr>";  

echo "<tr>";
echo "<th></th><th>Invoice (<font color='red'>PDF Format</font>)<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /></th>";
echo "</tr>";
 */  
echo "<tr><th colspan='4'><input type=submit name=submit value=Update></th></tr>";
echo "</table>";

echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='company' value='$company'>";
echo "<input type='hidden' name='ncas_account' value='$ncas_account'>";
echo "<input type='hidden' name='remit_address' value='$remit_address'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='eid' value='$eid'>";
echo "<input type='hidden' name='paylines' value='$paylines'>";

echo "</form>";
echo "</body></html>";

?>