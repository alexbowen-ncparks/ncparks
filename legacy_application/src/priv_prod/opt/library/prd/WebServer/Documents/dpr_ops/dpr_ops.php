<?php
//ini_set('display_errors',1);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
	$database="dpr_ops";
	$check_cookie=strpos(@$_SERVER['HTTP_COOKIE'],"PHPSESSID=");
if(@$_SERVER['HTTP_ORIGIN']=="" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
if(@$_SERVER['HTTP_ORIGIN']=="" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
	{

	include("../../include/iConnect.inc");
	mysqli_select_db($connection, 'divper');
	
	extract($_REQUEST);
	$sql="SELECT $database as level, t1.currPark, t1.accessPark, t1.beacon_num
	from emplist as t1
	where t1.emid='$emid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql c=$connection");
	$row=mysqli_fetch_assoc($result);

	session_start();

	$database="dpr_proj";
	$_SESSION[$database]['level']=$row['level'];
	$_SESSION[$database]['tempID']=$tempID;
	$_SESSION['tempID']=$tempID;
	$_SESSION[$database]['emid']=$emid;
	$_SESSION[$database]['select']=$row['currPark'];
	$_SESSION[$database]['accessPark']=$row['accessPark'];
	$_SESSION[$database]['beacon_num']=$row['beacon_num'];
	
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	header("Location: overview.php");
	exit;
	}
?>
