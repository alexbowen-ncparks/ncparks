<?php
ini_set('display_errors',1);
$database="photo_point";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection, $database);

date_default_timezone_set('America/New_York');

extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;
//exit;

if (!empty($unit_id))
	{
	$sql = "SELECT * FROM photo_point where unit_id='$unit_id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}
		
		// delete all photos and thumbnails
	$sql = "SELECT * FROM pp_photos where unit_id='$unit_id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		if(!empty($photo_link))
			{
			unlink($photo_link);
				$exp=explode("/",$photo_link);
				$tn=array_pop($exp);
				$tn_link=implode("/",$exp)."/ztn.".$tn;
				unlink($tn_link);
			}
		}
		$sql = "DELETE FROM pp_photos where unit_id='$unit_id'";
//		echo "$sql"; exit;
		$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	// delete all associated files
	$sql = "SELECT * FROM pp_files where unit_id='$unit_id'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		if(!empty($file_link))
			{
			unlink($file_link);
			}
		}
		$sql = "DELETE FROM pp_files where unit_id='$unit_id'";
//		echo "$sql"; exit;
		$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
	$sql = "DELETE from photo_point where unit_id='$unit_id'"; //echo "$sql";exit;
		$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
header("Location: pp_units.php");

?>