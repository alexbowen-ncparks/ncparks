<?php

$query3="SELECT
         t1.`po_line_num`,
		 t1.`po_line_num_beg_bal`,
		 t2.`payline_num`,
		 sum(t2.`payline_amount`) as `ytd_payments` 
         from `budget_service_contracts`.`po_lines` as t1 left join `budget_service_contracts`.`pay_lines` as t2 on t1.`scid`=t2.`scid` 
		 
		 where t1.`scid`='$scid'
       	 and   t1.`po_line_num`=t2.`payline_num`
		 and   t2.`cashier_approved`='y' 
		 group by t1.`po_line_num`
		 
		 ";

//echo "<br />Line17: query3=$query3<br />";		 
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$payline_count=mysqli_num_rows($result3);

echo "<table align='center'>";
echo "<tr><th>Line#</th><th>Available</th><th>Pay<br />Amount</th></tr>";

$begin_balance_total='';
$payments_total='';
$payline_total='';
$lineS_overdrawn='';
$new_balance_total='';
$available_balance_total='';

while ($row3=mysqli_fetch_array($result3))
{
extract($row3);

$begin_balance_total+=$po_line_num_beg_bal;

include("payline_payment_array.php");
$payline_total+=$pay_amount;
$available_balance=number_format($po_line_num_beg_bal-$ytd_payments,2,'.','');
$available_balance_total+=$available_balance;
$new_balance=number_format($available_balance-$pay_amount,2,'.','');



if($new_balance >= 0){$new_balance_ok="<font color='green'>ok</font>"; $line_overdrawn=0;}
if($new_balance < 0){$new_balance_ok="<font color='red'> line error</font>"; $line_overdrawn=1;}
$lineS_overdrawn+=$line_overdrawn;
echo "<tr>";
echo "<td><input name='payline_num[]' type='text' size='1' value='$po_line_num' readonly='readonly'></td>";
echo "<td>$available_balance</td>";
echo "<td><input name='payline_amount[]' type='text' size='5' value='$pay_amount'></td><td>$new_balance_ok</td>";
echo "</tr>";
}
//$available_total=number_format($available_total,2,'.','');
$available_balance_total=number_format($available_balance_total,2,'.','');
$payline_total=number_format($payline_total,2,'.','');
$payline_check=$invoice_amount-$payline_total;
//if($payline_check != 0){echo "<tr><td>Total<td>$available_balance_total</td><td><b>$payline_total</b></td><td><b>pay total</b></td></tr>";}
echo "<tr><td>Total<td>$available_balance_total</td><td>$payline_total</td><td></td></tr>";

echo "</table>";
if($payline_check != 0){echo "<table align='center'><tr><td><font color='red'>Pay Total does not match Invoice</font></td></tr></table>";}
?>