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


$query1e="SELECT crs_tdrr_division_deposits.park, crs_tdrr_division_deposits.center, crs_tdrr_division_deposits.f_year, crs_tdrr_division_deposits.orms_deposit_id AS  'crs_deposit_id', crs_tdrr_division_deposits.orms_deposit_date AS  'crs_deposit_date', crs_tdrr_division_deposits.controllers_deposit_id AS  'bank_deposit_number', crs_tdrr_division_deposits.bank_deposit_date, COUNT( crs_tdrr_division_history_parks.id ) AS  'manual_count', SUM( crs_tdrr_division_history_parks.amount ) AS  'manual_amount'
FROM crs_tdrr_division_history_parks
LEFT JOIN crs_tdrr_division_deposits ON crs_tdrr_division_history_parks.deposit_id = crs_tdrr_division_deposits.orms_deposit_id
WHERE crs_tdrr_division_history_parks.source =  'manual'
AND crs_tdrr_division_deposits.f_year >=  '1516'
GROUP BY crs_tdrr_division_history_parks.deposit_id
ORDER BY crs_tdrr_division_deposits.f_year, crs_tdrr_division_deposits.park, bank_deposit_number";

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query1e.  $query1e");

$num1e=mysqli_num_rows($result1e);
echo "<html><body>";
echo "<table><tr><td>Records: $num1e</td></tr></table>";
echo "<table border='1'>";

echo "<tr>
<td><font color='brown'>park</font></td>
<td><font color='brown'>center</font></td>
<td><font color='brown'>f_year</font></td>
<td><font color='brown'>crs_deposit_id</font></td>
<td><font color='brown'>crs_deposit_date</font></td>
<td><font color='brown'>bank_deposit_number</font></td>
<td><font color='brown'>bank_deposit_date</font></td>
<td><font color='brown'>manual_count</font></td>
<td><font color='brown'>manual_amount</font></td>


</tr>";

echo  "<form method='post' autocomplete='off' action='crs_deposits_manual_adj_update.php'>";
while ($row1e=mysqli_fetch_array($result1e)){

extract($row1e);

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
echo "<td><input type='text' size='8' name='park[]' value='$park' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='center[]' value='$center' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='f_year[]' value='$f_year' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='crs_deposit_id[]' value='$crs_deposit_id' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='crs_deposit_date[]' value='$crs_deposit_date' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='bank_deposit_number[]' value='$bank_deposit_number' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='bank_deposit_date[]' value='$bank_deposit_date' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='manual_count[]' value='$manual_count' readonly='readonly'</td>"; 
echo "<td><input type='text' size='8' name='manual_amount[]' value='$manual_amount' readonly='readonly'</td>"; 
 
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='num1e' value='$num1e'>";
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




















