<?php
//These are placed outside of the webserver directory for security
//include("../../include/authDIVPER.inc"); // used to authenticate users
$database="facilities";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 

extract($_REQUEST);

if($submit_label=="Delete")
	{
	$query = "DELETE FROM housing where id='$id'";
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
//	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}


$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$numFlds=mysql_num_rows($result);
while ($row=mysql_fetch_assoc($result))
	{
	$fieldArray[]=$row['Field'];
	}

if($submit_label=="Add")
	{

	$ignore=array("id","custom","affiliation_code","affiliation_name");

	for($i=0;$i<count($fieldArray);$i++)
		{
		$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
// 		$val="'".mysql_real_escape_string($val)."'";
		$val="'".$val."'";
		$arraySet.=",".$fieldArray[$i]."=".$val;
		}

$arraySet=trim($arraySet,",");
	
	$query = "INSERT INTO housing arraySet";
	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");

	header("Location: find.php?id=$id&submit_label=Find");
	exit;
	}


if($submit_label=="Update")
	{
	$query = "UPDATE housing SET GIS_ID='$GIS_ID' where id='$z_id'";
//	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
	header("Location: edit.php?id=$z_id");
	}


?>