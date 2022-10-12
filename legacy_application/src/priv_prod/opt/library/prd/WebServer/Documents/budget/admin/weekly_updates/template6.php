<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


echo "<br />";


$query1="select * from budget.partf_projects where 1 limit 10";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
while($row1=mysqli_fetch_assoc($result1)){$ARRAY1[]=$row1;
}

$query2="select * from budget20100817.partf_projects where 1 limit 10";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
while($row2=mysqli_fetch_assoc($result2)){$ARRAY2[]=$row2;
}

//echo "<pre>";print_r($ARRAY);echo "</pre>";exit;

$skip1=array();
$skip2=array();
//echo "<pre>";print_r($skip);echo "</pre>";exit;

echo "<table>";
echo "<tr>";
foreach($ARRAY2[0] as $field2=>$value2){
if(in_array($field2,$skip2)){continue;}
echo "<td>$field2</td>";}
echo "</tr>";
foreach($ARRAY1[0] as $field1=>$value1){
if(in_array($field1,$skip1)){continue;}
echo "<td>$field1</td>";}
echo "</tr>";
echo "</table>";
?>

























