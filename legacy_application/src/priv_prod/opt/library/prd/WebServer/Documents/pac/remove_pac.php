<?php
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);

//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;

$database="divper";
mysqli_select_db($connection,$database);

if($submit_label=="Remove as a PAC nominee")
	{
	$query = "DELETE FROM labels_affiliation where person_id='$id' AND affiliation_code='PAC_nomin'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	$sql="SELECT * from labels_affiliation where person_id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{
//		echo "none"; exit;
		$sql="DELETE from labels where id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	header("Location: add_new.php?park_code=$park_code");
	exit;
	}

if($submit_label=="Remove as a PAC member")
	{
	$query = "UPDATE ignore labels_affiliation set affiliation_code='PAC_former' where person_id='$id' AND affiliation_code='PAC'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query ");

	$query = "DELETE FROM labels_affiliation where person_id='$id' AND affiliation_code='PAC'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	header("Location: current_pac.php?park_code=$park_code");
	exit;
	}
	
if($submit_label=="Mark as PAC member")
	{
	$query = "UPDATE labels_affiliation set affiliation_code='PAC' where person_id='$id' AND affiliation_code='PAC_former'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

	header("Location: current_pac.php?park_code=$park_code");
	exit;
	}
	
if($submit_label=="Mark as PAC nominee")
	{
	$query = "UPDATE labels_affiliation set affiliation_code='PAC_nomin' where person_id='$id' AND affiliation_code='PAC'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

	header("Location: current_pac.php?park_code=$park_code");
	exit;
	}
?>