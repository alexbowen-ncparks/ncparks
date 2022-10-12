<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; 
 header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=pr63_export.csv");
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
$database="le";		
include("../../include/get_parkcodes_dist.php");

$database="le";
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

// $skip_fld=array("id","entered_by");
// $sql="SHOW columns FROM pr63";  
// $result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
//  while($row=mysqli_fetch_assoc($result))
// 	{
// 	if(in_array($row['Field'], $skip_fld)){continue;}
// 	$ARRAY_flds[]=$row['Field'];
// 	}
// echo "<pre>"; print_r($ARRAY_flds); echo "</pre>";  exit;

$sql="SELECT distinct t1.incident_code, t1.incident_name
FROM pr63 as t1
left join ems_codes as t3 on t1.incident_code=t3.incident_code
where t3.fosc='x'
order by t1.incident_code";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$var_ic=$row['incident_code']."*".$row['incident_name'];
		@$incident_code_source.="\"".$var_ic."\",";
		$incident_code_array[$row['incident_code']]=$row['incident_name'];
		}
// echo "<pre>"; print_r ($incident_code_array); echo "</pre>";  exit;

$show=array("ci_num","parkcode", "incident_code");
$sql="SHOW COLUMNS FROM pr63";
 $result = @mysqli_QUERY($connection,$sql); 
while($row=mysqli_fetch_assoc($result))
		{
// 		if(!in_array($row['Field'],$show)){continue;}
		$allFields[]=$row['Field'];
		}

$flds=implode(",",$allFields);

$clause="1 AND (";
	$temp=array();
	foreach($incident_code_array as $k=>$v)
		{
		$temp[]="incident_code='$k'";
		}
	$clause=implode(" or ",$temp);
	
$sql="SELECT $flds FROM pr63 where ($clause) and date_occur like '$date_occur%'  order by ci_num desc";  
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
 while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
					
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

$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
outputCSV($header_array, $ARRAY);
exit;
?>	