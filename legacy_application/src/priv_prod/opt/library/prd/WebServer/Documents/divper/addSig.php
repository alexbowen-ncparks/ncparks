<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="photos";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);

// extract($_REQUEST);

/*
if($tempID=="Reuter0909" AND !EMPTY($_FILES))
	{
	echo "<pre>";print_r($_REQUEST); print_r($_FILES); echo "</pre>";  exit;
	}
unlink('signature/Conolly1463.');
echo "<pre>";print_r($_REQUEST);
print_r($_SESSION);
print_r($_FILES);
echo "</pre>";exit;
*/

?>

<HTML>
<HEAD><TITLE>Store a signature in THE ID</TITLE>

<!-- THIS JUMP ONLY WORKS FOR FRAMES -->
<script language="JavaScript">
<!--
function MM_jumpMenu(selObj,restore){ //v3.0
eval("parent.frames['mainFrame']"+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

</HEAD>
<BODY><body bgcolor="beige">
<?php
    // Data from form is processed
if (@$submit == "Add Signature")
	{
	$size=$_FILES['sig']['size'];
	
	if($size<1)
		{
		echo "There was a problem uploading that signature.
		<br><br>Contact Tom Howard.";
		exit;
		}
	/*  
		print "<pre>";
	print_r($_REQUEST); 
	print_r($_FILES);
	  print "</pre>";
		exit;
	*/
	
	$file = $_FILES['sig']['name'];
	$uploadFile = $_FILES['sig']['tmp_name'];
	//$ext = substr(strrchr($file, "."), 1);// find file extention, mp3 e.g.
	// $file = str_replace(" ","",strtolower($sciName)).".".$ext;// remove spaces
	if(!is_uploaded_file($uploadFile)){echo "No photo was selected or loaded. Click your browser's BACK button."; exit;}
	
	$personID=str_replace("'","",$tempID);// remove ' from O'Neal e.g.
//	$fullName=addslashes($fullName);   // handles in connecROOT.inc
	$filename=$_FILES['sig']['name'];
	//$filename=addslashes($filename);
	$filesize=$_FILES['sig']['size'];
	$filetype=$_FILES['sig']['type'];
	
	
	if($filetype==""){
		echo "This signature could not be properly uploaded to the database. Attach the signature file to an email and send to Tom Howard."; exit;
			}
	
	
	$sql="REPLACE signature (fullName,filename,filesize,filetype,personID) "."VALUES ('$fullName','$filename','$filesize','$filetype','$personID')";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	//echo "$sql"; exit;
		$pid= mysqli_insert_id($connection);
		
	   
		$folder = "signature";
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
	if($filetype=="image/tiff"){$ext="tif";}
	if($filetype=="image/jpeg"){$ext="jpg";}
	if($filetype=="image/png"){$ext="png";}
	if($filetype=="image/gif"){$ext="gif";}
	
	
		$location = $folder."/".$personID.".".$ext;
	
		
	move_uploaded_file($uploadFile,$location);// create file on server
	
	  $sql = "UPDATE signature set link='$location' where personID='$personID'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	
	if(@$file_source=="retired_id")
		{
		echo "Sig has been added.<br />";
		echo "Return to <a href='/divper/~photoID_retired.php'>link</a>";
		echo "Return to <a href='/divper/~photoID_retired.php'>link</a>";
		exit;
		}
	echo "Sig has been added.";
	exit;
	} 

// *******************************************
    // Show the form to submit a new photo
if ($tempID)
	{
	$name=explode("_",$fullName);
	$fullName=$name[0]." ".$name[1];
		echo "<hr>

	 <form method='post' action='addSig.php' enctype='multipart/form-data'>";

	echo "Name of Employee: <input type='text' name='fullName' value='$fullName' size='75'><br><br>
  
	<hr>
	Make sure the Signature file is a <font color='red'>JPEG</font>.<br />
		<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='30000000'>
		<br>1. Click the BROWSE (or Choose File) button and select your signature.<br>
		<input type='file' name='sig'>
	<input type='hidden' name='tempID' value='$tempID'>
		<p>2. Then click this button. <input type='submit' name='submit' value='Add Signature'>
		</form>";

	echo "</BODY></HTML>";
	}

?>
