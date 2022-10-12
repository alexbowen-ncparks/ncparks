<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


echo "<form action='new_lines.php' name='new_lines'>";
echo "<table>";
echo "<tr><th>PO#</th><th>Line#</th><th>Beg Balance</th><th>YTD Payments</th><th>Available Balance</th></tr>";

echo "<tr>";
echo "<th><td><input name='po_num[]' type='text' value='$po_num' id='po_num'></td>";
echo "<th><td><input name='po_line_num[]' type='text' value='$po_line_num' id='po_line_num'></td>";
echo "<th><td><input name='po_line_num_beg_bal[]' type='text'  value='0.00' id='po_line_num_beg_bal'></td>";
echo "<th><td><input name='po_line_num_ytd_payments[]' type='text'  value='0.00' id='po_line_num_ytd_payments'></td>";
echo "<th><td><input name='po_line_num_avail_bal[]' type='text' value='0.00' id='po_line_num_avail_bal'></td>";
echo "</tr>";
	   

echo "<tr><td colspan='1' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "</table>";
echo "</form>";
?>