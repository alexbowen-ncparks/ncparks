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

$skip_fld=array("id","entered_by");
$sql="SHOW columns FROM pr63";  
$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
 while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'], $skip_fld)){continue;}
	$ARRAY_flds[]=$row['Field'];
	}
// echo "<pre>"; print_r($ARRAY_flds); echo "</pre>";  exit;
				
$skip_post=array("submit","submit_form","exclude_void");

foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld, $skip_post)){continue;}
		if(!empty($val))
			{
			if($fld=="le_approve" and $val=="y"){$val="x";}
			$temp[]="$fld='$val'";
			}
		}
	$clause=implode(" and ",$temp)." and `le_approve`!=''";
if(!empty($_POST['exclude_void'])){$clause.=" and disposition!='09'";}

$flds=implode(",",$ARRAY_flds);
$sql="SELECT $flds FROM pr63 where $clause  order by ci_num desc";  
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