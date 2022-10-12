<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database

include("../../include/salt.inc");
include("menu.php");
$level=$_SESSION['divper']['level'];
$tempLevel=$level;

$ckPosition=strtolower($_SESSION['position']);
$ps=strpos($ckPosition,"park super");
$oa=strpos($ckPosition,"office assistant");
if($ps>-1){$ckPosition="park superintendent";$tempLevel=2;}
if($oa>-1){$ckPosition="office assistant";$tempLevel=2;}

extract($_REQUEST);

if (@$submit == "Add File")
	{
	extract($_FILES);
	$file = $_FILES['doc']['name'];
	$ext = substr(strrchr($file, "."), 1);
	// print_r($_FILES); exit;
	if(!is_uploaded_file($doc['tmp_name']))
		{
		print_r($_FILES);  print_r($_REQUEST);exit;}
	
	$result=mysqli_QUERY($connection,"REPLACE work_plan_base (emid) "."VALUES ('$emid')");
	   
	$uploaddir = "work_plan_base/"; // make sure www has r/w permissions on this folder
	
	$emidSalted=md5($emid.$salt); // salt.inc
	$uploadfile1=$emidSalted;
	
	$uploadfile = $uploaddir.$emidSalted.".".$ext;
	
	move_uploaded_file($doc[tmp_name],$uploadfile);// create file on server
		
	  $sql = "UPDATE work_plan_base set wp_link='$uploadfile',wp_salt_link='$uploadfile1' where emid='$emid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
		echo "The Base Work Plan for $Fname $Lname has been successfully uploaded to the server.";
	//header("Location: search.php?Submit=display&dirNum=$dirNum");
		} 
	
	    // Show the form to submit a file
if (@$submit == "pdf")
	{
	
	  $sql = "SELECT wp_salt_link from work_plan_base where emid='$emid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_array($result);
	
	if(mysqli_num_rows($result)>0){
	$checkSalt=$row['wp_salt_link'];
	if($checkSalt!=$emidSalted){echo "Access not allowed.<br>checkSalt=$checkSalt<br>emidSalted=$emidSalted";exit;}
	}
	
	
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle, position.beacon_num
	FROM empinfo
	LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	LEFT  JOIN position ON emplist.posNum = position.posNum
	WHERE empinfo.emid='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);extract($row);
	
	@$check=explode(",",$_SESSION['divper']['supervise']);
	if(in_array($beacon_num,$check) OR $beacon_num==$_SESSION['beacon_num'])
		{$tempLevel=2;}
		
	if($tempLevel>1){
	   echo "<hr>
		<form method='post' action='workPlan_base.php' enctype='multipart/form-data'>
	
	Upload the Base Work Plan for <font color='blue'>$Fname $Lname</font><hr>
		<INPUT TYPE='hidden' name='emid' value='$emid'>
		<INPUT TYPE='hidden' name='Fname' value='$Fname'>
		<INPUT TYPE='hidden' name='Lname' value='$Lname'>
		<br>1. Click the button and select your Base Work Plan file. (not the completed one)<br>
		<input type='file' name='doc'  size='40'>
		<p>2. Then click this button. <font size='-2'>File should be either a .doc or .pdf file</font>
		<input type='submit' name='submit' value='Add File'></p>
		(Time to complete upload will vary depending on file size and speed of internet connection.)
		</form><hr>";
	  }
		
	 
	$sql = "SELECT wp_link from work_plan_base WHERE wp_salt_link='$emidSalted'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	
	if($num<1){echo "<font color='red'>No Base Work Plan exists</font> online for <font color='blue'>$Fname $Lname</font>.";exit;}
	$row=mysqli_fetch_array($result);extract($row);
	
	   echo "</tr><tr><td colspan='2'><font color='green'>View Base Work Plan</font> for $Fname $Lname <a href='$wp_link' target='_blank'>here</a>.</td></tr></table></body></html>";
	exit;
	}
?>