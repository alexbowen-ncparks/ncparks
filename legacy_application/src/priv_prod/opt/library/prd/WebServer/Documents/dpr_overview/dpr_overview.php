<?php
//ini_set('display_errors',1);
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
	$database="dpr_overview";
// 	$check_cookie=strpos(@$_SERVER['HTTP_COOKIE'],"PHPSESSID=");
// if(@$_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)
// if(@$_SERVER['HTTP_ORIGIN']=="https://10.35.152.9" or @$_SERVER['HTTP_REFERER']=="http://www.dpr.ncparks.gov/$database/index.html" or $check_cookie>-1)

	include("../../include/salt.inc");
	include("../../include/iConnect.inc");
	mysqli_select_db($connection, 'divper');
// 	include("../no_inject_i.php");
	
// 	extract($_REQUEST);
	$sql="SELECT $database as level, t1.currPark, t1.accessPark, t1.beacon_num, t1.password
	from emplist as t1
	where t1.emid='$emid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query.");
	$row=mysqli_fetch_assoc($result);
	 $ck_pword=md5($salt.$row['password']); 
	 if($ck_pword!=$ck2)
	 	{
// 	 	echo "$ck2<br />$ck_pword";
	 	exit;
	 	}
	session_start();

	$database="dpr_overview";
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
	
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	header("Location: overview.php");
	exit;
	
?>
