<?php
//echo "$sql";
//$track_funds_array from line 44 of view_form.php

// $ARRAY_table_text   from view_form.php
$sql = "SHOW COLUMNS FROM $var_table";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$ARRAY_textarea=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}
	
foreach($ARRAY_sort_field_text as $index=>$array)  // line 105 view_form.php
	{
	foreach($array as $k=>$v)
		{
		if($k=="id"){continue;}
		if($k=="field_title"){$rename_field_array[$v]=$array['field_text'];}
		if($k=="field_category"){$rename_field_category_array[$array['field_title']]=$v;}
		
		}
	}
// echo "<pre>";  print_r($rename_field_category_array); echo "</pre>"; // exit;  print_r($rename_field_array);


$admin_array=array("temp");

foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr bgcolor='yellow'>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=$rename_field_array[$fld];
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	echo "<tr$tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(in_array($value,$track_funds_array))
			{
			$amt_by_fund[$value][$array['deliv_class_type']]+=$array['deliv_value'];
			}
		
		if($level < 4 and in_array($fld,$admin_array)){continue;}
		
		if($fld=="deliv_num"){$tr=" bgcolor='yellow'";}else{$tr="";}
		
		if($fld=="deliv_value"){$dv_tot+=$value;}
		
		if(substr($value,-3)===".00"){$value="$".number_format($value,2);}
		echo "<td>$value</td>";
		
		}
	echo "</tr>";
	}
$dv_tot=number_format($dv_tot,2);
echo "<tr><td colspan='8' align='right' bgcolor='yellow'><strong>$$dv_tot</strong></td></tr>";

foreach($ARRAY_sub as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{	
		if($fld=="sub_total")
			{
			$line="<td align='right'>";
			$value="$".number_format($value,2);
			if(empty($array['deliv_class_type']))
				{
				$line.="<strong>".$value."</strong></td>";
				}
				else
				{$line.=$value."</td>";}		
			}
			else
			{
			$line="<td colspan='2'>$value</td>";
			}
		echo "$line";
		}
		echo "</tr>";
	}

?>