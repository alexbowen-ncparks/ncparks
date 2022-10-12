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
if($region=='all'){$all_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}


//CHOP and Budget Officer and Director and Reuter and Tingley
if($beacnum=='60033018' or $beacnum=='60032781' or $beacnum=='60032778' or $beacnum=='60032779' or $beacnum=='60033202')
{
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";

echo "<td align='left'><a href='budget_summary_division.php?region=core'><font  $shade_core>CORE $core_check";
if($region=='core')
{
echo "<br />$budget_group";
}
echo "</font></a>";
echo "</td>";

echo "<td align='left'><a href='budget_summary_division.php?region=pire'><font  $shade_pire>PIRE $pire_check";
if($region=='pire')
{
echo "<br />$budget_group";
}
echo "</font></a>";
echo "</td>";


echo "<td align='left'><a href='budget_summary_division.php?region=more'><font  $shade_more>MORE $more_check";
if($region=='more')
{
echo "<br />$budget_group";
}
echo "</font></a>";
echo "</td>";


echo "<td align='left'><a href='budget_summary_division.php?region=stwd'><font  $shade_stwd>STWD $stwd_check";
if($region=='stwd')
{
echo "<br />$budget_group";
}
echo "</font></a>";
echo "</td>";


echo "<td align='left'><a href='budget_summary_division.php?region=all'><font  $shade_all>ALL $all_check";
if($region=='all')
{
echo "<br />$budget_group";
}
echo "</font></a>";
echo "</td>";

echo "</tr>";
echo "</table>";
}

//core mgr and core oa  (fullwood,quinn)
if($beacnum=='60032912' or $beacnum=='60032892')
{
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";
echo "<td align='left'><a href='budget_summary_division.php?region=core'><font  $shade_core>CORE $core_check<br />$budget_group</font></a></td>";
echo "</tr>";
echo "</table>";
} 

//pire mgr and pire oa (greenwood,mitchener)
if($beacnum=='60033019' or $beacnum=='60033093') 
{
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";
echo "<td align='left'><a href='budget_summary_division.php?region=pire'><font  $shade_pire>PIRE $pire_check<br />$budget_group</font></a></td>";
echo "</tr>";
echo "</table>";
} 

 //more mgr and more oa (mcelhone,bunn)
if($beacnum=='60032913' or $beacnum=='60032931')
{
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";
echo "<td align='left'><a href='budget_summary_division.php?region=more'><font  $shade_more>MORE $more_check<br />$budget_group</font></a></td>";
echo "</tr>";
echo "</table>";
} 


?>