<?php

// used in dpr_labels_find.php

$sql = "SELECT affiliation_code,affiliation_name from labels_category order by affiliation_code";//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
	{
	extract($row);//print_r($row);
	if($affiliation_code=="LEDFOR"){continue;}
	$codeArray[]=$affiliation_code;
	$nameArray[]=strtoupper($affiliation_name);
	}
//print_r($codeArray);exit;

// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType

// Exclude array
//$exclude=array("id","cat_id","affiliation_code","affiliation_name",);

if(@$db_source=="donation")
	{
	$exclude=array("pac_term","pac_terminates","pac_nomin_month", "pac_nomin_year","pac_reappoint_date","pac_replacement","employer","pac_chair","pac_ex_officio","pac_nomin_comments","dist_approve");
	}
	else
	{$exclude=array();}

$sql = "SHOW COLUMNS FROM labels";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'],$exclude)){continue;}
	$fieldArray[]=$row['Field'];
	}


?>