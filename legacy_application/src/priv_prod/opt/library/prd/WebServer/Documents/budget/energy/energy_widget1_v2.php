<?php




$query5b="select cy,py1,py2,py3,py4 from fiscal_year where energy_update_year='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);


echo "<br /><br />";

echo "<table border='5' cellspacing='5'>";
while ($row5b=mysqli_fetch_array($result5b)){
echo "<tr>";

$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);
//echo "<br />f_year=$f_year<br />";
if($f_year==''){$f_year=$cy;}
//echo "<br />fyear=$fyear<br />";
//echo "<br />cy=$cy<br />";


if($cy==$f_year){$cy_td="<td><a href='energy_reporting.php?f_year=$cy&egroup=$egroup&report=$report&valid_account=$valid_account'><font class=cartRow>$cy $checkmark_image</font></a></td>";}
if($cy!=$f_year){$cy_td="<td><a href='energy_reporting.php?f_year=$cy&egroup=$egroup&report=$report&valid_account=$valid_account'>$cy</font></a></td>";}

if($py1==$f_year){$py1_td="<td><a href='energy_reporting.php?f_year=$py1&egroup=$egroup&report=$report&valid_account=$valid_account'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
if($py1!=$f_year){$py1_td="<td><a href='energy_reporting.php?f_year=$py1&egroup=$egroup&report=$report&valid_account=$valid_account'>$py1</font></a></td>";}

if($py2==$f_year){$py2_td="<td><a href='energy_reporting.php?f_year=$py2&egroup=$egroup&report=$report&valid_account=$valid_account'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
if($py2!=$f_year){$py2_td="<td><a href='energy_reporting.php?f_year=$py2&egroup=$egroup&report=$report&valid_account=$valid_account'>$py2</font></a></td>";}

if($py3==$f_year){$py3_td="<td><a href='energy_reporting.php?f_year=$py3&egroup=$egroup&report=$report&valid_account=$valid_account'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
if($py3!=$f_year){$py3_td="<td><a href='energy_reporting.php?f_year=$py3&egroup=$egroup&report=$report&valid_account=$valid_account'>$py3</font></a></td>";}

if($py4==$f_year){$py4_td="<td><a href='energy_reporting.php?f_year=$py4&egroup=$egroup&report=$report&valid_account=$valid_account'><font class=cartRow>$py4 $checkmark_image</font></a></td>";}
if($py4!=$f_year){$py4_td="<td><a href='energy_reporting.php?f_year=$py4&egroup=$egroup&report=$report&valid_account=$valid_account'>$py4</font></a></td>";}





echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";




echo "</tr>";

}
echo "</table>";


echo "<br />";
//echo "<table border='1'>";
//echo "<tr><td>tony</td><td>bass</td></tr>";
//echo "</table>";

if($report != 'cdcs')
{
echo "<table border='1'>
<tr><th>f_year</th><th>egroup</th><th>report</th></tr>
<tr><td>$f_year</td><td>$egroup</td><td>$report</td></tr>
</table>";
}

if($report == 'cdcs')
{
echo "<table border='1'>
<tr><th>f_year</th><th>egroup</th><th>report</th><th>Valid</th></tr>
<tr><td>$f_year</td><td>$egroup</td><td>$report</td><td><a href='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=cdcs&valid_account=y'><font color='brown'  $shade_valid_accounts_y>Y</font><br /><a href='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=cdcs&valid_account=n'><font color='brown'  $shade_valid_accounts_n>N</font></td></tr>
</table>";
}




echo "<br />";





?>