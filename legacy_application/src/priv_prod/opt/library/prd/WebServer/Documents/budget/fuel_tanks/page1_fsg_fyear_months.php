<?php

//if($cash_month==''){$cash_month='july';}
if($cash_month=='july'){$shade_july="class=cartRow";}
if($cash_month=='august'){$shade_august="class=cartRow";}
if($cash_month=='september'){$shade_september="class=cartRow";}
if($cash_month=='october'){$shade_october="class=cartRow";}
if($cash_month=='november'){$shade_november="class=cartRow";}
if($cash_month=='december'){$shade_december="class=cartRow";}
if($cash_month=='january'){$shade_january="class=cartRow";}
if($cash_month=='february'){$shade_february="class=cartRow";}
if($cash_month=='march'){$shade_march="class=cartRow";}
if($cash_month=='april'){$shade_april="class=cartRow";}
if($cash_month=='may'){$shade_may="class=cartRow";}
if($cash_month=='june'){$shade_june="class=cartRow";}

//echo "fyear=$fyear<br /><br />";


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

//if($park==''){$park=$concession_location;}
//if($center==''){$center=$concession_center;}


//echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
/*
if($filegroup=='daily')

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}
*/



//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=july' target='_blank'><font  $shade_july>Jul</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=august' target='_blank'><font  $shade_august>Aug</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=september' target='_blank'><font  $shade_september>Sep</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=october' target='_blank'><font  $shade_october>Oct</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=november' target='_blank'><font  $shade_november>Nov</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=december' target='_blank'><font  $shade_december>Dec</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=january' target='_blank'><font  $shade_january>Jan</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=february' target='_blank'><font  $shade_february>Feb</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=march' target='_blank'><font  $shade_march>Mar</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=april' target='_blank'><font  $shade_april>Apr</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=may' target='_blank'><font  $shade_may>May</font></a></td>";
echo "<td><a href='mfm_summary.php?fyear=$fyear&cash_month=june' target='_blank'><font  $shade_june>Jun</font></a></td>";




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







