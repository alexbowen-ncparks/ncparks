<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // database connection parameters
mysql_select_db($database,$connection);
extract($_REQUEST);

if($submit_label=="Delete")
	{
	$query = "DELETE FROM housing where gis_id='$gis_id'";
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
//	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}


$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());
$numFlds=mysql_num_rows($result);
while ($row=mysql_fetch_assoc($result))
	{
	$fieldArray[]=$row['Field'];
	}

if($submit_label=="Add")
	{

	$ignore=array("id","custom","affiliation_code","affiliation_name");

	for($i=0;$i<count($fieldArray);$i++){
	$val=${$fieldArray[$i]};// force the variable
	if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
	$val="'".mysql_real_escape_string($val)."'";
	$arraySet.=",".$fieldArray[$i]."=".$val;
		}

$arraySet=trim($arraySet,",");
	
	$query = "INSERT INTO housing arraySet";
	echo "Contact Tom. This has not been tested. $query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");

	header("Location: find.php?id=$id&submit_label=Find");
	exit;
	}


if($submit_label=="Update")
	{

mysql_select_db('divper',$connection);
$tempID=$_POST['tempID'];
$sql = "SELECT Fname,Lname FROM empinfo where tempID='$tempID'";//echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());
$row=mysql_fetch_assoc($result);
extract($row);
$occupant="$Fname $Lname";

//	echo "<pre>"; print_r($_REQUEST); print_r($_POST); echo "</pre>";  exit;
	// ****** Create Array of couplets for Insert/Update **********
	
$ignore=array("id","custom","affiliation_code","affiliation_name","file_link","occupant");

	
	for($i=0;$i<count($fieldArray);$i++)
		{
		$val=${$fieldArray[$i]};// force the variable
		//if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		if(in_array($fieldArray[$i],$ignore)){continue;}
		$val=trim($val,"\r\n");
		$val=trim($val," ");
		if($fieldArray[$i]=="park"){$val=strtoupper($val);}
		
		$val="'".mysql_real_escape_string($val)."'";
		$arraySet.=",`".$fieldArray[$i]."`=".$val;
		}
	

mysql_select_db($database,$connection);	
// SET $arraySet
$comment=mysql_real_escape_string($comment);
	$query = "REPLACE spo_dpr_comments SET comment='$comment', gis_id='$gis_id'";
//	echo "$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	
	if(is_array($file_id))
		{
		foreach($file_id as $k=>$v)
			{
			$query = "UPDATE `housing_attachment` SET housing_agreement='' where file_id='$v' and gis_id='$gis_id'";
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			}
		}
	if(is_array($housing_agreement))
		{
		foreach($housing_agreement as $k=>$v)
			{
			$query = "UPDATE `housing_attachment` SET housing_agreement='x' where file_id='$k' and gis_id='$gis_id'";
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			}
		}
		
	include("file_upload.php");
	
	header("Location: edit_fac.php?gis_id=$gis_id");
	}


?>