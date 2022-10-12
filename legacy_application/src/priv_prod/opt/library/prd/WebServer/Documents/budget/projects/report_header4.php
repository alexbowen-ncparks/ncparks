<?php


if($report=="center"){$shade_center="class=cartRow";}
if($report=="project"){$shade_project="class=cartRow";}
//if($report=="acct"){$shade_acct="class=cartRow";}

echo "<table border=2 cellspacing=2>";
echo "<tr>";



echo "<td><font size=4 color=brown >Financial Reports</font></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=cent&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_cent>Center</font></a></td>";
echo "<td><a href='project_reports_matrix.php?report=center&section=$section'><font  $shade_center>Center</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=budg&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_budg>Budget Group</font></a></td>";
echo "<td><a href='project_reports_matrix.php?report=project&section=$section'><font  $shade_project>Project</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=acct&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_acct>Account</font></a></td>";

echo "</tr>";
echo "</table>";

?>


