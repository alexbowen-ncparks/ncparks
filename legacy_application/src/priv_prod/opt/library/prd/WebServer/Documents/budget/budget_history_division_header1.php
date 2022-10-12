<?php
//echo "hello tony<br />";
//$filegroup='monthly';
//echo "<br />filegroup=$filegroup<br />";
if($region==''){$region="core";}
if($region=='core'){$shade_core="class=cartRow";}
if($region=='pire'){$shade_pire="class=cartRow";}
if($region=='more'){$shade_more="class=cartRow";}
if($region=='stwd'){$shade_stwd="class=cartRow";}
if($region=='all'){$shade_all="class=cartRow";}

if($region=='core'){$core_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($region=='pire'){$pire_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($region=='more'){$more_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($region=='stwd'){$stwd_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($region=='all'){$core_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";

echo "<td align='left'><a href='budget_summary_division.php?region=core'><font  $shade_core>CORE $core_check</font></a></td>";
echo "<td align='left'><a href='budget_summary_division.php?region=pire'><font  $shade_pire>PIRE $pire_check</font></a></td>";
echo "<td align='left'><a href='budget_summary_division.php?region=more'><font  $shade_more>MORE $more_check</font></a></td>";
echo "<td align='left'><a href='budget_summary_division.php?region=stwd'><font  $shade_stwd>CORE $stwd_check</font></a></td>";
echo "<td align='left'><a href='budget_summary_division.php?region=all'><font  $shade_all>ALL $all_check</font></a></td>";






?>