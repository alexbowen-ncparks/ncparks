<?php
include("menu.php");

extract($_REQUEST);
if(empty($park_code) AND empty($unit_id)){exit;}

$table_1="burn_history";
$table_2="units";

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'fire');

if(!empty($history_id) AND @$del=="delete")
	{
	$sql="Delete
	from $table_1
	where history_id='$history_id'
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
	}

$sql="SELECT unit_id,unit_name 
from $table_2 
where park_code='$park_code'
order by unit_name";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
while($row=mysqli_fetch_assoc($result))
	{
	$unit_name=$row['unit_name'];
	if($unit_name=="An unnamed unit")
		{
		$unit_name="(This unit has NOT been named.)";
		$message_1="Assign a name to an unnamed unit by selecting \"Burn Units\" in the first drop-down menu.";
		}
	$ARRAY_unit[$row['unit_id']]=$unit_name;
	}
if(empty($ARRAY_unit))
	{
	echo "<font color='red'>A Burn Unit must first be entered BEFORE a Burn History can be started.</font>"; exit;
	}
//echo "<pre>"; print_r($ARRAY_unit); echo "</pre>";

if(!empty($unit_id))
	{
	$sql="SELECT * 
	from prescriptions
	where park_code='$park_code' and unit_id='$unit_id'
	order by id";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_prescription[$row['id']]=$row['unit_prescription'];
		$ARRAY_prescription_name[$row['id']]=$row['file_name'];
		}
//	echo "<pre>"; print_r($ARRAY_prescription_name); echo "</pre>"; // exit;
	}
$file="burn_history.php";
	
if(!empty($ARRAY_unit))
	{
	echo "<table><tr>";
		echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\">
		<option selected=''>Select a Unit:</option>";
	foreach($ARRAY_unit as $k=>$v)
		{
		if(@$unit_id==$k)
			{
			$s="value";
			$pass_unit_name="$v";
			}
		else
			{$s="value";}
		echo "<option $s='$file?park_code=$park_code&unit_id=$k'>$v</option>";
		}
		echo "</select>";
		if(!empty($message_1)){echo "<br />$message_1";}
	echo "</form></td>";
	
	}

if(empty($_REQUEST['unit_id'])){exit;}


$sql="DELETE FROM burn_history where date_='0000-00-00'";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");

$sql="SELECT t1.*, t2.unit_name
from $table_1 as t1
LEFT JOIN $table_2 as t2 on t2.unit_id=t1.unit_id
where t2.unit_id='$unit_id'";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_history[]=$row;
	}

if(empty($ARRAY_history) OR @$submit=="Add")
	{
	$sql="INSERT IGNORE INTO $table_1 set park_code='$park_code', unit_id='$unit_id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
//	$new_id=mysqli_insert_id();
	
	$sql="SELECT history_id
	from $table_1 where park_code='$park_code' and unit_id='$unit_id' and date_='0000-00-00'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
	$row=mysqli_fetch_assoc($result);
		extract($row);
	}

echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a History for a $pass_unit_name:</option>";
	foreach($ARRAY_history as $index=>$array)
		{
		$u=$array['unit_id'];
		$k=$array['history_id'];
		$v=$array['date_'];
		echo "<option value='$file?park_code=$park_code&unit_id=$u&history_id=$k'>$v</option>";
		}
		echo "</select></form>";
	echo "</td>";

	
if(!empty($ARRAY_history))
	{
	echo "<td>&nbsp;&nbsp;&nbsp;<a href='burn_history.php?submit=Add&park_code=$park_code&unit_id=$unit_id'>Add</a> a Burn History for $pass_unit_name at $park_code</td>";
	
	}
echo "</tr></table>";

if(empty($history_id)){exit;}

unset($ARRAY);
$sql="SELECT t1.*, group_concat(concat(t2.burn_history_file_upload_id,'*',t2.evaluation)) as evaluation, group_concat(concat(t2.burn_history_file_upload_id,'*',t2.original_name)) as original_name
from $table_1 as t1
LEFT JOIN burn_history_uploads as t2 on t1.history_id=t2.history_id and t1.unit_id=t2.unit_id
where t1.history_id='$history_id'
group by t1.history_id";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "$sql<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

$sql="SELECT t3.burn_boss, t3.dpr_name, t3.non_dpr_name
from burn_history as t1
LEFT JOIN units as t2 on t1.unit_id=t2.unit_id
LEFT JOIN participants as t3 on t1.history_id=t3.history_id
where t1.history_id='$history_id'
";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$participant_ARRAY[]=$row;
	}
// echo "$sql<pre>"; print_r($participant_ARRAY); echo "</pre>"; // exit;
echo "<hr />";

echo "<form method='post' action='burn_history_upload.php' enctype='multipart/form-data'>";

echo "<table align='center'>";

$d=$ARRAY[0]['date_'];
echo "<tr><th colspan='2'><font color='brown' size='+1'>Burn History $d for Unit $pass_unit_name at $parkCodeName[$park_code]</font></th></tr>";

$skip=array("id","park_code","history_id","unit_id","original_name");
$rename=array("unit_name"=>"Unit Name and/or ID", "date_"=>"Date of Burn","acres_burned"=>"Acres Burned","unit_history_prescription"=>"Rx used on this fire,<br />may be used multiple times.","evaluation"=>"Evaluation of Burn","comments"=>"Comments","gis_done"=>"GIS entry completed","burn_type"=>"Type of Burn","latitude"=>"Latitude","longitude"=>"Longitude");

//echo "<pre>"; print_r($ARRAY); echo "</pre>";

$input_size=array("unit_name"=>"50", "acres_burned"=>"5");
foreach($ARRAY as $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td>$rename[$fld]</td>";
		if(array_key_exists($fld,$input_size))
			{$size="size='".$input_size[$fld]."'";}else{$size="";}
		$input="<input type='text' name='$fld' value=\"$value\" $size>";
		if($fld=="comments")
			{
			echo "<td><textarea name='$fld' rows='12' cols='75'>$value</textarea></td></tr>";
			continue;
			}
		if($fld=="burn_type")
			{
			if($value=="prescribed" or empty($value))
				{$ckp="checked"; $ckw="";}else{$ckp=""; $ckw="checked";}
			$input="<input type='radio' name='$fld' value='prescribed' $ckp>Prescribed";
			$input.="<input type='radio' name='$fld' value='wild' $ckw>Wild";
			}
		if($fld=="gis_done")
			{
			if(!empty($value)){$ck="checked";}else{$ck="";}
			$input="<input type='checkbox' name='$fld' value='x' $ck>";
			}
		if($fld=="date_")
			{
			$input="<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      			onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='date_' value='$value' size='12' id=\"f_date_c\" READONLY> yyyy-mm-dd";
			}
		if($fld=="unit_history_prescription")
			{
			echo "<td><select name='unit_history_prescription'><option selected=''></option>\n";
			foreach($ARRAY_prescription_name as $k=>$v)
				{
				echo "<option value='$k'>$v</option>\n";
				}
			echo "</select>";
			if(empty($ARRAY_prescription_name)){echo " No prescription. Add one using \"Burn Units & Prescriptions\" from first drop-down menu.";}
		
			if(!empty($value))
				{
				@$name=$ARRAY_prescription_name[$value];
				@$link=$ARRAY_prescription[$value];
				echo "&nbsp;&nbsp;&nbsp;View Prescription: <a href='/fire/$link' target='_blank'>$name</a>
				<input type='hidden' name='unit_history_prescription' value='$k'></td>";
				}
			echo "</td>";
			continue;
			}
		if($fld=="evaluation")
			{
			$input="Select your files to add (can include burn maps, evaluation forms).<br />
			<input type='file' name='file_upload_evaluation'  size='40'>";
			if(!empty($value))
				{
				$exp=explode(",",$value);
				$exp2=explode(",",$ARRAY[$index]['original_name']);
				foreach($exp as $k=>$v)
					{
					$exp1=explode("*",$v);
					$file_id=$exp1[0];
					$file=$exp1[1];
					$del_link="burn_history_upload.php?delete=$file_id";
					
					$exp3=explode("*",$exp2[$k]);
					$original_file=$exp3[1];
					$input.="<br />View Evaluation: <a href='$file' target='_blank'>file</a> ==> <b>$original_file</b>";
					if($level>3)
						{
						$input.=" ===> <a href='$del_link' onclick=\"return confirm('Are you sure you want to delete this File?')\">delete</a>";
						}
					}
			//	$evaluation=$value;
				}
			}
		echo "<td>$input</td>
		</tr>";
		}
	}

$unit_id=$ARRAY[0]['unit_id'];

if(!empty($unit_map))
	{
	echo "<input type='hidden' name='unit_map' value='$unit_map'>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='form_name' value='burn_history'>
<input type='hidden' name='history_id' value='$history_id'>
<input type='hidden' name='unit_id' value='$unit_id'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='submit' value='Update'>
</td></tr>";

echo "</form>";

echo "<tr><td></td><td align='right'>Enter <a href='participants.php?park_code=$park_code&unit_id=$unit_id&history_id=$history_id'>Participants</a>";
if(!empty($participant_ARRAY[0]['burn_boss']))
	{
	$bb=$participant_ARRAY[0]['burn_boss'];
	echo "<br /><br /><b>Burn Boss: $bb</b><br />";
	foreach($participant_ARRAY as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			if($k=="burn_boss"){continue;}
			if($v==""){continue;}
			echo "$v<br />";
			}
		
		}
	}
echo "</td></tr>";

if($level>3)
	{
	
echo "<tr><td><a href='burn_history.php?park_code=$park_code&history_id=$history_id&del=delete' onclick=\"return confirm('Are you sure you want this Burn History?')\">Delete</a></td></tr>";
	}

echo "</table>";

echo "</div></div>";
echo "
<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
	    });
	</script>
</html>";
?>