<?php

if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

//if($f_year=='1112'){$shade_1112="class=cartRow";}
/*
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
$filegroup='monthly';
if($filegroup=='monthly')

{
//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";

echo "<td><a href='energy_reporting.php?f_year=1314&egroup=$egroup&report=$report'><font  $shade_1314>1314</font></a></td>";
echo "<td><a href='energy_reporting.php?f_year=1213&egroup=$egroup&report=$report'><font  $shade_1213>1213</font></a></td>";
//echo "<td><a href='energy_reporting.php?f_year=1112&egroup=$egroup&report=$report'><font  $shade_1112>1112</font></a></td>";

/*
echo "<td><a href='vm_costs_monthly.php?f_year=1011'><font  $shade_1011>1011</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0910'><font  $shade_0910>0910</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0809'><font  $shade_0809>0809</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0708'><font  $shade_0708>0708</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0607'><font  $shade_0607>0607</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0506'><font  $shade_0506>0506</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0405'><font  $shade_0405>0405</font></a></td>";
echo "<td><a href='vm_costs_monthly.php?f_year=0304'><font  $shade_0304>0304</font></a></td>";
*/


}


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
if($report != 'cdcs')
{
echo "<table border='1'>
<tr><th>f_year</th><th>egroup</th><th>report</th></tr>
<tr><td>$f_year</td><td>$egroup</td><td>$report</td></tr>
</table>";
}

if($report == 'cdcs')
{
echo "<table border='1'>
<tr><th>f_year</th><th>egroup</th><th>report</th><th>Valid</th></tr>
<tr><td>$f_year</td><td>$egroup</td><td>$report</td><td><a href='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=cdcs&valid_account=y'><font color='brown'  $shade_valid_accounts_y>Y</font><br /><a href='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=cdcs&valid_account=n'><font color='brown'  $shade_valid_accounts_n>N</font></td></tr>
</table>";
}




echo "<br />";





?>







