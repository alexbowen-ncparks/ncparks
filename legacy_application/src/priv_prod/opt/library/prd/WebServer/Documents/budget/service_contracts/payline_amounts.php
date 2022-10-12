<?php
//echo "payline_amounts";
$query3="SELECT 
         t1.`po_line_num`,
		 t1.`po_line_num_beg_bal`,
		 t2.`payline_num`,
		 sum(t2.`payline_amount`) as 'ytd_payments' 
         from `budget_service_contracts`.`po_lines` as t1 left join `budget_service_contracts`.`pay_lines` as t2 on t1.`scid`=t2.`scid` 
		 
		 where t1.scid='$scid'
		 and t1.`po_line_num`=t2.`payline_num`
		 and t2.`cashier_approved`='y'
		 group by t1.`po_line_num`
		 
		 ";

//echo "query3=$query3<br />";	
		 
		 
//$query4="select po_line_num,po_line_num_beg_bal from service_contracts_po_lines where service_contracts_po_lines.scid='272' group by service_contracts_po_lines.po_line_num";		 
//$query5="select payline_num,concat('payline',payline_num,sum(payline_amount)) from service_contracts_invoices_paylines where scid='272' group by payline_num";		 
		 
		 
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$paylines=mysqli_num_rows($result3);
//echo "<table align='center'><tr><th>PO line#</th><th>Beginning<br />Balance</th><th>Total<br />Invoices</th><th>Available<br />Balance</th></tr>";
echo "<table align='center'><tr><th>Line#</th><th>Available</th><th>Pay<br />Amount</th></tr>";
$begin_balance_total='';
$payments_total='';
$none_available_lines='';
while ($row3=mysqli_fetch_array($result3))
{
extract($row3);
//$ytd_payments='0.00';
if($ytd_payments >= $po_line_num_beg_bal){$none_available_lines_total++;}
$begin_balance_total+=$po_line_num_beg_bal;
$payments_total+=$ytd_payments;

//$available_balance=number_format($po_line_num_beg_bal-$ytd_payments,2);
$available_balance=number_format($po_line_num_beg_bal-$ytd_payments,2,'.','');
echo "<tr>";
echo "<td><input name='payline_num[]' type='text' size='1' value='$po_line_num' readonly='readonly'></td>";
//echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal'><input type='hidden' name='id[]' value='$id'></td>";
//echo "<td><a href='current_invoice.php?step=2&report_type=form&id=$scid&line=$po_line_num' target='_blank'>$ytd_payments</a></td>";
//echo "<td>$ytd_payments</td>";
echo "<td>$available_balance</td>";
if($available_balance <= '0.00'){echo "<td><input name='payline_amount[]' type='text' size='5' value='$pay_amount' readonly='readonly'><br /><font color='red'>NO Funds</font></td>";} else {echo "<td><input name='payline_amount[]' type='text' size='5' value='$pay_amount'></td>";}
echo "</tr>";
}
//$available_total=number_format($begin_balance_total-$payments_total,2);
$available_total=number_format($begin_balance_total-$payments_total,2,'.','');
echo "<tr><td>Total</td><td>$available_total</td></tr>";
//echo "<tr><td>paylines=$paylines</td><td>none_available_lines_total=$none_available_lines_total</td></tr>";

echo "</table>";
if($paylines==$none_available_lines_total){echo "<table align='center'><tr><td><font color='red'>NO Funds Available to pay Invoice</font></td></tr></table>"; exit;}
?>