<?php

if($sector==''){$sector='admi';}
if($sector=='admi'){$shade_admi="class=cartRow";}
if($sector=='dede'){$shade_dede="class=cartRow";}
if($sector=='dire'){$shade_dire="class=cartRow";}
if($sector=='eadi'){$shade_eadi="class=cartRow";}
if($sector=='nara'){$shade_nara="class=cartRow";}
if($sector=='nodi'){$shade_nodi="class=cartRow";}
if($sector=='opad'){$shade_opad="class=cartRow";}
if($sector=='sodi'){$shade_sodi="class=cartRow";}
if($sector=='wedi'){$shade_wedi="class=cartRow";}


/*
if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}

if($f_year=='1011'){$shade_1011="class=cartRow";}

if($f_year=='0910'){$shade_0910="class=cartRow";}
*/
echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table align='center' border='2' cellspacing='5'>";
echo "<tr>";
echo "<br />";
/*
if($park==''){$park=$concession_location;}
if($center==''){$center=$concession_center;}
*/

echo "<td><font size=4 color=brown >Customers</font></td>";
echo "<td><a href='bright_idea2.php?sector=admi'><font  $shade_admi>ADMI</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=dede'><font  $shade_dede>DEDE</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=dire'><font  $shade_dire>DIRE</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=eadi'><font  $shade_eadi>EADI</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=nara'><font  $shade_nara>NARA</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=nodi'><font  $shade_nodi>NODI</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=opad'><font  $shade_opad>OPAD</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=sodi'><font  $shade_sodi>SODI</font></a></td>";
echo "<td><a href='bright_idea2.php?sector=wedi'><font  $shade_wedi>WEDI</font></a></td>";



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







