<?php

date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include_once("../../include/get_parkcodes_i.php");
include_once("../../include/iConnect.inc");

if(@$_POST["submit_form"]=="Update Info")
	{
	include("edit_info.php");
	}
if(@$_POST["submit_form"]=="Update Uploads")
	{
	include("edit_uploads.php");
	}
if(@$_POST["submit_form"]=="Delete Person")
	{
	include("edit_action.php");
	}

if(!empty($_GET['track_id']))
	{
	mysqli_select_db($connection,$dbName);
	$sql="SELECT link from hr_forms where track_id='$track_id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	extract($row);
	unlink($link);
	$sql="DELETE FROM hr_forms
	WHERE track_id='$track_id'"; //ECHO "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$id=$track_id;
	}
		
mysqli_select_db($connection,$dbName);
$table="applicants";
$sql = "SHOW COLUMNS FROM $table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}

if(empty($ARRAY_forms))
	{
	$sql="SELECT * from required_forms_2 order by sort_order";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_forms[]=$row['form_name'];
		}
	
	}
	
$sql="SELECT t1.*, t1.id as track_id, t2.id as form_id, t2.form_name as form, t2.file_link as link, t3.id as form_id_other, t3.form_name as form_other, t3.file_link as link_other
from $table as t1
left join hr_forms as t2 on t1.id=t2.track_id
left join hr_forms_other as t3 on t1.id=t3.track_id
 WHERE t1.id='$id'"; 
//  ECHO "$sql<br /><br />"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY=$row;
	$tempID=$row['tempID'];
	$ARRAY_form_link[$row['form']]=$row['link'];
	$ARRAY_form_id[$row['form']]=$row['form_id'];
	$ARRAY_form_link_other[$row['form_id_other']]=$row['link_other'];
	$ARRAY_form_id_other[$row['form_id_other']]=$row['form_id_other'];
	$ARRAY_form_name_other[$row['form_id_other']]=$row['form_other'];
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
// echo "<pre>"; print_r($ARRAY_form_link); echo "</pre>"; // exit;	
// Form to edit an item
echo "<style>
.head {
font-size: 22px;
color: #999900;
}

table.alt_color tr:nth-child(odd) {
    background-color: #ffe6cc;
    font-weight: bold;
    color: #994d00;
    }
table.alt_color tr:nth-child(even) {
    background-color: #fff2e6;
    font-weight: bold;
    color: #663300;
}
td.top {
 vertical-align: text-top;
 }
 table.alt_color td {
 padding: 5px;
 }
div.relative {
    position: relative;
    width: 20px;
}
div.absolute {
    position: absolute;
    top: 180px;
    left: 450px;
}
#button_info
	{border:1px solid #ffcc00;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px;
  font:2.4em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size: 110%;
	 background-color:rgba(255,204,0,1);
  border:1px solid #ffcc00;
	}
#button_upload
	{border:1px solid #ffcc00;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px;
  font:2.4em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size: 110%;
	 background-color:rgba(255,204,0,1);
  border:1px solid #ffcc00;
	}
.ui-datepicker {
  font-size: 80%;
}
</style>";

$skip=array("id","form_id","track_id");
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_i.php above
$disposition_array=array("Surplus","Scrap","Landfill","Park Use");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$date_array=array("date_submit"=>"datepicker1","date_action"=>"datepicker2");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item, e.g., estimated value.", "description"=>" - Please describe the item.");

$rename_array=array("Lname"=>"Last Name", "Fname"=>"First Name", "M_initial"=>"Middle Initial", "ssn_last4"=>"Last four digits of SSN","driver_license"=>"Driver's License","beaconID"=>"Employee BEACON Number");

$admin_array=array("disposition","category","sub_cat");

$readonly_array=array("tempID","ssn_last4");
echo "<div class='relative'>";
echo "<form action='edit_form.php' method='POST'>";

echo "<table><tr><td class='head' colspan='2'>Update Employee Info</td></tr>";
echo "<tr><td colspan='2'>Verify that this information is correct.</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$value=$ARRAY[$fld];
	echo "<tr>";
	echo "<td>$fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	if(in_array($fld, $readonly_array)){$ro="READONLY";}else{$ro="";}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" $ro></td>";
	if(in_array($fld,$drop_down))
		{
		$select_array=${$fld."_array"};
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v==$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" - ".$caption[$fld];
			}
		$line.="</td>";
		}
	
	if($fld=="track")
		{
		$val=$_SESSION['hr_perm']['tempID'];
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"$val\" readonly></td>";
		}	
	
	echo "$line";
	echo "</tr>";
	}
echo "</table>";
echo "</div>";

echo "<div>";

echo "<table><tr><td colspan='2' align='center'>
<input type='hidden' name='id' value=\"$id\">
<input id='button_info' type='submit' name='submit_form' value=\"Update Info\">
</td>";
// echo "<td><input type='submit' name='submit_form' value=\"Delete Person\" onclick=\"return confirm('Are you sure you want to delete this Person?')\"></td>";

echo "</tr>";
echo "</table>";
echo "</form>";
echo "</div>";

echo "<div class='absolute'>";

echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table class='alt_color' border='1'>";
// echo "<pre>"; print_r($ARRAY_form_link); echo "</pre>"; // exit;
foreach($ARRAY_forms as $k=>$v)
	{
	$v1=str_replace(" ","_",$v);
	if($v1=="Other_Upload"){continue;}
//	fmod($k,2)==0?$tr="bgcolor='#CCC'":$tr="bgcolor='white'";
	if(array_key_exists($v1, $ARRAY_form_link))
		{
		$val=$ARRAY_form_link[$v1];
		$file_id=$ARRAY_form_id[$v1];
	//	@$FileDetails = stat($val);
		echo "<tr><td>$v</td><th><a href='$val' target='_blank'>View</th><td><a href='del_file.php?id=$file_id&track_id=$id'  onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td></tr>";
		}
		else
		{
		echo "<tr><td>$v</td><td><input type='file' name='file_upload[]'></td>";
		}
	echo "</tr>";
	}
echo "</table><hr /><table align='center'>";
//echo "<pre>"; print_r($ARRAY_form_link_other); echo "</pre>"; // exit;
if(!empty($ARRAY_form_link_other))
	{
	foreach($ARRAY_form_link_other as $k=>$v)
		{
		if(empty($v)){continue;}
			$val=$ARRAY_form_name_other[$k];
			$file_id=$ARRAY_form_id_other[$k];
	echo "<tr><td>$val</td><th><a href='$v' target='_blank'>View</th><td><a href='del_file_other.php?id=$file_id&track_id=$id'>Delete</a></td></tr>";
		}
	}
echo "<tr bgcolor='aliceblue'><td>Other Upload(s) [if needed]</td><td><input type='file' name='file_upload_other[]'></td></tr>";


echo "<tr><td colspan='3' align='center'>
<input type='hidden' name='tempID' value=\"$tempID\">
<input type='hidden' name='id' value=\"$id\">
<input id='button_upload' type='submit' name='submit_form' value=\"Update Uploads\">
</td>";
// echo "<td><input type='submit' name='submit_form' value=\"Delete Person\" onclick=\"return confirm('Are you sure you want to delete this Person?')\"></td>";

echo "</tr>";
echo "</table>";
echo "</form>";
echo "</div>";
echo "</html>";

?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
</script>