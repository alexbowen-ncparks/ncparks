<?php

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/get_parkcodes_reg.php");
// include("../../include/connectROOT.inc"); 
mysqli_select_db($connection,'divper'); // database

include("../../include/salt.inc");
include("menu.php");
$level=$_SESSION['divper']['level'];
$tempLevel=$level;
$log_emid=$_SESSION['logemid'];

// extract($_REQUEST);

 //echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
 //echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$ckPosition=strtolower($_SESSION['position']);
$ps=strpos($ckPosition,"park super");
$oa=strpos($ckPosition,"office assistant");
if($ps>-1){$ckPosition="park superintendent";$tempLevel=2;}
if($oa>-1){$ckPosition="office assistant";$tempLevel=2;}
// $midSalted_user=md5($log_emid.$salt); // salt.inc
$emidSalted_user=md5($log_emid.$salt); // salt.inc

if($level>4 and !empty($emidSalted))
	{
// 	echo "emidSalted $emidSalted<br />emidSalted_user $emidSalted_user<br /><br />";
	}


if($tempLevel<2)
	{
	if(@$emidSalted != $midSalted_user){exit;}
	if($log_emid != $emid){exit;}
	}
	
$expand_access=array("Ron Anundson"=>"14","Pam Witt"=>"610"); // $emid
if(in_array($log_emid,$expand_access)){$tempLevel=2;}

if ($submit == "Add PDF")
	{
	//mysqli_select_db("find.map");
	//$mapName = strtoupper($mapName);
	extract($_FILES);
	$file = $_FILES['pdf']['name'];
	$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.
	//if($ext!="pdf"||$ext!="PDF"){echo "Make sure you are uploading a PDF file. The filename should end in .pdf or .PDF";}
	// print_r($_FILES); exit;
	if(!is_uploaded_file($pdf['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);exit;}
	
	$result=mysqli_QUERY($connection,"REPLACE compassess (emid) "."VALUES ('$emid')");
	   
	$uploaddir = "coas/"; // make sure www has r/w permissions on this folder
	
	$emidSalted=md5($emid.$salt); // salt.inc
	$uploadfile1=$emidSalted.time();
	
	$uploadfile = $uploaddir.$uploadfile1.".pdf";
	
	move_uploaded_file($pdf['tmp_name'],$uploadfile);// create file on server
		
	  $sql = "UPDATE compassess set ca_link='$uploadfile',ca_salt_link='$uploadfile1' where emid='$emid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

		echo "The Competency Assessment for $Fname $Lname has been successfully uploaded to the server.";
	$sql = "SELECT * from compassess WHERE emid='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);extract($row);
	
	$file="coas/".$ca_salt_link.".pdf";
	$file1=$ca_link;
	if(file_exists($file)){$link=$file;}else{$link=$file1;}
	
	   echo "<br /><br />View Competency Assessment <a href='$link'>here</a>.";
	   		mysqli_CLOSE($connection);
		} 
	
	    // Show the form to submit a file
if ($submit == "pdf")
	{
	  $sql = "SELECT ca_salt_link from compassess where emid='$emid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_array($result);
	
	if(mysqli_num_rows($result)>0)
	{
	$checkSalt=substr($row['ca_salt_link'],0,-10);
	$checkSalt=$row['ca_salt_link'];
	if($checkSalt!=$emidSalted)
		{
		echo "Access not allowed.<br>checkSalt=$checkSalt<br>emidSalted=$emidSalted";exit;
		}
	}
	
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle, position.beacon_num
	FROM empinfo
	LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
	WHERE empinfo.emid='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);extract($row);
	
	@$check=explode(",",$_SESSION['divper']['supervise']);
	if(in_array($beacon_num,$check) OR $beacon_num==$_SESSION['beacon_num'])
		{$tempLevel=2;}
		
	if($tempLevel>1){
	
	   echo "<hr>
		<form method='post' action='compAssess.php' enctype='multipart/form-data'>
	
	Upload the Competency Assessment for <font color='blue'>$Fname $Lname</font><hr>
		<INPUT TYPE='hidden' name='emid' value='$emid'>
		<INPUT TYPE='hidden' name='Fname' value='$Fname'>
		<INPUT TYPE='hidden' name='Lname' value='$Lname'>
		<br>1. Click the button and select your PDF file.<br>
		<input type='file' name='pdf'  size='40'>
		<p>2. Then click this button. 
		<input type='submit' name='submit' value='Add PDF'></p>
		(Time to complete upload will vary depending on file size and speed of internet connection.)
		</form><hr>";
	  }
		
	 
	$sql = "SELECT * from compassess WHERE emid='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	
	if($num<1){echo "No Competency Assessment exists online for <font color='blue'>$Fname $Lname</font>.";exit;}
	$row=mysqli_fetch_array($result);extract($row);
	
	$file="coas/".$ca_salt_link.".pdf";
	$file1=$ca_link;
	if(file_exists($file)){$link=$file;}else{$link=$file1;}
	
	   echo "</tr><tr><td colspan='2'>View Competency Assessment for $Fname $Lname <a href='$link'>here</a>.</td></tr></table></body></html>";
	exit;
	}
?>