<?php

//echo "8<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

       $database="irecall";
include("../../include/iConnect.inc"); // new login method

extract($_POST);


$upperID = strtoupper($ftempID);
$tempID = $ftempID;

mysqli_select_db($connection,"divper");
$sql = "SELECT tempID,password as cpassword,irecall, emid as id
FROM divper.emplist where tempID='$ftempID'";
$result = mysqli_query($connection,$sql) or die("Error 1: $sql");
//echo "$sql"; exit;
$row=mysqli_fetch_array($result);
//print_r($row);//exit;
extract($row);
$num=mysqli_num_rows($result);

if($num<1)
	{
	mysqli_select_db($connection,$database);
	$sql = "SELECT last_name as tempID, level, right(phone,4) as cpassword, formerid as id
	FROM irecall.former_emp 
	where last_name='$ftempID'";//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("Error 1: $sql");
	$num=mysqli_num_rows($result);


	if($num<1)
		{
		mysqli_select_db($connection,$database);
		$sql = "SELECT tempID, irecall as level, password as cpassword, emid as id
		FROM divper.nondpr 
		where tempID='$ftempID'";//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("Error 1: $sql ".mysqli_error($connection));
		$num=mysqli_num_rows($result);
		}
	while($row=mysqli_fetch_array($result))
		{
		extract($row);
		$passArray[]=$row['cpassword'];
		}
	}

$UtempID = strtoupper($tempID);
//echo "u=$fpassword $upperID $UtempID<br>";
//print_r($passArray);exit;
if($upperID==$UtempID)
	{
	// login is correct
	
	
	if(!in_array($fpassword,$passArray) AND $cpassword!=$fpassword)
		{
		$message_new = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
		include("login_form.php"); exit;
		 }
			 
			 // Login Correct

		header("Location: /irecall/irecall.php?name=$upperID&id=$id");exit;
		header("Location: /irecall/irecall.php?name=$upperID&id=$id");exit;
	
			 
	}
else  // login not correct
	{
	 unset($do);                                            // 53
	 $message_new = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
	 include("login_form.php");
	}

?>
