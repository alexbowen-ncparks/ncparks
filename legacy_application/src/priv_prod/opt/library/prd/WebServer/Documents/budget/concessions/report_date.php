<?php


//if($report=="cent"){$shade_cent="class=cartRow";}
//if($report=="budg"){$shade_budg="class=cartRow";}
//if($report=="acct"){$shade_acct="class=cartRow";}

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


echo "<table border=2 cellspacing=2>";
echo "<tr>";



echo "<td><font size=4 color=brown >Balance Date</font></td>";
echo "<td><font  class='cartRow'>$report_date</font></a></td>";


echo "</tr>";
echo "</table>";

?>


