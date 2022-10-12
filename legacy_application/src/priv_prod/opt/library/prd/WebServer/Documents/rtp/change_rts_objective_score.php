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

include("../../include/iConnect.inc");
extract($_POST);
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

$test_update=${$table_field};
$pfn=$_POST['project_file_name'];
if($old_value != $test_update)
	{
	if(empty($why_change_add))
		{
		$message="You must indicate a reason for changing the $table_field value.<br />$pfn NOT updated.<br />";
		header("Location: /rtp/view_objective_score.php?project_file_name=$pfn&message=$message");
		exit;
		}
	}
mysqli_select_db($connection,$dbName);


include("scoring_arrays.php");

//"why_change",
$skip_post=array("why_change_add","submit_form","project_file_name","table_field", "editor", "old_value", "old_index");
$track_post=array("why_change_add","table_field","editor", "old_value");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_post)){continue;}
	$var[]=$fld."='$value'";
	}
$clause=implode(",",$var);
$pfn=$_POST['project_file_name'];

$TABLE=$scoring_flds_table[$_POST['table_field']];

$set_cycle=="pa"?$TABLE.="_pa":$TABLE;

$sql="UPDATE $TABLE
set $clause
where project_file_name='$pfn'
"; 
// ECHO "$set_cycle $sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

unset($var);
foreach($_POST as $fld=>$value)
	{
	if(!in_array($fld,$track_post)){continue;}
	IF($fld=="why_change_add" and !empty($value))
		{
		$value.=": ".$_SESSION['rtp']['username'];
		$var[]="why_change=concat(why_change,'$value', '\n')";
		continue;
		}
	$var[]=$fld."='$value'";
	}
$clause=implode(",",$var);
$var_table_fld=$_POST['table_field'];
$twt=$_POST[$var_table_fld];
$clause.=", new_value='$twt'";

$set_cycle=="pa"?$TABLE="track_objective_score_updates_pa":$TABLE="track_objective_score_updates";
$sql="UPDATE $TABLE
set $clause
where project_file_name='$pfn' and table_field='$var_table_fld'
"; 
// echo "$sql<pre>"; print_r($_POST); echo "</pre>";  exit;
//  ECHO "<br /><br />$sql"; exit;
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
header("Location: view_objective_score.php?project_file_name=$pfn");
?>