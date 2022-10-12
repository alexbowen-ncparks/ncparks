<?php




$query_fy_header="SELECT cy,py1,py2,py3,py4,py5,py6,py7,py8,py9,py10,py11,py12 from fiscal_year where active_year_concession_fees='y' ";

//echo "<br />Line 8: query_fy_header=$query_fy_header<br />";

$result_fy_header = mysqli_query($connection, $query_fy_header) or die ("Couldn't execute query_fy_header.  $query_fy_header");

$row_fy_header=mysqli_fetch_array($result_fy_header);
extract($row_fy_header);

if($f_year==''){$f_year=$cy;}

// origin of class=CartRow below
//Menu Bar : /budget/menu1415_v1.php Includes File named:  /budget/menu1415_v1_style.php
//.... /budget/menu1415_v1_style.php has CSS that defines: class=cartRow. produces Yellow shading for Fiscal Year selected by User


if($f_year==$cy){$shade_cy="class=cartRow";}
if($f_year==$py1){$shade_py1="class=cartRow";}
if($f_year==$py2){$shade_py2="class=cartRow";}
if($f_year==$py3){$shade_py3="class=cartRow";}
if($f_year==$py4){$shade_py4="class=cartRow";}
if($f_year==$py5){$shade_py5="class=cartRow";}
if($f_year==$py6){$shade_py6="class=cartRow";}
if($f_year==$py7){$shade_py7="class=cartRow";}
if($f_year==$py8){$shade_py8="class=cartRow";}
if($f_year==$py9){$shade_py9="class=cartRow";}
if($f_year==$py10){$shade_py10="class=cartRow";}
if($f_year==$py11){$shade_py11="class=cartRow";}
if($f_year==$py12){$shade_py12="class=cartRow";}




echo "<table border=2 cellspacing=2>";

echo "<tr>";



echo "<td><font size=4 color=brown >Fiscal Year</font></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$cy&ncas_center=$ncas_center'><font  $shade_cy>$cy</font></a></td>";
echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py1&ncas_center=$ncas_center'><font  $shade_py1>$py1</font></a></td>";
echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py2&ncas_center=$ncas_center'><font  $shade_py2>$py2</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py3&ncas_center=$ncas_center'><font  $shade_py3>$py3</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py4&ncas_center=$ncas_center'><font  $shade_py4>$py4</font></a></td>";



echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py5&ncas_center=$ncas_center'><font  $shade_py5>$py5</font></a></td>";


echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py6&ncas_center=$ncas_center'><font  $shade_py6>$py6</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py7&ncas_center=$ncas_center'><font  $shade_py7>$py7</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py8&ncas_center=$ncas_center'><font  $shade_py8>$py8</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py9&ncas_center=$ncas_center'><font  $shade_py9>$py9</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py10&ncas_center=$ncas_center'><font  $shade_py10>$py10</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py11&ncas_center=$ncas_center'><font  $shade_py11>$py11</font></a></td>";

echo "<td><a href='vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$py12&ncas_center=$ncas_center'><font  $shade_py12>$py12</font></a></td>";







echo "</tr>";

echo "</table>";



?>





