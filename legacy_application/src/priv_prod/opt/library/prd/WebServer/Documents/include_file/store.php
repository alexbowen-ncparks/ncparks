<?php

	/*  
		print "<pre>";
	print_r($_REQUEST); 
	print_r($_FILES);
	  print "</pre>";
		exit;
	*/
	
	$uploadFile = $_FILES['photo']['tmp_name'];
	if(!is_uploaded_file($uploadFile)){echo "No photo was selected or loaded. Click your browser's BACK button."; exit;}

	$newdate = date("Y-m-d");
	$file = $_FILES['photo']['name'];
	$var_type=explode("/",$_FILES['photo']['type']);
	
	
	//	$pid= mysql_insert_id();
$pid="123_test";	// for testing

		$folder = "photos";
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
		
		$dir = explode("-",$newdate);
		$dirname = $dir[0];
		$folder = "photos/".$dirname;
	
	if (!file_exists($folder)) {mkdir ($folder, 0777);}


		$dirname = $dir[0]."/".$dir[1];
		$folder = "photos/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
		$location = $folder."/".$pid.".jpg";

	move_uploaded_file($uploadFile,$location);// create file on server
	
	// This creates a thumbnail using functions in resize.php
	include("resize.php");// loads functions to make thumbnail
	
	$p=$pid.".jpg";
	$wid=640;
	$hei=640;
			$tn=$folder."/640.".$p;
			$tn640=$tn;
	$p640="640.".$pid.".jpg";
	createthumb($folder."/".$p,$tn,$wid,$hei);
	
	
	$wid=150;
	$hei=150;
			$tn=$folder."/ztn.".$p;
	createthumb($folder."/".$p,$tn,$wid,$hei);
	
	
	// Prepare thumbnail of photo obtained from upload form to add to db
	$data = addslashes(fread(fopen($tn, "r"), filesize ($tn))); 
	 /*
	// used to debug script   
		print "<pre>";
	if (move_uploaded_file($photo[tmp_name],$location)) {
		print "File is valid, and was successfully uploaded. ";
		print "Here's some more debugging info:\n";
		print_r($_FILES);
	} else {
		print "Possible file upload attack!  Here's some debugging info:\n";
		print_r($_FILES);
		print_r($_REQUEST); echo "$location";
	}
	print "</pre>";
	 */    
	
?>
