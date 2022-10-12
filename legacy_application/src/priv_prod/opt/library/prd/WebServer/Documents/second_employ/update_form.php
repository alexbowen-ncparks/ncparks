<?php
ini_set('display_errors',1);
include("../../include/get_parkcodes_i.php");// database connection parameters

$database="second_employ";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
include("../../include/auth.inc"); // used to authenticate users

include("../../include/iConnect.inc");// database connection parameters

$skip=array("submit","action","id");
$clause="set ";
foreach($_POST as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$v=addslashes($v);
	$clause.="`$k`='".$v."',";
	}
$clause=rtrim($clause,",");
$db = mysqli_select_db($connection,'second_employ') or die ("Couldn't select database");

if($_POST['action']=="Enter")
	{
	$sql="INSERT INTO request $clause";
//echo "$sql"; exit;
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$id=mysqli_insert_id($connection);
	}
	else
	{
	$id=$_REQUEST['id'];
	$sql="UPDATE request $clause WHERE id='$id'";
//echo "$sql"; exit;
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	}

//echo "$sql"; exit;

header("Location: form.php?a=1&id=$id");


?>
