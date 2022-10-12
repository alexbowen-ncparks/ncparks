<?php


//if($report=="cent"){$shade_cent="class=cartRow";}
//if($report=="budg"){$shade_budg="class=cartRow";}
//if($report=="acct"){$shade_acct="class=cartRow";}

include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
if($period != 'today')
{
$query1="select max(time2) as 'last_activity'
         from report_user_activity
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "last_activity=$last_activity";
$query1a="update report_user_activity_dates
          set report_date='$last_activity'
		  where 1 ";
		  
//echo $query1a;		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");


$query2="select report_date
         from report_user_activity_dates
		 where 1";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "report_date=$report_date";

echo "<table border=2 cellspacing=2 align='center'>";
echo "<tr>";



echo "<td><font size=4 color=brown >Last Activity</font></td>";
echo "<td><font  class='cartRow'>$report_date</font></a></td>";


echo "</tr>";
echo "</table>";
}



?>


