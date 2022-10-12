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
//print_r($_REQUEST);print_r($_FILES);//exit;
?>

<HTML>
<HEAD><TITLE>Store photograph into iRECALL</TITLE></HEAD>
<body bgcolor="beige">
<?php
    // Data from form is processed

    
if (@$submit == "hide")
	{
	$sql = "UPDATE irecall.photos set mark='x' where pid='$pid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	exit;
	}
    
if (@$submit == "Add Photo")
	{
	//print_r($_FILES);//exit;
		mysql_select_db("irecall");
	//$timestamp = strtotime($datePhoto);
	$newdate = $datePhoto;
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
	//echo "$file";exit;
	
	$ext = substr(strrchr($file, "."), 1);// find file extention, jpg e.g.
	
	if(!is_uploaded_file($photo[tmp_name])){echo "not loaded"; exit;}
	
	$uploaddir = "photos/";
	$query="INSERT INTO irecall.photos (sid,parkX,filename,filesize,filetype,pid,photographer,caption,comment, date,phototitle,submitter) "."VALUES ('$sid','$park','$file','$photo[size]','$photo[type]','$pid','$photographer','$caption','$comment','$newdate','$phototitle','$submitter')";
	$result=MYSQL_QUERY($query);
		$pid= mysql_insert_id(); 
	if(!$pid){echo "sql=$query";exit;}
	$uploadfile = $uploaddir.$pid.$file;
	
	move_uploaded_file($photo[tmp_name],$uploadfile);// create file on server
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
	echo "<br><br>Add another <a href='addPhotoSound.php?submit=Add%20a%20Photo'>photo:</a><br>";
	echo "<br>Return to <a href='menu.php'>Main Page</a>";} 
	else
	{echo "There was a problem, and your photo was not entered. Contact Tom Howard (tom.howard@ncmail.net) for help.";}
	}
    // Show the form to submit a new photo
if (@$submit == "Add a Photo")
	{
		echo "<hr>";
	?>
		<form method="post" action="addPhotoSound.php" enctype="multipart/form-data">
	<table><tr><td>Name of person submitting photo: </td><td><input type="text" name="submitter" value="<?php echo $submitter; ?>" size="26"></td></tr>
	<tr><td>
	Date of Photo (if known):</td><td>
	Photo Title (if you have one):</td></tr><tr><td><input type="text" name="datePhoto" value="<?php echo $date; ?>" size="16"></td><td><input type="text" name="phototitle" value="<?php echo $phototitle; ?>" size="50"></td></tr></table><table><tr></tr><tr><td>
	State Park (if known):</td></tr><tr><td><input type="text" name="park" value="<?php echo $park; ?>" size="50"></td></tr><tr><td>
	Photographer (if known):</td></tr><tr><td><input type="text" name="photographer" value="<?php echo $photographer; ?>" size="50"></td></tr><tr><td>
	Caption to go with photo:</td></tr><tr><td><textarea cols="40" rows="5" name="caption"><?php echo $caption; ?>
	</textarea></td></tr><tr><td>
	Any comment from person submitting photo:<br><textarea cols="40" rows="5" name="comment"><?php echo $comment; ?>
	</textarea></td></tr></table><hr>
		<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="10000000">
	1. Click this button and select your photo.<br>
		<input type="file" name="photo"  size="40">
	<input type="hidden" name="pid" value="<?php echo $pid; ?>"
		<p>2. Then click this button. <input type="submit" name="submit" value="Add Photo">
		</form>
	<?php
	echo "Make sure your photo is in the JPEG/JPG format. If you have any questions about adding a photo, please contact either Tom Howard (tom.howard@ncmail.net) or Siobhan O'Neal (siobhan.oneal@ncmail.net)";
	}


    // Show the form to submit edit photo info
if (@$submit == "Submit Edit" || @$submit == "editPhoto") 
	{
	if($submit == "Submit Edit")
		{
//		echo "<pre>"; print_r($_REQUEST); echo "</pre>";// EXIT;
		   $photographer = addslashes($photographer);
		   $phototitle = addslashes($phototitle);
		   $caption = addslashes($caption);
		   
		$query = "update irecall.photos set datePhoto='$date', photographer='$photographer', phototitle='$phototitle', caption='$caption' where pid=$pid"; //echo "$query"; exit;
		$resultPhoto = @mysql_query($query, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		header("Location:view.php?var=photos");exit;
		}
	
	if($submit == "editPhoto")
		{
		if($pid)
			{
			$query = "select * from irecall.photos where pid=$pid";
			$resultPhoto = @mysql_query($query, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
			$rowPhoto=mysql_fetch_array($resultPhoto);
			extract($rowPhoto);
			}
		}
		// else show the form to submit new data:
	  @$photog = urldecode($photog);
	   @$caption = urldecode($caption);
	 
	?>
		<form action="addPhotoSound.php" method="POST">
		<hr>REVIEW the info.<br><br>
		Date of Photo: 
		<input type="text" name="date" value="<?php echo $datePhoto; ?>" size="16">  <br><br>
		Photographer: <input type="text" name="photographer" value="<?php echo $photographer; ?>" size="50"><br>
	
	<br>
	   Photo Title:<br><textarea cols="40" rows="2" name="phototitle"><?php echo "$phototitle"; ?>
	</textarea>
	<br>
	Caption:<br><textarea cols="40" rows="7" name="caption"><?php echo "$caption"; ?>
	</textarea>
	
	<?php
	echo "<input type='hidden' name='pid' value='$pid'>";
	?>
		 <br><br><br><input type="submit" name="submit" value="Submit Edit">
		</form><hr>
	<?php 
	} 

    // Show the form to submit a sound
if (@$submit == "Add a Sound File")
	{
	$sql = "SELECT name FROM irecall where sid='$sid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_array($result);
	extract($row);
	MYSQL_CLOSE();
	echo "<hr>";
	?>
	<form method="post" action="<?php echo $PHP_SELF; ?>" enctype="multipart/form-data">
	<?php echo "Unit: $name"; ?>
	<br><br>
	Date of Sound: 
	<input type="text" name="dateSound" value="<?php echo $date; ?>" size="16">  <b>IMPORTANT</b> Enter Date as either yyyy-mm-dd OR m/d/yyyy<br><br>
	Source of sound:<br>webirecall's URL, original recording, etc. <input type="text" name="source" value="<?php echo $recorder; ?>" size="50"><br><br>
	Comment/Name: <textarea cols="40" rows="5" name="comment"><?php echo $comment; ?>
	</textarea><hr>
	<INPUT TYPE="hidden" name="sid" value="<?php echo $sid; ?>"
	<INPUT TYPE="hidden" name="name" value="<?php echo $name; ?>"
	<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="1000000">
	<br>1. Click the button to select your sound file.<br>
	<input type="file" name="sound"  size="40">
	<input type="hidden" name="pid" value="<?php echo $pid; ?>"
	<p>2. Then click this button. <input type="submit" name="submit" value="Add Sound">
	</form>  
	<?php } ?>

<?php
    // Data from Sound form is processed
if (@$submit == "Add Sound")
	{
	$type = $sound['type']; if($type==""){echo "Improper sound format. Type=$type";exit;}
	$pos1 = strpos($type, "audio");
	$pos2 = strpos($type, "video");
	if($pos1+$pos2 === ""){echo "Make sure the sound file is of a supported type: mp3, wav, or mov. Contact me if you are having difficulty.";exit;}
	
		mysql_select_db("irecall.sounds");
	$timestamp = strtotime($dateSound);
	$newdate = date("y/m/d", $timestamp);
	$name = strtoupper($name);
	
	$file = $_FILES['sound']['name'];
	$ext = substr(strrchr($file, "."), 1);// find file extention, mp3 e.g.
	$file = str_replace(" ","",strtolower($pid)).".".$ext;// remove spaces
	if(!is_uploaded_file($sound[tmp_name])){echo "not loaded"; exit;}
	
	$uploaddir = "sounds/";
	 
	$result=MYSQL_QUERY("INSERT INTO irecall.sounds (sid,comment,type,source) "."VALUES ('$sid','$comment','$type','$source')");
		$soid= mysql_insert_id();
		
	$uploadfile = $uploaddir.$soid.$file;
	
	move_uploaded_file($sound[tmp_name],$uploadfile);// create file on server
		
	  $sql = "UPDATE sounds set link='$uploadfile' where soid='$soid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();
	// Display
	echo "<br><br><a href='$uploadfile' target='_blank'>Listen to Sound for $name in a new window</a>";
	echo "<br><br><br><a href='edit.php?sid=$sid&v=e'>Return</a>";
	}

// **************** STORY ***************************
    // Show the form to submit a new Story
if (@$submit == "Add a Story")
	{
		echo "<hr>
		<form method='post' action='$PHP_SELF' enctype='multipart/form-data'>
	
	Story submitted by:<br><textarea cols='60' rows='1' name='authorname'>$authorname
	</textarea><hr>
	Story Title:<br><textarea cols='60' rows='1' name='title'>$title
	</textarea><br>
	Story Text:<br><textarea cols='80' rows='20' name='storytext'>$storytext
	</textarea><br>
	Any Comment from person submitting story:<br><textarea cols='80' rows='19' name='comment'>$comment
	</textarea>
	<br><INPUT TYPE='submit' name='submit' value='Add story'>
		</form>
	<br>If you have any questions about entering a story, contact Siobhan O'Neal (siobhan.oneal@ncmail.net)";
	}

if ($submit == "Add story")
	{
	if(!$storytext){echo "You must enter a story. Click your Browser's BACK button.";exit;}
	mysql_select_db("irecall.story");
	$authorname=addslashes($authorname);
	$title=addslashes($title);
	$storytext=addslashes($storytext);
	$comment=addslashes($comment);
	
	$result=MYSQL_QUERY("INSERT INTO irecall.story (authorname, storytext,title,comment) "."VALUES ('$authorname','$storytext','$title','$comment')");
		$mid= mysql_insert_id();
	
	if($mid){
	// Display
	echo "<br><br>Your story was successfully added.";
	
	echo "<br><br>Add another <a href='addPhotoSound.php?submit=Add%20a%20Story'>Story:</a><br>";
	
	echo "<br><br><br><a href='menu.php'>Return</a>";
	}
	else
	{echo "There was a problem, and your story was not entered. Contact Tom Howard (tom.howard@ncmail.net) for help.";}
		} 
?>
</BODY>
</HTML>