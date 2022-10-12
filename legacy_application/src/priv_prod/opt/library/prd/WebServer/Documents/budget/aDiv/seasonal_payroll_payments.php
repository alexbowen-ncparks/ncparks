<?php

session_start();

/*
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
extract($_REQUEST);
if($source!="hr")
	{
	include("../../../include/authBUDGET.inc");
	include("../../../include/activity.php");
	}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

if(!@$f_year){include("../~f_year.php");}

$sql = "SELECT payment_date, employee_name, employee_id, sum( amount ) AS 'amount'
FROM beacon_payments
WHERE 1 AND f_year = '$f_year' AND center = '$center'
and valid_entry='y'
GROUP BY id
ORDER BY payment_date DESC , employee_name ASC;
";
 $result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result)){
	$ARRAY[]=$row;
	@$total+=$row['amount'];
	}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	$total=number_format($total,2);
	echo "<table border='1' align='center'><tr><td colspan='4' align='center'>Seasonal Payroll for $parkcode [$center] for FY $f_year</td></tr>
	<tr><td colspan='4' align='center'>Includes both 531311 and 531312 (if any) positions</td></tr>
	<tr><td colspan='4' align='center'><font color='blue'>$$total</font> thru ".$ARRAY[0]['payment_date']."</td></tr><tr>";
	foreach($ARRAY[0] as $k=>$v){
		echo "<th>$k</th>";
		}
		echo "</tr>";
	foreach($ARRAY as $num=>$array){
		echo "<tr>";
			foreach($array as $field=>$value){
				echo "<td>$value</td>";
				}
		echo "</tr>";
		}
	echo "<table></html>";
?>



