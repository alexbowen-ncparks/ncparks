<?php
if(empty($_SESSION))
	{
	session_start();
	$set_cycle=$_SESSION['rtp']['set_cycle'];
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
	}

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

//  echo "Still in test mode.<pre>"; print_r($_POST); echo "</pre>";  exit;
extract($_POST);

include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$TABLE="nctc_track_subjective_scores";

$set_cycle=="pa"?$TABLE.="_pa":$TABLE;

$pfn=$_POST['project_file_name'];

if(!EMPTY($individual_comments_add))
	{
	$sql="INSERT INTO $TABLE
	set individual_comments='$individual_comments_add', member_name='$member_name', project_file_name='$pfn'
	"; 
//  	 ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}

/*
if(!EMPTY($group_comments))
	{
	$sql="UPDATE $TABLE
	set group_comments=concat(`group_comments`, '$group_comments', '\n')
	where project_file_name='$pfn'
	"; 
// 	 ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_affected_rows($connection)<1)
		{
		$sql="INSERT INTO $TABLE
		set group_comments=concat('$group_comments', '\n'), project_file_name='$pfn'
		"; 
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
		}
	}
*/


if(!EMPTY($_POST['table_field']))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$skip_post=array("submit_form","project_file_name","table_field","individual_comments_add");
	$track_post=array("project_file_name","table_field", "com_member_0","com_member_1","com_member_2", "com_member_3", "com_member_4", "com_member_5", "com_member_6");
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip_post)){continue;}
		if($value==="")
			{$var[]=$fld."=NULL";}
			else
			{$var[]=$fld."='$value'";}
		
		}
//	$editor=$_POST['editor'];
	$table_field=$_POST['table_field'];
	$clause=implode(",",$var);
	//$clause.=", editor=concat(editor,' | ','".$table_field.":".$editor."')";
	
	if($set_cycle=="fa")
		{
		$sql="UPDATE $TABLE
		set $clause
		where project_file_name='$pfn' and member_name='$member_name'
		"; 
// 		echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$num=mysqli_affected_rows($connection);
		if($num===0)
			{
			$clause.=", project_file_name='$pfn'";
			$sql="INSERT INTO $TABLE
			set $clause
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
	
		}
	if($set_cycle=="pa")
		{		
		$sql="UPDATE $TABLE
		set $clause
		where project_file_name='$pfn'
		"; 
	//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$num=mysqli_affected_rows($connection);
		if($num===0)
			{
			$clause.=", project_file_name='$pfn'";
			$sql="INSERT INTO $TABLE
			set $clause
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			}
		}
//	ECHO "$sql"; exit;
}

header("Location: view_nctc_subjective_score.php?project_file_name=$pfn&sc=subjective");
?>