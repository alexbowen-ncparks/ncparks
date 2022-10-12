<?php
echo "<h2 align='center'>Department of Environment and Natural Resources</h2>
<h2 align='center'>Cash Receipts Journal Voucher with Summary</h2>
<h5 align='right'>Page ___of___</h5>

<form>
<table align='center' cellspacing='15' style='font-size:25pt';>";
//echo "<tr><td colspan='10' align='right'>Page__of__</td></tr>";
echo "<tr>
<td>Document ID:</td> <td><input type='text' name='docid' value='1621' size='7' readonly='readonly' ></td>
<td><font color='red'>Deposit Date:</font></td> <td><input type='text' name='depdate' value='$deposit_date_new_header2' size='15'></td>
<td>Budget Code:</td> <td><input type='text' name='budcode' value='$budcode' size='9' readonly='readonly'></td>
</tr>
<tr>
<td>APP Code</td> <td><input type='text' name='appcode' value='' size='5' readonly='readonly'></td>
<td>GL Effective Date:</td> <td><input type='text' name='gleffect' value='' size='11' readonly='readonly'></td>
</tr>
<tr>
<td>Division</td> <td><u>Parks & Recreation</u></td>
<td>Data Type Code:</td> <td><input type='text' name='datatc' value='1' size='2' readonly='readonly'></td>
<td><font color='red'>Deposit No:</font></td> <td><input type='text' name='depnum'  size='15'></td>
</tr>
</table>";
?>