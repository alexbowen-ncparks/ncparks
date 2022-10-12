<?php
include("menu.php");

extract($_REQUEST);
if(empty($park_code) AND empty($unit_id)){exit;}

$table="units";
$file=$_SERVER['PHP_SELF'];

$sql="SELECT park_code as `check`
from park_plan where park_code='$park_code'";
$result = mysql_query($sql,$connection) or die ("Couldn't execute select query. $sql c=$connection");
if(mysql_num_rows($result)<1)
	{
//	echo " You must enter a <font color='red'>Fire Management Plan</font> record for this park before creating any Burn Units.";
//	exit;
	}
	
$sql="SELECT unit_id,unit_name 
from $table where park_code='$park_code'
order by unit_name";
$result = mysql_query($sql,$connection) or die ("Couldn't execute select query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
	{
	$unit_name=$row['unit_name'];
	if(empty($unit_name)){$unit_name="This unit has NOT been named.";}
	$ARRAY[$row['unit_id']]=$unit_name;
	}

if(empty($ARRAY) OR @$submit=="Add")
	{
	$sql="INSERT IGNORE INTO $table set park_code='$park_code'";
	$result = mysql_query($sql,$connection) or die ("Couldn't execute select query. $sql c=$connection");

	$sql="SELECT unit_id
	from $table where park_code='$park_code' and unit_name='An unnamed unit'";
	$result = mysql_query($sql,$connection) or die ("Couldn't execute select query. $sql c=$connection");
	$row=mysql_fetch_assoc($result);
		extract($row);
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";
$file="units.php";

if(!empty($ARRAY))
	{
	echo "<table><tr>";
		echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a Unit:</option>";
	foreach($ARRAY as $k=>$v)
		{
		//$array[unit_name]
		echo "<option $s='$file?park_code=$park_code&unit_id=$k'>$v</option>";
		}
		echo "</select></form>";
	echo "</td>";
	
	echo "<td>&nbsp;&nbsp;&nbsp;<a href='units.php?submit=Add&park_code=$park_code'>Add</a> a unit to $park_code</td>";
	
	echo "</tr></table>";
	}
if(empty($unit_id)){exit;}

unset($ARRAY);
$sql="SELECT t1.*, t2.unit_prescription, t2.file_name
from $table as t1
Left Join prescriptions as t2 on t1.unit_id=t2.unit_id
where t1.unit_id='$unit_id'";
$result = mysql_query($sql,$connection) or die ("Couldn't execute select query. $sql ".mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY)){echo "No unit was found with a unit_id = $unit_id";exit;}
//echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";

echo "<hr />
<div align='center'>";

echo "<table><tr><td>This section is where you upload all current prescriptions. To upload information regarding fires that have been performed add to the <strong>Burn History</strong> page.<br /><br />
It is expected that there will be geographic or temporal overlap on prescriptions. Error on the side of more information and describe in the Comments box what you have uploaded.</td></tr></table>";
echo "<form method='post' action='burn_unit_upload.php' enctype='multipart/form-data'>";

echo "<table border='1'>";


echo "<tr><th colspan='2'><font color='green'>Burn Units and Prescriptions at $parkCodeName[$park_code]</font></th></tr>";

if(!empty($ARRAY[0]['unit_name']))
	{$unit_name=$ARRAY[0]['unit_name'];}
	else
	{$unit_name="";}
echo "<tr><th colspan='2'><font color='brown' size='+1'>Burn Unit: $unit_name</font><br /><font color='orange' >Enter Documentation/Evaluations of all burns in the \"Burn History\" section.</font></th></tr>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
$skip=array("unit_id","park_code","map_annotate","prescription","file_name");
if($ARRAY[0]['unit_name']=="An unnamed unit")
	{
	$ren_name="<br /><font color='red'>Give this unit a name.</font>";
	}
	else
	{
	$ren_name="";
	}
$rename=array("unit_name"=>"Unit Name and/or ID $ren_name", "acres"=>"Acres in Rx","fireline"=>"Total Linear Feet of Fireline","unit_prescription"=>"Unit Prescription(s)","unit_map"=>"Unit Map(s)<br />(more than 1 if needed)", "comments"=>"Comments");

$input_size=array("unit_name"=>"50", "acres"=>"5","fireline"=>"5");
foreach($ARRAY as $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td>$rename[$fld]</td>";
		if(array_key_exists($fld,$input_size)){$size="size='".$input_size[$fld]."'";}else{$size="";}
		$input="<input type='text' name='$fld' value=\"$value\" $size>";
		if($fld=="comments")
			{
			$input="<textarea name='$fld' rows='12' cols='35'>$value</textarea>";
			}
		if($fld=="prescription")
			{
			$input="";
			if(!empty($value))
				{
				$input="View Rx for Unit <a href='$value' target='_blank'>$unit_name</a> <==> <a href='burn_unit_upload.php?del=$unit_id'>delete</a>";
				$unit_prescription=$value;
				}
			$input.="<br /><br />Select your file to upload. <font size='-2'>(Should be a Word or PDF file.)</font><br />
			<input type='file' name='file_upload_prescription'  size='40'>";
			}
		if($fld=="unit_map")
			{
			$var_map=explode(",",$value);
			$input="";
			if(count($var_map)>0)
				{
				foreach($var_map as $k1=>$v1)
					{
					if(empty($v1)){continue;}
					$array_map[]=str_replace("fire_unit_map/","",$v1);
					}
				$var_annotate=explode("`",$ARRAY[$index]['map_annotate']);
			
				foreach($var_annotate as $k3=>$v3)
						{
						if(empty($v3)){continue;}
						$var4=explode("=",$v3);
						if(!empty($var4[1]))
							{$pass_a[$var4[0]]=$var4[1];}
						}
				
				foreach($var_map as $k1=>$v1)
					{
					if(empty($v1)){continue;}
					$v2=str_replace("fire_unit_map/","",$v1);
					$var_ext=explode(".",$v2);
					$ext=array_pop($var_ext);
					
		/*			if($ext=="jpg" OR $ext=="jpeg")
						{
						$input.="View Unit Map ==> <a href='view_map.php?unit_id=$unit_id&img=$v2' target='_blank'>$v2</a> <a href='burn_unit_upload.php?park_code=$park_code&unit_id=$unit_id&ref=$v1&submit=del' onclick=\"return confirm('Are you sure you want this Map?')\">Delete</a><br />";
						}
			*/			
			//		if($ext=="pdf")
			//			{
						$input.="View Unit Map ==> <a href='$v1' target='_blank'>$v2</a><br /><a href='burn_unit_upload.php?park_code=$park_code&unit_id=$unit_id&ref=$v1&submit=del' onclick=\"return confirm('Are you sure you want this Map?')\">Delete</a><br />";
			//			}
						
					$ma=@$pass_a[$v2];
					$input.="Annotate<br />this Map:
					<textarea name='map_annotate[$v2]' rows='2' cols='40'>$ma</textarea>
					<br />------------------------------------------<br />";
					}
				}
			$input.="<br />Select your file to upload. <font size='-2'>(Should be a JPEG or PDF file.)</font><br />
			<input type='file' name='file_upload_unit_map'  size='40'>";
			if(!empty($value))
				{
				$unit_map=$value;
				}
			}
		echo "<td>$input</td>
		</tr>";
		}
	}

$unit_id=$ARRAY[0]['unit_id'];

echo "<tr><td align='center'><a href='unit_delete.php?unit_id=$unit_id' onclick=\"return confirm('Are you sure you want to delete this Unit? This will also delete any Rx and maps!')\">Delete</a></td><td align='center'>";

if(!empty($unit_prescription))
	{
	echo "<input type='hidden' name='unit_prescription' value='$unit_prescription'>";
	}
if(!empty($unit_map))
	{
//	echo "<input type='hidden' name='unit_map' value='$unit_map'>";
	}
echo "<input type='hidden' name='form_name' value='fire_plan'>
<input type='hidden' name='unit_id' value='$unit_id'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='submit' value='Update'>
</td></tr>";

echo "</table>";

echo "</form>";

echo "</div>";
?>