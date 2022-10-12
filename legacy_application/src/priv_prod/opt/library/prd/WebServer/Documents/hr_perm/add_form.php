<?php

date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

include("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");


if(@$_POST["submit_form"]=="Add Item")
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
		echo "<pre>"; print_r($empty_array); echo "</pre>"; // exit;
		}
	}
	
mysqli_select_db($connection,$dbName);
$table="required_forms_2";
$sql = "SHOW COLUMNS FROM $table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}

echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
// Form to add an item
echo "<style>
.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
</style>";

$skip=array("id");
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_i.php above
$disposition_array=array("Surplus","Scrap","Landfill","Park Use");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("identifiers"=>" - Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>" - Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item, e.g., estimated value.", "description"=>" - Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

$date_array=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2");
// make sure jquery is being called in _base_top.php

echo "<form action='add_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Add an Item to Lost and Found</td></tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link"){$var_fld="<font color='magenta'>photo</font>";}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
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
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows'></textarea>";
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
	if($fld=="entered_by")
		{
		$val=$_SESSION[$dbName]['tempID'];
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"$val\" readonly></td>";
		}	
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='submit' name='submit_form' value=\"Add Item\">
</td></tr>";
echo "</table>";
echo "</form></html>";

?>