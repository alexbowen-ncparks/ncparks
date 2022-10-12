<?php
extract($_REQUEST);
if($fyear==''){$fyear='2122';}
if($report_type==''){$report_type='reports';}


if($fyear=='2122'){$fyear_2122_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='2021'){$fyear_2021_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1920'){$fyear_1920_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1819'){$fyear_1819_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1718'){$fyear_1718_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1617'){$fyear_1617_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1516'){$fyear_1516_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}


echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td><font color='brown'>Report Year</brown></td>";

if($report_type=='reports')
{
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=2122'><font  $shade_2122>2122 $fyear_2122_check</font></a></td>";	
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=2021'><font  $shade_2021>2021 $fyear_2021_check</font></a></td>";	
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1920'><font  $shade_1920>1920 $fyear_1920_check</font></a></td>";	
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1819'><font  $shade_1819>1819 $fyear_1819_check</font></a></td>";	
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1718'><font  $shade_1718>1718 $fyear_1718_check</font></a></td>";	
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1617'><font  $shade_1617>1617 $fyear_1617_check</font></a></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1516'><font  $shade_1516>1516 $fyear_1516_check</font></a></td>";

echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a></td>";
}
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