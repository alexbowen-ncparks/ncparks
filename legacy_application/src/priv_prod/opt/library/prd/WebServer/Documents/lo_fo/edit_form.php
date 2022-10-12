<?php

date_default_timezone_set('America/New_York');
$database="lo_fo"; 
$dbName="lo_fo";

include("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include("../../include/get_parkcodes_reg.php");
// include("../../include/iConnect.inc");

if(@$_POST["submit_form"]=="Update")
	{
	include("edit_action.php");
	}
if(@$_POST["submit_form"]=="Delete Item")
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
$sql = "SHOW COLUMNS FROM items";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}
	
$sql="SELECT t1.*, t2.link 
from items as t1
left join file_upload as t2 on t1.id=t2.track_id
 WHERE t1.id='$id'"; 
//  ECHO "$sql"; //exit;
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
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_i.php above
$disposition_array=array("Surplus","Scrap","Landfill","Park Use","Returned to Owner");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit/Debit Card", "Checkbook", "Traveler's Check");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("identifiers"=>"Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>"Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item.", "description"=>"Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Update an Item in Lost and Found</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$value=$ARRAY[$fld];
	echo "<tr>";
	echo "<td>$fld</td>";
	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\"></td>";
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
	
	if($fld=="update_by")
		{
		$val=$_SESSION['lo_fo']['tempID'];
		$value=$val."_".date("Y-m-d H:i:s")." | ".$value;
		$line="<td><textarea name='$fld' cols='50' rows='2' readonly>$value</textarea></td>";
		}	
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value=\"$id\">
<input type='submit' name='submit_form' value=\"Update\">
</td>
<td><input type='submit' name='submit_form' value=\"Delete Item\" onclick=\"return confirm('Are you sure you want to delete the item?')\"></td>
</tr>";
echo "</table>";
echo "</form></html>";

?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
</script>