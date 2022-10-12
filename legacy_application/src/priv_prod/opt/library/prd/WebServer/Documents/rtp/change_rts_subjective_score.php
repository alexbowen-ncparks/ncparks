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
session_start();
$tempID=$_SESSION['rtp']['tempID'];

//  echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);

$TABLE="rts_track_subjective_scores";

$set_cycle=="pa"?$TABLE.="_pa":$TABLE;

$pfn=$_POST['project_file_name'];

if(!EMPTY($_POST['individual_comments_add']))
	{
	$sql="UPDATE $TABLE
	set individual_comments=concat(individual_comments, '".$_POST['individual_comments_add']."', ': $tempID', '\n')
	where project_file_name='$pfn'
	"; 
// 	 ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}

if(!EMPTY($_POST['group_comments_add']))
	{
	$sql="UPDATE $TABLE
	set group_comments=concat(group_comments,'".$_POST['group_comments_add']."', '\n')
	where project_file_name='$pfn'
	"; 
// 	 ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
	
if(!EMPTY($_POST['comments_to_nctc_add']))
	{
	$sql="UPDATE $TABLE
	set comments_to_nctc=concat(comments_to_nctc,'".$_POST['comments_to_nctc_add']."', '\n')
	where project_file_name='$pfn'
	"; 
 //	 ECHO "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
if(!EMPTY($_POST['table_field']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip_post=array("submit_form","project_file_name","editor","table_field");
	$track_post=array("project_file_name","table_field","editor", "mountain", "piedmont", "coastal");
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip_post)){continue;}
		if($value==="")
			{$var[]=$fld."=NULL";}
			else
			{$var[]=$fld."='$value'";}
		
		}
	$editor=$_POST['editor'];
	$table_field=$_POST['table_field'];
	$clause=implode(",",$var);
	$clause.=", editor=concat(editor,' | ','".$table_field.":".$editor."')";
	
	if($set_cycle=="fa")
		{
		$sql="UPDATE $TABLE
		set $clause
		where project_file_name='$pfn'
		"; 
//		echo "$sql"; exit;
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
//		echo "$sql"; exit;
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

header("Location: view_subjective_score.php?project_file_name=$pfn&sc=subjective");
?>