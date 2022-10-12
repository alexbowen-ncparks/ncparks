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
//$vehicle_repair_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/vehicle_repair1.png' alt='picture of vehicle repair'></img>";



$vehicle_repair_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/vehicle_repair1.png' alt='picture of vehicle repair'></img><br /><font color='brown'>$grand_total</font>";


if($level==1){$park_header=$concession_location;}


/*
echo "<td align='center'><font size='5' color='brown'>$park_header Vehicle<br />RepairCosts<br />$vehicle_repair_icon</font></td><th>Repairs<br />532331</th><th>Fluids<br />533330</th><th>Tires<br />533340</th><th>Parts<br />533350</th>";
*/

echo "<td align='center'><font size='5' color='brown'>$park_header Vehicle<br />RepairCosts<br />$vehicle_repair_icon</font></td><th>Repairs<br />532331<br /><br /><font color='brown'>$total_532331</font></th><th>Fluids<br />533330<br /><br /><font color='brown'>$total_533330</font></th><th>Tires<br />533340<br /><br /><font color='brown'>$total_533340</font></th><th>Parts<br />533350<br /><br /><font color='brown'>$total_533350</font></th>";




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







