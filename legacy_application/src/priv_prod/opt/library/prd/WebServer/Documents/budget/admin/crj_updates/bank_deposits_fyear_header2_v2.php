<?php
if($f_year==''){$f_year='1415';}
if($f_year=='1415'){$shade_1415="class=cartRow";}

if($f_year=='1314'){$shade_1314="class=cartRow";}




echo "<table border=2 cellspacing=2>";

echo "<tr>";




echo "<td><font size=4 color=brown >Fiscal<br />Year</font></td>";
//echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";

//echo "<td><font size=4 color=brown >Fiscal Year</font></td>";
echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
/*
if($filegroup=='weekly')

{echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_weekly.php' >Weekly</A></b></font></td>";}

if($filegroup!='weekly')

{echo "<td><font size=4 ><b><A href='park_posted_deposits_weekly.php' >Weekly</A></b></font></td>";}
*/

$filegroup="daily";
/*
if($filegroup=='daily') 

{echo "<td><font size=4 class=cartRow ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}


if($filegroup!='daily') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center' >Daily</A></b></font></td>";}
*/
// CRS Parks
if($pcode != 'CACR' 
and $pcode != 'CHRO' 
and $pcode != 'DISW' 
and $pcode != 'ELKN' 
and $pcode != 'FOFI' 
and $pcode != 'FOMA' 
and $pcode != 'GRMO' 
and $pcode != 'HARI' 
and $pcode != 'JORI' 
and $pcode != 'MARI' 
and $pcode != 'SILA' 
and $pcode != 'WEWO' 
and $pcode != 'MOJE' 
and $beacnum != '60032781'
and $beacnum != '60036015'
)
{

echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'><font  $shade_1415>1415</font></a></td>";


echo "<td><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'><font  $shade_1314>1314</font></a></td>";

}
else

//Non-CRS Parks
{
echo "<td><a href='bank_deposits.php?add_your_own=y&f_year=1415&park=$park&center=$center'><font  $shade_1415>1415</font></a></td>";


echo "<td><a href='bank_deposits.php?add_your_own=y&f_year=1314&park=$park&center=$center'><font  $shade_1314>1314</font></a></td>";
}

echo "</tr>";

echo "</table>";


?>





