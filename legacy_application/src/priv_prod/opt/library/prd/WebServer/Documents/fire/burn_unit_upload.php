<?php
$database="fire";
// include("../../include/connectROOT.inc"); // database connection parameters
// mysql_select_db($database,$connection);

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'fire');

date_default_timezone_set('America/New_York');

extract($_REQUEST);

// echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;

if (!empty($del_rx))
	{
	$exp=explode(".",$del_rx);
	$sql = "SELECT * from prescriptions where unit_id='$exp[0]' and id='$exp[1]'";  //echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);
	
//	$unit_prescription="fire_prescription/2013/CABE_38_prescription_2013-03-22_16:41:32.txt";
	$sql = "DELETE FROM prescriptions where unit_id='$exp[0]' and id='$exp[1]'";
//	  echo "$unit_prescription<br />$sql"; //exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	unlink($unit_prescription);
	
		header("Location: units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}
	
if (!empty($del_map))
	{
	$exp=explode(".",$del_map);
	$sql = "SELECT * from maps where unit_id='$exp[0]' and id='$exp[1]'";  //echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);
	
	$sql = "DELETE FROM maps where unit_id='$unit_id' and id='$id'";
//	  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	unlink($unit_map);
	
		header("Location: units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}
	
// added th_20220226
if (!empty($del_action_review))
	{
	$exp=explode(".",$del_action_review);
	$sql = "SELECT * from after_action where unit_id='$exp[0]' and id='$exp[1]'";  //echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); extract($row);

	$sql = "DELETE FROM after_action where unit_id='$exp[0]' and id='$exp[1]'";
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	unlink($action_review_link);
	
		header("Location: units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}
	
if ($submit == "Update")
	{
	extract($_FILES);
	$size = $_FILES['file_upload_prescription']['size'];
		
	if($size>10)
		{
		$type = $_FILES['file_upload_prescription']['type']; 
		$file_name = $_FILES['file_upload_prescription']['name'];
		$exp=explode(".",$file_name);
		$ext=array_pop($exp);
		
		$file_name=str_replace(" ","_",$file_name);
		$file_name=str_replace("?","_",$file_name);
		$file_name=str_replace("'","",$file_name)." at ".formatSizeUnits($size);
		
		$var = explode("/",$type);
		
		$time=date("Y-m-d H:i:s");
		$timestamp=str_replace(" ","_",$time);
		$file = $park_code."_".$_REQUEST['unit_id']."_prescription_".$timestamp.".".$ext;
//		$remove_file = $file;
		
//		echo "$file<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
		
		if(!is_uploaded_file($_FILES['file_upload_prescription']['tmp_name']))
			{
			print_r($_FILES);  print_r($_REQUEST);
			exit;
			}
		
		
		$folder="fire_prescription"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
//		echo "$uploadfile";exit;
		
//		$delete_file=$folder."/".$remove_file;
//		unlink($delete_file);
		
		move_uploaded_file($_FILES['file_upload_prescription']['tmp_name'],$uploadfile);// create file on server
		$rx="unit_prescription='$uploadfile', file_name='$file_name'";
		}
		else
		{
		$rx="";
		$rx_url_flds="rx_link='$rx_link'";
		}


// Unit Map
	$size = $_FILES['file_upload_unit_map']['size'];
	if($size>0)
		{
		$type = $_FILES['file_upload_unit_map']['type']; 
		$file_name = $_FILES['file_upload_unit_map']['name']; 
		$exp=explode(".",$file_name);
		$ext=array_pop($exp);
		
		$file_name=str_replace(" ","_",$file_name);
		$file_name=str_replace("?","_",$file_name);
		$file_name=str_replace("'","",$file_name)." at ".formatSizeUnits($size);
		
		$time=date("Y-m-d H:i:s");
		$timestamp=str_replace(" ","_",$time);
		$file = $park_code."_".$_REQUEST['unit_id']."_map_".$timestamp.".".$ext;
//		$remove_file = $file;
		
//		echo "$file<pre>";print_r($_FILES); print_r($_REQUEST);echo "</pre>"; exit;
		
		if(!is_uploaded_file($_FILES['file_upload_unit_map']['tmp_name']))
			{
			print_r($_FILES);  print_r($_REQUEST);
			exit;
			}
		
		$map_annotate=$_REQUEST[''];
		$folder="fire_unit_map"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
//		echo "$uploadfile";exit;
		
//		$delete_file=$folder."/".$remove_file;
//		unlink($delete_file);
		
		move_uploaded_file($_FILES['file_upload_unit_map']['tmp_name'],$uploadfile);// create file on server
		$map_flds="unit_map='$uploadfile', map_annotate='$map_annotate', map_name='$file_name'";
		}
		else
		{
		$map_flds="";
		$map_url_flds="map_annotate='$map_annotate'";
		}

// Unit Action Review
// added th_20220226
	$size = $_FILES['file_upload_action_review']['size'];
	if($size>0)
		{
		$type = $_FILES['file_upload_action_review']['type']; 
		$file_name = $_FILES['file_upload_action_review']['name']; 
		$exp=explode(".",$file_name);
		$ext=array_pop($exp);
		
		$file_name=str_replace(" ","_",$file_name);
		$file_name=str_replace("?","_",$file_name);
		$file_name=str_replace("'","",$file_name)." at ".formatSizeUnits($size);
		
		$time=date("Y-m-d H:i:s");
		$timestamp=str_replace(" ","_",$time);
		$file = $park_code."_".$_REQUEST['unit_id']."_action_review_".$timestamp.".".$ext;
		
		if(!is_uploaded_file($_FILES['file_upload_action_review']['tmp_name']))
			{
			print_r($_FILES);  print_r($_REQUEST);
			exit;
			}
		
		$folder="fire_action_review"; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$year=date('Y');
		$folder.="/".$year; //make sure www has r/w permissions on this folder
		if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$uploadfile = $folder."/".$file;
		move_uploaded_file($_FILES['file_upload_action_review']['tmp_name'],$uploadfile);// create file on server
		$action_review_flds="action_review_title='$file_name', action_review_link='$uploadfile'";
		}
		else
		{
		$action_review_flds="";
		}



// Update	
$acres=str_replace(',','',$acres);
$fireline=str_replace(',','',$fireline);
// $unit_name=addslashes($unit_name);
// $comments=addslashes($comments);
if(isset($map_annotate))
	{
	foreach($map_annotate as $k=>$v)
		{
		@$annotate.=$k."=".$v."`";
		}
	}
if(!isset($unit_prescription)){$unit_prescription="";}
if(!isset($annotate)){$annotate="";}
	$sql = "UPDATE units
	set unit_name='$unit_name', acres='$acres', comments='$comments' where unit_id='$unit_id'";//	  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	if(!empty($rx))
		{
		$sql = "INSERT INTO prescriptions
		set unit_id='$unit_id', park_code='$park_code', $rx";
	//	  echo "$sql";exit;
		$result = @mysqli_query( $connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
		
	if(!empty($map_flds))
		{
		$sql = "INSERT INTO maps
		set unit_id='$unit_id', park_code='$park_code', $map_flds";
	//	  echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}

// added th_20220226		
	if(!empty($action_review_flds))
		{
		$sql = "INSERT INTO after_action
		set unit_id='$unit_id', park_code='$park_code', $action_review_flds";
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
		
	if(!empty($rx_url_flds))
		{
		$sql = "SELECT unit_id from prescriptions where unit_id='$unit_id'";
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		if(mysqli_num_rows($result)>0)
			{
			$sql = "UPDATE prescriptions
			set $rx_url_flds where unit_id='$unit_id'";
			}
			else
			{
			$sql = "INSERT INTO prescriptions
			set $rx_url_flds, unit_id='$unit_id',park_code='$park_code'";
			}
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	if(!empty($map_url_flds))
		{
		$sql = "SELECT unit_id from maps where unit_id='$unit_id'";
		$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		if(mysqli_num_rows($result)>0)
			{
			$sql = "UPDATE maps
			set $map_url_flds where unit_id='$unit_id'";
			}
			else
			{
			$sql = "INSERT INTO maps
			set $map_url_flds, unit_id='$unit_id',park_code='$park_code'";
			}
		$result = @mysqli_query($connection,$sql) or die("c=$connection $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
		
	header("Location: units.php?park_code=$park_code&unit_id=$unit_id");
	exit;
	}
	
function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
?>