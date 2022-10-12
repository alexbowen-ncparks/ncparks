<?php
ini_set('display_errors',1);

$database="retail";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters

mysqli_select_db($connection,$database);

//echo "<pre>"; print_r($_POST); echo "</pre>";

foreach($_POST['website'] as $id=>$value)
	{
	$sql="UPDATE  outlets set website='$value' where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	if(!empty($_POST['sold_at_park'][$id]))
		{
		$value=$_POST['sold_at_park'][$id];
		if($value=="-"){$value="";}
		$sql="UPDATE  outlets set sold_at_park='$value' where id='$id'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	
	
	if(!empty($_POST['who_sells'][$id]))
		{
		$value=$_POST['who_sells'][$id];
		if($value=="-"){$value="";}
		$sql="UPDATE  outlets set who_sells='$value' where id='$id'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
		
	if(!empty($_POST['retail_staff'][$id]))
		{
		$value=$_POST['retail_staff'][$id];
		if($value=="-"){$value="";}
		$sql="UPDATE  outlets set retail_staff='$value' where id='$id'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	}


header("Location: form.php");
?>