<?php

date_default_timezone_set('America/New_York');
$permit_year=date("Y");
$database="climb"; 
$dbName="climb";

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

//include("../../include/get_parkcodes_i.php");
$parkCode=array("CHRO","CRMO","HARO","PIMO","STMO");
include("../../include/iConnect.inc");

if(@$_POST["submit_form"]=="Create Permit")
	{
	include("add_action.php");
	if(!empty($ci_num))
		{
		$id=$ci_num;
		include("edit_form.php");
		exit;
		}
	if(!empty($empty_array))
		{
		echo "<table><tr><td>These fields must not be empty.</td></tr>";
		foreach($empty_array as $k=>$v)
			{
			echo "<tr><th>$v</th></tr>";
			}
		echo "</table>";
		}
	}
	
mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM permit";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}

$sql = "SELECT * FROM permit order by id desc limit 1";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
if(mysqli_num_rows($result)<1)
	{
	$var_permit_number="GCP_".$permit_year."_".str_pad(1, 4, 0, STR_PAD_LEFT);
	}
	else
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$var_id=$row['id']+1;
		$var_permit_number="GCP_".$permit_year."_".str_pad($var_id, 4, 0, STR_PAD_LEFT);
		}
	}

// Form to add an item
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";

$skip=array("id","link","date_action","permit_status","crs_code");
$readonly=array("permit_number");
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

$date_array=array("date_submit"=>"datepicker1","date_action"=>"datepicker2");
$size_array=array("permit_year"=>"5","phone"=>"25","email"=>"25","date_submit"=>"10","date_action"=>"10","permit_number"=>"15","crs_code"=>"15");

echo "<form action='add_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Create a Group Climbing Permit</td></tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$ro="";
	if(in_array($fld, $readonly)){$ro="readonly";}
	
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link"){$var_fld="<font color='magenta'>scanned permit</font>";}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	$value="";
	if($fld=="permit_number"){$value=$var_permit_number;}
	if($fld=="permit_year"){$value=$permit_year;}
	
	$size=50;
	if(array_key_exists($fld, $size_array))
		{$size=$size_array[$fld];}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='$size' $ro></td>";
	
	if(in_array($fld,$drop_down))
		{
		if($level<2){$value=$pass_park_code;}else{$value="";}
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
		}
		
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='submit' name='submit_form' value=\"Create Permit\">
</td></tr>";
echo "</table>";

echo "<hr /><table>
<tr><td>
1. Have the applicant complete a Group Climbing Permit form.<br />

2. Enter the applicant information into this form.<br />

3. Other instructions/comments can go here.
</td></tr>
</table>";

echo "</form></html>";

?>
