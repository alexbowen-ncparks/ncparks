<?php

date_default_timezone_set('America/New_York');
$database="lo_fo"; 
$dbName="lo_fo";

include("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");

if(@$_POST["submit_form"]=="Add Item")
	{
	include("add_action.php");
	}
	
mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM items";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}

// Form to add an item
echo "<style>
.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
</style>
";

$skip=array("id","update_by");
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_i.php above
$disposition_array=array("Surplus","Scrap","Landfill","Park Use");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$textarea=array("description","identifiers","where_stored","comments");

$caption=array("identifiers"=>" - Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>" - Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item, e.g., estimated value.", "description"=>" - Please describe the item.");

$admin_array=array("disposition","category","sub_cat");

echo "<form action='add_form.php' id='lo_fo_form' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Add an Item to Lost and Found</td></tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link"){$var_fld="<font color='magenta'>photo</font>";}
	echo "<td>$var_fld</td>";
	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
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
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
    <script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("lo_fo_form");
  frmvalidator.addValidation("parkcode","req","Please enter the Park Code");
  frmvalidator.addValidation("date_found","req","Please enter the date the Item was found.");

</script>
</script>