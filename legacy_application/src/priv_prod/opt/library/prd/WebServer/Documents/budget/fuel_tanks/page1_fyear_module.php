<?php

//if($fyear==''){$fyear=$f_year;}


$today=date("Y-m-d");
$today2=str_replace("-","",$today);
//echo "<br />Line 8: today=$today<br />";
//echo "<br />Line 9: today2=$today2<br />";

//if(($fyear=='') and ($today2 <= '20180702' )){$fyear='1718';}
//if(($fyear=='') and ($today2 >= '20180703' )){$fyear='1819';}

//if($fyear==''){$fyear='1718';}
$fyear='1718';
if($fyear=='1819'){$shade_1819="class=cartRow";}
if($fyear=='1718'){$shade_1718="class=cartRow";}
if($fyear=='1617'){$shade_1617="class=cartRow";}
if($fyear=='1516'){$shade_1516="class=cartRow";}
if($fyear=='1415'){$shade_1415="class=cartRow";}
/*
if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}

if($f_year=='1011'){$shade_1011="class=cartRow";}

if($f_year=='0910'){$shade_0910="class=cartRow";}
*/
echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
/*
if($filegroup=='daily')

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}
*/



//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

//echo "<td><a href='page1.php?fyear=1819&parkcode=$parkcode'><font  $shade_1819>1819</font></a></td>";
echo "<td><a href='page1.php?fyear=1718&parkcode=$parkcode'><font  $shade_1718>1718</font></a></td>";
echo "<td><a href='page1.php?fyear=1617&parkcode=$parkcode'><font  $shade_1617>1617</font></a></td>";
echo "<td><a href='page1.php?fyear=1516&parkcode=$parkcode'><font  $shade_1516>1516</font></a></td>";
echo "<td><a href='page1.php?fyear=1415&parkcode=$parkcode'><font  $shade_1415>1415</font></a></td>";



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







