<?php

//echo "<br />Hello fyear_head_naspd_annual2.php"; exit;
echo "<br />";

$query3="select cy from fiscal_year where active_year='y' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year

if($f_year==''){$f_year=$cy;}

//Replace static Fiscal year Menu Bar with "dynamically produced menu".  This will automatically change in the NEW Fiscal year when MoneyCounts Administrator changes the "active_year" in TABLE=fiscal_year (bass 12/9/19)
$query5b="select cy,py1,py2,py3,py4 from fiscal_year where active_year='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");
$num5b=mysqli_num_rows($result5b);

echo "<table border='5' cellspacing='5' align='center'>";
while ($row5b=mysqli_fetch_array($result5b)){
echo "<tr>";

$checkmark_image="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

extract($row5b);



if($py1==$f_year){$py1_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py1'><font class=cartRow>$py1 $checkmark_image</font></a></td>";}
if($py1!=$f_year){$py1_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py1'>$py1</a></td>";}


if($py2==$f_year){$py2_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py2'><font class=cartRow>$py2 $checkmark_image</font></a></td>";}
if($py2!=$f_year){$py2_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py2'>$py2</a></td>";}

if($py3==$f_year){$py3_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py3'><font class=cartRow>$py3 $checkmark_image</font></a></td>";}
if($py3!=$f_year){$py3_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py3'>$py2</a></td>";}

if($py4==$f_year){$py4_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py4'><font class=cartRow>$py4 $checkmark_image</font></a></td>";}
if($py4!=$f_year){$py4_td="<td><a href='naspd_annual.php?report_type=$report_type&f_year=$py4'>$py4</a></td>";}





echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";


echo "</tr>";

}
echo "</table>";








?>