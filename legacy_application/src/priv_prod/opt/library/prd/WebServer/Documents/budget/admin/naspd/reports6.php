<?php

echo "<br />
		current fiscal year == $cy
		<br />
		past fiscal year == $py1
		<br />
		past 2 fiscal year == $py2
		<br />
		past 3 fiscal year == $py3
		<br />
		past 4 fiscal year == $py4
		<br />
	";

echo "<table align='center'>";
echo "<tr>";
echo "<td><a href='../../../budget/portal.php?dbTable=bd725_dpr_account_detail3_rec' target='_blank'>Receipts Detail</a></td>";
echo "<td><a href='../../../budget/portal.php?dbTable=bd725_dpr_receipt_type_by_fund_ws' target='_blank'>Receipts by Fund</a></td>";
echo "<td><a href='../../../budget/portal.php?dbTable=bd725_naspd6' target='_blank'>Expenses and Funding</a></td>";
echo "</tr>";
echo "</table>";


?>