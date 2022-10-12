<?php


if($report=="center"){$shade_report_center="class=cartRow";}
if($report=="project"){$shade_report_project="class=cartRow";}
if($report=="spo"){$shade_report_spo="class=cartRow";}

//if($report=="acct"){$shade_acct="class=cartRow";}

echo "<table border=2 cellspacing=2>";
echo "<tr>";



echo "<td><font size=4 color=brown >Financial Reports</font></td>";
echo "<td><a href='/budget/projects/project_reports_matrix2.php?report=center'><font  $shade_report_center>Center</font></a></td>";
echo "<td><a href='/budget/projects/project_reports_matrix2.php?report=project'><font  $shade_report_project>Project</font></a></td>";
echo "<td><a href='/budget/projects/project_reports_matrix2.php?report=spo'><font  $shade_report_spo>SPO</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=budg&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_budg>Budget Group</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=acct&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_acct>Account</font></a></td>";

echo "</tr>";
echo "</table>";

?>


