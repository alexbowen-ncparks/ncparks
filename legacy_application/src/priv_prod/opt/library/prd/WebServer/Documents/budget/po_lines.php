<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
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


if($submit2=='Update'){include("service_contracts_po_lines_update.php");}
if($submit3=='Update'){include("service_contracts_po_lines_update.php");}

// brings back # of existing PO lines from TABLE=service_contracts_po_lines
$query1="select count(id) as 'po_line_count' from service_contracts_po_lines where scid='$scid' "; //echo "query1=$query1<br />";	
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); //echo "<br />po_line_count=$po_line_count<br />"; //exit;

// brings back Vendor Name and PO# from TABLE=service_contracts
$query2="select park,vendor,po_num from service_contracts where id='$scid' "; //echo "query2=$query2<br />";	
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); //echo "<br />vendor=$vendor<br />po_num=$po_num<br />"; //exit;


if($po_line_count == 0)
{
if($lines_requested=='')
{
echo "<form action='po_lines.php' method='post'><table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='purple'>$po_num</font></td><td>Lines Needed:</td><td><input name='lines_requested' type='text' size='5'></td><td><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit' value='Update'></td></tr></table></form>"; exit;
}

if($lines_requested!='')
{
echo "<table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='red'>$po_num</font></td><td>Lines Needed:<font color='red'>$lines_requested</font></td></tr></table>";	
	
	
echo "<form action='po_lines.php' method='post'>";
echo "<table align='center'>";
//echo "<tr><th>PO#</th><th>Line#</th><th>Beg Balance</th><th>YTD Payments</th><th>Available Balance</th></tr>";
echo "<tr><th>Line#</th><th>Beg Balance</th></tr>";



for($j=0;$j<$lines_requested;$j++)
{
echo "<tr>";
//echo "<td><input name='po_num[]' type='text' size='10' value='$po_num' id='po_num'></td>";
echo "<td><input name='po_line_num[]' type='text' size='5' value='$po_line_num' id='po_line_num'></td>";
echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal' id='po_line_num_beg_bal'></td>";
//echo "<td><input name='po_line_num_ytd_payments[]' type='text' size='10'  value='0.00' id='po_line_num_ytd_payments'></td>";
//echo "<td><input name='po_line_num_avail_bal[]' type='text' size='10' value='0.00' id='po_line_num_avail_bal'></td>";




echo "</tr>";
	   
}
echo "<tr><td colspan='5' align='right'><input type='hidden' name='lines2add' value='$j'><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "</table>";
echo "</form>";
}
}


if($po_line_count > 0)
{
//echo "<font color='red'>Create Code to bring back PO lines with Edit/Add Capability</font>"; exit;	

$query3="select po_line_num,po_line_num_beg_bal,id from service_contracts_po_lines where scid='$scid' "; //echo "query3=$query3<br />";	
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
if($submit3 != 'Update')
{
echo "<table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='red'>$po_num</font></td><td>Lines:<font color='red'>$num3</font></td></tr></table>";
}

if($submit3 == 'Update')
{
echo "<table align='center'><tr><td><font color='brown'>$vendor($park)</font></td><td>PO# <font color='green'>$po_num</font></td><td><font color='green'>$num3 Lines Updated</font>";
echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />";
echo "</td></tr></table>";
}


echo "<form action='po_lines.php' method='post'>";
echo "<table align='center'><tr><th>PO line#</th><th>Beginning<br />Balance</th></tr>";
while ($row3=mysqli_fetch_array($result3))
{
extract($row3);
echo "<tr>";
echo "<td><input name='po_line_num[]' type='text' size='5' value='$po_line_num'></td>";
echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal'><input type='hidden' name='id[]' value='$id'></td>";
echo "</tr>";
}
echo "<tr><td colspan='5' align='right'><input type='hidden' name='lines2edit' value='$num3'><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit3' value='Update'></td></tr>";
echo "</table>";
echo "</form>";
}

?>