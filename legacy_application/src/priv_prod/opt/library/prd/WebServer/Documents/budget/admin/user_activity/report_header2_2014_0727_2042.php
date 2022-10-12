<?php


if($report=="user"){$shade_user="class=cartRow";}
if($report=="browser"){$shade_browser="class=cartRow";}
//if($report=="location"){$shade_location="class=cartRow";}
if($report=="application"){$shade_application="class=cartRow";}
if(@$admin=="administrator"){$shade_administrator="class=cartRow";}

echo "<table border=2 cellspacing=2>";
echo "<tr>";

if(!isset($range_day_start)){$range_day_start="";}
if(!isset($range_year_end)){$range_year_end="";}
if(!isset($range_month_end)){$range_month_end="";}
if(!isset($range_day_end)){$range_day_end="";}
if(!isset($history)){$history="";}
if(!isset($shade_administrator)){$shade_administrator="";}


echo "<td><font size=4 color=brown >Usage Reports</font></td>";

echo "<td><a href='user_activity_matrix.php?report=user&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_user>User</font></a></td>";

echo "<td><a href='user_activity_matrix.php?report=browser&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_browser>Browser</font></a></td>";


/*
echo "<td><a href='user_activity_matrix.php?report=location&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_location>Location</font></a></td>";
*/
if(!isset($shade_application)){$shade_application="";}
echo "<td><a href='user_activity_matrix.php?report=application&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_application>Application</font></a></td>";

echo "<td><a href='user_activity_matrix.php?report=$report&admin=administrator&section=$section&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'><font  $shade_administrator>Administrator</font></a></td>";

echo "</tr>";
if(@$admin=='administrator')
{echo "<tr><td colspan='4'><td><a href='user_activity_matrix.php?report=$report&admin=update_tables&section=$section&user_level=$user_level&history=$history&period=$period'><font  $shade_acct>Update Tables</font></a></td></tr>";}


echo "</table>";

?>


