<?php
$gt=$pass_gt;
echo "<html><body><table cellpadding='2'>";
ECHO "<tr><th colspan='9'><h3>DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES</h3></th></tr>";

ECHO "<tr><th colspan='8'><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CASH RECEIPTS JOURNAL VOUCHER WITH SUMMARY</h3></th><td>Page __ of __</td></tr>";

echo "<tr><td colspan='9'> </td></tr>";

echo "<tr>
<td colspan='4' align='left'>DOCUMENT ID: 1621</td>
<td colspan='1' align='right'>Deposit Date: </td><td>$start_date</td>
<td colspan='1' align='right'>Budget Code: </td><td>14300</td>
</tr>";

echo "<tr>
<td colspan='4' align='left'>APP. CODE:</td>
<td colspan='4' align='left'>GL EFFECTIVE DATE:</td>
</tr>";

echo "<tr>
<td colspan='4' align='left'>DIVISION: Parks & Recreation</td>
<td colspan='1' align='left'>DATA TYPE CODE:</td><th>1</th>
<td colspan='1' align='right'>Deposit No.: </td><td></td>
</tr>";

echo "</table>";

echo "<table border='1' cellpadding='2'>";
ECHO "<tr><th>OFFICE<br />USE</th><th>Line<br />No.</th><th>COMPANY</th><th>ACCOUNT</th><th>CENTER</th><th>AMOUNT</th><th>DR<BR />CR</th><th>LINE<br />DESCRIPTION</th><th>ACCT<br />RULE</th></tr>";

if($park=="WHLA" OR $park=="BATR")
	{
	$pb="Patsy Hair";
	$phone="910-669-2928";
	//,"CAMPING","SALES TAX","56-6000372","56-6000372","TEL. REFUND","MISC REVENUE","SPEC ACTVITY","SALES PUB","SALES PUB","BANDANA"
	//,"434410004","211940","53-8322", "53-8322","53-2811","437990","435200009","434310","211940","533800029"
	$line_desc=array("","State Lake Permits");
	$account_array=array("","435200008");
	}
	
if($park=="PETT")
	{
	$pb="Bonnie Ambrose";
	$phone="(252) 797-4475";
	$line_desc=array("","State Lake Permits","Vendor Fee","Sales Firewood","Sales Firewood","Campsites");
	$account_array=array("","435200008","435900001","434150004",  "211940","434410003");
	}
if($park=="LAWA")
	{
	$pb="Janice Mercer";
	$phone="910-646-4748";
	$line_desc=array("","State Lake Permits","Vendor Fee","Campsites");
	$account_array=array("","435200008","435900001","434410003");
	}
$i++;
while($i<15)
	{
	echo "<tr>";
	$j=1;
	while($j<10)
		{
		$h="";$td=""; $f1=""; $f2="";
		if($j==2){$h=($i-9); $td=" align='center'";}
		if($j==3){$h="1601"; $td=" align='center'";}
		if($j==4)
			{
			$td=" align='center'";
			$h=@$account_array[$i-9]; 
			}
		if($j==5){$h="1280".$rcc; $td=" align='center'";}
		if($j==6 AND $i==10)
			{
			$gt="$ &nbsp;".number_format($gt,2);
			$h=$gt; $td=" align='center'"; $f1="<font color='red'>"; $f2="</font>";
			}
		if($j==7){$h="CR"; $td=" align='center'";}
		if($j==8)
			{
			$td=" align='center'";
			$h=@$line_desc[$i-9]; 
			}
		echo "<td$td>$f1$h$f2</td>";
		$j++;
		}
	echo "</tr>";
	$i++;
	}

echo "</table>";

echo "<table>";
echo "<tr>
<td colspan='4' align='left'>Justification:</td>
</tr>";

echo "<tr><td colspan='9'> </td></tr>";

echo "<tr><td colspan='9'> </td></tr></table>";

if($park=="WHLA" OR $park=="BATR")
	{
	$pb="Patsy Hair";
	$phone="910-669-2928";
	}
$spaces="______________________";
echo "<table><tr>
<td align='left'>Prepared by: </td><td><u>$pb</u></td>
<td align='left'>Phone No.: </td><td><u>$phone</u></td>
<td align='left'>TOTAL DEBITS: </td><TD><u>$spaces</u></TD>
</tr>";

echo "<tr>
<td align='left'>Approved by:</td><td><u>$spaces</u></td>
<td align='left'>Date: </td><td><u>$spaces</u></td>
<td align='left'></td>
</tr>";

echo "<tr>
<td align='left'>Entered by:</td><td><u>$spaces</u></td>
<td align='left'>Date: </td><td><u>$spaces</u></td>
<td align='left'>TOTAL CREDITS: </td><TD>_____________<u>$gt</u></TD>
</tr>";

echo "<tr><td colspan='4'> </td></tr></table>";

echo "<table><tr>
<td colspan='4' align='left'>DETAIL CHECK LIST IS BELOW FOR LISTING CHECKS INDIVIDUALLY</td>
</tr>";

echo "<tr><td colspan='4'> </td></tr>";

echo "<tr><td colspan='4'> </td></tr>";
echo "</table>";
?>