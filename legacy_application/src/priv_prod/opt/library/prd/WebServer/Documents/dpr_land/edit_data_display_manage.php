<?php
$database="dpr_land"; 
$dbName="dpr_land";

include("../../include/iConnect.inc"); // includes no_inject.php

mysqli_select_db($connection,$dbName);
$sql = "SELECT * FROM $select_table limit 1";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row;
	}
//    echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";  //exit;

$rev_array=array_reverse($ARRAY_fields[0]);
//echo "<pre>"; print_r($rev_array); echo "</pre>";  exit;

foreach($rev_array as $fld=>$value)
	{
	$sql = "REPLACE edit_data_display set `select_table`='$select_table', field_name='$fld', show_field='No'"; //echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}

header("Location: edit_data_display.php?message=Update complete. Click the item.");

?>