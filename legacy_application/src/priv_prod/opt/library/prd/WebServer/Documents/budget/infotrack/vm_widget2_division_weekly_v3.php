<?php

if($f_year=='1415'){$shade_1415="class=cartRow";}

if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}

if($f_year=='1011'){$shade_1011="class=cartRow";}

if($f_year=='0910'){$shade_0910="class=cartRow";}
if($f_year=='0809'){$shade_0809="class=cartRow";}
if($f_year=='0708'){$shade_0708="class=cartRow";}
if($f_year=='0607'){$shade_0607="class=cartRow";}
if($f_year=='0506'){$shade_0506="class=cartRow";}
if($f_year=='0405'){$shade_0405="class=cartRow";}
if($f_year=='0304'){$shade_0304="class=cartRow";}

echo "<br />";
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >$park</font></td>";

if($filegroup=='daily')

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}




//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";


echo "<td><a href='vm_costs_center_daily_division.php?f_year=1415&park=$park&center=$center'><font  $shade_1415>1415</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=1314&park=$park&center=$center'><font  $shade_1314>1314</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=1213&park=$park&center=$center'><font  $shade_1213>1213</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=1112&park=$park&center=$center'><font  $shade_1112>1112</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=1011&park=$park&center=$center'><font  $shade_1011>1011</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0910'><font  $shade_0910>0910</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0809'><font  $shade_0809>0809</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0708'><font  $shade_0708>0708</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0607'><font  $shade_0607>0607</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0506'><font  $shade_0506>0506</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0405'><font  $shade_0405>0405</font></a></td>";
echo "<td><a href='vm_costs_center_daily_division.php?f_year=0304'><font  $shade_0304>0304</font></a></td>";





/*

if($filegroup!='monthly') 

{echo "<td><font size=4 ><b><A href='vm_costs_monthly.php' >Monthly</A></b></font></td>";}
*/


/*




if($filegroup=='customize')

{echo "<td><font size=4 class=cartRow><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}



if($filegroup!='customize') 

{echo "<td><font size=4 ><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}

*/

echo "</tr>";

echo "</table>";
echo "<br />";






?>







