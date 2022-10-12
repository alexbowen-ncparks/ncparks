<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
//print_r($_SESSION);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;

extract($_REQUEST);

if(empty($rep))
	{include("menu.php");}

//substring_index(t4.county,',',1) as 'Work County'
$sql = "SELECT 'DNCR' as COMPANY, 'Parks and Rec' AS DIVISION,t1.beacon_num AS 'BEACON Pos#', t3.beaconID AS 'BEACON ID#', t1.park as 'At Park', t2.currPark, concat(t3.Lname, ', ', t3.Fname, ' ', t3.Mname) as NAME, t3.chaunum as 'CDL License', cdl_exp_date, '10' as 'EMPLOYEEJOBCLASS', 'DOT' as 'EMPLOYEETYPE', t4.county as 'Work County'
FROM divper.`position` as t1
left join divper.emplist as t2 on t2.beacon_num=t1.beacon_num
left join divper.empinfo as t3 on t2.emid=t3.emid
left join dpr_system.dprunit as t4 on t2.currPark=t4.parkcode
where t1.cdl='y'
order by currPark";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$c=count($ARRAY);
$i=0;
$today=date("Y-m-d");
if(@$rep=="1")
	{
	$header_array[]=array_keys($ARRAY[0]);
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=cdl_report.csv");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies
	function outputCSV($header_array, $data) {
		$output = fopen("php://output", "w");
		foreach ($header_array as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		foreach ($data as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		fclose($output);
	}

	outputCSV($header_array, $ARRAY);

	exit;
	}

?>