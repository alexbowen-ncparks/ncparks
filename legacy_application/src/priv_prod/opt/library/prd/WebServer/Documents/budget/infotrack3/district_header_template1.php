<?php
extract($_REQUEST);
if($district==''){$district='east';}
$report_type='reports';



if($district=='east'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='north'){$north_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='south'){$south_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='west'){$west_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='stwd'){$stwd_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td align='left'><a href='district_header_template1.php?district=east'><font>east $east_check</font></a></td>";
echo "<td align='left'><a href='district_header_template1.php?district=north'><font>north $north_check</font></a></td>";
echo "<td align='left'><a href='district_header_template1.php?district=south'><font>south $south_check</font></a></td>";
echo "<td align='left'><a href='district_header_template1.php?district=west'><font>west $west_check</font></a></td>";
echo "<td align='left'><a href='district_header_template1.php?district=stwd'><font>stwd $stwd_check</font></a></td>";





echo "</tr>";

echo "</table>";






?>







