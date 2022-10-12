<?php
echo "<h2 align='center'>Department of Environment and Natural Resources</h2>
<h2 align='center'>Cash Receipts Journal Voucher with Summary</h2>
<h5 align='right'>Page ___of___</h5>

<form>
<table align='center' cellspacing='15' style='font-size:5pt';>";
//echo "<tr><td colspan='10' align='right'>Page__of__</td></tr>";
echo "<tr>
<td>Document ID:</td> <td><input type='text' name='docid' value='1621' size='7' ></td>
<td>Deposit Date:</td> <td><input type='text' name='depdate' value='' size='15'></td>
<td>Budget Code:</td> <td><input type='text' name='budcode' value='$budcode' size='9'></td>
</tr>
<tr>
<td>APP Code</td> <td><input type='text' name='appcode' value='' size='5' ></td>
<td>GL Effective Date:</td> <td><input type='text' name='gleffect' value='' size='11'></td>
</tr>
<tr>
<td>Division</td> <td><u>Parks & Recreation</u></td>
<td>Data Type Code:</td> <td><input type='text' name='datatc' value='1' size='2'></td>
<td>Deposit No:</td> <td><input type='text' name='depnum'  size='15'></td>
</tr>
</table>";
?>