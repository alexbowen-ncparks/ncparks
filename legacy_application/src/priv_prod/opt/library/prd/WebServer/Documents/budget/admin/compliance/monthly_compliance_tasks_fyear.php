<?php

//if($fyear==''){$fyear=$f_year;}
/*
if($compliance_fyear==''){$compliance_fyear='1920' ;}
if($compliance_fyear=='2021'){$shade_2021="class=cartRow";}
if($compliance_fyear=='1920'){$shade_1920="class=cartRow";}
if($compliance_fyear=='1819'){$shade_1819="class=cartRow";}
if($compliance_fyear=='1718'){$shade_1718="class=cartRow";}
if($compliance_fyear=='1617'){$shade_1617="class=cartRow";}
*/

//062820: class=cartRow is defined in PHP File:  /budget/menu1415_v1_style.php
//062820: /budget/menu1415_v1_style.php is an INCLUDE File in Parent File: /budget/menu1415_v1.php

$shade="class=cartRow";


$query1="select report_year as 'compliance_fyear' from fiscal_year where active_year_compliance='y' ";
		 
echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

echo "<br />compliance_fyear=$compliance_fyear<br />";

//echo "<br />Line 30<br />";









echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal Year</font></td>";


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

//echo "<td><a href='step_group.php?report_type=$report_type&compliance_fyear=2021'><font  $shade_2021>2021</font></a></td>";
echo "<td><font  $shade>$compliance_fyear</font></td>";
//echo "<td><a href='step_group.php?report_type=$report_type&compliance_fyear=1819'><font  $shade_1819>1819</font></a></td>";
//echo "<td><a href='step_group.php?report_type=$report_type&compliance_fyear=1718'><font  $shade_1718>1718</font></a></td>";
//echo "<td><a href='step_group.php?report_type=$report_type&compliance_fyear=1617'><font  $shade_1617>1617</font></a></td>";


echo "</tr>";

echo "</table>";
echo "<br />";


?>