<?php
//exit;
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,$database);

include("../../include/salt.inc");
	

include("menu.php");
$level=$_SESSION['divper']['level'];
$tempLevel=$level;
$log_emid=$_SESSION['logemid'];
$emidSalted_user=md5($log_emid.$salt); // salt.inc

//echo "$emidSalted<br />$emidSalted_user";

if($level<5)
	{
	if(@$emidSalted != $emidSalted_user){exit;}
	if($log_emid != $emid){exit;}
	}
$ckPosition=strtolower($_SESSION['position']);
$ps=strpos($ckPosition,"park super");
$oa=strpos($ckPosition,"office assistant");
if($ps>-1){$ckPosition="park superintendent";$tempLevel=2;}
if($oa>-1){$ckPosition="office assistant";$tempLevel=2;}

//$expand_access=array("Ron Anundson"=>"14"); // $emid
$expand_access=array(); // $emid
if(in_array($log_emid,$expand_access)){$tempLevel=2;}

if ($submit == "Add PDF")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//	echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
	if($_FILES['pdf']['error']==0)
		{
		extract($_FILES);
		$file = $_FILES['pdf']['name'];
		$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.
		
	//	 print_r($_FILES); echo "45"; exit;
		if(!is_uploaded_file($pdf['tmp_name']))
			{
			echo "48"; print_r($_FILES);  print_r($_REQUEST);  exit;
			}

		$result=mysqli_QUERY($connection,"REPLACE work_plan (emid) "."VALUES ('$emid')");

		$uploaddir = "work_plans/"; // make sure www has r/w permissions on this folder

		//	$emidSalted=md5($emid.$salt); // salt.inc
		$uploadfile1=$emidSalted;

		$uploadfile = $uploaddir.$emidSalted.".pdf";

		move_uploaded_file($pdf['tmp_name'],$uploadfile);// create file on server

		$sql = "UPDATE work_plan set wp_link='$uploadfile',wp_salt_link='$uploadfile1', wp_rating='$wp_rating' where emid='$emid'";
		}
		ELSE
		{
		$sql = "UPDATE work_plan set wp_rating='$wp_rating' where emid='$emid'";
	//	echo "$sql"; exit;
		}
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

		$message="The 2014 VIP for $Fname $Lname has been successfully uploaded to the server.";
	//header("Location: search.php?Submit=display&dirNum=$dirNum");
	$submit="pdf";
		} 
	
	    // Show the form to submit a file
if ($submit == "pdf")
	{
	
	  $sql = "SELECT wp_salt_link from work_plan where emid='$emid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_array($result);
	
	if(mysqli_num_rows($result)>0)
		{
		$checkSalt=$row['wp_salt_link'];
		if($checkSalt!=$emidSalted)
			{
		//	echo "Access not allowed.<br>checkSalt=$checkSalt<br>emidSalted=$emidSalted";
			echo "Access not allowed.";
			exit;}
		}
	if(!empty($message))
		{echo "<font color='green' size='+2'>$message</font><br />";}
	
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle, position.beacon_num
	FROM empinfo
	LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
	WHERE empinfo.emid='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); //echo "$sql";
	$row=mysqli_fetch_array($result);extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	
	@$check=explode(",",$_SESSION['divper']['supervise']);
	if(in_array($beacon_num,$check) OR $beacon_num==$_SESSION['beacon_num'])
		{$tempLevel=2;}
	
	if($tempLevel>1)
		{
		$sql = "SELECT wp_link,wp_rating from work_plan WHERE wp_salt_link='$emidSalted'";//echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);

		if($num<1)
			{
			echo "<font color='red'>No 2014 VIP exists</font> online for <font color='blue'>$Fname $Lname</font>.";
		//	exit;
			}
			else
			{
			$row=mysqli_fetch_array($result);
			extract($row);
			}
		   echo "<hr>
			<form method='post' action='workPlan.php' enctype='multipart/form-data'>
		
		Upload the 2014 VIP for <font color='blue'>$Fname $Lname</font><hr>
			<INPUT TYPE='hidden' name='emid' value='$emid'>
			<INPUT TYPE='hidden' name='Fname' value='$Fname'>
			<INPUT TYPE='hidden' name='Lname' value='$Lname'>
			<br>1. Click the button and select your PDF file.<br>
			<input type='file' name='pdf'  size='40'>";
			if($tempLevel>1)
				{
			//	echo "w=$wp_rating";
				if(!isset($wp_rating)){$wp_rating="";}
				$rating_array=array("U"=>"Did not meet expectations","BG"=>"Inconsistently met expectations","G"=>"Met expectations","VG"=>"Exceeded expectations","O"=>"Consistently exceeded expectations","I"=>"Insufficient time to evaluate","LA"=>"Leave of absence");
				echo "<br /><br />2. Enter performance rating. &nbsp;";
				foreach($rating_array as $k=>$v)
					{
					if($wp_rating==$k){$ck="checked";}else{$ck="";}
					echo "<BR /><input type='radio' name='wp_rating' required value='$k' $ck>$v";
					}
				
				echo "<br>";
				}
			echo "<p>3. Then click this button. 
			<input type='submit' name='submit' value='Add PDF'></p>
			(Time to complete upload will vary depending on file size and speed of internet connection.)
			</form><hr>";
		  }
		
	
		if(!empty($wp_link))
			{
			echo "<p><font color='green'>View 2014 VIP</font> for $Fname $Lname <a href='$wp_link' target='_blank'>here</a>.</p>";
			}
			
		if($level>4 or @$tempID=="Oneal1133")
			{
			echo "<p><font color='green'>View Performance Rating Summary for Operations</font> <a href='workPlan_vip_summary.php'>here</a>.</p>";
			}
	   echo "</body></html>";
	exit;
	}
?>