<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection, $database);
extract($_REQUEST);

if($submit_label=="Delete")
	{
	$query = "DELETE FROM housing where id='$id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
//	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}

//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

foreach($_POST AS $fld=>$value)
	{
	$fieldArray[]=$fld;
	}

if($submit_label=="Add")
	{

	$ignore=array("id","custom","affiliation_code","affiliation_name","fac_name");

	for($i=0;$i<count($fieldArray);$i++){
	$val=${$fieldArray[$i]};// force the variable
	if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
// 	$val="'".mysqli_real_escape_string($val)."'";
	$val="'".$val."'";
	$arraySet.=",".$fieldArray[$i]."=".$val;
		}

$arraySet=trim($arraySet,",");
	
	$query = "INSERT INTO housing arraySet";
	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

	header("Location: find.php?gis_id=$gis_id&submit_label=Find");
	exit;
	}


if($submit_label=="Update" or empty($submit_label))
	{
// 	if($level>4)
// 		{
// 		echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>"; 
// 		exit;
// 		}
mysqli_select_db($connection,'divper');
$tempID=$_POST['tempID'];
if(!empty($tempID))
	{
	$sql = "SELECT Fname,Nname,Lname FROM empinfo where tempID='$tempID'";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	extract($row);
	$Fname=addslashes($Fname);
	$Nname=addslashes($Nname);
	$Lname=addslashes($Lname);
	$occupant="";
	if(empty($Nname))
		{$occupant.=$Fname." ".$Lname;}
		else
		{$occupant.=$Fname." (".$Nname.") ".$Lname;}
	
		$pass_occupant=$occupant;
		}
		else
		{$pass_occupant="";}
	//	echo "$sql<pre>"; print_r($_REQUEST); print_r($_POST); echo "</pre>$Fname $Nname $Lname";  exit;
		// ****** Create Array of couplets for Insert/Update **********


	mysqli_select_db($connection,'facilities');
$ignore=array("occupant","submit_label","attachment_num","status", "housing_gis_id", "file_id", "housing_agreement","spo_comment","fac_name");
	// spo_comment goes into spo_dpr_comments    "comment", 

	extract($_POST);

//  	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;	
foreach($_POST AS $fld=>$val)
	{
	if($fld=="gis_id")
		{
		$fld_gis_id="gis_id='".$val."'";
		continue;
		}
	if(in_array($fld,$ignore)){continue;}
	$val=trim($val,"\r\n");
	$val=trim($val," ");
	if($fld=="park"){$val=strtoupper($val);}
	
// 	$val="'".mysqli_real_escape_string($connection,$val)."'";
	$val="'".$val."'";
	$arraySet.=",`".$fld."`=".$val;
	}
	$arraySet=trim($arraySet,",");
// 	$pass_occupant=mysqli_real_escape_string($connection,$pass_occupant);
	$arraySet.=",occupant='$pass_occupant'";

//echo "$arraySet"; exit;


mysqli_select_db($database,$connection);	

	if(is_array($_POST['file_id']))
		{
		extract($_POST['file_id']);
		$gis_id=$_POST['gis_id'];
		foreach($file_id as $k=>$v)
			{
			$query = "UPDATE `housing_attachment` SET housing_agreement='' where file_id='$v' and gis_id='$gis_id'";
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
			}
		}
	if(is_array($housing_agreement))
		{
		extract($_POST['housing_agreement']);
		$gis_id=$_POST['gis_id'];
		foreach($housing_agreement as $k=>$v)
			{
			$query = "UPDATE `housing_attachment` SET housing_agreement='x' where file_id='$k' and gis_id='$gis_id'";
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
		}
		
	$query = "UPDATE housing SET $arraySet where gis_id='$gis_id'";
//	echo "$query";   // exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
//	$affect=mysqli_affected_rows($connection);
	
	$query = "UPDATE spo_dpr_comments SET `comment`='$spo_comment' where gis_id='$gis_id'";
//	echo "$query";    exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
	if($affect<1)
		{
		$query = "REPLACE housing SET $arraySet, $fld_gis_id";
//	echo "<br /><br />$query";   exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
		$affect=mysqli_affected_rows($connection);
		$query = "UPDATE spo_dpr_comments SET `comment`='$spo_comment' where gis_id='$gis_id'";
	//	echo "$query";    exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
		}
//	echo "$affect updated";
//	echo "<br /><br />$query";   
//exit;	
	include("file_upload.php");
	
	header("Location: edit.php?gis_id=$gis_id");
	}


?>