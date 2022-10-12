<?php
include("page_list_view.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include_once("_base_top.php");
//$pass_park_code=@$_SESSION[$database]['select'];

//include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");

$var_table=$var;	
mysqli_select_db($connection,$dbName);

if($var_table=="scores")
	{
	include("scores.php");
	exit;
	}
	
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
	$ARRAY[]=$row;
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

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

	
echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table border='1' cellpadding='5'><tr><td class='head' colspan='4'>View $var_table</td></tr>";

if($var_table=="project_budget")
	{
	$skip[]="project_file_name";
	include("display_project_budget.php");
	}
	else
	{
	include("display.php");
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