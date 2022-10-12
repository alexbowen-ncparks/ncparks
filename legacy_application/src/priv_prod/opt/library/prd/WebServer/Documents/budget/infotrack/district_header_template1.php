<?php
extract($_REQUEST);
if($district==''){$district='east';}
$report_type='reports';

/*
if($fyear=='1415'){$shade_1415="class=cartRow";}

if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}
if($fyear=='0910'){$shade_0910="class=cartRow";}

*/


if($district=='east'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='north'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='south'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='west'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";



echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a></td>";
echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=1314'><font  $shade_1314>1314 $fyear_1314_check</font></a></td>";
echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=1213'><font  $shade_1213>1213 $fyear_1213_check</font></a></td>";
echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=1112'><font  $shade_1112>1112 $fyear_1112_check</font></a></td>";
echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=1011'><font  $shade_1011>1011 $fyear_1011_check</font></a></td>";
echo "<td align='left'><a href='fyear_head_template1.php?report_type=$report_type&fyear=0910'><font  $shade_0910>0910 $fyear_0910_check</font></a></td>";



echo "</tr>";

echo "</table>";






?>







