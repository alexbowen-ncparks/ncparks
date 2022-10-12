<?php

$database="hr";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');

//echo "c=$connection";exit;

extract($_REQUEST);

$TABLE="employ_position";
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$user=$_SESSION['logname'];
$stamp=$user."-".date('Ymd')."A";

$sql = "UPDATE $TABLE set date_approve='$date_approve', track=concat(track,',', '$stamp')  where tempID='$tempID' and beacon_num='$beacon_num' and parkcode='$parkcode'";
//  echo "$sql";exit;
$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
    mysqli_CLOSE($connection);
/*
	header("Location: upload_forms.php?parkcode=$parkcode&tempID=$tempID&beacon_num=$beacon_num&process_num=$process_num&date_approve=$date_approve");
*/
header("Location: /hr/new_hire.php?Lname=$Lname&submit=Find");
exit;	
?>

