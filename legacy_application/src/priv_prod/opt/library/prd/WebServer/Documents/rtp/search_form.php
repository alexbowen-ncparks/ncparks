<?php

date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include_once("_base_top.php");
//$pass_park_code=@$_SESSION[$database]['select'];

//include("../../include/get_parkcodes_i.php");
include("../../include/iConnect.inc");

mysqli_select_db($connection,$dbName);
if(@$_POST["submit_form"]=="Search" or @$_POST["submit_form"]=="Show All")
	{
	include("search_action.php");
	if($c>0)
		{exit;}
	}
	
$sql = "SHOW COLUMNS FROM project_info";
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

$skip=array("id","link");
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_i.php above
$disposition_array=array("Surplus","Scrap","Landfill","Park Use");
$category_array=array("Monetary","Non-Monetary","Personal Belongings");
$sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$admin_array=array("disposition","category","sub_cat");

echo "<table><tr><td class='head' colspan='2'>Search the RTP Applications</td><td><form action='search_form.php' method='POST'>
<input type='hidden' name='project_file_name' value=\"rtp\">
<input type='submit' name='submit_form' value=\"Show All\">
</form></td></tr></table>";
echo "<form action='search_form.php' method='POST'>";
echo "<table>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
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
	if(in_array($fld,$drop_down))
		{
		$select_array=${$fld."_array"};
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			$s="";
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='submit' name='submit_form' value=\"Search\">
</td></tr>";
echo "</table>";
echo "</form></html>";

?>