<?php
// echo "hello1"; exit;
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];

echo "<style>
.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
</style>";

include("../../include/get_parkcodes_i.php"); // include iConnect.inc with includes no_inject.php

mysqli_select_db($connection,$dbName);

$sql = "SHOW TABLES FROM $dbName"; 
$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_table[]=$row;
	}
// echo "<pre>"; print_r($ARRAY_table); echo "</pre>"; // exit;
echo "<div><form method='POST'>
<table><tr><td class='head' colspan='2'>Search the DPR Land database</td></tr>
<tr><td>Select a table: 
<select name='select_table' onChange=\"this.form.submit();\"><option value='' selected></option>\n";
foreach($ARRAY_table as $index=>$array)
	{
	foreach($array as $k=>$v)
		{
		if(substr($v,0,8)=="display_" and empty($allow_admin)){continue;}
		echo "<option value='$v'>$v</option>\n";
		}
	}
echo "</select>
</td>";
if(!empty($select_table))
	{
	echo "<td>Click \"Search\" without entering any criterion for all records in the <b>$select_table</b> table.</td>";
	}

echo "</tr>
</table>
<hr />
</form>
</div>";

if(@$_POST["submit_form"]=="Search")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	extract($_POST);
	include("search_action.php");
	if($c>0)
		{exit;}
	}

if(empty($select_table))
	{
	exit;
	}

// **********
$dropdown_file="values_".$select_table.".php";
include($dropdown_file);  // get values for various dropdowns

	
$sql = "SHOW COLUMNS FROM $select_table";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}


$skip=array();
$table_length=strlen($select_table);

include("form_arrays.php");

echo "<form action='search_form.php' method='POST'>";
echo "<table>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
//	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$ck_field=substr($fld,0,$table_length)."_id";
	if($fld==$ck_field){continue;}
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	echo "<tr>";
	echo "<td>$fld</td>";
//	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	
	
if(in_array($fld,$drop_down))
		{
		$select_array=${$fld."_array"};
// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if(@${$fld}===$k){$s="selected";}else{$s="";}
			$val=$k;
			if(in_array($fld,$flip_key)){$val=$k;}
			$line.="<option value='$val' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Search\"></td>";
echo "</tr>";
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