<?php



if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}





echo "<table border=2 cellspacing=2>";

echo "<tr>";







echo "<td><font size=4 color=brown >Fiscal Year</font></td>";

echo "<td><a href='energy_main2.php?f_year=1213'><font  $shade_1213>1213</font></a></td>";
echo "<td><a href='energy_main.php?f_year=1112'><font  $shade_1112>1112</font></a></td>";

//echo "<td><a href='energy_main.php?f_year=1112'><font  $shade_1112>1112</font></a></td>";

if($level=5)
{
echo "<td><a href='/budget/admin/energy_updates/main.php?project_category=fms&project_name=energy_updates'>Admin Updates</a></td>";
}

echo "</tr>";

echo "</table>";



?>





