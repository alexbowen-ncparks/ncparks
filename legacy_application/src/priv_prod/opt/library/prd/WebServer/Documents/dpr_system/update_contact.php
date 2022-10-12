<?php
ini_set('display_errors', 1);

@extract($_REQUEST);
if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

	$sql="update survey_2013 as t1,
(
select concat(contact,', ',`Name of Site`) as contact, `Physical Address`, `Zip Code`, `Phone Number` from survey_2013 where park_code = '$source_park') as t2

set t1.contact = t2.contact,
    t1.`Physical Address` = t2.`Physical Address`,
    t1.`Zip Code` = t2.`Zip Code`,
    t1.`Phone Number` = t2.`Phone Number`
where t1.park_code='$target_park'";

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

mysqli_close($connection);


header("Location: site_survey.php?park_code=$target_park");
?>