<?php
$database="rtp"; 
$dbName="rtp";

date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");

if($submit_form=="Update")
	{
	include("update_table.php");
	if($_POST['source']=="view_form")
		{
		header("Location: view_form.php?var=$var_table&project_file_name=$project_file_name");
		exit;
		}
	}
			
include("page_list_view.php");

include_once("_base_top.php");

$var_table=$var;	
mysqli_select_db($connection,$dbName);

if($var_table=="scores")
	{
	include("scores.php");
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

$sql = "SHOW COLUMNS FROM $var_table";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$ARRAY_textarea=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	$temp=$row['Type'];
	$exp=explode("(",$temp);
	if($exp[0]=="varchar")
		{
		$var_temp=substr($exp[1],0,-1);
		if($var_temp>120)
			{$ARRAY_textarea[]=$row['Field'];}
		}
	}

$sql="SELECT *
from rtp_objective_scores as t1
WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_base_scores[$row['table_value']]=$row['table_score'];
	}
	
//echo "<pre>"; print_r($ARRAY_base_scores); echo "</pre>"; // exit;
//, t2.link 
//left join file_upload as t2 on t1.id=t2.track_id

$sql="SELECT t1.*
from $var_table as t1
 WHERE t1.project_file_name='$project_file_name'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
$skip=array("id");
$drop_down=array("trail_work_type","dot_category","state_trail","land_status","gov_body_approval", "public_communication");
$trail_work_type_array=array("Approved Trail/Greenway Facilities","Combination","Informational Trail Head/Directional Trail Markers","New Trail/Greenway - unpaved","Purchase of Tools/Equipment","Trail/Greenway Renovation");
$dot_category_array=array("Motorized Diverse Use","Non-motorized Diverse Use","Non-motorized Single Use - Canoe/Kayak","Non-motorized Single Use - Pedestrian");
$state_trail_array=array("Deep River State Trail","Fonta Flora State Trail","Mountains-to-Sea State Trail","N.C. State Park Trail","Yadkin River State Trail","All Other Trails");
$land_status_array=array("Public Land","Private Land with Stipulations","Private Land");
$gov_body_approval_array=array("No","Yes (documentation attached)");
$public_communication_array=array("No","A public meeting specifically called for this purpose","During a 30 day public comment period","During a town, city, or county government meeting that allowed public comment.","Online Survey");

$scoring_flds=array("trail_work_type","dot_category","state_trail","land_status","gov_body_approval","public_communication");

$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

//$textarea=array("description","identifiers","where_stored","comments");
$textarea=$ARRAY_textarea;

$caption=array("identifiers"=>"Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>"Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item.", "description"=>"Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Update $var_table</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$value=$ARRAY[$fld];
	echo "<tr>";
	echo "<td>$fld</td>";
	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='75'></td>";
	if(in_array($fld,$drop_down))
		{
		$select_array=${$fld."_array"};
		$line="<td><select name='$fld'><option value=\"$value\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v==$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$textarea))
		{
		$rows=10;$cols=100;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" - ".$caption[$fld];
			}
		$line.="</td>";
		}
	if($fld=="link")
		{
		$line="<td>
		<input type='file' name='file_upload'  size='20'>";
		if(!empty($value))
			{
			$line.="<a href='$value' target='_blank'>View</a> Photo	
		<a href='edit_form.php?track_id=$id'  onclick=\"return confirm('Are you sure you want to delete this Photo?')\">Delete</a> Photo";
			}	
		$line.="</td>";
		}	
	
	if(in_array($fld,$scoring_flds))
		{
		$score=$ARRAY_base_scores[$value];
		$line.="<td align='left'>$score</td>";
		}	
		
	echo "$line";
	echo "</tr>";
	}
// echo "<tr><td colspan='2' align='center'>
// <input type='hidden' name='id' value=\"$id\">
// <input type='submit' name='submit_form' value=\"Update\">
// </td>
// </tr>";
echo "</table>";
echo "</form></html>";

//<td><input type='submit' name='submit_form' value=\"Delete Item\" onclick=\"return confirm('Are you sure you want to delete the item?')\"></td>
?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
</script>