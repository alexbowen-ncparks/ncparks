<?php
// echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;

if(!empty($_POST))
	{
	$database="inspect";
	session_start();
	$level=$_SESSION[$database]['level'];
	$parkcode=$_SESSION[$database]['select'];
	//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
	//These are placed outside of the webserver directory for security
	if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
	include("../../include/iConnect.inc"); // database connection parameters
	mysqli_select_db($connection,$database);

	$TABLE =$add_ems;
	}
	
foreach($_FILES['file_upload']['tmp_name'] as $i=>$value)
	{
	$temp_name=$_FILES['file_upload']['tmp_name'][$i];
	if($temp_name==""){continue;}
	
	if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i]))
		{
// 		echo "<pre>";print_r($_FILES);  print_r($_REQUEST);echo "</pre>";
// 		exit;
		}
	
	if(empty($_POST['title'][$i]))
		{
		$title=$_FILES['file_upload']['name'][$i];
		}
		else
		{$title=$_POST['title'][$i];}
	$comments=$_POST['comments'][$i];
	
	$title=htmlspecialchars_decode($title);
	$sql="INSERT into $TABLE SET record_type='$add_ems', title='$title', comments='$comments'"; 
// 	echo "$sql<br />"; 
// 	exit;
	$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$id= mysqli_insert_id($connection);

	$uploaddir = "ems_emr_docs_folder"; // make sure www has r/w permissions on this folder
	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}
	
	$var=$_FILES['file_upload']['name'][$i];
	
	$var=str_replace("&amp;","&",$var);
	$var=str_replace(",","",$var);
	$var=str_replace("\"","",$var);
	$var=str_replace("“","",$var);
	$var=str_replace("”","",$var);
	$var=str_replace("- ","-",$var);
	$var=str_replace(" -","-",$var);
	$var=str_replace("-","_",$var);
	$var=str_replace(" ","_",$var);
	$uploadfile = $uploaddir."/".$var;
// echo "u=$uploadfile"; exit;
	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);

	$sql = "UPDATE $TABLE set link='$uploadfile' where id='$id'";
// 	echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}

if(!empty($id))
	{
	header("Location: home.php");
	exit;
	}
	
	
include("pm_menu_new.php");
echo "
Upload EMS Files

<form method='post' action='add_file.php' enctype='multipart/form-data'>
<table style='margin-right:auto; margin-left:auto'>
<tr><td>File Type: <input type='text' name='add_ems' value=\"$add_ems\" size='15' readonly></td></tr>
<tr><td>Title of Document 1: <input type='text' name='title[]' value=\"\" size='33'><input type='file' name='file_upload[]'></td></tr>
<tr><td>Comments on Document 1:<br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>
<tr><td>Title of Document 2: <input type='text' name='title[]' value=\"\" size='33'><input type='file' name='file_upload[]'></td></tr>
<tr><td>Comments on Document 2: <br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>
<tr><td>Title of Document 3: <input type='text' name='title[]' value=\"\" size='33'><input type='file' name='file_upload[]'></td></tr>
<tr><td>Comments on Document 3:<br /><textarea name='comments[]' cols='55' rows='2'></textarea></td></tr>
<tr><td><input type='submit' name='submit_form' value=\"Upload\"></td></tr>
</table>
</form>
</td></tr></table>";

?>