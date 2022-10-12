<?php
$database="irecall";
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);
extract ($_FILES);
extract ($_REQUEST);
// This is very messy and should be cleaned up! Later perhaps.
// modified by Tom Howard after
// store.php3 - by Florian Dittmer <dittmer@gmx.net>
// Example php script to demonstrate the storing of binary files into
// an sql database. More information can be found at http://www.phpbuilder.com/
//print_r($_REQUEST);print_r($_FILES);exit;
?>

<HTML>
<HEAD><TITLE>Store photograph into iRECALL</TITLE></HEAD>
<body bgcolor="beige">
<?php
    // Data from form is processed
if (@$submit == "Add Photo")
	{
	//print_r($_FILES);//exit;
		mysql_select_db("irecall");
	//$timestamp = strtotime($datePhoto);
	//$newdate = $datePhoto;
	$park = addslashes(strtoupper($park));
	$phototitle = addslashes($phototitle);
	$photographer = addslashes($photographer);
	$caption = addslashes($caption);
	$comment = addslashes($comment);
	$submitter = addslashes($submitter);
	
	$file=str_replace(":", "-",$_FILES['photo']['name']);
	$file=strtolower(trim($file));
	$file=str_replace(" ", "_",$file);
	$file=str_replace("/", "-",$file);
	$file=str_replace("&", "-",$file);
	$file=str_replace(".jpg", "*jpg",$file);
	$file=str_replace(".jpeg", "*jpg",$file);
	$file=str_replace(".", "-",$file);
	$file=str_replace("*jpg", ".jpg",$file);
	//echo "$file";exit;
	
	$ext = substr(strrchr($file, "."), 1);// find file extention, jpg e.g.
	
	if(!is_uploaded_file($photo['tmp_name'])){echo "not loaded"; exit;}
	
	$uploaddir = "photos/";
	$query="INSERT INTO irecall.photos (sid,parkX,filename,filesize,filetype,pid,photographer,caption,comment, datePhoto,phototitle,submitter) "."VALUES ('$sid','$park','$file','$photo[size]','$photo[type]','$pid','$photographer','$caption','$comment','$datePhoto','$phototitle','$submitter')";
	$result=MYSQL_QUERY($query);
		$pid= mysql_insert_id(); 
	if(!$pid){echo "sql=$query";exit;}
	$uploadfile = $uploaddir.$pid.$file;
	
	move_uploaded_file($photo['tmp_name'],$uploadfile);// create file on server
	// This creates a thumbnail using functions in tnModified.php
	$p=$uploadfile.".jpg";
	$p=$uploadfile;
	
			$tn="photos/ztn.".$pid.$file;
		
	  $sql = "UPDATE irecall.photos set link='$uploadfile' where pid='$pid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();
	$wid=150;
	$hei=150;
	include("tnModified.php");
	createthumb($p.$filename,$tn,$wid,$hei);
	// Display
	IF($pid){
	echo "<br>Photo was successfully added.<br>Here is a thumbnail of photo:<br><img src='$tn'>";
	echo "<br><br>Add another <a href='photo.php'>photo:</a><br>";
	echo "<br>Return to <a href='home.php'>Main Page</a>";} 
	else
	{echo "There was a problem, and your photo was not entered. Contact Tom Howard (tom.howard@ncdenr.gov) for help.";}
	}
    // Show the form to submit a new photo
if (@$submit == "" || @$submit=="Add Photo of this person")
	{
	if(!isset($submitter)){$submitter="";}
	if(!isset($datePhoto)){$datePhoto="";}
	if(!isset($phototitle)){$phototitle="";}
	if(!isset($photographer)){$photographer="";}
	if(!isset($park)){$park="";}
	if(!isset($caption)){$caption="";}
	if(!isset($comment)){$comment="";}
		echo "<hr>";
	?>
		<form method="post" action="photo_add.php" enctype="multipart/form-data">
	<table><tr><td>Name of person submitting photo: </td><td><input type="text" name="submitter" value="<?php echo $submitter; ?>" size="26"></td></tr>
	<tr><td>
	Date of Photo (if known):</td><td>
	Photo Title (if you have one):</td></tr><tr><td><input type="text" name="datePhoto" value="<?php echo $datePhoto; ?>" size="16"></td><td><input type="text" name="phototitle" value="<?php echo $phototitle; ?>" size="50"></td></tr></table><table><tr><td>
	State Park (if known):</td></tr><tr><td><input type="text" name="park" value="<?php echo $park; ?>" size="50"></td></tr><tr><td>
	Photographer (if known):</td></tr><tr><td><input type="text" name="photographer" value="<?php echo $photographer; ?>" size="50"></td></tr><tr><td>
	Caption to go with photo:</td></tr><tr><td><textarea cols="40" rows="5" name="caption"><?php echo $caption; ?></textarea></td></tr><tr><td>
	Any comment from person submitting photo:<br><textarea cols="40" rows="5" name="comment"><?php echo $comment; ?></textarea></td></tr></table><hr>
		<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="10000000">
	1. Click this button and select your photo.
		<input type="file" name="photo"  size="40">
		<p>2. Then click this button. <input type="submit" name="submit" value="Add Photo">
		</form>
	<?php
	echo "Make sure your photo is in the JPEG/JPG format. If you have any questions about adding a photo, please contact either Tom Howard (tom.howard@ncmail.net) or Siobhan O'Neal (siobhan.oneal@ncmail.net)";
	}


    // Show the form to submit edit photo info
if (@$submit == "Edit the Photo Info" || @$submit == "editPhoto") 
	{
	if($submit == "editPhoto"){
	if($pid){
	$query = "select * from irecall.photos where pid=$pid";
	$resultPhoto = @mysql_query($query, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$rowPhoto=mysql_fetch_array($resultPhoto);
	extract($rowPhoto);
	}
	}
		// else show the form to submit new data:
	  $photog = urldecode($photog);
	   $caption = urldecode($caption);
	 
	?>
		<form action="updatePhoto.php" method="POST">
	
	<b><?php echo "$name"; ?></b>
		<hr>REVIEW the info.<br><br>
		Date of Photo: 
		<input type="text" name="date" value="<?php echo $date; ?>" size="16">  <b>IMPORTANT</b> Enter Date as either yyyy-mm-dd OR m/d/yyyy<br><br>
		Photographer: <input type="text" name="photographer" value="<?php echo $photographer; ?>" size="50"><br>
	
	<br>
	   Photo Title:<br><textarea cols="40" rows="2" name="phototitle"><?php echo "$phototitle"; ?>
	</textarea>
	<br>
		captions:<br><textarea cols="40" rows="7" name="caption"><?php echo "$caption"; ?>
	</textarea>
	
	<?php
	echo "<input type='hidden' name='pid' value='$pid'>";
	?>
		 <br><br><br><input type="submit" name="submit" value="Submit Edit">
		</form><hr>
	<?php 
	} 

?>
</BODY>
</HTML>