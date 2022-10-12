<?php
if($egroup=='electricity' and $report=='cdcs'){$shade_electricity_cdcs="class=cartRow";}
if($egroup=='electricity' and $report=='accounts'){$shade_electricity_accounts="class=cartRow";}
if($egroup=='electricity' and $report=='cost'){$shade_electricity_cost="class=cartRow";}
if($egroup=='electricity' and $report=='usage'){$shade_electricity_usage="class=cartRow";}
if($egroup=='electricity' and $report=='rate'){$shade_electricity_rate="class=cartRow";}


if($egroup=='water' and $report=='cdcs'){$shade_water_cdcs="class=cartRow";}
if($egroup=='water' and $report=='accounts'){$shade_water_accounts="class=cartRow";}
if($egroup=='water' and $report=='cost'){$shade_water_cost="class=cartRow";}
if($egroup=='water' and $report=='usage'){$shade_water_usage="class=cartRow";}
if($egroup=='water' and $report=='rate'){$shade_water_rate="class=cartRow";}


if($egroup=='natgas_propane' and $report=='cdcs'){$shade_natgas_propane_cdcs="class=cartRow";}
if($egroup=='natgas_propane' and $report=='accounts'){$shade_natgas_propane_accounts="class=cartRow";}
if($egroup=='natgas_propane' and $report=='cost'){$shade_natgas_propane_cost="class=cartRow";}
if($egroup=='natgas_propane' and $report=='usage'){$shade_natgas_propane_usage="class=cartRow";}
if($egroup=='natgas_propane' and $report=='rate'){$shade_natgas_propane_rate="class=cartRow";}


if($valid_account=='y'){$shade_valid_accounts_y="class=cartRow";}
if($valid_account=='n'){$shade_valid_accounts_n="class=cartRow";}




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
if($level==1){$park_header=$concession_location;}

echo "<td align='center'><font size='5' color='brown'>$park_header<br />Energy<br />$energy_icon</font></td><th>Electricity<br />532210<br /><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=cdcs&valid_account=y'><font color='brown'  $shade_electricity_cdcs>CDCS</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=accounts'><font color='brown'  $shade_electricity_accounts>Accounts</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=cost'><font color='brown'  $shade_electricity_cost>Cost</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=usage'><font color='brown'  $shade_electricity_usage>Usage</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=rate'><font color='brown'  $shade_electricity_rate>Rate</font></a></th>

<th>Water<br />532230<br /><a href='energy_reporting.php?f_year=$f_year&egroup=water&report=cdcs&valid_account=n'><font color='brown'  $shade_water_cdcs>CDCS</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=water&report=accounts'><font color='brown'  $shade_water_accounts>Accounts</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=water&report=cost'><font color='brown'  $shade_water_cost>Cost</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=water&report=usage'><font color='brown'  $shade_water_usage>Usage</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=water&report=rate'><font color='brown'  $shade_water_rate>Rate</font></a></th>


<th>NatGas & Propane<br />532220<br /><a href='energy_reporting.php?f_year=$f_year&egroup=natgas_propane&report=cdcs&valid_account=n'><font color='brown'  $shade_natgas_propane_cdcs>CDCS</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=natgas_propane&report=accounts'><font color='brown'  $shade_natgas_propane_accounts>Accounts</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=natgas_propane&report=cost'><font color='brown'  $shade_natgas_propane_cost>Cost</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=natgas_propane&report=usage'><font color='brown'  $shade_natgas_propane_usage>Usage</font></a><br /><a href='energy_reporting.php?f_year=$f_year&egroup=natgas_propane&report=rate'><font color='brown'  $shade_natgas_propane_rate>Rate</font></a></th>


<th>Fuel Oil<br />532241</th>";
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







