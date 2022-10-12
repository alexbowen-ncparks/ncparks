<?php

if($fyear=='1415'){$shade_1415="class=cartRow";}

if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}
if($fyear=='0910'){$shade_0910="class=cartRow";}
if($fyear=='0809'){$shade_0809="class=cartRow";}
if($fyear=='0708'){$shade_0708="class=cartRow";}
if($fyear=='0607'){$shade_0607="class=cartRow";}
if($fyear=='0506'){$shade_0506="class=cartRow";}
if($fyear=='0405'){$shade_0405="class=cartRow";}


echo "<br />";
echo "<table border='5' cellspacing='5'>";
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
if($filegroup=='monthly')

{
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=1415'><font  $shade_1415>1415</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=1314'><font  $shade_1314>1314</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=1213'><font  $shade_1213>1213</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=1112'><font  $shade_1112>1112</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=1011'><font  $shade_1011>1011</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0910'><font  $shade_0910>0910</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0809'><font  $shade_0809>0809</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0708'><font  $shade_0708>0708</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0607'><font  $shade_0607>0607</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0506'><font  $shade_0506>0506</font></a></td>";
echo "<td><a href='park_inc_stmts_by_fyear.php?fyear=0405'><font  $shade_0405>0405</font></a></td>";




}



if($filegroup!='monthly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";}
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







