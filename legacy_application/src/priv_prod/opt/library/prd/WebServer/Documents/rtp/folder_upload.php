<?php
/**
 * Directory/Folder upload
 * @author kiash
 * @link http://www.w3bees.com/2013/03/directory-upload-using-html-5-and-php.html
 */
 
 // modified by Tom Howard

if(empty($_SESSION))
	{
	session_start();
	}
if(empty($_SESSION['rtp']['set_cycle'])){echo "Contact Tom Howard."; exit;}
 
// echo "<pre>";  print_r($_SESSION); print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
$database="rtp"; 
$dbName="rtp";

include("../../include/iConnect.inc");

$var_table=$var;
$project_file_name=$_POST['project_file_name'];
mysqli_select_db($connection,$dbName);

date_default_timezone_set('America/New_York');
//$year=date("Y");
$year=substr($project_file_name,0,4); //echo "$project_file_name y=$year"; exit;
$count = 0;

	if($_SESSION['rtp']['set_cycle']=="pa"){$upload_dir="uploads_pa";}
	if($_SESSION['rtp']['set_cycle']=="fa"){$upload_dir="uploads";}
	
$upload_folder=$upload_dir."/".$year;  //echo "$upload_folder"; exit;
		if (!file_exists($upload_folder))
			{mkdir ($upload_folder, 0777);chmod($upload_folder,0777);}

$upload_folder=$upload_dir."/".$year."/".$project_file_name;  //echo "$upload_folder"; exit;
		if (!file_exists($upload_folder))
			{mkdir ($upload_folder, 0777);chmod($upload_folder,0777);}
						
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach ($_FILES['files']['name'] as $i => $name) {
        if ($_FILES['files']['error'][$i] == 0) {
        if($name==".DS_Store")
        	{continue;}
        $name=str_replace(" ","_",$name);
        $name=str_replace("'","",$name);
        $name=str_replace("\"","",$name);
        $name=str_replace("/","_",$name);
        
        
	$e=explode(".",$_FILES['files']['name'][$i]); //echo "<pre>"; print_r($e); echo "</pre>";  exit;
	$ext=array_pop($e);
	
	$form_name=$project_file_name."_".$i."_".time();
	$file_name = $form_name.".".$ext;
	$uploadfile=$upload_folder."/".$file_name;
	
	if($_SESSION['rtp']['set_cycle']=="pa"){$TABLE="attachments_pa";}
	if($_SESSION['rtp']['set_cycle']=="fa"){$TABLE="attachments";}
	
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $upload_folder."/".$file_name)) 
				{
				$sql="INSERT INTO $TABLE 
				SET project_file_name='$project_file_name', upload_file_name='$name', link='$uploadfile', stored_file_name='$file_name' "; 
			//	echo "$sql"; exit;
		$result = @mysqli_query($connection,$sql);
					$count++;
				}
        }
    }
}
header("Location: view_form.php?var=attachments&project_file_name=$project_file_name");
?>