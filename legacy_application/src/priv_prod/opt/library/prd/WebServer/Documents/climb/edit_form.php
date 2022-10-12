<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
date_default_timezone_set('America/New_York');
$database="climb"; 
$dbName="climb";

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

//include("../../include/get_parkcodes_i.php");

$parkCode=array("CHRO","CRMO","HARO","PIMO","STMO");
include("../../include/iConnect.inc");

if(@$_POST["submit_form"]=="Update Permit")
	{
	include("edit_action.php");
	}
if(@$_POST["submit_form"]=="Delete Permit")
	{
	include("edit_action.php");
	}

if(!empty($_GET['track_id']))
	{
	mysqli_select_db($connection,$dbName);
	$sql="SELECT link from file_upload where track_id='$track_id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	extract($row);
	unlink($link);
	$sql="DELETE FROM file_upload
	WHERE track_id='$track_id'"; //ECHO "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$id=$track_id;
	}
		
mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM permit";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}
	
$sql="SELECT t1.*, t2.link 
from permit as t1
left join file_upload as t2 on t1.id=t2.track_id
 WHERE t1.id='$id'"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY=$row;
	}
	
// Form to edit an item
echo "<style>
.head {
font-size: 22px;
color: #999900;

td.top {
 vertical-align: text-top;
 }

.ui-datepicker {
  font-size: 80%;
}
</style>";

$skip=array("id");
$magenta_array=array("date_action","permit_status","link","crs_code");
$readonly=array("permit_number","date_submit");

$drop_down=array("park_code","disposition","category","sub_cat");
$radio_flds=array("insurance","permit_status");
$insurance_array=array("Yes","No");
$permit_status_array=array("Approved","Denied","Rescinded","Void");

$park_code_array=$parkCode;  //see get_parkcodes_i.php above
// $disposition_array=array("Surplus","Scrap","Landfill","Park Use");
// $category_array=array("Monetary","Non-Monetary","Personal Belongings");
// $sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("identifiers"=>" - Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>" - Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item, e.g., estimated value.", "description"=>" - Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

//$date_array=array("date_submit"=>"datepicker1","date_action"=>"datepicker2");
$date_array=array("date_action"=>"datepicker2");

$size_array=array("permit_year"=>"5","phone"=>"25","email"=>"25","date_submit"=>"10","date_action"=>"10","permit_number"=>"15","crs_code"=>"15");

echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Update a Group Camping Permit</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$value=$ARRAY[$fld];
	$ro="";
	if(in_array($fld, $readonly)){$ro="readonly";}
	
	echo "<tr>";
	$var_fld=$fld;
	if(in_array($fld,$magenta_array))
		{
		$var_fld="<font color='magenta'>$fld</font>";
		if($fld=="link"){$var_fld="<font color='magenta'>scanned permit</font>";}
		}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	$size=50;
	if(array_key_exists($fld, $size_array))
		{$size=$size_array[$fld];}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='$size' $ro></td>";
	
	if(in_array($fld,$drop_down))
		{
	//	if($level<2){$value=$pass_park_code;}else{$value="";}
		$select_array=${$fld."_array"};
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v==$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$radio_flds))
		{
		$select_array=${$fld."_array"};
		$line="<td>";
		foreach($select_array as $k=>$v)
			{
			if($v==$value){$ck="checked";}else{$ck="";}
			$line.="<input type='radio' name='$fld' value=\"$v\" $ck>$v";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows' $ro></textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" ".$caption[$fld];
			}
		$line.="</td>";
		}
	if($fld=="link")
		{
		$line="<td>
		<input type='file' name='file_upload'  size='20'>
		</td>";
		if(!empty($value))
			{
			$line.="<td>View <a href='$value' target='_blank'>Permit</a></td>";
			}
		}
		
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value=\"$id\">
<input type='submit' name='submit_form' value=\"Update Permit\">";
if($level>3)
	{
	echo "<input type='submit' name='submit_form' value=\"Delete Permit\" onClick=\"return confirm('Do you really want to delete this permit?')\">";
	}

echo "</td></tr>";
echo "</table>";

echo "<hr /><table>
<tr><td>
1. Enter the date you acted on this application.<br />

2. Indicate the Permit Status.<br />

3. Upload the scanned permit as a PDF.<br />

4. The CRS code will be the Permit Number unless it needs to be changed.

</td></tr>
</table>";

echo "</form></html>";

?>
