<?php
$skip_find=array("submit_form");
if(!empty($export_csv))
	{	
	$_POST=$export_csv;
	}
foreach($_POST as $fld=>$value)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	if(in_array($fld, $skip_find)){continue;}
	if(!empty($value))
		{
		if($value=="_blank")
			{
			$pass_post[$fld]="_blank";
			$temp[]="$fld = ''";
			}
			else
			{
			$pass_post[$fld]=$value;
			if($fld=="submitted_by")
				{
				$temp[]="t2.Lname like '%$value%'";
				}
				else
				{
				$temp[]="$fld like '%$value%'";
				}
			}
		}
	}
if(empty($temp))
	{
	$clause="1";
	$pass_post['id']="";
	}
	else
	{
	$clause=implode(" and ", $temp);
	}
$sql="SELECT t1.*, concat(t1.submitted_by, ' ', t2.Fname, ' ', t2.Lname) as submitted_by from project as t1
left join divper.empinfo as t2 on t1.submitted_by=t2.emid
where $clause order by proj_number";  
if(empty($export_csv))
	{
// 	echo "$sql";
	if($clause==1){$clause="All";}
	echo "Searched for $clause";
	}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	echo "<br /><br />No project was found using $clause<br /><br />";
	echo "<a href='find_export.php'>Return to search form.</a>";
	exit;
	}
	
if(!empty($export_csv))
	{
// 	$ARRAY=$export_array;
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=project_export.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
// 		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
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
	}
$skip=array();
$c=count($ARRAY);
// echo "79<pre>"; print_r($pass_post); echo "</pre>"; // exit;
echo "<table><tr><td colspan='2'>$c projects</td><td><a href='find_export.php'>New Query</a></td><td><form method='post' action='find_export.php' onClick=\"this.form.submit()\">";
foreach($pass_post as $p_k=>$p_v)
	{
	echo "<input type='hidden' name='export_csv[$p_k]' value=\"$p_v\">";
	}
echo "<INPUT TYPE='submit' name='submit_form' value=\"Export Query\"></form>
</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
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
		if(strlen($value)>50){$value=substr($value, 0, 51)."...";}
		if($fld=="id" and empty($query))
			{
			$value="<form method='POST' action='project.php' target='_blank' onclick=\"this.form.submit()\">
			<input type='hidden' name='id' value='$value'>
			<input type='submit' name='submit' value='Show'>
			</form>";
			}

		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>