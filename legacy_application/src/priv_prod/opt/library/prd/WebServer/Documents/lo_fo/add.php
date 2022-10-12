<?php

date_default_timezone_set('America/New_York');
$database="lo_fo"; 
$dbName="lo_fo";

include("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");

mysqli_select_db($connection,$dbName);
if(@$_POST["submit_form"]=="Add Item")
	{
	include("add_action.php");
	}
	
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
</style>";

$skip=array("id");
echo "<form action='add_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Add an Item to Lost and Found</td></tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<tr>";
	echo "<td>$fld</td>";
	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	if($fld=="park_code")
		{
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($parkCode as $k=>$v)
			{
			if($v==$pass_park_code and $level<5){$s="selected";}else{$s="";}
			$line.="<option value='$v'>$v</option>";
			}
		$line.="</select>\n";
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
</script>