<?php


if($fyear==''){$fyear='2223';}

/*
if($f_year=='1516'){$shade_1516="class=cartRow";}
if($f_year=='1415'){$shade_1415="class=cartRow";}
*/

if($fyear=='2425'){$shade_2425="class=cartRow";}
if($fyear=='2324'){$shade_2324="class=cartRow";}
if($fyear=='2223'){$shade_2223="class=cartRow";}
if($fyear=='2122'){$shade_2122="class=cartRow";}
if($fyear=='2021'){$shade_2021="class=cartRow";}
if($fyear=='1920'){$shade_1920="class=cartRow";}
if($fyear=='1819'){$shade_1819="class=cartRow";}
if($fyear=='1718'){$shade_1718="class=cartRow";}
if($fyear=='1617'){$shade_1617="class=cartRow";}
if($fyear=='1516'){$shade_1516="class=cartRow";}
if($fyear=='1415'){$shade_1415="class=cartRow";}



//if($f_year=='1314'){$shade_1314="class=cartRow";}

//if($f_year=='1213'){$shade_1213="class=cartRow";}

//if($f_year=='1112'){$shade_1112="class=cartRow";}

//if($f_year=='1011'){$shade_1011="class=cartRow";}

//if($f_year=='0910'){$shade_0910="class=cartRow";}
echo "<br />";
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";

//echo "<tr>";
//echo "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "tempID=$tempID";

//cho "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "<td><font size='4'  class=cartRow><b><A href='park_posted_deposits.php' >CRJ-Park Posted</a></b></font></td>";


/*

if($filegroup=='yearly')

{echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}



if($filegroup!='yearly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}
*/
/*
if($filegroup=='monthly')

{

*/
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=2223'><font  $shade_2223>2223</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=2122'><font  $shade_2122>2122</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=2021'><font  $shade_2021>2021</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1920'><font  $shade_1920>1920</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1819'><font  $shade_1819>1819</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1718'><font  $shade_1718>1718</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1617'><font  $shade_1617>1617</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1516'><font  $shade_1516>1516</font></a></td>";
echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&fyear=1415'><font  $shade_1415>1415</font></a></td>";
//echo "<td><a href='bank_deposits_menu_division_final.php?f_year=1314'><font  $shade_1314>1314</font></a></td>";
//echo "<td><a href='bank_deposits_menu_division_final.php?f_year=1213'><font  $shade_1213>1213</font></a></td>";
//echo "<td><a href='bank_deposits_menu_division_final.php?f_year=1112'><font  $shade_1112>1112</font></a></td>";
//echo "<td><a href='bank_deposits_menu_division_final.php?f_year=1011'><font  $shade_1011>1011</font></a></td>";
//echo "<td><a href='bank_deposits_menu_division_final.php?f_year=0910'><font  $shade_0910>0910</font></a></td>";


/*
}
*/
/*

if($filegroup!='monthly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";}

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







