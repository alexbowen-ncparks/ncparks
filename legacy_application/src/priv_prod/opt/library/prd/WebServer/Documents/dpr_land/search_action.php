<?php

mysqli_select_db($connection,$dbName);
//  echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit_form");
$equal_array=array("park_id","county_id","land_assets_id","project_status_id", "park_classification_id", "critical");

$select_table="land_assets";
if(!empty($last_name))
	{
	$select_table="land_owner";
	}
if(!empty($business_name))
	{
	$select_table="business_name";
	}
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if(in_array($fld,$equal_array))
		{$temp[]="t1.".$fld."='".$value."'";}
		else
		{$temp[]="t1.".$fld." like '%".$value."%'";}
	//	{$temp[]="t1.".$fld."='".$value."'";}
	
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}

// , t2.link 
// left join file_upload as t2 on t1.id=t2.track_id

if($select_table=="land_assets")
	{
	$sql="SELECT t1.*
	FROM `edit_data_display`  as t1
	WHERE 1 and select_table='land_assets' and show_field!='Yes'"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$land_assets_skip_fields[]=$row['field_name'];
		}
//  	echo "<pre>"; print_r($land_assets_skip_fields); echo "</pre>"; // exit;
	}
$t2_fields="";
$t2_join="";
$t3_fields="";
$t3_join="";
$t4_fields="";
$t4_join="";
$t5_fields="";
$t5_join="";
$t6_fields="";
$t6_join="";
$t7_join="";
$t7_fields="";
if($select_table=="land_assets")
	{
	$t2_fields="t2.county_name, ";
	$t2_join="left join county_name as t2 on t1.county_id=t2.county_id";
	$t3_fields="concat(t3.park_abbreviation,'-',t1.county_id,'-',t1.land_assets_id) as 'File Number', ";
	$t3_join="left join park_name as t3 on t1.park_id=t3.park_id";
	$t4_fields="concat(t4.land_interest_type, ' - ', t4.spo_letter) as 'land_interest_type', ";
	$t4_join="left join`land_interest_type` as t4 on t1.land_interest_id=t4.land_interest_type_id";
	$t5_fields="t5.description as 'priority', ";
	$t5_join="left join priority as t5 on t1.priority_id=t5.priority_id";
	$t6_fields="t6.project_status, ";
	$t6_join="left join project_status as t6 on t1.project_status_id=t6.project_status_id";
	$t7_fields="t7.classification, ";
	$t7_join="left join park_classification as t7 on t1.park_classification_id=t7.park_classification_id";
	}
$sql="SELECT $t2_fields $t3_fields $t4_fields $t5_fields $t6_fields $t7_fields t1.* 
from $select_table as t1
$t2_join
$t3_join
$t4_join
$t5_join
$t6_join
$t7_join
WHERE $clause"; 
if($level>4)
	{
//   	ECHO "level 4 $sql"; exit;
	}
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//  echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip_view=array();
if(mysqli_num_rows($result)>0)
	{
	$skip=array();
	if($select_table=="land_assets")
		{
		$skip=$land_assets_skip_fields;
		}
	if($select_table=="land_owner")
		{
		include("assets_land_owner.php");
		$skip_view=array("land_owner_id");
		}
	if($select_table=="business_name")
		{
		include("assets_business_name.php");
		$skip_view=array("business_name_id");
		}
	$c=count($ARRAY);
	echo "<table border='1' class='alternate' cellpadding='3'><tr><td colspan='20'>$c records for $clause</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
		//	echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if(substr($fld,-3,3)=="_id" and empty($table_id))
					{$table_id=$fld;}
				$var[]="<th>$fld</th>";
			//	echo "<th>$fld</th>";
				}
			$header_array_0=implode($var);
		//	echo "</tr>";
			}
	if(fmod($index,10)==0)
		{echo "<tr>$header_array_0</tr>";}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="acreage")
				{
				$acreage_array[$array['project_status']][]=$value;
				if($array['project_status']=="Closed")
					{
					$acreage_array_classification[$array['classification']][]=$value;
					}
				}
			if($fld=="link" and !empty($value))
				{$value="<a href='$value' target='_blank'>photo</a>";}
			if($fld==$table_id and !in_array($fld,$skip_view))
				{
				$var_value="<strong><a href='view_form.php?select_table=$select_table&$table_id=$value'>View</a> $value</strong>";
				if($level>4)
					{
					$value_edit="<form action='edit_form.php' method='post' target='_blank'>
					<input type='hidden' name='select_table' value='land_assets'>
					<input type='hidden' name='table_id' value='$value'>
					<input type='submit' name='submit_admin' value='Edit $value'>
					</form>";}
					else
					{$value_edit="";}
				$value=$var_value."<br /><br />".$value_edit;
				}
			if($fld=="comments" and strlen($value)>100)
				{$value=substr($value,0,100)."...";}
				
				
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	
	if(!empty($acreage_array))
		{
		foreach($acreage_array as $acreage_status=>$status_acres_array)
			{
			$acres_by_status[$acreage_status]=array_sum($status_acres_array);
			}
		echo "<tr>
		<td colspan='3'>
			<table>
			<tr><th>Acreage by Status</th></tr>";
			foreach($acres_by_status as $status=>$acres)
				{
				echo "<tr><td>$status</td><td>$acres</td></tr>";
				}
			echo "</table>
		</td>
		<td colspan='4' valign='top'>
			<table>
			<tr><th colspan='3'>Acreage by Classification for Closed Tracts</th></tr>";
			if(!empty($acreage_array_classification))
				{
				foreach($acreage_array_classification as $classification=>$array)
					{
					$sub_tot=array_sum($array);
					echo "<tr><td>$classification</td><td>$sub_tot</td></tr>";
					}
				}
			echo "</table>
		</td>
		</tr>";
		}
	echo "</table>";
// 		echo "<pre>"; print_r($acres_by_status); echo "</pre>"; // exit;
// 		echo "<pre>"; print_r($acreage_array_classification); echo "</pre>"; // exit;
}
else
{
$c=0;
echo "<br /><font color='magenta'>No item was found using $clause</font>";
exit;
}

if(!empty($ARRAY_sub))
	{
	$skip=array();
	$c=count($ARRAY_sub);
	$c1=count($header_array);
	echo "<table class='alternate' border='1' cellpadding='4'><tr><td class='head' colspan='$c1'>$table_title</td></tr>";
	foreach($ARRAY_sub AS $index_1=>$array_1)
		{
		$value_title_1=""; $value_title_2="";
		@$value_title_1=$pass_value_1[$index_1];
		@$value_title_2=$pass_value_2[$index_1];
		//$index_1 
		echo "<tr><td class='head' colspan='$c1'>$value_title_1 $value_title_2</td></tr>";
		
	echo "<tr>";
	foreach($header_array as $header=>$blank)
		{
		echo "<th>$header</th>";
		}
	echo "</tr>";
		foreach($array_1 AS $index_2=>$array_2)
			{
			echo "<tr>";
			foreach($array_2 as $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if($fld==$key_field and !empty($value))
						{$value="<a href='view_form.php?select_table=$select_table&$key_field=$value'>View</a> $value";}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		}
echo "</table>";
	}
	
?>


