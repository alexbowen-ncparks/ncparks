<?php

if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}

if($f_year=='1011'){$shade_1011="class=cartRow";}

if($f_year=='0910'){$shade_0910="class=cartRow";}











echo "<table border=2 cellspacing=2>";

echo "<tr>";




//echo "<td><font size=4 color=brown >$park-$center</font></td>";
//echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";

//echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
echo "<br />";
echo "<td><font size=4 color=brown >$park-$center</font></td>";
/*
if($filegroup=='weekly')

{echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_weekly.php' >Weekly</A></b></font></td>";}

if($filegroup!='weekly')

{echo "<td><font size=4 ><b><A href='park_posted_deposits_weekly.php' >Weekly</A></b></font></td>";}
*/

$filegroup="daily";

if($filegroup=='daily') 

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}





if($filegroup!='daily') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}




echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=1314&park=$park&center=$center'><font  $shade_1314>1314</font></a></td>";

echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=1213&park=$park&center=$center'><font  $shade_1213>1213</font></a></td>";

echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=1112&park=$park&center=$center'><font  $shade_1112>1112</font></a></td>";

echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=1011&park=$park&center=$center'><font  $shade_1011>1011</font></a></td>";

echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=0910&park=$park&center=$center'><font  $shade_0910>0910</font></a></td>";



echo "</tr>";

echo "</table>";


?>





