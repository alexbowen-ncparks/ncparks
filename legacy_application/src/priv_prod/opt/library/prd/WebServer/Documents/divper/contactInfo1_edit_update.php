<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database); // database

// echo "<pre>";print_r($_POST);echo "</pre>"; //exit;
$skip=array("submit","section");
$loc=$_POST['section'];

foreach($_POST as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	foreach($v as $key=>$val)
		{
		if($k=="varCol"){$val=strtoupper($val);}
		$string="$k='".html_entity_decode($val)."', ";
		$string=trim($string,", ");
		$query="UPDATE position SET $string, toggle='' where beacon_num='$key'"; 
		//	echo "$query<br><br>"; //exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query2. $query");
		}
		
	}
	
//		exit;
	$test=array_key_exists('toggle',$_POST);
	echo "29<pre>"; print_r($_POST['toggle']); echo "</pre>"; // exit;
	IF(!empty($test))
		{
		foreach($_POST['toggle'] as $key=>$val)
			{
			$query="UPDATE position SET toggle='x' where beacon_num='$key'";  //echo "$query";
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query2. $query");
			}
		}
// exit;
header("Location: contactInfo1_edit.php?loc=$loc");
?>