<?php

echo "<pre>"; print_r($_FILES); echo "</pre>";  //exit;
//extract($_REQUEST);
echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');
//echo "<table>";

$passYear=date('Y'); // used to create file storage folder hierarchy

if(!empty($_FILES['file_upload']['tmp_name']))
	{
	
	include("../../include/iConnect.inc");
	$database="facilities";

	mysqli_select_db($connection,"facilities"); // database

	$gis_id=$_POST['gis_id'];
	// ********** ACTION
	// includes deletion of previous file since a timestamp is used to get around browser cacheing 
	$num=count($_FILES['file_upload']['tmp_name']);

	// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

	for($i=0;$i<$num;$i++)
		{
		$temp_name=$_FILES['file_upload']['tmp_name'][$i];
		if($temp_name==""){continue;}

		if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i])){exit;}

		$original_file_name = $_FILES['file_upload']['name'][$i];
		$exp=explode(".",$original_file_name);
		$ext=array_pop($exp);

		$original_file_name = str_replace("/", "_", $original_file_name);
		$original_file_name = str_replace("'", "_", $original_file_name);
		$original_file_name = str_replace("\"", "_", $original_file_name);
		$original_file_name = str_replace(":", "_", $original_file_name);
		$original_file_name = str_replace(" ", "_", $original_file_name);
		
		// if(!empty($existing_map))
		// 	{
		// 	unlink($existing_map);
		// 	}

		$uploaddir = "uploads/facility_report/"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$sub_folder=$uploaddir."/".date("Y");
		if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}

		$ts=time();
		$file_name=$gis_id."_".$ts.".".$ext;
// echo "fn=$original_file_name<br />"; 
// echo "f=$file_name"; exit;
		$uploadfile = $sub_folder."/".$file_name;
// echo "$uploadfile"; exit;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
// 		chmod($uploadfile,0777);

		$sql="INSERT INTO facility_attachment set gis_id='$gis_id', file_name='$original_file_name', link='$uploadfile'"; 
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
		echo "$sql"; exit;
		}
	}

// *********** Display ***********
if(!isset($limit_park)){$limit_park="";}
$sql="Select gis_id, file_id, link, title  
From `facility_attachment` 
where 1 AND gis_id='$gis_id' $limit_park";
//  echo "$sql";
$result = @MYSQLI_QUERY($connection,$sql);
$j=1;

echo "<table border='1'>";
if($result)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
			if($row['link']!="")
				{
				$link="$j: <a href='$link' target='_blank'>$title</a>";
				if($j==1){$da="Facility Attachment";}else{$da="";}
				echo "<tr><td>$da</td><td align='left'>$link</td>";
				echo "<td>
				<input type='hidden' name='file_id[$file_id]' value='$file_id'></td>";
if($level>1 or ($park_abbr==$_SESSION['facilities']['select']))
	{
	echo "<td><a href='delete_facility_attachment.php?pass_id=$file_id&gis_id=$gis_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td>";
	}
echo "</tr>";
				$j++;
				}
		}
	}
		
$forms_array=array("inspection_report"=>"Inspection Report must be a <font color='red'>Word .doc or .docx</font>");
		
		$form_name=$forms_array['inspection_report'];
		echo "<tr>
		<td colspan='5'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='hidden' name='gis_id' value='$gis_id'>
		<input type='hidden' name='fac_type' value='$fac_type'>
		<input type='file' name='file_upload[]'  size='40'>
		<input type='submit' name='submit_report' value=\"Upload Doc\">
		</td>";
$to="jerry.howerton@ncparks.gov";
$to.=";adrian.oneal@ncparks.gov";
$to.=";derrick.evans@ncparks.gov";
// $to.=";cara.hadfield@ncparks.gov";
//$to.=";maria.cucurullo@ncparks.gov";
$subject="Facility Report for $gis_id";
$body="";
$email="<a href=\"mailto:$to?Subject=$subject\">Email Interested Parties</a>";	
echo "<td>$email</td>";

		echo "</tr>";
	
//echo "</table>";

?>