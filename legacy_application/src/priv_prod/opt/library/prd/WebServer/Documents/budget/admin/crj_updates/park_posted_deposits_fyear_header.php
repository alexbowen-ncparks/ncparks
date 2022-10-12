<?php

if($f_year=='1314'){$shade_1314="class=cartRow";}

if($f_year=='1213'){$shade_1213="class=cartRow";}

if($f_year=='1112'){$shade_1112="class=cartRow";}

if($f_year=='1011'){$shade_1011="class=cartRow";}











echo "<table border=2 cellspacing=2>";

echo "<tr>";




echo "<td><font size=4 color=brown >$park-$center</font></td>";


//echo "<td><font size=4 color=brown >Fiscal Year</font></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=1314&ncas_center=$ncas_center'><font  $shade_1314>1314</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=1213&ncas_center=$ncas_center'><font  $shade_1213>1213</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=1112&ncas_center=$ncas_center'><font  $shade_1112>1112</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=1011&ncas_center=$ncas_center'><font  $shade_1011>1011</font></a></td>";







echo "</tr>";

echo "</table>";



?>





