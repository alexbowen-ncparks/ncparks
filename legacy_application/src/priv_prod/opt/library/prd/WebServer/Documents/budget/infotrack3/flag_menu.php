<?php
if($menu_fa=='fa1'){$shade_fa1="class='cartRow'";}
if($menu_fa=='fa2'){$shade_fa2="class='cartRow'";}
if($menu_fa=='fa3'){$shade_fa3="class='cartRow'";}
if($menu_fa=='fa4'){$shade_fa4="class='cartRow'";}
if($menu_fa=='fa5'){$shade_fa5="class='cartRow'";}
if($menu_fa=='fa6'){$shade_fa6="class='cartRow'";}
echo "<table align='center' >";	
echo "<tr>";
echo "<th><img height='75' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_259.png' alt='red trash can' title='red flag'></img>' <br />Flags</th>";

echo "<th><a href='fixed_assets1.php?menu_fa=fa1'><font $shade_fa1>FAS<br />Form</font></a></th>";
echo "<th><a href='fixed_assets_doc_lookup.php?menu_fa=fa2'><font $shade_fa2>Invoice<br />Lookup</font></a></th>";
//echo "<th><a href='fixed_assets3.php?menu_fa=fa3'><font $shade_fa3>fa3</font></a></th>";
//echo "<th><a href='fixed_assets4.php?menu_fa=fa4'><font $shade_fa4>fa4</font></a></th>";
//echo "<th><a href='fixed_assets5.php?menu_fa=fa5'><font $shade_fa5>fa5</font></a></th>";
//echo "<th><a href='fixed_assets6.php?menu_fa=fa6'><font $shade_fa6>fa6</font></a></th>";
//echo "<th><a href='fixed_assets_doc_lookup.php' target='_blank'><font $shade_fa7>fa7</font></a></th>";
echo "</tr>";	
echo "</table>";
?>