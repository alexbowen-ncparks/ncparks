<?php
extract($_REQUEST);



// query to bring back correct fiscal year

$query20a="select f_year as 'report_year'
           from purchase_approval_report_dates 
		   where 1 order by id desc limit 1  ";

//echo "query20a=$query20a<br />";


$result20a = mysqli_query($connection, $query20a) or die ("Couldn't execute query 20a.  $query20a");

$row20a=mysqli_fetch_array($result20a);
extract($row20a);



$query5b="select cy,py1 from fiscal_year where report_year='$report_year' ";
//$query5b="select cy,py1,py2,py3 from fiscal_year where report_year='$report_year' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";
echo "<td><font size=4 color='brown' >Fiscal Year</font></td>";

while ($row5b=mysqli_fetch_array($result5b)){


$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);
if($fyear==''){$fyear=$cy;}
//echo "<br />fyear=$fyear<br />";
//echo "<br />cy=$cy<br />";

if($cy==$fyear){$cy_td="<td><a href='preapproval_yearly.php?fyear=$cy&parkcode=$parkcode'><font class=cartRow>$cy $checkmark_image</font></a></td>";}
if($cy!=$fyear){$cy_td="<td><a href='preapproval_yearly.php?fyear=$cy&parkcode=$parkcode'>$cy</font></a></td>";}

if($py1==$fyear){$py1_td="<td><a href='preapproval_yearly.php?fyear=$py1&parkcode=$parkcode'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
if($py1!=$fyear){$py1_td="<td><a href='preapproval_yearly.php?fyear=$py1&parkcode=$parkcode'>$py1</font></a></td>";}
/*
if($py2==$fyear){$py2_td="<td><a href='preapproval_yearly.php?fyear=$py2&parkcode=$parkcode'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
if($py2!=$fyear){$py2_td="<td><a href='preapproval_yearly.php?fyear=$py2&parkcode=$parkcode'>$py2</font></a></td>";}

if($py3==$fyear){$py3_td="<td><a href='preapproval_yearly.php?fyear=$py3&parkcode=$parkcode'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
if($py3!=$fyear){$py3_td="<td><a href='preapproval_yearly.php?fyear=$py3&parkcode=$parkcode'>$py3</font></a></td>";}
*/


echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";






}
echo "</tr>";
echo "</table>";
echo "<br />";



?>







