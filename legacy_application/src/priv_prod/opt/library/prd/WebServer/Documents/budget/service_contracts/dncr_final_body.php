<?php
$query11="SELECT `scid`,`invoice_num`,`invoice_amount` as 'invoice_total',`contract_administrator`,`manager`,`document_location` from `budget_service_contracts`.`invoices` where `id`='$id' ";
//echo "<br />query11=$query11<br />";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");
//$row11=mysqli_fetch_array($result11);

$result11=mysqli_query($connection,$query11) or die ("Couldn't execute query 11. $query11");
$row11=mysqli_fetch_array($result11);
extract($row11);
$invoice_total2=number_format($invoice_total,2);
////echo "<br />scid=$scid<br />";
////echo "<br />invoice_num=$invoice_num<br />";
////echo "<br />document_location=$document_location<br />";

//$query12="select * from `budget_service_contracts`.`invoices` where id='$id' ";

$query12="select
         `budget_service_contracts`.`invoices`.`invoice_num`,
         `budget_service_contracts`.`invoices`.`invoice_date`,
         `budget_service_contracts`.`invoices`.`company`,
         `budget_service_contracts`.`invoices`.`ncas_account`,
         `budget_service_contracts`.`invoices`.`center`,
         `budget_service_contracts`.`pay_lines`.`payline_num`,
         sum(`budget_service_contracts`.`pay_lines`.`payline_amount`) as 'line_amount'
		 from `budget_service_contracts`.`invoices`
		 left join `budget_service_contracts`.`pay_lines` on `budget_service_contracts`.`invoices`.`scid`=`budget_service_contracts`.`pay_lines`.`scid`
		 where  `budget_service_contracts`.`invoices`.`scid`='$scid'
		 and    `budget_service_contracts`.`pay_lines`.`scid`='$scid'
		 and    `budget_service_contracts`.`invoices`.`invoice_num`='$invoice_num'
		 and    `budget_service_contracts`.`pay_lines`.`invoice_num`='$invoice_num'
		 and    `budget_service_contracts`.`pay_lines`.`payline_amount`!='0.00'
		 group by `budget_service_contracts`.`pay_lines`.`payline_num` 
		 order by `budget_service_contracts`.`pay_lines`.`payline_num` asc ";		


////echo "<br />query12=$query12<br />";

//exit;
//$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
//$num12=mysqli_num_rows($result12);

$result12=mysqli_query($connection,$query12) or die ("Couldn't execute query 12. $query12");
$num12=mysqli_num_rows($result12);

echo "<br />";
echo "<table border=1 align='center'>";

echo "<tr>";
echo "<th>Invoice Number<br /><a href='$document_location' target='_blank'>VIEW</a></th>";
echo "<th>Invoice<br />Date</th>";
echo "<th>Company</th>";
echo "<th>Account<br />(Account must match<br />account on P.O.)</th>";
echo "<th>PO<br />Line#</th>";
echo "<th>Center<br />(Center must match Center on P.O.)</th>";
echo "<th>Total</th>";              
echo "</tr>";
while ($row12=mysqli_fetch_array($result12)){
extract($row12);

//$available_before_invoice=$line_num_beg_bal-$previous_amount_paid;
//$available_before_invoice2=number_format($available_before_invoice,2);
//$invoice_amount2=number_format($invoice_amount,2);
$line_amount2=number_format($line_amount,2);
//$previous_amount_paid2=number_format($previous_amount_paid,2);
//$cummulative_amount_paid2=number_format($cummulative_amount_paid,2);
//$line_num_beg_bal2=number_format($line_num_beg_bal,2);

$invoice_date2=date('m/d/y', strtotime($invoice_date));

if($invoice_date=='0000-00-00')
{$invoice_date2='unknown';}
else
$invoice_date2=date('m/d/y', strtotime($invoice_date));





//if($manager_date=='0000-00-00'){$manager_date2='';} else {$manager_date2=date('m/d/y', strtotime($manager_date));}


//if($puof_date=='0000-00-00'){$puof_date2='';} else {$puof_date2=date('m/d/y', strtotime($puof_date));}

echo "<tr bgcolor='cornsilk'><td>$invoice_num</td><td>$invoice_date2</td><td>$company</td><td>$ncas_account</td><td>$payline_num</td><td>$center</td><td>$line_amount2</td></tr>";
		
}
echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Grand Totals</td><td>$invoice_total2</td></tr>";	
	

echo "</table>";
echo "<br />";


?>