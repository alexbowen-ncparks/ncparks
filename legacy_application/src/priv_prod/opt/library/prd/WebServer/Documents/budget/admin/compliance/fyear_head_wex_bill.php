<?php
extract($_REQUEST);
if($fyear==''){$fyear='1718';}
$report_type='reports';

/*
if($fyear=='1415'){$shade_1415="class=cartRow";}

if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}
if($fyear=='0910'){$shade_0910="class=cartRow";}

*/

if($fyear=='1718'){$fyear_1718_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1617'){$fyear_1617_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1516'){$fyear_1516_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
/*
if($fyear=='1314'){$fyear_1314_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1213'){$fyear_1213_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1112'){$fyear_1112_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1011'){$fyear_1011_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='0910'){$fyear_0910_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
*/



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td><font color='brown'>Report Year</brown></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1718'><font  $shade_1718>1718 $fyear_1718_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1617'><font  $shade_1617>1617 $fyear_1617_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1516'><font  $shade_1516>1516 $fyear_1516_check</font></a></td>";

echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a></td>";

/*
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1314'><font  $shade_1314>1314 $fyear_1314_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1213'><font  $shade_1213>1213 $fyear_1213_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1112'><font  $shade_1112>1112 $fyear_1112_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1011'><font  $shade_1011>1011 $fyear_1011_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=0910'><font  $shade_0910>0910 $fyear_0910_check</font></a></td>";
*/


echo "</tr>";

echo "</table>";






?>







