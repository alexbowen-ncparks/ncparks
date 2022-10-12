<?php

if($scorer_count=='1')
{
if($flagM=='1'){$shade_fm1="class='cartRow'";}
if($flagM=='2'){$shade_fm2="class='cartRow'";}

echo "<table align='center' cellpadding='10' >";	
echo "<tr>";
echo "<th><img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_259.png' alt='red trash can' title='red flag'></img></th>";

echo "<th><a href='menu1314.php?flagM=1'><font $shade_fm1>Add</font></a></th>";
echo "<th><a href='menu1314.php?flagM=2'><font $shade_fm2>View</font></a></th>";
//echo "<th><a href='fixed_assets3.php?menu_fa=fa3'><font $shade_fa3>fa3</font></a></th>";
//echo "<th><a href='fixed_assets4.php?menu_fa=fa4'><font $shade_fa4>fa4</font></a></th>";
//echo "<th><a href='fixed_assets5.php?menu_fa=fa5'><font $shade_fa5>fa5</font></a></th>";
//echo "<th><a href='fixed_assets6.php?menu_fa=fa6'><font $shade_fa6>fa6</font></a></th>";
//echo "<th><a href='fixed_assets_doc_lookup.php' target='_blank'><font $shade_fa7>fa7</font></a></th>";
echo "</tr>";
echo "</table>";	




if($flagM==1)
{	
echo "<form>";
echo "<table align='center'>";
echo "<tr>";
echo "<th>";
echo "<select name='pintype'>
  <option value='bank_deposit'>bank_deposit</option>
  <option value='pcard'>pcard</option>
  </select>";

echo "</th>";
echo "</tr>";


echo "</table>";
echo "</form>";	
}




}
?>