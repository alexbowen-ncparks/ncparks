<?php


echo "<table border='5' cellspacing='5'>";

echo "<tr>";


$vehicle_repair_icon="<img height='60' width='60' src='/budget/infotrack/icon_photos/vehicle_repair1.png' alt='picture of vehicle repair'></img><br /><font color='brown'>$grand_total</font>";


if($level==1){$park_header=$concession_location;}

echo "<td align='center'><font size='5' color='brown'>$park_header Vehicle<br />RepairCosts<br />$vehicle_repair_icon</font></td><th>Repairs<br />532331<br /><br /><font color='brown'>$total_532331</font></th><th>Fluids<br />533330<br /><br /><font color='brown'>$total_533330</font></th><th>Tires<br />533340<br /><br /><font color='brown'>$total_533340</font></th><th>Parts<br />533350<br /><br /><font color='brown'>$total_533350</font></th>";



echo "</tr>";

echo "</table>";







?>







