<?phpinclude("../../include/connectBUDGET.inc");// database connection parameters$tempFund=" and fund='1280'";$db="wholemay31";$sql="SELECT coa.description,acct, sum(credit) AS c, sum(debit) AS d, (sum(credit)-sum(debit)) as NetFROM $dbLEFT JOIN coa on coa.ncasNum=$db.acctWHERE (acctLIKE '531%' ) AND sqldate < '2005.06.00' $tempFund GROUP  BY acct";//echo "$sql";exit;echo "<html><header></header><title></title><body>";echo "<table><tr><td>Account </td><td>Description</td><td align='right'>Credit</td><td align='right'>Debit</td><td align='right'>Total</td></tr>";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");while($row=mysqli_fetch_array($result)){extract($row);$tot1=$d-$c;$t1=$t1+$tot1;$tot1=number_format($tot1,2);$c=number_format($c,2);$d=number_format($d,2);echo "<tr><td>$acct </td><td>$description</td><td align='right'>$c</td><td align='right'> $d</td><td align='right'>$tot1</td></tr>";}$t1=number_format($t1,2);echo "<tr><td bgcolor='yellow' align='right'>531xxx</td><td></td><td></td><td>$t1</td></tr></table>";$sql="SELECT acct, sum(credit) AS c, sum(debit) AS d, (sum(credit)-sum(debit)) as NetFROM $dbWHERE (acctLIKE '532%' ) AND sqldate < '2005.06.00' $tempFund GROUP  BY acct";echo "<table><tr><td>Account </td><td>Description</td><td align='right'>Credit</td><td align='right'>Debit</td><td align='right'>Total</td></tr>";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");while($row=mysqli_fetch_array($result)){extract($row);$tot2=$d-$c;$t2=$t2+$tot2;$tot2=number_format($tot2,2);$c=number_format($c,2);$d=number_format($d,2);echo "<tr><td>$acct </td><td>$description</td><td align='right'>$c</td><td align='right'> $d</td><td align='right'>$tot2</td></tr>";}$t2=number_format($t2,2);echo "<tr><td bgcolor='yellow' align='right'>532xxx</td><td></td><td></td><td>$t2</td></tr></table>";echo "</body></html>";?>