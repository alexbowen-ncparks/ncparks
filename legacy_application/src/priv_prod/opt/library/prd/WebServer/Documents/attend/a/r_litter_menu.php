<?phpecho "<div align='center'>";echo "<table><tr>";$sql = "SELECT distinct park from vol_stats ORDER BY park";$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");	while($row=mysqli_fetch_array($result)){	extract($row);$park=strtoupper($park);	$parkCode[]=$park;	}	$categories=array("Administration"=>"admin_hours","Campground Host"=>"camp_host_hours");//	print_r($categories);exit;	echo "<form action='r_vol_hours.php'><td>Park: <select name='parkcode'>";echo "<option $s=''>\n";              for ($n=0;$n<count($parkCode);$n++)          {$scode=$parkCode[$n];$parkArray[]=$scode;if($scode==$parkcode){$s="selected";}else{$s="value";}echo "<option $s='$scode'>$scode\n";          }echo "</select></td>";echo "<td>Category: <select name='cat'>";echo "<option $s=''>\n";              while (list($k,$v)=each($categories))          {$scode=$v;if($scode==$cat){$s="selected";}else{$s="value";}echo "<option $s='$scode'>$k\n";          }echo "</select></td>";echo "<td>YearMonth (e.g., 200607):<input type='text' name='year_month' value='$year_month' size='10'></td><td>";echo "<input type='submit' name='submit' value='Submit'></td></form>";echo "</tr></table><hr>";?>