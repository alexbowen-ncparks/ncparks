<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
$beacnum=$_SESSION['budget']['beacon_num']; 
//echo "<br />beacnum=$beacnum<br />";
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
$menu_sc='po_lines';
//include("service_contracts_menu2.php");
include("service_contracts_menu.php");
echo "<br />";


if($submit2=='Update'){include("service_contracts_po_lines_update.php");}
if($submit3=='Update'){include("service_contracts_po_lines_update.php");}
//echo "<br />Line 31<br />"; exit;
// brings back # of existing PO lines from TABLE=service_contracts_po_lines
//$query1="select count(id) as 'po_line_count' from service_contracts_po_lines where scid='$scid' "; //echo "query1=$query1<br />";	
$query1="select count(`id`) as 'po_line_count' from `budget_service_contracts`.`po_lines` where `scid`='$scid' "; 
//echo "query1=$query1<br />";	
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1); 
echo "<br />po_line_count=$po_line_count<br />"; //exit;

// brings back Vendor Name and PO# from TABLE=service_contracts
//$query2="select park,vendor,po_num from service_contracts where id='$scid' "; //echo "query2=$query2<br />";	
$query2="select park,vendor,po_num from `budget_service_contracts`.`contracts` where `id`='$scid' "; //echo "query2=$query2<br />";	
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); //echo "<br />vendor=$vendor<br />po_num=$po_num<br />"; //exit;


if($po_line_count == 0)
{
if($lines_requested=='')
{
echo "<form action='po_lines.php' method='post'><table align='center'><tr><td><font color='red'>$vendor($park)</font></td><td>PO# <font color='red'>$po_num</font></td><td>Lines Needed:</td><td><input name='lines_requested' type='text' size='5'></td><td><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit' value='Update'></td></tr></table></form>"; exit;
}

if($lines_requested!='')
{
echo "<table align='center'><tr><td><font color='red'>$vendor($park)</font></td><td>PO# <font color='red'>$po_num</font></td><td>Lines Needed:<font color='red'>$lines_requested</font></td></tr></table>";	
	
	
echo "<form action='po_lines.php' method='post'>";
echo "<table align='center'>";
//echo "<tr><th>PO#</th><th>Line#</th><th>Beg Balance</th><th>YTD Payments</th><th>Available Balance</th></tr>";
echo "<tr>";
echo "<th>Line#</th><th>Beg Balance</th>";
echo "</tr>";


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
/*
$query3="select po_line_num,po_line_num_beg_bal,payline_num,sum(payline_amount) as 'ytd_payments' 
         from service_contracts_po_lines 
		 left join service_contracts_invoices_paylines on service_contracts_po_lines.scid=service_contracts_invoices_paylines.scid 
		 where service_contracts_po_lines.scid='$scid' and service_contracts_po_lines.po_line_num=service_contracts_invoices_paylines.payline_num
		 group by service_contracts_po_lines.po_line_num ";
*/		 
$query0="select count(`id`) as 'po_line_count2' from `budget_service_contracts`.`po_lines` where `scid`='$scid' and po_line_num='0' "; 
//echo "query1=$query1<br />";	
$result0=mysqli_query($connection,$query0) or die ("Couldn't execute query 0. $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
	

echo "<br /><br />po_line_count2=$po_line_count2<br /><br />";
//$po_line_count2 represents number of records where Line 0 is present (see Query0 above)
// ALL PO's should have Line 0.  If line 0 is not present, Lines will be automatically inserted into Tables for Line 0
if($po_line_count2==0)
{	

$query0a="insert into `budget_service_contracts`.`po_lines` set `scid`='$scid',`po_line_num`='0',`po_line_num_beg_bal`='0' "; 
echo "query0a=$query0a<br />";	
$result0a=mysqli_query($connection,$query0a) or die ("Couldn't execute query 0a. $query0a");

$query0b="insert into `budget_service_contracts`.`pay_lines` set `scid`='$scid',`payline_num`='0',`preDB`='y',`cashier_approved`='y',`manager_approved`='y' "; 
echo "query0b=$query0b<br />";	
$result0b=mysqli_query($connection,$query0b) or die ("Couldn't execute query 0b. $query0b");


}
	
$query3="SELECT
         t1.`po_line_num`,
		 t1.`po_line_num_beg_bal`,
		 t2.`payline_num`,
		 sum(t2.`payline_amount`) as `ytd_payments` 
         from `budget_service_contracts`.`po_lines` as t1 left join `budget_service_contracts`.`pay_lines` as t2 on t1.`scid`=t2.`scid` 
		 
		 where t1.`scid`='$scid'
       	 and   t1.`po_line_num`=t2.`payline_num`
		 and   t2.`manager_approved`='y' 
		 group by t1.`po_line_num`
		 
		 ";		 



		 

echo "query3=$query3<br />";	
		 
		 
//$query4="select po_line_num,po_line_num_beg_bal from service_contracts_po_lines where service_contracts_po_lines.scid='272' group by service_contracts_po_lines.po_line_num";		 
//$query5="select payline_num,concat('payline',payline_num,sum(payline_amount)) from service_contracts_invoices_paylines where scid='272' group by payline_num";		 
		 
		 
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
if($submit3 != 'Update')
{
echo "<table align='center'><tr><td><font color='red'>$vendor($park)</font></td><td>PO# <font color='red'>$po_num</font></td></tr></table>";
}

if($submit3 == 'Update')
{
echo "<table align='center'><tr><td><font color='green'>$vendor($park)</font></td><td>PO# <font color='green'>$po_num</font></td><td><font color='green'>$num3 Lines Updated</font>";
echo "<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr></table>";
}


echo "<form action='po_lines.php' method='post'>";
echo "<table align='center'><tr><th>PO line#</th><th>Beginning<br />Balance</th><th>Total<br />Invoices</th><th>Available<br />Balance</th></tr>";
while ($row3=mysqli_fetch_array($result3))
{
extract($row3);
//$ytd_payments='0.00';
$available_balance=number_format($po_line_num_beg_bal-$ytd_payments,2);
echo "<tr>";
echo "<td><input name='po_line_num[]' type='text' size='1' value='$po_line_num' readonly='readonly'></td>";
//echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal'><input type='hidden' name='id[]' value='$id'></td>";
echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal'></td>";
//echo "<td><a href='current_invoice.php?step=2&report_type=form&id=$scid&line=$po_line_num' target='_blank'>$ytd_payments</a></td>";
echo "<td>$ytd_payments</td>";
echo "<td>$available_balance</td>";
echo "</tr>";
}
echo "<tr>";
echo "<td><input name='po_line_num_new' type='text' size='1'</td>"; 
echo "<td><input name='po_line_num_beg_bal_new' type='text' size='10'</td>"; 
echo "</tr>";
echo "<tr><td colspan='4'><input type='hidden' name='lines2edit' value='$num3'><input type='hidden' name='scid' value='$scid'><input type='submit' name='submit3' value='Update'></td></tr>";
echo "<tr><td><a href='po_invoice_preDB_add.php?id=$scid'>Pre-DB Payments</td><td></td><td></td><td><a href='po_invoice_add.php?id=$scid'>Pay Bill</td><td></td></tr>";
echo "</table>";
echo "</form>";
}

?>