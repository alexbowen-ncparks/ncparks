<?php

if($f_year=='1415'){$shade_1415="class=cartRow";}
if($calmonth=='jul'){$shade_jul="class=cartRow";}
if($calmonth=='aug'){$shade_aug="class=cartRow";}
if($calmonth=='sep'){$shade_sep="class=cartRow";}
if($calmonth=='oct'){$shade_oct="class=cartRow";}
if($calmonth=='nov'){$shade_nov="class=cartRow";}
if($calmonth=='dec'){$shade_dec="class=cartRow";}
if($calmonth=='jan'){$shade_jan="class=cartRow";}
if($calmonth=='feb'){$shade_feb="class=cartRow";}
if($calmonth=='mar'){$shade_mar="class=cartRow";}
if($calmonth=='apr'){$shade_apr="class=cartRow";}
if($calmonth=='may'){$shade_may="class=cartRow";}
if($calmonth=='jun'){$shade_jun="class=cartRow";}

/*
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
*/
echo "<br />";
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal Year</font></td>";

if($filegroup=='daily')

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}




//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";


echo "<td><a href='small_purchases_report2a.php?f_year=1415'><font  $shade_1415>1415</font></a></td>";


echo "</tr>";

echo "</table>";
echo "<br />";
echo "<table border='1'>";
echo "<tr>";
echo "<td><a href='small_purchases_report2a.php?calmonth=jul&month_number=07'><font  $shade_jul>Jul</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=aug&month_number=08'><font  $shade_aug>Aug</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=sep&month_number=09'><font  $shade_sep>Sep</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=oct&month_number=10'><font  $shade_oct>Oct</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=nov&month_number=11'><font  $shade_nov>Nov</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=dec&month_number=12'><font  $shade_dec>Dec</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=jan&month_number=01'><font  $shade_jan>Jan</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=feb&month_number=02'><font  $shade_feb>Feb</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=mar&month_number=03'><font  $shade_mar>Mar</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=apr&month_number=04'><font  $shade_apr>Apr</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=may&month_number=05'><font  $shade_may>May</td>";
echo "<td><a href='small_purchases_report2a.php?calmonth=jun&month_number=06'><font  $shade_jun>Jun</td>";
echo "</table>";





?>







