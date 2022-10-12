<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);
mysqli_select_db($connection,$database);

if($submit_label=="Delete"){
	$query = "DELETE FROM labels where id='$pass_id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
	
	$query = "DELETE FROM labels_affiliation where person_id='$pass_id'";
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: dpr_labels_find.php?message=Previous record deleted.");
	exit;
	}

//echo "update <pre>"; print_r($_REQUEST); echo "</pre>";  exit;

if($submit_label=="Add" or $submit_label=="Add a Donor")
	{
	mysqli_select_db($connection,"divper");
	$ignore=array("db_source","submit_label");
	$check_value=array("Last_name","donor_organization","donor_type");
	IF(isset($_GET)){$_POST=$_GET;}
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$check_value) AND $val=="")
			{
			if($fld=="Last_name" OR $fld=="donor_organization")
				{
				if($_POST['Last_name']=="" and $_POST['donor_organization']=="")
					{
					$set_error[]=$fld;
					continue;
					}
				}
				else
				{
				$set_error[]=$fld;
				}
			}
		if(in_array($fld,$ignore) OR $val==""){continue;}
		$val="'".$val."'";
		@$arraySet.=",".$fld."=".$val;
		}
	if(!empty($set_error))
		{		
		echo "<table><tr><td>Missing Values - You must designate at lease some of these: </td></tr>";
		foreach($set_error as $fld=>$value)
			{
			echo "<tr><td align='right'><font color='red'>$value</font></td></tr>";
			}
		echo "<tr><td>Click your browser's back button.</td></tr></table>";
		exit;
		}
		
	$arraySet=trim($arraySet,",");
	$query = "INSERT INTO labels set $arraySet";
//		echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
	$person_id=mysqli_insert_id($connection);
	$query = "INSERT INTO labels_affiliation set person_id='$person_id', affiliation_code='DONOR'";
	//	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: /donation/form.php?id=$person_id");
	exit;
	}


if($submit_label=="Update")
	{
//	echo "<pre>"; print_r($_REQUEST); print_r($_POST); echo "</pre>";  exit;
	// ****** Create Array of couplets for Insert/Update **********
	
	$ignore=array("pass_id","add_cat","submit_label","db_source","contact","donate","source_db");
	$check_value=array("Last_name","donor_organization","donor_type");
	$arraySet="";

	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$check_value) AND $val=="")
			{
			if($fld=="Last_name" OR $fld=="donor_organization")
				{
				if($_POST['Last_name']=="" and $_POST['donor_organization']=="")
					{
					$set_error[]=$fld;
					continue;
					}
				}
				else
				{
				$set_error[]=$fld;
				}
			}
		if(in_array($fld,$ignore)){continue;}
		$val="'".$val."'";
		if($fld=="park"){$val=strtoupper($val);}
		$arraySet.=$fld."=$val,";
		}
	if(!empty($set_error))
		{		
		echo "<table><tr><td>Missing Values - You must designate at lease some of these: </td></tr>";
		foreach($set_error as $fld=>$value)
			{
			echo "<tr><td align='right'><font color='red'>$value</font></td></tr>";
			}
		echo "<tr><td>Click your browser's back button.</td></tr></table>";
		exit;
		}
	$arraySet=trim($arraySet,",");
	
	$query = "UPDATE labels SET $arraySet where id='$pass_id'";
//	echo "$query";   exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	if($_REQUEST['add_cat'][0]=="DONOR")
		{
		$query = "SELECT * from labels_affiliation where person_id='$pass_id' and affiliation_code='DONOR'";
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		$num=mysqli_num_rows($result);
		if($num<1)
			{
			$query = "INSERT into labels_affiliation SET person_id='$pass_id', affiliation_code='DONOR'";
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
		}
//exit;

	}
	header("Location: form.php?id=$pass_id&submit_label=Find");


?>