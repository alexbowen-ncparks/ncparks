<?php
//ini_set('display_errors',1);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
	$database="dpr_proj";
	$check_cookie=strpos(@$_SERVER['HTTP_COOKIE'],"PHPSESSID=");
if(@$_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
if(@$_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
	{

	include("../../include/iConnect.inc");
	mysqli_select_db($connection, 'divper');

$reviewer_array=array("1"=>"pasu","2"=>"resu","3"=>"chom","4"=>"ensu","5"=>"plnr","6"=>"chop","7"=>"dedi");

	$sql="SELECT $database as level, t1.currPark, t1.accessPark, t1.beacon_num
	from emplist as t1
	where t1.emid='$emid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
	
	if(mysqli_num_rows($result)<1)
		{
		$sql="SELECT $database as level, t1.currPark
		 from nondpr as t1
		 where t1.emid='$emid'";
		 $result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
		 }
	$row=mysqli_fetch_assoc($result);

	session_start();

	$database="dpr_proj";
	$_SESSION[$database]['level']=$row['level'];
	$_SESSION[$database]['tempID']=$tempID;
	$_SESSION['tempID']=$tempID;
	$_SESSION[$database]['emid']=$emid;
	$_SESSION[$database]['select']=$row['currPark'];
	IF($row['currPark']=="SODI")
		{
		$_SESSION[$database]['select']="PIRE";
		}
	IF($row['currPark']=="EADI")
		{
		$_SESSION[$database]['select']="CORE";
		}
	IF($row['currPark']=="WEDI")
		{
		$_SESSION[$database]['select']="MORE";
		}
	$_SESSION[$database]['accessPark']=$row['accessPark'];
	$_SESSION[$database]['beacon_num']=$row['beacon_num'];
	$_SESSION[$database]['review_level']=$reviewer_array[$row['level']];
	@$_SESSION[$database]['previous_reviewer']=$reviewer_array[$row['level']-1];
	$_SESSION[$database]['next_reviewer']=$reviewer_array[$row['level']+1];
	
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	header("Location: overview.php");
	exit;
	}
?>
