<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
extract($_REQUEST);
//$po_num='NC10469313';

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

include ("../../budget/menu1415_v1_new.php");
echo "<br />";
$menu_sc='SC3';
include("service_contracts_menu.php");
echo "<br />";

// brings back # of existing PO lines from TABLE=service_contracts_po_lines
$query1="select count(id) as 'po_line_count' from service_contracts_po_lines where scid='$scid' "; echo "query1=$query1<br />";	
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); echo "<br />po_line_count=$po_line_count"; //exit;

// brings back Vendor Name and PO# from TABLE=service_contracts
$query2="select park,vendor,po_num from service_contracts where id='$scid' "; echo "query2=$query2<br />";	
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); echo "<br />vendor=$vendor<br />po_num=$po_num"; //exit;







if($submit2=='Update')
{
echo "<font color='red'>send data to New Table and bring back Confirmation to User</font>"; exit;	
	
	
	
	
}

if($po_line_count==0)
{
if($lines_requested=='')
{
echo "<form action='new_po_lines.php'><table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='purple'>$po_num</font></td><td>Lines Needed:</td><td><input name='lines_requested' type='text' size='5'></td><td><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit' value='Update'></td></tr></table></form>"; exit;
}

if($lines_requested!='')
{
echo "<table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='purple'>$po_num</font></td><td>Lines Needed:<font color='red'>$lines_requested</font></td></tr></table>";	
	
	
echo "<form action='new_po_lines.php' name='new_lines'>";
echo "<table align='center'>";
//echo "<tr><th>PO#</th><th>Line#</th><th>Beg Balance</th><th>YTD Payments</th><th>Available Balance</th></tr>";
echo "<tr><th>PO#</th><th>Line#</th><th>Beg Balance</th></tr>";



for($j=0;$j<$lines_requested;$j++)
{
echo "<tr>";
echo "<td><input name='po_num[]' type='text' size='10' value='$po_num' id='po_num'></td>";
echo "<td><input name='po_line_num[]' type='text' size='5' value='$po_line_num' id='po_line_num'></td>";
echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal' id='po_line_num_beg_bal'></td>";
//echo "<td><input name='po_line_num_ytd_payments[]' type='text' size='10'  value='0.00' id='po_line_num_ytd_payments'></td>";
//echo "<td><input name='po_line_num_avail_bal[]' type='text' size='10' value='0.00' id='po_line_num_avail_bal'></td>";




echo "</tr>";
	   
}
echo "<tr><td colspan='5' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "</table>";
echo "</form>";
}
}
?>