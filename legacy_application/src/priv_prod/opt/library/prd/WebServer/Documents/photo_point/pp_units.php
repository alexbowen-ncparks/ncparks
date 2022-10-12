<?php

if(empty($_SESSION))
	{session_start();}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		if($_SESSION['photo_point']['tempID']=="Morris7487")
			{
			$photo_point_park[]="BATR";
			$photo_point_park[]="SARU";
			// normally this would be set in accessPark in the Personnel db. In this case BATR is not under
			// CLNE so an exception was hand-coded. TEH _20190705
// 			echo "<pre>"; print_r($photo_point_park); echo "</pre>"; // exit;
			}
		
		if($_SESSION['photo_point']['tempID']=="Staib8359")
			{
			$photo_point_park[]="BATR";
			$photo_point_park[]="SARU";
			// normally this would be set in accessPark in the Personnel db. In this case BATR is not under
			// CLNE so an exception was hand-coded. TEH _20190726
// 			echo "<pre>"; print_r($photo_point_park); echo "</pre>"; // exit;
			}
extract($_REQUEST);
if(empty($park_code) AND empty($pp_code) AND empty($unit_id))
	{
	include("menu.php");  // includes connection and db select
	exit;
	}
include("../../include/iConnect.inc");
mysqli_select_db($connection, "photo_point");

$table="photo_point";
$file=$_SERVER['PHP_SELF'];

if(!empty($unit_id))
	{
	$sql="SELECT park_code, pp_code, pp_name
	from $table where unit_id='$unit_id'
	";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
	$row=mysqli_fetch_assoc($result); //echo "$sql";
	if(empty($row))
		{
		Header("Location: pp_units.php");
		exit;
		}
	extract($row);
	}

if(!empty($pp_code))
	{
	$var=explode("_",$pp_code);
	$park_code=$var[0];
	$sql="SELECT pp_code, pp_name
	from $table where pp_code='$pp_code'
	order by pp_code";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[$row['pp_code']]=$row['pp_name'];
		}
	}

$sql="SELECT unit_id, pp_code, pp_name, concat(pp_code,'-',pp_name,' on ',date) as point_name_date
from $table where park_code='$park_code'
order by pp_code";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_points[$row['pp_code']]=$row['pp_name'];
	if(!empty($pp_code) AND $row['pp_code']==$pp_code)
		{
		$ARRAY_point_name[$row['unit_id']]=$row['pp_name'];
		$ARRAY_point_name_date[$row['unit_id']]=$row['point_name_date'];
		}
	
	}
	
$file="pp_units.php";

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(empty($ARRAY_points) OR @$submit!="")
	{
	if(empty($submit))
		{
		include("menu.php");  // includes connection and db select
		$add_year=date("Y");
		echo "<h3>Do you wish to create a new Photo Point for $park_code?</h3>
		<a href='pp_units.php'>No</a>
		<br /><br />
		<form action='pp_units.php' method='POST'>Add a new Photo Point for <b>$park_code:</b>
		<input type='hidden' name='park_code' value='$park_code'>
		<input type='text' name='year' value='$add_year' size='5'>
		<input type='submit' name='submit' value='Add New PP'><font color='red'> Make sure year is correct!</font>
		</form>
		"; exit;
		}
	
	
	if($submit=="Add to Existing")
		{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$pp_name=str_replace("'","",$pp_name);
		$sql="INSERT INTO $table set park_code='$park_code', pp_code='$pp_code', pp_name='$pp_name'";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
		$unit_id=mysqli_insert_id($connection); 

	//	$sql="UPDATE $table set pp_code='$pp_code', year='$year' where unit_id='$unit_id'";
	//	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ");
		header("Location: pp_units.php?unit_id=$unit_id");
		exit;
		}
		
	if($submit=="Add New PP")
		{
		$sql="SELECT pp_code
		from $table where park_code='$park_code'
		order by pp_code desc
		limit 1";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ");
		$row=mysqli_fetch_assoc($result);
		$temp=$row['pp_code'];
		$exp=explode("_", $temp);
		$num=$exp[1]+1;   //echo "n=$num"; exit;

		$sql="INSERT IGNORE INTO $table set park_code='$park_code'";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
		$unit_id=mysqli_insert_id($connection); 

		$pp_code=$park_code."_".str_pad($num,3,0,STR_PAD_LEFT); //echo " p=$pp_code";
		$sql="UPDATE $table set pp_code='$pp_code', year='$year' where unit_id='$unit_id'";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ");
		header("Location: pp_units.php?unit_id=$unit_id");
		exit;
		}
	}
	else
	{
	include("menu.php");  // includes connection and db select
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";

$sql="SELECT latoff, lonoff
from dpr_system.dprunit where parkcode='$park_code'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
$row=mysqli_fetch_assoc($result); //print_r($row);
extract($row);

	
if(!empty($ARRAY_points))
	{
	echo "<table><tr>";
	echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\">
	<option selected=''>Select a Photo Point:</option>";
	foreach($ARRAY_points as $k=>$v)
		{
		echo "<option value='pp_units.php?pp_code=$k'>$k - $v</option>\n";
		}
	echo "</select></form>";
	echo "</td>";

	if(!empty($pp_code))
		{
		$pp_name=$ARRAY_points[$pp_code];
		echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\">
		<option selected=''>View Existing Photo Set for $pp_code $pp_name:</option>";
		foreach($ARRAY_point_name_date as $k=>$v)
			{
			echo "<option value='pp_units.php?unit_id=$k'>$v</option>\n";
			}
		echo "</select></form>";
		echo "</td>";
		}
	$add_year=date("Y");
	if(!empty($pp_code))
		{
		$pp_name=$ARRAY_point_name[$k];
		echo "<td><form action='pp_units.php' method='POST'>Add a new set of photos for <b>$pp_code $pp_name:</b>
		<input type='hidden' name='pp_code' value='$pp_code'>
		<input type='hidden' name='park_code' value='$park_code'>
		<input type='hidden' name='pp_name' value='$pp_name'>
		<input type='hidden' name='year' value='$add_year' size='5'>
		<input type='submit' name='submit' value='Add to Existing'>
		</form></td>";
		}
	echo "<td><form action='pp_units.php' method='POST'>Add a new Photo Point for <b>$park_code:</b>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='hidden' name='year' value='$add_year' size='5'>
	<input type='submit' name='submit' value='Add New PP'><font color='red'>
	</form></td>";
	echo "</tr></table>";	
	}
	
	
if(empty($pp_code) or empty($unit_id)){exit;}

unset($ARRAY);
$sql="SELECT t1.*, t2.id, t2.direction, t2.photo_link, t2.photo_name, t3.id as file_id, t3.file_link, t3.file_name
from $table as t1
Left Join pp_photos as t2 on t1.unit_id=t2.unit_id
Left Join pp_files as t3 on t1.unit_id=t3.unit_id
where t1.unit_id='$unit_id'";
//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$ARRAY_photo_direction[$row['id']]=$row['direction'];
	$ARRAY_photo_link[$row['id']]=$row['photo_link'];
	$ARRAY_photo_name[$row['id']]=$row['photo_name'];
	$ARRAY_file_link[$row['file_id']]=$row['file_link'];
	$ARRAY_file_name[$row['file_id']]=$row['file_name'];
	}
if(empty($ARRAY)){echo "No unit was found with a pp_code = $pp_code";exit;}
//echo "$sql<pre>"; print_r($ARRAY); print_r($ARRAY_file); print_r($ARRAY_photo_link); echo "</pre>";

if(empty($unit_id))
	{$unit_id=$ARRAY[0]['unit_id'];}
	

echo "<hr />
<div align='center'>";

echo "<form method='post' name='editForm' action='photo_unit_upload.php' enctype='multipart/form-data' name=\"f1\" onsubmit=\"return checkButtons(this);\">";

echo "<table border='1' cellpadding='3'>";


echo "<tr><th colspan='2'><font color='green' size='+2'>Photo Point at $parkCodeName[$park_code]</font></th></tr>";

if(!empty($ARRAY[0]['pp_name']))
	{$pp_name=$ARRAY[0]['pp_name'];}
	else
	{$pp_name="";}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
$skip=array("id","unit_id","park_code","map_annotate","prescription","photo_name","file_id","file_link","file_name","lon");

if($ARRAY[0]['pp_name']=="")
	{
	$ren_name="<br /><font color='#009933'>Give this Photo Point a name.</font>";
	}
	else
	{
	$ren_name="";
	}
$rename=array("pp_name"=>"Photo Point Name $ren_name", "pp_code"=>"Photo Point Code","year"=>"Year","season"=>"Seasons","direction"=>"Compass Direction", "comment"=>"Comment", "lat"=>"Coords", "photo_link"=>"Photos","season"=>"Season","distance"=>"Distance Camera to board","date"=>"Date (yyyy-mm-dd)","category"=>"Category","burn_unit"=>"Burn Unit (if applicable)");

$readonly=array("pp_code");

$input_size=array("pp_name"=>"50", "acres"=>"5","fireline"=>"5");
foreach($ARRAY as $index=>$array)
	{
	if($index>0){continue;}
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td align='right' valign='top'>$rename[$fld]</td>";
		if(array_key_exists($fld,$input_size)){$size="size='".$input_size[$fld]."'";}else{$size="";}
		
		if(in_array($fld,$readonly)){$RO="readonly";}else{$RO="";}
		$input="<input type='text' name='$fld' value=\"$value\" $size $RO>";
		
		if($fld=="comment")
			{
			$input="<textarea name='$fld' rows='2' cols='95'>$value</textarea>";
			$input.="<br />Upload any supporting file(s): <input type='file' name='file_upload_pp_file'  size='40'>";
			foreach($ARRAY_file_link as $file_id=>$v)
				{
				if(empty($file_id)){continue;}
				$pn=$ARRAY_file_name[$file_id];
				$fl=$ARRAY_file_link[$file_id];
				$exp=explode("/",$v);
				$input.="<br /><b>$pp_code $array[year] $array[season]</b>
				- <a href='$v' target='_blank'>$pn</a> ==> <a href='photo_unit_upload.php?park_code=$park_code&unit_id=$unit_id&del_file=$file_id' onclick=\"return confirm('Are you sure you want this File?')\">delete</a><br />";
				}
			}
			
		if($fld=="lat")
			{
			if(empty($ARRAY[0]['lat'])){$lat=$latoff;}else{$lat=$ARRAY[0]['lat'];}
			if(empty($ARRAY[0]['lon'])){$lon=$lonoff;}else{$lon=$ARRAY[0]['lon'];}
			$input="Latitude:<input type='text' name='lat' value=\"$lat\" size='10'>";
			$input.=" Longitude:<input type='text' name='lon' value=\"$lon\" size='10'>";
			$input.="<input type='button' value='Map It!' onclick=\"return popitLatLon('lat_long.php?pp_code=$pp_code&park=$park_code&lat=$lat&lon=$lon')\">";
			}
		if($fld=="season")
			{
			$input="";
			$val_array=array("Growing","Dormant","Concurrent");
			foreach($val_array as $k=>$v)
				{
				if($value==$v)
					{$ck="checked";}
					else
					{$ck="";}
				$input.="<input type='radio' name='$fld' value='$v' $ck>$v ";
				}
			}
			
		if($fld=="category")
			{
			$input="";
			$val_array=array("Rx fire","Wildfire","Invasive species","Visitor impact","Restoration", "Cultural Resource","Unspecified");
			foreach($val_array as $k=>$v)
				{
				if($value==$v OR empty($value))
					{$ck="checked";} else {$ck="";}
				$input.="<input type='radio' name='$fld' value='$v' $ck>$v ";
				}
			}
				
		if($fld=="direction")
			{
			$input="";
			$val_array=array("N","E","S","W");
			foreach($val_array as $k=>$v)
				{
				if(in_array($v,$ARRAY_photo_direction))
					{continue;}
				if(count($ARRAY_photo_direction)==3)
					{$ck="checked";} else {$ck="";}
				$input.="<input type='radio' name='$fld' value='$v' $ck>$v ";
				}
			}
			
		if($fld=="date")
			{
			$input="<input type='text' name='date' value='$value' id=\"f_date_c\" size='12'>
<img src=\"/jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" /><script type=\"text/javascript\">
		Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
		});
	</script>";
			}
		if($fld=="photo_link")
			{
			$i=0;
			$input="<table><tr>";
			if(!empty($value))
				{
				foreach($ARRAY_photo_link as $photo_id=>$v)
					{
					$i++;
					$pn=$ARRAY_photo_name[$photo_id];
					$exp=explode("/",$v);
					$tn="ztn.".array_pop($exp);
					$tn_link=implode("/",$exp)."/".$tn;
					$dir=$ARRAY_photo_direction[$photo_id];
				$input.="<td><font color='magenta'>$pp_code $array[year] $array[season] $dir</font> 
				- <b>$pn</b>
				<br /><a href='$v' target='_blank'><img src='$tn_link'></a> ==> <a href='photo_unit_upload.php?park_code=$park_code&unit_id=$unit_id&del_photo=$photo_id' onclick=\"return confirm('Are you sure you want this Photo?')\">delete</a></td>";
					if(fmod($i,2)==0){$input.="</tr><tr>";}
					}
				}
			if($i<4)
				{
				$input.="<tr><td colspan='2'>Select a photo to upload. <font size='-2'>(Should be a JPG.)</font> <input type='file' name='file_upload_pp_photo'  size='40'></td></tr>";
				}
			$input.="</table>";
			}
		echo "<td>$input</td>
		</tr>";
		}
	}

$pp_code=$ARRAY[0]['pp_code'];

echo "<tr>";

if($level>2)
	{
	echo "<td align='center'><a href='unit_delete.php?unit_id=$unit_id' onclick=\"return confirm('Are you sure you want to delete this Unit? This will also delete all Photos and Files for the unit!')\">Delete</a></td><td align='center'>";
	}
	else
	{
	echo "<td>Contact a member of the Resource Management Section<br />if you need to delete this photo point.</td><td>";
	}

$unit_id=$ARRAY[0]['unit_id'];
echo "<div id=\"ValidationError\" name=\"ValidationError\">
</div>";

echo "<input type='hidden' name='form_name' value='fire_plan'>
<input type='hidden' name='unit_id' value='$unit_id'>
<input type='hidden' name='pp_code' value='$pp_code'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='submit' value='Update'>
</td></tr>";

echo "</table>";

echo "</form>";

echo "</div>";
?>