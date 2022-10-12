<?php
ini_set('display_errors', 1);
if($_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

if(empty($_SESSION)){session_start();}

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
$clause="";
$skip=array("id","submit");
$not=array("park_code","pasu_approve","photo_link");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(!in_array($fld,$not))
		{$fld=str_replace("_"," ",$fld);}
	
	$clause.="`$fld`='$value', ";
	}
$clause=rtrim($clause,", ");
if(!empty($_POST['id']))
	{
	$id=$_POST['id'];
	$sql="UPDATE dncr_1920 set $clause where id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	}
	else
	{
	$sql="INSERT INTO dncr_1920 set $clause";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$id=mysqli_insert_id($connection);
	}
if($_SESSION['dpr_system']['tempID']=='Howard6319')
	{
//	echo "$sql"; exit;
	}

mysqli_close($connection);


header("Location: dncr_request.php?id=$id");
?>