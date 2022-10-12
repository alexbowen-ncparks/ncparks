<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
	$database="fire";
	$check_cookie=strpos(@$_SERVER['HTTP_COOKIE'],"PHPSESSID=");
if($_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or $_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
if($_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or $_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
	{
	include("../../include/iConnect.inc");
	mysqli_select_db($connection,'divper');
	extract($_REQUEST);
	$sql="SELECT fire as level, currPark, accessPark 
	from emplist WHERE emplist.emid = '$emid' AND emplist.tempID='$tempID'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
	
	$num = @mysqli_num_rows($result);
	$row=mysqli_fetch_assoc($result);


if($num<1)
	{
	mysqli_select_db($connection,'divper'); // database 
	$sql = "SELECT $db as 'level',divper.nondpr.currPark, divper.nondpr.Fname, divper.nondpr.Lname, divper.nondpr.tempID as new_tempID
	FROM divper.nondpr 
	WHERE nondpr.tempID = '$tempID'";
	// echo "sql=$sql<br />";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	//echo "$sql"; //exit;
	$num_nondpr = @mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	$test=$row['currPark'];  //echo "t=$test";
	$level=$row['level']; 
	$tempID=$row['new_tempID']; 
	
	if($num_nondpr<1){echo "Access denied.";exit;}
	}


	session_start();

	$_SESSION[$database]['level']=$row['level'];
	$_SESSION[$database]['tempID']=$tempID;
	$_SESSION['tempID']=$tempID;
	$_SESSION[$database]['emid']=$emid;
	$_SESSION[$database]['select']=$row['currPark'];
/* 2022-02-28: CCOOPER (thoward) - setting the park access in this file, is like setting it in the manage_access.php screen, so Tom commented this out and added the additional parks for fire only in menu.php */ 
// 	$temp_access_park="PIMO,HARO";
// 	IF($tempID=="Windsor6679")
// 		{
// 		$row['accessPark']=$temp_access_park;
// 		}
/* 2022-02-28 End CCOOPER (thoward)   */
	if(!empty($row['accessPark']))
		{
		$_SESSION[$database]['accessPark']=$row['accessPark'];
		}
//	echo "hello"; exit;
	header("Location: menu.php");
	}
?>
