<?php


if($note_group=="web"){$shade_web="class=cartRow";}
if($note_group=="document"){$shade_documents="class=cartRow";}
if($note_group=="note"){$shade_notes="class=cartRow";}
if($note_group=="message"){$shade_messages="class=cartRow";}
if($note_group=="photo"){$shade_photos="class=cartRow";}
//echo "<h2 align='center'>home</h2>";
echo "<table border=2 cellspacing=2>";
echo "<tr>";

//echo "<td><font size=5 color=brown >Folder</font></td>";
echo "<td><font size=5 color=brown><a href='projects_menu.php?folder=$folder'>Home</a></font></td>";
echo "<td><font size=5 color=brown class=cartRow><b>$project_category</b></font></td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "<table>";
echo "<tr>";
echo "<td><font size=5 color=brown class=cartRow><b>$project_name</b></font></td>";
echo "<td><a href='project1_menu.php?folder=$folder&note_group=web&project_category=$project_category&project_name=$project_name&category_selected=y&name_selected=y'><font  $shade_web>WebPages</font></a></td>";
echo "<td><a href='project1_menu.php?folder=$folder&note_group=document&project_category=$project_category&project_name=$project_name&category_selected=y&name_selected=y'><font  $shade_documents>Documents</font></a></td>";
echo "<td><a href='project1_menu.php?folder=$folder&note_group=note&project_category=$project_category&project_name=$project_name&category_selected=y&name_selected=y'><font  $shade_notes>Notes</font></a></td>";
//echo "<td><a href='project1_menu.php?folder=$folder&note_group=message&project_category=$project_category&project_name=$project_name&category_selected=y&name_selected=y'><font  $shade_messages>Messages</font></a></td>";
echo "<td><a href='project1_menu.php?folder=$folder&note_group=photo&project_category=$project_category&project_name=$project_name&category_selected=y&name_selected=y'><font  $shade_photos>Photos</font></a></td>";

//echo "<td><a href='reports_all_centers_summary_by_division.php?report=budg&section=$section&accounts=$accounts&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_budg>Budget Group</font></a></td>";
//echo "<td><a href='reports_all_centers_summary_by_division.php?report=acct&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_acct>Account</font></a></td>";

echo "</tr>";
echo "</table>";

?>
