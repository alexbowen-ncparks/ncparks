<?php

// include("../../include/get_parkcodes_dist.php");

$database="dpr_land";
include("../../include/auth.inc"); // used to authenticate users
include("../../../include/iConnect.inc"); 
mysqli_select_db($connection,'dpr_land'); // database

$level=$_SESSION['dpr_land']['level'];

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  land_assets";
 $result = @mysqli_QUERY($connection,$sql)or die ("Couldn't execute query 15. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
}
// echo "$sql<pre>"; print_r($allFields); echo "</pre>"; exit;

if(!empty($park_classification_id)){$where="and park_classification_id='$park_classification_id'";}
if(!empty($park_id)){$where="and park_id='$park_id'";}

$sql = "SELECT DISTINCT t1.park_id, t2.park_name, t1.park_classification_id, t3.classification, t2.park_abbreviation
From land_assets as t1
left join park_name as t2 on t1.park_id=t2.park_id
left join park_classification as t3 on t1.park_id=t3.park_classification_id
where t1.acreage > 0 
order by t2.park_name
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 27. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_class[$row['park_abbreviation']][$row['park_classification_id']]=$row['classification'];
	}
echo "<pre>"; print_r($ARRAY_class); echo "</pre>";  exit;

$sql = "SELECT  concat_ws(' ',class_type,class) as UNIT_TYPE, count(class) as UNITS,  sum(acres_fee) as 'SIZE_(acres_fee)', sum(easement) as 'SIZE_(easement)', sum(acres_fee)+sum(easement) as 'SIZE_(total_acres)', sum(acres_water) as 'SIZE_(water_acres)', sum(length_miles) as 'LENGTH_(miles)'
From dpr_acres
LEFT JOIN dpr_acres_class_sort as t2 on dpr_acres.class=t2.unit_class
group by class,class_type
order by sort_order  ,parkcode";
// order by 'SIZE_(acres_fee)' desc ,parkcode";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_values(array_keys($ARRAY[0]));

if(!empty($rep))
	{
// 	$ARRAY=$export_array;
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=dpr_acreage_export.csv");
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
		
	}
$num=count($ARRAY);

echo "<html><table border='1' cellpadding='2'>";

echo "<tr><td colspan='5' align='center'><a href='land_acres.php' target='_blank'><font color='green'>Detailed Report</font></a></td>
<td align='center'><a href='land_acres_report.php?rep=1'><font color='brown'>.cvs Export </font></a></td>
<td align='center'><a href='https://auth.dpr.ncparks.gov/system_plan/' target='_blank'><font color='brown'>SYS_PLAN </font></a></td>
</tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){
	$v=str_replace("_"," ",$v);
	echo "<th>$v</th>";}
echo "</tr>";

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$j=0;
// $total=array();
// $unit_type_num=array();
$grand=0;
foreach($ARRAY as $index=>$array)
	{
	$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}


	echo "<tr>";
		foreach($array as $key=>$value)
			{
			@$total[$key]+=$value;
			if($key!="UNITS" AND $key!="UNIT_TYPE")
				{$value=number_format($value,2);}
			if($value==="0.00"){$value="&nbsp;";}
	
			if($key=="UNIT_TYPE")
				{
				$parse=explode(" ",$value);
				$v2=$parse[1]." ".$parse[2];
				if(!empty($parse[3])){$v2.=" ".$parse[3];}
				$value="<a href='land_acres.php?class=$v2'>$value</a>";
				@$unit_type_num[$key]['num']+=$array['UNITS'];
				@$unit_type_fee[$key]['fee']+=$array['SIZE_(acres_fee)'];
				@$unit_type_easement[$key]['easement']+=$array['SIZE_(easement)'];
				@$unit_type_acres[$key]['total_acres']+=$array['SIZE_(total_acres)'];
				@$unit_type_water[$key]['water_acres']+=$array['SIZE_(water_acres)'];
				@$unit_type_miles[$key]['miles']+=$array['LENGTH_(miles)'];
				
				if(strpos($ARRAY[$index]['UNIT_TYPE'],"STATE TRAIL")>-1)
					{
					@$unit_type_num_sl['STATE TRAIL']=$array['UNITS'];
					}
				if(strpos($ARRAY[$index]['UNIT_TYPE'],"STATE RIVER")>-1)
					{
					@$unit_type_num_sl['STATE RIVER'][]=1;
					}
				}

			echo "<td align='right'>$value</td>";
			}
	echo "</tr>";
	if($array['UNIT_TYPE']==" STATE LAKE") // initial space is necessary
		{
		$val1=$unit_type_num['UNIT_TYPE']['num'];
		$val2=number_format($unit_type_fee['UNIT_TYPE']['fee'],0);
		$val3=number_format($unit_type_easement['UNIT_TYPE']['easement'],0);
		$val4=number_format($unit_type_acres['UNIT_TYPE']['total_acres'],0);
		$val5=number_format($unit_type_water['UNIT_TYPE']['water_acres'],0);
		echo "<tr><td align='right'>subtotal</td>
		<th>$val1</th><th>$val2</th><th>$val3</th><th>$val4</th><th>$val5</th>
		</tr>"; // exit;
		}
	if($array['UNIT_TYPE']=="RECREATIONAL STATE RIVER") // initial space is NOT necessary
		{
// 	echo "<pre>"; print_r($unit_type_num_sl); echo "</pre>"; // exit;
		$v1=$unit_type_num_sl['STATE TRAIL'];
		$v2=array_sum($unit_type_num_sl['STATE RIVER']);
		$val1="$v1 ST + $v2 SR = ".($v1+$v2);
		$val2="2,171.00";
		$val3="87.00";
		$val4="2,258.00";
		$val5="";
		$val6=number_format($unit_type_miles['UNIT_TYPE']['miles'],2);
		echo "<tr><td align='right'>subtotal</td>
		<th>$val1</th><th>$val2</th><th>$val3</th><th>$val4</th><th>$val5</th><th>$val6</th>
		</tr>"; // exit;
		}
	}

//echo "<pre>"; print_r($fieldNames); echo "</pre>"; // exit;
// Totals
$skip_fld=array("SIZE_(acres_fee)","LENGTH_(miles)","SIZE_(easement)");
echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	$f="";
	if($k==2){$f=$num." units";}
		if($v=="UNITS")
			{
			if($total[$v])
				{
				$f=round(number_format($total[$v],0));
				$var_f=$f-2;
				$f.=" Unit Classes<br />";
				$f.="$var_f Park Units<br />(combining LURI classes)";
				}
			}
		else
			{
			if($total[$v]){$f=number_format($total[$v],0);}
			if(!in_array($v, $skip_fld))
				{
				$grand+=$total[$v];
				}
			}
 
	echo "<th>$f</th>";
	}
	
$grand=number_format($grand,0);
echo "</tr>
<tr><td colspan='7'>&nbsp;</td></tr>
<tr><th align='right' colspan='7'>Grand Total Land (SP, SNA, SRA, ST) and Water (State Lakes): $grand acres</th></tr>";

echo "</table></body></html>";
?>