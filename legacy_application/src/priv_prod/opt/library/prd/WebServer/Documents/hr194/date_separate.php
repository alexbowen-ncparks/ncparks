<?php
session_start();
if($_SESSION['hr']['level']<1){exit;}
$level=$_SESSION['hr']['level'];
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
include("../../include/iConnect.inc"); // database connection parameters
$database="hr";
mysqli_select_db($connection,$database);
	
date_default_timezone_set('America/New_York');
extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

$user=$_SESSION['logname'];
$stamp=$user."-".date('Ymd')."S";

IF(@$date_to_separate!="")
	{
		$two_weeks_ago=date('Y-m-d', strtotime('-2 week'));
		IF($level>3)
			{
			$two_weeks_ago=$date_to_separate;
			}

		if($date_to_separate<$two_weeks_ago)
			{
			$m1="<font color='red'>No Go! Your separation date of $date_to_separate is older than two weeks ago. Only dates on or after ($two_weeks_ago) will be accepted.</font><br />Contact your HR rep for further instructions.";
		//	$m1=htmlentities($m1);
			header("Location: /hr194/upload_separation.php?parkcode=$parkcode&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num&m1=$m1&date_to_separate=$date_to_separate");
			header("Location: /hr194/upload_separation.php?parkcode=$parkcode&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num&m1=$m1&date_to_separate=$date_to_separate");
			exit;
			}
// 			
// 	echo "Separation will work.";
// 	exit;
		if(!isset($reason)){$reason="";}
		$TABLE="employ_position";
		$sql = "UPDATE $TABLE set date_to_separate='$date_to_separate', reason='$reason', track=concat(track,',', '$stamp') WHERE tempID='$tempID' AND beacon_num='$beacon_num'";
			//  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

			
	header("Location: /hr194/upload_separation.php?Lname=$Lname&date_to_separate=$date_to_separate&beacon_num=$beacon_num&tempID=$tempID&parkcode=$parkcode&reason=$reason&m=x");
	header("Location: /hr194/upload_separation.php?Lname=$Lname&date_to_separate=$date_to_separate&beacon_num=$beacon_num&tempID=$tempID&parkcode=$parkcode&reason=$reason&m=x");
	}
    
IF(@$confirm_separation=="x")
	{
		$TABLE="employ_separate";

		$sql = "INSERT into $TABLE set date_separated='$date_separated', track=concat(track,',', '$stamp'), tempID='$tempID', beacon_num='$beacon_num',  parkcode='$parkcode', comments='$comments', reason='$reason'";
		//beaconID='$beaconID',
			//  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
		$TABLE="employ_position";
		$comments=mysqli_real_escape_string($comments);
		$sql = "DELETE FROM $TABLE where tempID='$tempID' and beacon_num='$beacon_num' and date_to_separate='$date_separated'";
			//  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
	header("Location: /hr/separation.php?tempID=$tempID&varSep=separated&submit=Find");
	}
    
exit;	
?>

