<?php

if($fyear==''){$fyear=$f_year;}
if($compliance_fyear==''){$compliance_fyear='1920' ;}
if($compliance_fyear=='2122'){$shade_2122="class=cartRow";}
if($compliance_fyear=='2021'){$shade_2021="class=cartRow";}
if($compliance_fyear=='1920'){$shade_1920="class=cartRow";}
if($compliance_fyear=='1819'){$shade_1819="class=cartRow";}
if($compliance_fyear=='1718'){$shade_1718="class=cartRow";}
if($compliance_fyear=='1617'){$shade_1617="class=cartRow";}


echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal Year</font></td>";


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=2122&parkcode=$parkcode'><font  $shade_2122>2122</font></a></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=2021&parkcode=$parkcode'><font  $shade_2021>2021</font></a></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=1920&parkcode=$parkcode'><font  $shade_1920>1920</font></a></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=1819&parkcode=$parkcode'><font  $shade_1819>1819</font></a></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=1718&parkcode=$parkcode'><font  $shade_1718>1718</font></a></td>";
echo "<td><a href='monthly_compliance_admin.php?compliance_fyear=1617&parkcode=$parkcode'><font  $shade_1617>1617</font></a></td>";

echo "</tr>";

echo "</table>";
echo "<br />";


?>