<?php

/*
if($fyear=='1617'){$shade_1617="class=cartRow";}
if($fyear=='1516'){$shade_1516="class=cartRow";}
if($fyear=='1415'){$shade_1415="class=cartRow";}

if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}

if($fyear=='0910'){$shade_0910="class=cartRow";}
if($fyear=='0809'){$shade_0809="class=cartRow";}
if($fyear=='0708'){$shade_0708="class=cartRow";}
if($fyear=='0607'){$shade_0607="class=cartRow";}


echo "<br />";
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}





echo "<td><font size=4 color=brown >Fiscal Year</font></td>";


echo "<td><a href='equipment_requests_prior_years.php?fyear=1617&park=$park&center=$center'><font  $shade_1617>1617</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1516&park=$park&center=$center'><font  $shade_1516>1516</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1415&park=$park&center=$center'><font  $shade_1415>1415</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1314&park=$park&center=$center'><font  $shade_1314>1314</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1213&park=$park&center=$center'><font  $shade_1213>1213</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1112&park=$park&center=$center'><font  $shade_1112>1112</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=1011&park=$park&center=$center'><font  $shade_1011>1011</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0910'><font  $shade_0910>0910</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0809'><font  $shade_0809>0809</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0708'><font  $shade_0708>0708</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0607'><font  $shade_0607>0607</font></a></td>";
*/

$query12="select cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10 from fiscal_year where active_year='y'  ";
$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");



$num12=mysqli_num_rows($result12);

echo "<table>";
while ($row12=mysqli_fetch_array($result12)){
extract($row12);


echo "<tr>";
/*
echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$cy&park=$park&center=$center'><font  $shade_$cy>$cy</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py1&park=$park&center=$center'><font  $shade_$py1>$py1</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py2&park=$park&center=$center'><font  $shade_$py2>$py2</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py3&park=$park&center=$center'><font  $shade_$py3>$py3</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py4&park=$park&center=$center'><font  $shade_$py4>$py4</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py5&park=$park&center=$center'><font  $shade_$py5>$py5</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py6&park=$park&center=$center'><font  $shade_$py6>$py6</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=$py7'><font  $shade_0910>0910</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0809'><font  $shade_0809>0809</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0708'><font  $shade_0708>0708</font></a></td>";
echo "<td><a href='equipment_requests_prior_years.php?fyear=0607'><font  $shade_0607>0607</font></a></td>";

*/

if($fyear==''){$fyear=$cy;}
echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
// font class=cartRow (creates yellow highlight) is from a CORE Styling Sheet: /budget/menu1415_v1_style_new.php  which is INCLUDED via  ("/budget/menu1415_v1_new.php");
if($cy==$fyear)
{$cy_td="<td><a href='equipment_requests_prior_years.php?fyear=$cy&park=$park&center=$center'><font class=cartRow>$cy $checkmark_image</font></a></td>";} //chosen
else
{$cy_td="<td><a href='equipment_requests_prior_years.php?fyear=$cy&park=$park&center=$center'>$cy</a></td>";}	//not chosen


if($py1==$fyear)
{$py1_td="<td><a href='equipment_requests_prior_years.php?fyear=$py1&park=$park&center=$center'><font class=cartRow>$py1 $checkmark_image</font></a></td>";} //chosen
else
{$py1_td="<td><a href='equipment_requests_prior_years.php?fyear=$py1&park=$park&center=$center'>$py1</a></td>";}	//not chosen


if($py2==$fyear)
{$py2_td="<td><a href='equipment_requests_prior_years.php?fyear=$py2&park=$park&center=$center'><font class=cartRow>$py2 $checkmark_image</font></a></td>";} //chosen
else
{$py2_td="<td><a href='equipment_requests_prior_years.php?fyear=$py2&park=$park&center=$center'>$py2</a></td>";}	//not chosen

if($py3==$fyear)
{$py3_td="<td><a href='equipment_requests_prior_years.php?fyear=$py3&park=$park&center=$center'><font class=cartRow>$py3 $checkmark_image</font></a></td>";} //chosen
else
{$py3_td="<td><a href='equipment_requests_prior_years.php?fyear=$py3&park=$park&center=$center'>$py3</a></td>";}  //not chosen

if($py4==$fyear)
{$py4_td="<td><a href='equipment_requests_prior_years.php?fyear=$py4&park=$park&center=$center'><font class=cartRow>$py4 $checkmark_image</font></a></td>";} //chosen
else
{$py4_td="<td><a href='equipment_requests_prior_years.php?fyear=$py4&park=$park&center=$center'>$py4</a></td>";}  //not chosen

if($py5==$fyear)
{$py5_td="<td><a href='equipment_requests_prior_years.php?fyear=$py5&park=$park&center=$center'><font class=cartRow>$py5 $checkmark_image</font></a></td>";} //chosen
else
{$py5_td="<td><a href='equipment_requests_prior_years.php?fyear=$py5&park=$park&center=$center'>$py5</a></td>";}  	//not chosen

if($py6==$fyear)
{$py6_td="<td><a href='equipment_requests_prior_years.php?fyear=$py6&park=$park&center=$center'><font class=cartRow>$py6 $checkmark_image</font></a></td>";} //chosen
else
{$py6_td="<td><a href='equipment_requests_prior_years.php?fyear=$py6&park=$park&center=$center'>$py6</a></td>";}  //not chosen

if($py7==$fyear)
{$py7_td="<td><a href='equipment_requests_prior_years.php?fyear=$py7&park=$park&center=$center'><font class=cartRow>$py7 $checkmark_image</font></a></td>";} //chosen
else
{$py7_td="<td><a href='equipment_requests_prior_years.php?fyear=$py7&park=$park&center=$center'>$py7</a></td>";}   //not chosen

if($py8==$fyear)
{$py8_td="<td><a href='equipment_requests_prior_years.php?fyear=$py8&park=$park&center=$center'><font class=cartRow>$py8 $checkmark_image</font></a></td>";} //chosen
else
{$py8_td="<td><a href='equipment_requests_prior_years.php?fyear=$py8&park=$park&center=$center'>$py8</a></td>";}   //not chosen

if($py9==$fyear)
{$py9_td="<td><a href='equipment_requests_prior_years.php?fyear=$py9&park=$park&center=$center'><font class=cartRow>$py9 $checkmark_image</font></a></td>";} //chosen
else
{$py9_td="<td><a href='equipment_requests_prior_years.php?fyear=$py9&park=$park&center=$center'>$py9</a></td>";} // not chosen

if($py10==$fyear)
{$py10_td="<td><a href='equipment_requests_prior_years.php?fyear=$py10&park=$park&center=$center'><font class=cartRow>$py10 $checkmark_image</font></a></td>";}   //chosen
else
{$py10_td="<td><a href='equipment_requests_prior_years.php?fyear=$py10&park=$park&center=$center'>$py10</a></td>";}   //not chosen





echo "$cy_td";
echo "$py1_td";
echo "$py2_td";
echo "$py3_td";
echo "$py4_td";
echo "$py5_td";
echo "$py6_td";
echo "$py7_td";
echo "$py8_td";
echo "$py9_td";
echo "$py10_td";


echo "</tr>";













}




echo "</table>";
echo "<br />";






?>