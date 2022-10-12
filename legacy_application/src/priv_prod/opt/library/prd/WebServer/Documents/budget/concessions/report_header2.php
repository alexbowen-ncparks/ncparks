<?php


if($report=="cent"){$shade_cent="cartRow";}else{$shade_cent="";}
if($report=="budg"){$shade_budg="class=cartRow";}else{$shade_budg="";}
if($report=="acct"){$shade_acct="class=cartRow";}else{$shade_acct="";}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="select report_date
         from report_budget_history_dates
		 where 1";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

//$report_date2=

echo "<table border='2' cellspacing='2' align='center'>";
echo "<tr>";



echo "<td><font size='4' color='brown' >MoneyTracker</font><br />
          <font class='cartRow'> $report_date</font></td>";
echo "<td><a href='reports_all_centers_summary_by_division.php?report=cent&amp;section=$section&amp;district=$district&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  class='$shade_cent'>Center</font></a></td>";

echo "<td><a href='reports_all_centers_summary_by_division.php?report=budg&amp;section=$section&amp;district=$district&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_budg>Budget Group</font></a></td>";


echo "<td><a href='reports_all_centers_summary_by_division.php?report=acct&amp;section=$section&amp;district=$district&amp;accounts=$accounts&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_year_start2=$range_year_start2&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_year_end2=$range_year_end2&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'><font  $shade_acct>Account</font></a></td>";

//2022-08-11: CCOOPER Matrix work - Echo vars to table
/*echo"<td> COOPER  <br>
                 section=$section <br>
                 district=$district <br>
                 accounts=$accounts <br>
                 history=$history <br>
                 period=$period <br>
                 range_year_start=$range_year_start <br>
                 range_year_start2=$range_year_start2 <br>
                 range_month_start=$range_month_start <br>
                 range_day_start=$range_day_start <br>
                 range_year_end=$range_year_end <br>
                 range_year_end2=$range_year_end2  <br>
                 range_month_end=$range_month_end  <br>
                 range_day_end=$range_day_end </td>";
// 2022-08-11: End CCOOPER */

//echo "<td><a href='reports_all_centers_summary_by_division.php?report=acct&section=$section&accounts=$accounts&history=$history&period=$period'><font  $shade_acct>Account</font></a></td>";

echo "</tr>";
if($report=='cent')
{
echo "<tr><td><a href='center_list.php' target='_blank'>View Center Listing</td></tr>";
}
echo "</table>";


?>


