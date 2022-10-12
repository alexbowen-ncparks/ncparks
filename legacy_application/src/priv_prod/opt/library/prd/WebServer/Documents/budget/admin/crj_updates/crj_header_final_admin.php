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
if($dncr=='y')
{
echo "<h2 align='center'><font color='blue'>Department of Natural and Cultural Resources</font></h2>";
}

if($dncr=='n')
{
echo "<h2 align='center'><font color='red'>Department of Environment and Natural Resources</font></h2>";
}


echo "<h2 align='center'>Cash Receipts Journal Voucher with Summary</h2>
<h5 align='right'>Page ___of___</h5>";
*/


/*
echo "<table><tr><td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'>
CRJ</a></td></tr></table>";
*/

echo "<form>
<table align='center' cellspacing='15' style='font-size:25pt';>";
//echo "<tr><td colspan='10' align='right'>Page__of__</td></tr>";
/*
echo "<tr>
<td>Document ID:</td> <td><input type='text' name='docid' value='1621' size='7' readonly='readonly' ></td>
<td><font color='red'>Deposit Date:</font></td> <td><input type='text' name='depdate' value='$bank_deposit_date2' size='15'></td>
<td>Budget Code:</td> <td><input type='text' name='budcode' value='$budcode' size='9' readonly='readonly'></td>
</tr>
<tr>
<td>APP Code</td> <td><input type='text' name='appcode' value='' size='5' readonly='readonly'></td>
<td>GL Effective Date:</td> <td><input type='text' name='gleffect' value='' size='11' readonly='readonly'></td>
</tr>";
*/

echo "<tr>";
echo "<td><font color='brown'>Division:</font></td> <td><u>DPR</u></td>";
//echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td><font color='brown'>Section:</font></td> <td><u>Budget</u></td>";
echo "</tr>";


echo "<tr>";
echo "<td><font color='brown'>Prepared by:</font></td> <td><u>$cashier_fullname</u></td>";
//echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td><font color='brown'>Approved by:</font></td> <td><u>$manager_fullname</u></td>";
echo "</tr>";








echo "</table>";
?>