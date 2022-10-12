<?php

$sql="SELECT t1.*
from park_classification as t1
 WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_classification[]=$row;
	$park_classification_id_array[$row['park_classification_id']]=$row['classification'];
	}
	
$var_select_table="park_classification";
$var_value=$var_select_table;
// Jan did not follow normal naming scheme
$var_value="classification";  //echo "var_value $var_value<br />";
$var_array=$var_value."_array";  //echo "var_array $var_array<br />";
${$var_array}=array();  
$var_id=$var_select_table."_id"; // echo "var_id $var_id<br />";
$sql="SELECT t1.*
from $var_select_table as t1
 WHERE 1"; //ECHO "$sql<br />"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$classification_array[$row[$var_id]]=$row[$var_value];
	$classification_abbreviation_array[$row[$var_id]]=$row["classification_abbreviation"];
	}
$add_fields_array=array("classification_abbreviation");
//  echo "classification_array <pre>"; print_r($classification_array); echo "</pre>"; // exit;
//  echo "classification_abbreviation_array <pre>"; print_r($classification_abbreviation_array); echo "</pre>"; // exit;
?>