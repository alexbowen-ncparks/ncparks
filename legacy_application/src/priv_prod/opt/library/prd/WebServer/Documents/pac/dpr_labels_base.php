<?php

// used in dpr_labels_find.php
// see database divper for associated tables
// database is NOT 'pac'

$sql = "SELECT affiliation_code,affiliation_name from labels_category order by affiliation_code";//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//$numFlds=mysqli_num_rows($result);

$include=array("PAC","PAC_FORMER","PAC_nomin");
while ($row=mysqli_fetch_assoc($result))
	{
	extract($row);//print_r($row);
	if(!in_array($affiliation_code,$include)){continue;}
	$codeArray[]=$affiliation_code;
	$nameArray[]=strtoupper($affiliation_name);
	}
//print_r($codeArray);exit;

// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType

// Exclude array
//$exclude=array("id","cat_id","affiliation_code","affiliation_name",);

$sql = "SHOW COLUMNS FROM labels";//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
	{
	$fieldArray[]=$row['Field'];
	}


?>