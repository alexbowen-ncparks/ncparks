<?php
$f_year='1415';
if($f_year=='1415'){$shade_1415="class=cartRow";}
//echo "gid2=$gid";


//echo "<br />";
echo "<table border='5' cellspacing='5'>";
echo "<tr>";
echo "<br />";

if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}


echo "<td><font size=4 color=brown >Fiscal<br />Year</font></td>";

if($filegroup=='daily')

{echo "<td><font size=4 class=cartRow ><b><A href='' >Daily</A></b></font></td>";}




//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

echo "<td><a href='games.php?f_year=1415&park=$park&center=$center'><font  $shade_1415>1415</font></a></td>";
echo "</tr>";

echo "</table>";
echo "<br />";
if($level<3)
{
include("../../../budget/infotrack/missions_headline_park_gid8.php");
}


//echo "gid2=$gid";
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


//echo "<br />";

//echo "gid2=$gid";

//echo "gid2=$gid";


?>







