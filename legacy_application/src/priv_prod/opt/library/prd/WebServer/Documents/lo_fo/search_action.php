<?php
if(empty($connection))
	{
	$db="lo_fo";
	include("../../include/iConnect.inc");
	}
mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit_form","rep");
$equal_array=array("park_code","disposition","category","sub_cat");
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if(in_array($fld,$equal_array))
		{$temp[]=$fld."='".$value."'";}
		else
		{$temp[]=$fld." like '%".$value."%'";}
	
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}
if(!empty($disposition) and $disposition=="blank")
	{
	$clause="1 and disposition=''";
	}
$sql="SELECT t1.*, t2.link 
from items as t1
left join file_upload as t2 on t1.id=t2.track_id
 WHERE $clause
 order by date_found desc"; 
//  ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(mysqli_num_rows($result)>0)
	{
	if(!empty($rep))
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		$header_array[]=array_keys($ARRAY[0]);
		$file_name="DPR_lost_found_".date("Y-m-d").".csv";
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
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
	$skip=array();
	$c=count($ARRAY);
	echo "<table border='1'><tr><td colspan='2'>$c reports </td><td colspan='13'><form method='POST' action='search_action.php'>
	<input type='hidden' name='rep' value=\"1\">";	
	if(!empty($clause))
		{
		foreach($_POST AS $fld=>$value)
			{
			echo "<input type='hidden' name='$fld' value=\"$value\">";
			}
		}
	echo "<input type='submit' name='submit_form' value=\"Export\">
	</form></td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		$id=$array['id'];
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="link" and !empty($value))
				{$value="<a href='$value' target='_blank'>photo</a>";}
			if($fld=="id")
				{$value="<a href='edit_form.php?id=$id'>Edit</a>&nbsp;item&nbsp;$id";}
			if($fld=="comments" and strlen($value)>100)
				{$value=substr($value,0,100)."...";}
				
				
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
}
else
{
$c=0;
echo "No item was found using $clause";
}
	
?>