<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];
echo "
<style>
table.alternate tr:nth-child(odd) td{
background-color: #ffd7b3;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
</style>";
include("../../include/iConnect.inc"); // includes no_inject.php

if(@$_POST["submit_form"]=="Update")
	{
	include("display_action.php");
	}

$sql = "SELECT * FROM `display_land_assets`"; 
$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
$row=mysqli_fetch_assoc($result);
extract($row);


$ARRAY_table[0]['Tables_in_dpr_land']="land_assets";

// echo "<pre>"; print_r($ARRAY_table); echo "</pre>"; // exit;
echo "<div><form method='POST'>
<table><tr><td class='head' colspan='2'>The DPR Land database - Manage Display of Fields for a Table</td></tr>
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
<input type='hidden' name='allow_admin' value=\"1\">
</td>";

echo "</tr>
</table>
</form>
</div>";

if(empty($select_table))
	{
	exit;
	}	
mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM $select_table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
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


$table_length=strlen($select_table);

// echo "<pre>"; print_r($ARRAY_fields); echo "</pre>"; // exit;
echo "<form action='edit_display.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='4'>Indicate which Fields to display when Searching Land Assets</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	echo "<tr>";
	if(${$fld}=="Yes"){$cky="checked";$ckn="";}else{$ckn="checked";$cky="";}
	echo "<td>
	<input type='radio' name='$fld' value=\"Yes\" $cky>
	<input type='radio' name='$fld' value=\"No\" $ckn>
	</td>
	<td>$fld</td>";
	echo "</tr>";
	}
$var_select_table="display_".$select_table;
echo "<tr><td colspan='4' align='center'>
<input type='hidden' name='select_table' value=\"$var_select_table\">
<input type='submit' name='submit_form' value=\"Update\">
</td></tr>";
echo "</table>";
echo "</form>";

echo "</html>";

?>