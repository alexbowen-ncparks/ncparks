<?php
if($egroup=='electricity' and $report=='accounts'){$shade_electricity_accounts="class=cartRow";}
//if($f_year=='1314'){$shade_1314="class=cartRow";}
/*
echo "<table border='5' cellspacing='5'>";
echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";
echo "</tr></table>";
*/
echo "<table border='5' cellspacing='5'>";
//echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";

//echo "<tr>";
//echo "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "tempID=$tempID";

//cho "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "<td><font size='4'  class=cartRow><b><A href='park_posted_deposits.php' >CRJ-Park Posted</a></b></font></td>";





//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly.php' >Park Deposits</A></b></font></td>";


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_v2.php' >Park Bank Deposits-Posted</A></b></font></td>";
echo "<tr>";
/*
if($level < '3')
{
echo "<td><font size='5' color='brown'>$concession_location</font></td>";
}

*/

$energy_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/energy1.png' alt='picture of energy icon'></img>";


echo "<td align='center'><font size='5' color='brown'>Energy<br />Reporting<br >$energy_icon</font></td><th>Electricity<br />532210<br /><a href='vm_costs_monthly.php?f_year=$f_year&egroup=electricity&report=accounts'><font color='brown'  $shade_electricity_accounts>Accounts</font></a><br />Costs<br />Rate<br />Usage</font></th><th>Water<br />532230</th><th>NatGas & Propane<br />532220</th><th>Fuel Oil<br />532241</th>";
/*
if($level < '3')
{
echo "<td><font size='5' color='brown'>$concession_location</font></td>";
}
else
{
echo "<td><font size='5' color='brown'>$posTitle</font></td>";
}
*/



echo "</tr>";

echo "</table>";







?>







