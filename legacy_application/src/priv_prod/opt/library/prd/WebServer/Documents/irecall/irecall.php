<?php

//if(empty($_SERVER['HTTP_COOKIE'])){exit;}

$database="divper";
$db="irecall";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
 //echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

extract($_REQUEST);
mysqli_select_db( $connection,$database); // database 

$sql = "SELECT tempID,password as cpassword,irecall as level
FROM divper.emplist where emid='$id' and tempID='$name'";
$result = mysqli_query($connection,$sql) or die("Error 1: $sql");
//echo "$sql"; exit;
$row=mysqli_fetch_array($result);
//print_r($row);//exit;
extract($row);
$num=mysqli_num_rows($result);

if($num<1)
	{
	mysqli_select_db($connection,"irecall");
	$sql = "SELECT last_name as tempID,level,right(phone,4) as cpassword 
	FROM irecall.former_emp 
	where formerid='$id' and last_name='$name'";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("Error 1: $sql");
	$num=mysqli_num_rows($result);
	

	if($num<1)
		{
		mysqli_select_db($database,$connection);
		$sql = "SELECT tempID, irecall as level, password as cpassword, emid as id
		FROM divper.nondpr 
		where tempID='$name'";//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("Error 1: $sql ".mysqli_error($connection));
		$num=mysqli_num_rows($result);
		}
	while($row=mysqli_fetch_array($result))
		{
		extract($row);
		$passArray[]=$row['cpassword'];
		}
	}

if($num<1)
	{
	echo "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>$sql";
	 exit;
	 }
			 
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  EXIT;
$user_address=$_SERVER['REMOTE_ADDR'];
mysqli_select_db($connection,$db); // database 
$sql = "INSERT INTO login set loginName='$tempID',loginTime=now(),userAddress='$user_address',level='$level'"; 
//echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

session_start();
$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['tempID'] = $tempID;

header("Location: view.php");
?>
