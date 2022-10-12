<?php
$database="fire";
// include("../../include/connectROOT.inc"); // database connection parameters
// mysql_select_db($database,$connection);

date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'fire');

extract($_REQUEST);

//print_r($_FILES); 
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;
//exit;
if(!empty($delete))
	{	
	$sql = "SELECT * from burn_history_uploads where burn_history_file_upload_id='$delete'";
	$result = @mysqli_query($connection,$sql);
	$row=mysqli_fetch_array($result);
	extract($row); 
	$path="/opt/library/prd/WebServer/Documents/fire/";
	$file=$path.$evaluation;
	unlink($file); 
	$sql = "DELETE from burn_history_uploads where burn_history_file_upload_id='$delete'";
	$result = @mysqli_query($connection,$sql);
	header("Location: burn_history.php?park_code=$park_code&unit_id=$unit_id&history_id=$history_id");
	exit;
	}
	
	
if ($submit == "Update")
	{
	extract($_FILES);
		
// Evaluation
	$size = $_FILES['file_upload_evaluation']['size'];
	if($size>10)
		{
		$original_name = $_FILES['file_upload_evaluation']['name']; 
		$var = explode(".",$original_name);
		$ext=array_pop($var);
		$time=time();
			
		$file = $park_code."_unit_".$_REQUEST['unit_id']."_evaluation"."_".$time.".".$ext;
		
	//	echo "<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>$file"; exit;
			
		$folder="fire_evaluation"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
	//	echo "$uploadfile";exit;
		
		move_uploaded_file($_FILES['file_upload_evaluation']['tmp_name'],$uploadfile);// create file on server
		
		$evaluation_file=$uploadfile;
		
	$sql = "INSERT INTO burn_history_uploads
	set park_code='$park_code', unit_id='$unit_id', history_id='$history_id', evaluation='$evaluation_file', original_name='$original_name'";
//	  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql);
	
		}


// Update	
$acres_burned=str_replace(',','',$acres_burned);
$comments=addslashes($comments);
if(!isset($unit_history_prescription)){$unit_history_prescription="";}
if(!isset($gis_done)){$gis_done="";}

	$sql = "UPDATE burn_history
	set park_code='$park_code', unit_id='$unit_id', date_='$date_',  acres_burned='$acres_burned', unit_history_prescription='$unit_history_prescription', comments='$comments', gis_done='$gis_done', burn_type='$burn_type', latitude='$latitude', longitude='$longitude'
	WHERE history_id='$history_id'";
//	  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql);
	
	
		header("Location: burn_history.php?park_code=$park_code&unit_id=$unit_id&history_id=$history_id");
	exit;
	}
?>