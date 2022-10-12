<?php






/*
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<td>";
echo "Contract Recap for Line#";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Beginning Balance for Line";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Total YTD Payments";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Ending Balance Available";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
*/
//Left Side Table Ends
echo "<td>";
echo "<table align='center'>";
echo "<tr><th>Contract Recap</th></tr>";
echo "</table>";
echo "<table align='center' border='1'>";
echo "<tr><th>Line#</th><th>Begin<br /> Balance</th><th>YTD<br /> Payments</th><th>Ending<br /> Balance</th></tr>";
//echo "</td>";


/*
$query="select `payline_num` from `budget_service_contracts`.`invoices_paylines` where `scid`='$scid' and `invoice_num`='$invoice_num' order by `payline_num` ";
//echo "query=$query";	
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

//$paylines = array();

while($row =  mysqli_fetch_assoc($result))
	{
	//$payline_pay[$row['payline_num']]=$row['payline_amount'];	 	  
	$payline_pay[]=$row['payline_num'];	 	  
    }

//echo "<pre>";print_r($payline_pay);echo "</pre>";//exit;

//$pay_amount=$payline_pay[$payline_num];
//echo "pay_amount=$pay_amount";

//foreach ($payline_pay as $value) {
foreach ($payline_pay as $payline_num) {
//   echo "<td>$value</td>";
$query="select `begin_balance`,(`cummulative_amount`-`invoice_amount`) as 'ytd_payments',(`begin_balance`- (`cummulative_amount`-`invoice_amount`)) as 'ending_balance'
                        from `budget_service_contracts`.`invoices_paylines`
						where `scid`='$scid' and `invoice_num`='$invoice_num' and `payline_num`='$payline_num' ";
						
   
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
*/
$query="select `payline_num`,`begin_balance`,(`cummulative_amount`-`invoice_amount`) as 'ytd_payments',(`begin_balance`- (`cummulative_amount`-`invoice_amount`)) as 'ending_balance',invoice_amount as 'invoice_amount_check'
                        from `budget_service_contracts`.`invoices_paylines`
						where `scid`='$scid' and `invoice_num`='$invoice_num' order by `payline_num` ";
						
//echo "<br /><br />contract_recap.php LINE 77: query=$query<br /><br />";						
$result = mysqli_query($connection,$query) or die ("Couldn't execute query .  $query");						

while ($row=mysqli_fetch_array($result))
{
extract($row);
$begin_balance2=number_format($begin_balance,2);
$ytd_payments2=number_format($ytd_payments,2);
$ending_balance2=number_format($ending_balance,2);

//echo "<td><table border='1'><tr><td>$payline_num</td></tr><tr><td>$begin_balance2</td></tr><tr><td>$ytd_payments2</td></tr><tr><td>$ending_balance2</td></tr></table></td>";  
if($invoice_amount_check != '0.00')
{
echo "<tr><td>$payline_num</td><td>$begin_balance2</td><td>$ytd_payments2</td><td>$ending_balance2</td></tr>";
}
}
echo "</td>";
echo "</table>";






   
 //echo "<br /><br />Line 66: query=$query<br /><br /"; 
   

   
   




/*
$arr = array(1, 2, 3, 4);
foreach ($arr as $value) {
   echo "<td>$value</td>";
}

*/






?>