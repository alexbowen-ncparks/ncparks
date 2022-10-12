<?php
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
extract($_POST);
if(empty($rep))
	{
	include("menu.php");

	$sql="SELECT distinct park_code
	from burn_history
	where 1
	order by park_code";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_park_code[]=$row['park_code'];
		}
	}
			
if(!empty($_POST['submit']))
	{
	extract($_POST);
	$skip=array("submit","acres_greater","acres_less","comments","rep","clause");
	$month_array=array("jan"=>"01","feb"=>"02","mar"=>"03","apr"=>"04","may"=>"05","jun"=>"06","jul"=>"07","aug"=>"08","sep"=>"09","oct"=>"10","nov"=>"11","dec"=>"12");
	
	foreach($_POST AS $fld=>$value)
		{
		//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
		if(in_array($fld,$skip)){continue;}
		if($value==""){continue;}
		if($fld=="date_start_range")
			{
			$new_sort="date_";
			@$clause.="and t1.date_ >='$value'";
			continue;
			}
		if($fld=="date_end_range")
			{
			@$clause.=" and t1.date_ <='$value'";
			continue;
			}
			
			
		if($fld=="date_")
			{
			if($value>31){@$clause.=" and t1.".$fld." like '%".$value."%'";}
			if(is_numeric($value) and $value<31)
				{
				$value=str_pad($value,2,"0", STR_PAD_LEFT);
				@$clause.=" and t1.".$fld." like '%-".$value."'";
				}
			if(array_key_exists(strtolower($value),$month_array))
				{
				$value=strtolower($value);
				$value=$month_array[$value];
				@$clause.=" and t1.".$fld." like '%-".$value."-%'";
				}
			}
		else
		{@$clause.=" and t1.".$fld."='".$value."'";}
		
		}
	if(!empty($acres_greater))
		{
		if(!is_numeric($acres_greater)){exit;}
		@$clause.=" and acres_burned >=$acres_greater";
		}
	if(!empty($acres_less))
		{
		if(!is_numeric($acres_less)){exit;}
		@$clause.=" and acres_burned <=$acres_less";
		}
	if(!empty($comments))
		{
		@$clause.=" and t1.comments like '%$comments%'";
		}
	
	if(!isset($clause)){$clause="";}
	if(empty($connection))
		{
		$db="fire";
		include("../../include/iConnect.inc");
		mysqli_select_db($connection,$db);
		}
// 	echo "76<pre>"; print_r($_POST); echo "</pre>$clause";  exit;
	if(isset($_POST['clause']))
		{
		$clause=stripslashes($_POST['clause']);
		}
	
//	echo "83<pre>"; print_r($_POST); echo "</pre>$clause";  exit;

$order_by="t1.park_code, t1.unit_id";
if(!empty($new_sort)){$order_by="t1.date_, t1.park_code, t1.unit_id";}
	$sql="SELECT t2.unit_name, t1.* 
		from burn_history as t1
		LEFT JOIN units as t2 on t1.unit_id=t2.unit_id
		where 1 $clause
		order by $order_by";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
	}

if(empty($rep))
	{
	echo "<hr />
	<div align='center'>";

	echo "<form method='post' action='search.php'>";

	echo "<table>";

	echo "<tr><th colspan='2'>Burn History Search</th></tr>";

	if(!isset($date_)){$date_="";}
	if(!isset($date_start_range)){$date_start_range="";}
	if(!isset($date_end_range)){$date_end_range="";}
	if(!isset($burn_type)){$burn_type="";}
	echo "<tr><td>Date of Burn:</td><td><input type='text' name='date_' value='$date_'> partial dates, e.g., 2011 for year, Feb for month, or 7 for day</td></tr>";

	echo "<tr><td>Date Range of Burn:</td>
			<td>Start of Date Range:<input type='text' name='date_start_range' value='$date_start_range' id='datepicker1'>  End of Date Range:<input type='text' name='date_end_range' value='$date_end_range' id='datepicker2'></td></tr>";

	echo "<tr><td>Parks with a Burn:</td><td><select name='park_code'><option selected=''></option>\n";
	foreach($ARRAY_park_code as $k=>$v)
		{
		if(@$park_code==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option\n>";
		}
	echo "</select></td></tr>";

	$burn_type_array=array("prescribed"=>"Prescribed","wild"=>"Wild",""=>"Both");
	echo "<tr><td>Burn Type:</td><td>";
	
	foreach($burn_type_array as $k=>$v)
		{
		if($k==$burn_type){$ck="checked";}else{$ck="";}
		echo "<input type='radio' name='burn_type' value=\"$k\" $ck>$v";
		}
	echo "</td></tr>";

	if(!isset($acres_greater)){$acres_greater="";}
	echo "<tr><td>Acres Burned >=</td><td><input type='text' name='acres_greater' value='$acres_greater' size='6'></td></tr>";

	if(!isset($acres_less)){$acres_less="";}
	echo "<tr><td>Acres Burned <=</td><td><input type='text' name='acres_less' value='$acres_less' size='6'></td></tr>";

	if(!isset($comments)){$comments="";}
	echo "<tr><td>Comments:</td><td><input type='text' name='comments' value=\"$comments\"></td></tr>";

	echo "<tr><td colspan='2' align='center'>
	<input type='submit' name='submit' value='Search'></form></td>
	<td>
	<form action='search.php'><input type='submit' name='reset' value='Reset'></form>
	</td>";
	if(!empty($clause))
		{
		echo "<td>
		<form method='POST' action='search.php'>
		<input type='hidden' name='rep' value='x'>
		<input type='hidden' name='clause' value=\"$clause\">
		<input type='submit' name='submit' value='Excel Export'>
		</form>
		</td>";
		}
	echo "</tr>";
	echo "</table>";
	echo "</div>";

	IF(EMPTY($ARRAY)){ECHO "No record found.</html>"; exit;}
	// ************************
	}

$skip=array("unit_history_prescription","evaluation","unit_id");

//echo "<pre>"; print_r($ARRAY); echo "</pre>";

if(!empty($rep))
	{
	$header_array[]=array_keys($ARRAY[0]);

	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
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
	

echo "<table border='1' cellpadding='3'><tr>";
foreach($ARRAY[0] as $fld=>$val)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<th>$fld</th>";
	}
echo "</tr>";
	
foreach($ARRAY as $index=>$array)
	{
	extract($array);
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$td="";
		if(in_array($fld,$skip)){continue;}
		if($fld=="acres_burned"){@$total+=$value;}
		
		if($fld=="unit_name")
			{
			if(empty($value)){$value="not named";}
			if(empty($rep))
				{$value="<a href='units.php?park_code=$park_code&unit_id=$unit_id' target='_blank'>$value</a>";}
			
			}
		
		if($fld=="history_id")
			{
			if(empty($value)){$value="not named";}
			if(empty($rep))
				{$value="<a href='burn_history.php?park_code=$park_code&unit_id=$unit_id&history_id=$history_id' target='_blank'> burn summary</a>";}
			
			$td=" align='center'";
			}
		echo "<td$td>$value</td>";
		}
	echo "</tr>";
	}
	if(empty($rep))
		{echo "<tr><td colspan='5' align='right'>Total acres: $total</td></tr>";}

echo "</table>";

echo "</html>";
?>