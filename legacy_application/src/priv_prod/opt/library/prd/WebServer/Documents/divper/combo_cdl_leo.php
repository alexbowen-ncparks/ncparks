<?php
ini_set('display_errors',1);
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

//substring_index(t4.county,',',1)
$sql = "SELECT 'DNCR' as COMPANY, 'Parks and Rec' AS DIVISION, t1.beacon_num as BEACON_POSITION, t3.beaconID AS 'BEACON ID#', concat(t3.Lname, ', ', t3.Fname, ' ', t3.Mname) as NAME, '20' as 'EMPLOYEEJOBCLASS', 'LEO' as 'EMPLOYEETYPE', t4.county as 'Work County', t2.currPark 
FROM divper.`position` as t1 
left join divper.emplist as t2 on t2.beacon_num=t1.beacon_num 
left join divper.empinfo as t3 on t2.emid=t3.emid 
left join dpr_system.dprunit as t4 on t2.currPark=t4.parkcode 
where t1.beacon_title like 'Law%' AND t3.Lname!=''

UNION 

SELECT 'DNCR' as COMPANY, 'Parks and Rec' AS DIVISION, t1.beacon_num as BEACON_POSITION, t3.beaconID AS 'BEACON ID#', concat(t3.Lname, ', ', t3.Fname, ' ', t3.Mname) as NAME, '10' as 'EMPLOYEEJOBCLASS', 'CDL' as 'EMPLOYEETYPE', t4.county as 'Work County', t2.currPark 
FROM divper.`position` as t1 
left join divper.emplist as t2 on t2.beacon_num=t1.beacon_num 
left join divper.empinfo as t3 on t2.emid=t3.emid 
left join dpr_system.dprunit as t4 on t2.currPark=t4.parkcode 
where t1.cdl='y' and t3.cdl_exp_date!='0000-00-00' 
order by EMPLOYEETYPE, NAME";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$c=count($ARRAY);
$skip=array("currPark");
$i=0;
if(empty($rep))
	{
	echo "<table border='1' cellpadding='3'>";
	echo "<tr><td colspan='2'><a href='combo_cdl_leo.php?rep=1'>Excel export</a></td>
	<td colspan='2'>Combination CDL and LEO</td>
	</tr>";}
if(@$rep=="1")
	{
	$header_array[]=array_keys($ARRAY[0]);

	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=combo_cdl_leo.csv");
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
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr><td></td>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
		$i++;
	echo "<tr><td>$i</td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		IF($fld=="Work County" and $value=="")
			{
			if($array['currPark']=="EADI"){$value="Wayne";}
			if($array['currPark']=="WEDI"){$value="Iredell";}
			}
		IF($fld=="NAME" and $value=="")
			{$value="VACANT";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

if(empty($rep))
	{echo "</body></html>";}
?>