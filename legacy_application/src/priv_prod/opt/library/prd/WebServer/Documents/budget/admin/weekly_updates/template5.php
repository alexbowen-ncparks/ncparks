<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$query1="select * from budget.partf_projects where 1 limit 10 ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
while($row=mysqli_fetch_assoc($result1)){$ARRAY[]=$row;
}
echo "<pre>";print_r($ARRAY);echo "</pre>";exit;

$skip=array();
//echo "<pre>";print_r($skip);echo "</pre>";exit;

echo "<table><tr>";
foreach($ARRAY[0] as $field=>$value){
if(in_array($field,$skip)){continue;}
echo "<th>$field </th>";
}
echo "</tr>";
$query2="select * from budget20100824.partf_projects where 1 limit 10";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
while($row=mysqli_fetch_assoc($result2)){$ARRAY[]=$row;
}
//echo "<pre>";print_r($ARRAY);echo "</pre>";exit;

$skip=array();
//echo "<pre>";print_r($skip);echo "</pre>";exit;

echo "<table><tr>";
foreach($ARRAY[0] as $field=>$value){
if(in_array($field,$skip)){continue;}
echo "<th>$field </th>";
}
echo "</tr>";









echo "</table>";



?>

























