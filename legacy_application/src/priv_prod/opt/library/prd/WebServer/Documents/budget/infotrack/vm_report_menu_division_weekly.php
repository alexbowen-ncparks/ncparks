<?php

//if($f_year=='1314'){$shade_1314="class=cartRow";}
/*
echo "<table border='5' cellspacing='5'>";
echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";
echo "</tr></table>";
*/

echo "<br />";
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
$vehicle_repair_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/vehicle_repair1.png' alt='picture of vehicle repair'></img><br /><font color='red'>$grand_total</font>";

if($level==1){$park_header=$concession_location;}

echo "<td align='center'><font size='5' color='brown'>$park_header Vehicle<br />RepairCosts<br />$vehicle_repair_icon</font></td><th><font color='brown'>Repairs<br />532331</font><br /><br />$total_532331</th><th><font color='brown'>Fluids<br />533330</font><br /><br />$total_533330</th><th><font color='brown'>Tires<br />533340</font><br /><br />$total_533340</th><th><font color='brown'>Parts<br />533350</font><br /><br />$total_533350</th>";
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







