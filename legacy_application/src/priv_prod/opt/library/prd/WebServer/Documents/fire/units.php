<?php
include("menu.php");

extract($_REQUEST);
if(empty($park_code) AND empty($unit_id)){exit;}

$table="units";
$file=$_SERVER['PHP_SELF'];

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'fire');

$sql="SELECT park_code as `check`
from park_plan where park_code='$park_code'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
if(mysqli_num_rows($result)<1)
	{
//	echo " You must enter a <font color='red'>Fire Management Plan</font> record for this park before creating any Burn Units.";
//	exit;
	}

$sql="SELECT link as fire_park_map, map_num, map_name
from fire_park_map where park_code='$park_code'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		$exp_path=explode("/",$fire_park_map);
		$img_file=array_pop($exp_path);
		$exp_file=explode(".",$img_file);
		array_pop($exp_file); 
		$base_file=implode(".",$exp_file);
		$img=implode("/",$exp_path)."/ztn.".$base_file.".jpg";
		if($level>3)
			{
		$del=$map_name." <a href='upload_burn_unit_map.php?park_code=$park_code&del=$map_num' onclick=\"return confirm('Are you sure you want to delete this Image?')\">delete this map</a><br />";
			}
			else
			{$del=$map_name."<br />";}
		$tn_array[$map_num]="Click image to view:<br /><a href='$fire_park_map' target='_blank'><img src='$img'></a> $del";
		$photo_array[$map_num]="$base_file";
		}
	}
$sql="SELECT unit_id,unit_name 
from $table where park_code='$park_code'
order by unit_name";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$unit_name=$row['unit_name'];
	if(empty($unit_name)){$unit_name="This unit has NOT been named.";}
	$ARRAY[$row['unit_id']]=$unit_name;
	}

if(empty($ARRAY) OR @$submit=="Add")
	{
	$sql="INSERT IGNORE INTO $table set park_code='$park_code'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");

	$sql="SELECT unit_id
	from $table where park_code='$park_code' and unit_name='An unnamed unit'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
	$row=mysqli_fetch_assoc($result);
		extract($row);
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;
$file="units.php";

if(!empty($ARRAY))
	{
	echo "<table><tr>";
		echo "<td valign='top'><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\">
		<option selected=''>Select a Unit:</option>";
	foreach($ARRAY as $k=>$v)
		{
		//$array[unit_name]
		echo "<option value='$file?park_code=$park_code&unit_id=$k'>$v</option>";
		}
		echo "</select></form>";
	echo "</td>";
	
	echo "<td valign='top'>&nbsp;&nbsp;&nbsp;<a href='units.php?submit=Add&park_code=$park_code'>Add</a> a unit to $park_code</td>";
	
	echo "<td>&nbsp;&nbsp;Upload an overall burn unit map for $park_code - 	
	<a onclick=\"toggleDisplay('unit_map');\" href=\"javascript:void('')\">Map</a>

      <div id=\"unit_map\" style=\"display: none\"><form method=post action=upload_burn_unit_map.php enctype='multipart/form-data'>";
      for($i=1;$i<6;$i++)
      	{
      	if(empty($photo_array[$i]))
      		{
		echo "Map $i
		<input type='file' name='files[$i]'>
		<input type='hidden' name='park_code' value='$park_code'>
		<br />";
		}
      		else
      		{		
      		echo "Map $i
		$photo_array[$i]
		<br />";
		}

      	}
      echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Upload'></form></div></td>";
	
	if(!empty($unit_id))
		{echo "<td>&nbsp;&nbsp;&nbsp;Burn <a href='burn_history.php?park_code=$park_code&unit_id=$unit_id' target='_blank'>History</a></td>";}
	
	echo "</tr>";
	if(!empty($tn_array))
		{
		echo "<tr><td colspan='5'>";
		foreach($tn_array as $k=>$v)
			{
			echo "$v";
			}
		echo "</td></tr>";
		}
	echo "</table>";
	}
if(empty($unit_id)){exit;}

unset($ARRAY);
// added join on after_action
// added ARRAY for action review docs th_20220226

$sql="SELECT t1.*, t2.unit_prescription, t2.file_name,t2.id as rx_id, t2.rx_link, t3.unit_map, t3.map_name, t3.id as map_id, t3.map_annotate, t4.id as action_review_id, t4.action_review_title, t4.action_review_link
from $table as t1
Left Join prescriptions as t2 on t1.unit_id=t2.unit_id
Left Join maps as t3 on t1.unit_id=t3.unit_id
Left Join after_action as t4 on t1.unit_id=t4.unit_id
where t1.unit_id='$unit_id'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	
	if($row['file_name']!="")
		{
		$ARRAY_rx[$row['rx_id']]=$row['unit_prescription'];
		$ARRAY_file[$row['rx_id']]=$row['file_name'];
		$ARRAY_rx_url[$row['rx_id']]=$row['rx_link'];
		}
	if($row['map_id']!="")
		{
		$ARRAY_map_link[$row['map_id']]=$row['unit_map'];
		$ARRAY_map_name[$row['map_id']]=$row['map_name'];
		$ARRAY_map_url[$row['map_id']]=$row['map_annotate'];
		}
	if($row['action_review_id']!="")
		{
		$ARRAY_action_review_title[$row['action_review_id']]=$row['action_review_title'];
		$ARRAY_action_review_link[$row['action_review_id']]=$row['action_review_link'];
		}
		
	}
if(empty($ARRAY)){echo "No unit was found with a unit_id = $unit_id";exit;}
//echo "$sql<pre>"; print_r($ARRAY); print_r($ARRAY_file); print_r($ARRAY_map_link); echo "</pre>";

if(empty($park_code)){
	$park_code=$ARRAY[0]['park_code'];}
echo "<hr />
<div align='center'>";

echo "<table><tr><td>This section is where you upload all current prescriptions. To upload information regarding fires that have been performed add to the <strong>Burn History</strong> page.<br /><br />
It is expected that there will be geographic or temporal overlap on prescriptions. Error on the side of more information and describe in the Comments box what you have uploaded.</td></tr></table>";

echo "<form method='post' action='burn_unit_upload.php' enctype='multipart/form-data'>";

echo "<table border='1'>";


echo "<tr><th colspan='2'><font color='green' size='+2'>Burn Units and Prescriptions at $parkCodeName[$park_code]</font></th></tr>";

if(!empty($ARRAY[0]['unit_name']))
	{$unit_name=$ARRAY[0]['unit_name'];}
	else
	{$unit_name="";}
echo "<tr><th colspan='2'><font color='brown' size='+1'>Burn Unit: $unit_name</font><br /><font color='blue' >Enter Documentation/Evaluations of all burns in the \"Burn History\" section.</font></th></tr>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
$skip=array("unit_id","park_code","map_annotate","prescription","file_name","rx_id","map_id","map_name","rx_link", "action_review_id","action_review_link");
if($ARRAY[0]['unit_name']=="An unnamed unit")
	{
	$ren_name="<br /><font color='red'>Give this unit a name.</font>";
	}
	else
	{
	$ren_name="";
	}
$rename=array("unit_name"=>"Unit Name and/or ID $ren_name", "acres"=>"Acres in Rx","fireline"=>"Total Linear Feet of Fireline","unit_prescription"=>"Unit Prescription(s)","unit_map"=>"Unit Map(s)", "comments"=>"Comments", "action_review_title"=>"Action Review Document", "action_review_comment"=>"Action Review Comment", "action_review_link"=>"Action Review Link");

$input_size=array("unit_name"=>"50", "acres"=>"5","fireline"=>"5");
foreach($ARRAY as $index=>$array)
	{
	if($index>0){continue;}
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td>$rename[$fld]</td>";
		if(array_key_exists($fld,$input_size)){$size="size='".$input_size[$fld]."'";}else{$size="";}
		$input="<input type='text' name='$fld' value=\"$value\" $size> $fld";
		if($fld=="comments")
			{
			$input="<textarea name='$fld' rows='10' cols='75'>$value</textarea>";
			}
		if($fld=="unit_prescription")
			{
			$input="";
			if(!empty($ARRAY_rx))
				{
				foreach($ARRAY_rx as $rx_id=>$unit_prescription)
					{
					$file_name=$ARRAY_file[$rx_id];
					$url_rx=$ARRAY_rx_url[$rx_id];
					$rx_id=$unit_id.".".$rx_id;
					$input.="View Rx for Unit $unit_name <b>$file_name</b> <==> <a href='$unit_prescription' target='_blank'>View</a>";
					if($level>3)
						{
						$input.="<====> <a href='burn_unit_upload.php?del_rx=$rx_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">delete</a><br />";
						} 
					}	
				}
			$input.="<br />Select your file to upload. <font size='-2'>(Should be an Excel, Word or PDF file.)</font><br />
			<input type='file' name='file_upload_prescription'  size='40'><br /><br />";	
			if(!empty($url_rx))
				{$url_rx_link="<a href='$url_rx' target='_blank'>show Rx</a>";}
				else
				{
				$url_rx_link="";
				$url_rx="";
				}
			$input.="URL for any Rx already uploaded: $url_rx_link<br /><input type='text' name='rx_link' value='$url_rx' size='100'>";	
			}
			
		if($fld=="unit_map")
			{
			$input="";
			if(!empty($ARRAY_map_link))
				{
				foreach($ARRAY_map_link as $map_id=>$unit_map)
					{
					$map_name=$ARRAY_map_name[$map_id];
					$url_map=$ARRAY_map_url[$map_id];
					$map_id=$unit_id.".".$map_id;
					$input.="View Map for Unit $unit_name <b>$map_name</b> <==>  <a href='$unit_map' target='_blank'>View</a>";
					if($level>3)
						{$input.="<====> <a href='burn_unit_upload.php?del_map=$map_id' onclick=\"return confirm('Are you sure you want to delete this Map?')\">delete</a><br />";
						}
					}
				}
			$input.="<br />Select your file to upload. <font size='-2'>(Should be a JPG or PDF file.)</font><br />
			<input type='file' name='file_upload_unit_map'  size='40'><br />";
			
			if(!empty($url_map))
				{$url_map_link="<a href='$url_map' target='_blank'>show map</a>";}
				else
				{
				$url_map_link="";
				$url_map="";
				}
			$input.="<br />URL for any Map already uploaded: $url_map_link<br /><input type='text' name='map_annotate' value='$url_map' size='100'>";
			}
			
// adds fld to work with action review docs th_20220226
		if($fld=="action_review_title")
			{
			$input="";
			if(!empty($ARRAY_action_review_title))
				{
				foreach($ARRAY_action_review_link as $action_review_id=>$action_review_link)
					{
					$action_review_title=$ARRAY_action_review_title[$action_review_id];
					$action_review_link=$ARRAY_action_review_link[$action_review_id];
					$action_review_id=$unit_id.".".$action_review_id;
					$input.="View Action Review for Unit $unit_name <b>$action_review_title</b> <==>  <a href='$action_review_link' target='_blank'>View</a>";
					if($level>3)
						{$input.="<====> <a href='burn_unit_upload.php?del_action_review=$action_review_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">delete</a><br />";
						}
					}
				}
			$input.="<br />Select your file to upload. <font size='-2'>(Should be a Word or PDF file.)</font><br />
			<input type='file' name='file_upload_action_review'  size='40'><br />";

			}
		echo "<td>$input</td>
		</tr>";
		}
	}

$unit_id=$ARRAY[0]['unit_id'];

echo "<tr>";

if($level>3)
	{
	echo "<td align='center'><a href='unit_delete.php?unit_id=$unit_id' onclick=\"return confirm('Are you sure you want to delete this Unit? This will also delete any Rx and maps!')\">Delete</a></td><td align='center'>";
	}
	else
	{
	echo "<td>Contact Thomas C. or Jon B. if you need to delete this unit.</td><td>";
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