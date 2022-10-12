<?php

$database="divper";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database


//$cashier='ake2721';
//if($cashier=='Hunt3953'){$cashier='Barbour3953';}
//if($cashier)
//echo "tempid=$tempid"; exit;
//if($tempid=='Hunt3953'){$tempid='Barbour3953';}
//echo "tempid=$tempid<br >"; //exit;
//$tempid='Owen7422';
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";
	//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute sql. $sql");
	//$row=mysqli_fetch_array($result);
	//$num=mysqli_num_rows($result); echo "n=$num";
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$signature_name=$Fname." ".$Lname;
	
//echo "sql=$sql";
//echo "<br />Fname=$Fname<br />";
//echo "<br />Lname=$Lname<br />";
if($tempid=='Owen7422'){$signature_name='Rebecca Owen';}
//echo "<br />signature_name=$signature_name<br />";



?>