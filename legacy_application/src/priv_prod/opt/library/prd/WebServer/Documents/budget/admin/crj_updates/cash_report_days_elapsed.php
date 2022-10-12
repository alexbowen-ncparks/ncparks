<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
$today=date("Ymd", time() );
$yesterday=date("Ymd", time() - 60 * 60 * 24);
$dayb4yesterday=date("Ymd", time() - 60 * 60 * 24*2);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters




$query1="truncate table cash_report_days_elapsed1;";
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="insert into cash_report_days_elapsed1
(park,center,deposit_id,deposit_date,manager_date,manager)
select park,center,orms_deposit_id,orms_deposit_date,manager_date,manager
from crs_tdrr_division_deposits
where download_date >= '20140702' and trans_table='y'
and f_year='1718' ; ";
			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");



$query1c="update cash_report_days_elapsed1
          set today_date='$today'
		  where 1";
			 
mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");


$query1c1="update cash_report_days_elapsed1
          set manager_date2=manager_date
		  where manager_date != '0000-00-00' ";
			 
mysqli_query($connection, $query1c1) or die ("Couldn't execute query 1c1.  $query1c1");

$query1c2="update cash_report_days_elapsed1
          set manager_date2=today_date
		  where manager_date = '0000-00-00' ";
			 
mysqli_query($connection, $query1c2) or die ("Couldn't execute query 1c2.  $query1c2");


/*
$query1d="update cash_report_days_elapsed1
          set days_elapsed=datediff(manager_date2,deposit_date)
		  where 1 ";
			 
mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
*/

$query1e="select id,deposit_date,manager_date2 from cash_report_days_elapsed1";

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query1e.  $query1e");

$num1e=mysqli_num_rows($result1e);
echo "<html><body>";
echo "<table><tr><td>Records: $num1e</td></tr></table>";
echo "<table border='1'>";

echo "<tr>
<td><font color='brown'>deposit_date</font></td>
<td><font color='brown'>manager_date2</font></td>
<td><font color='brown'>id</font></td>


</tr>";

echo  "<form method='post' autocomplete='off' action='cash_report_days_elapsed_update_1718.php'>";
while ($row1e=mysqli_fetch_array($result1e)){

extract($row1e);

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 echo "<td><input type='text' size='8' name='deposit_date[]' value='$deposit_date' readonly='readonly'</td>"; 
 echo "<td><input type='text' size='8' name='manager_date2[]' value='$manager_date2' readonly='readonly'</td>";
echo "<td><input type='text' size='1' name='id[]' value='$id' readonly='readonly'</td>";
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='num1e' value='$num1e'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo   "</form>";
 echo "</table>";
 echo "</body>";
echo "</html>";
 



 

/*
$query1b="select manager_date,deposit_date
          from cash_report_days_elapsed1
		  where id='1' ";
			 
 
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$row1b=mysqli_fetch_array($result1b);
extract($row1b);


$query2="SELECT count( hid )-1 as 'days_elapsed'
FROM `mission_headlines`
WHERE 1
AND date >= '$deposit_date'
AND date <= '$manager_date'
AND weekend = 'n'";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query2a="update cash_report_days_elapsed1
          set days_elapsed='$days_elapsed'
		  where id='1' ";
			 
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

*/
//echo "update successful";

	  
  

 ?>