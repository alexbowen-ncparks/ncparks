<?php
ini_set('display_errors',1);

$database="retail";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters

mysqli_select_db($connection,$database);

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

$skip=array("submit");
$clause="set ";
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}

	$clause.="$fld='".$value."',";
	}
	$clause=rtrim($clause,",");
	$id=$_POST['id'];
	$vn=$_POST['vendor_name'];
	$sql="REPLACE vendors $clause";
//	echo "$sql";exit;
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

header("Location: vendors.php?u=1&edit=1&id=$id&vendor_name=$vn");
?>