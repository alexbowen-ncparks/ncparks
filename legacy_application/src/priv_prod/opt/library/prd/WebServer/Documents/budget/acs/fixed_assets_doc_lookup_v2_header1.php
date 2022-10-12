<?php

//if($f_year=='1415'){$shade_1415="class=cartRow";}
if($calmonth=='07'){$shade_jul="class=cartRow";}
if($calmonth=='08'){$shade_aug="class=cartRow";}
if($calmonth=='09'){$shade_sep="class=cartRow";}
if($calmonth=='10'){$shade_oct="class=cartRow";}
if($calmonth=='11'){$shade_nov="class=cartRow";}
if($calmonth=='12'){$shade_dec="class=cartRow";}
if($calmonth=='01'){$shade_jan="class=cartRow";}
if($calmonth=='02'){$shade_feb="class=cartRow";}
if($calmonth=='03'){$shade_mar="class=cartRow";}
if($calmonth=='04'){$shade_apr="class=cartRow";}
if($calmonth=='05'){$shade_may="class=cartRow";}
if($calmonth=='06'){$shade_jun="class=cartRow";}

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

/*
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";




echo "<td><font size=4 color=brown >Fiscal Year</font></td>";


echo "<td><a href='fixed_assets_doc_lookup_v2.php?f_year=1415'><font  $shade_1415>1415</font></a></td>";


echo "</tr>";

echo "</table>";
*/
echo "<br />";
echo "<table border='1'>";
echo "<tr>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=07&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_jul>Jul</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=08&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_aug>Aug</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=09&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_sep>Sep</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=10&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_oct>Oct</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=11&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_nov>Nov</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=12&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_dec>Dec</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=01&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_jan>Jan</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=02&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_feb>Feb</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=03&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_mar>Mar</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=04&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_apr>Apr</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=05&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_may>May</td>";
echo "<td><a href='fixed_assets_doc_lookup_v2.php?calmonth=06&location=$location&center=$center&account=$account&fiscalyear=$fiscalyear&submit=search'><font  $shade_jun>Jun</td>";
echo "</table>";





?>







