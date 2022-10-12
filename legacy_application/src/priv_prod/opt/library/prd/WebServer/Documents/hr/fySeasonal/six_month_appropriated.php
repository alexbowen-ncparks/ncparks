<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['hr']['level'];

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
include("../../../include/get_parkcodes_reg.php");
date_default_timezone_set('America/New_York');

$database="hr";
mysqli_select_db($connection,$database);

$flds_2="t1.osbm_title, t1.budget_hrs_a, t1.budget_weeks_a, t1.center_code, t1.beacon_posnum,t4.funding_source,t3.tempID";
$where1="WHERE t1.budget_weeks_a>24 and t4.funding_source='appropriated'";

$sql = "SELECT $flds_2
	FROM seasonal_payroll_fiscal_year as t1
	LEFT JOIN employ_position as t2 on t1.beacon_posnum=t2.beacon_num
	LEFT JOIN employ_separate as t3 on t1.beacon_posnum=t3.beacon_num
	LEFT JOIN classification as t4 on t1.beacon_posnum=t4.beacon_num
	$where1
	ORDER  BY  t1.center_code, t3.tempID desc, t1.osbm_title, t1.comments desc, t1.beacon_posnum";
// echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$result_array=array();
	$testArray=array();
	while($row=mysqli_fetch_assoc($result)){
		if(in_array($row['beacon_posnum'],$testArray)){continue;}
		$result_array[]=$row;
		$testArray[]=$row['beacon_posnum'];
		}
		
	$c=count($result_array);
$ARRAY=$result_array;	
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=six_month_approp.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
			$output = fopen("php://output", "w");
// 			foreach ($comment_line as $row) {
// 				fputcsv($output, $row); // here you can change delimiter/enclosure
// 			}
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
		
// $skip=array();
// $c=count($ARRAY);
// echo "<table><tr><td>$c</td></tr>";
// foreach($ARRAY AS $index=>$array)
// 	{
// 	if($index==0)
// 		{
// 		echo "<tr>";
// 		foreach($ARRAY[0] AS $fld=>$value)
// 			{
// 			if(in_array($fld,$skip)){continue;}
// 			echo "<th>$fld</th>";
// 			}
// 		echo "</tr>";
// 		}
// 	echo "<tr>";
// 	foreach($array as $fld=>$value)
// 		{
// 		if(in_array($fld,$skip)){continue;}
// 		echo "<td>$value</td>";
// 		}
// 	echo "</tr>";
// 	}
// 	echo "</table>";
?>