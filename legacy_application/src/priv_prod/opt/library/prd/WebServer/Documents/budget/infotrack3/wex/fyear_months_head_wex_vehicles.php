<?php

//if($wex_month==''){$wex_month='july';}
if($wex_month=='july'){$shade_july="class=cartRow";}
if($wex_month=='august'){$shade_august="class=cartRow";}
if($wex_month=='september'){$shade_september="class=cartRow";}
if($wex_month=='october'){$shade_october="class=cartRow";}
if($wex_month=='november'){$shade_november="class=cartRow";}
if($wex_month=='december'){$shade_december="class=cartRow";}
if($wex_month=='january'){$shade_january="class=cartRow";}
if($wex_month=='february'){$shade_february="class=cartRow";}
if($wex_month=='march'){$shade_march="class=cartRow";}
if($wex_month=='april'){$shade_april="class=cartRow";}
if($wex_month=='may'){$shade_may="class=cartRow";}
if($wex_month=='june'){$shade_june="class=cartRow";}

//echo "fyear=$fyear<br /><br />";
//$wex_calyear1="20".substr($wex_fyear,0,2);
//$wex_calyear2="20".substr($wex_fyear,2,2);
//echo "<br />wex_calyear1=$wex_calyear1<br />";
//echo "<br />wex_calyear2=$wex_calyear2<br />";

echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<br />";


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=july' ><font  $shade_july>Jul</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=august' ><font  $shade_august>Aug</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=september' ><font  $shade_september>Sep</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=october' ><font  $shade_october>Oct</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=november' ><font  $shade_november>Nov</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=december' ><font  $shade_december>Dec</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=january' ><font  $shade_january>Jan</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=february' ><font  $shade_february>Feb</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=march' ><font  $shade_march>Mar</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=april' ><font  $shade_april>Apr</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&wex_month=may' ><font  $shade_may>May</font></a></td>";
echo "<td><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear&&wex_month=june' ><font  $shade_june>Jun</font></a></td>";




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