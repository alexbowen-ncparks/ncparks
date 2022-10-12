<?php

ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database

extract($_GET);
$table=str_replace("_link","_upload",$form);
if($table=="form_19_upload")
	{$table="form19_upload";}
	else
	{$table="form_".$table;}
	
if($table=="form_emp_statement_upload")
	{$table="form_employee_statement_upload";}
if($table=="form_wit_statement_upload")
	{$table="form_witness_statement_upload";}
	
$sql="SELECT file_link from $table
	where wc_id='$wc_id'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
foreach($ARRAY as $index=>$array)
	{
	extract($array);
	$file="/opt/library/prd/WebServer/Documents/work_comp/".$file_link;
	// echo "$file"; exit;
	unlink($file);
	$sql="DELETE from $table
	where wc_id='$wc_id'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
	}
echo "That form was deleted. You may close this tab.";
?>