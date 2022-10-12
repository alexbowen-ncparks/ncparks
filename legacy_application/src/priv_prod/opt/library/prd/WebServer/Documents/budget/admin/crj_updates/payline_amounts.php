<?php
//echo "payline_amounts";
$query3="select po_line_num,po_line_num_beg_bal,payline_num,sum(payline_amount) as 'ytd_payments' 
         from service_contracts_po_lines 
		 left join service_contracts_invoices_paylines on service_contracts_po_lines.scid=service_contracts_invoices_paylines.scid 
		 where service_contracts_po_lines.scid='$scid' and service_contracts_po_lines.po_line_num=service_contracts_invoices_paylines.payline_num
		 group by service_contracts_po_lines.po_line_num
		 
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
while ($row3=mysqli_fetch_array($result3))
{
extract($row3);
//$ytd_payments='0.00';
$begin_balance_total+=$po_line_num_beg_bal;
$payments_total+=$ytd_payments;

$available_balance=number_format($po_line_num_beg_bal-$ytd_payments,2);
echo "<tr>";
echo "<td><input name='payline_num[]' type='text' size='1' value='$po_line_num' readonly='readonly'></td>";
//echo "<td><input name='po_line_num_beg_bal[]' type='text' size='10' value='$po_line_num_beg_bal'><input type='hidden' name='id[]' value='$id'></td>";
//echo "<td><a href='current_invoice.php?step=2&report_type=form&id=$scid&line=$po_line_num' target='_blank'>$ytd_payments</a></td>";
//echo "<td>$ytd_payments</td>";
echo "<td>$available_balance</td>";
if($available_balance <= '0.00'){echo "<td><font color='red'>NO Funds</font></td>";} else {echo "<td><input name='payline_amount[]' type='text' size='5' value='$pay_amount'></td>";}
echo "</tr>";
}
echo "<tr><td>$begin_balance_total</td><td>$payments_total</td></tr>"
echo "</table>";

?>