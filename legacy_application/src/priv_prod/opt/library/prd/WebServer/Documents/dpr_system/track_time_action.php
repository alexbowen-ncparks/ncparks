<?php
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
// 	echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;

if(!empty($_GET['link']) and $act=="Delete")
	{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
	$link=$_GET['link'];
	$exp=explode("/", $link);
	$exp1=explode("_",array_pop($exp));
	$pass_ticket_id=$exp1[0];
	$sql="DELETE FROM track_time_uploads where ticket_id='$pass_ticket_id' and link='$link'";
// 	echo "$sql<pre>"; print_r($exp1); echo "</pre>"; exit;
	$result = mysqli_query($connection,$sql) or die("13 $sql ".mysqli_error($connection));
	unlink($link);
	$_POST['submit_form']="";
	}
if($_POST['submit_form']=="Add")
	{
	$skip_action_insert=array("ticket_id","submit_form","notes","date_update","time_in_hours","send_email");
	$temp=array();
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_action_insert)){continue;}
		$temp[]="$fld='$val'";
		}
	$clause=implode(",",$temp);
	$sql="INSERT INTO track_time set $clause";
// 	echo "$sql<br /><br />"; exit;
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$insert_id=mysqli_insert_id($connection);
	
	if(!empty($send_email))
		{
		include("send_email.php");
		}
		
	$location_code=$_POST['location_code'];

	$temp=array();
	$skip_action_update=array("ticket_id","submit_form","ticket_status","resolution", "date_create","location_code","employee_status","client","activity","database_app","sub_application","send_email");
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_action_update)){continue;}
		$temp[]="$fld='$val'";
		}
	$temp[]="ticket_id='$insert_id'";
	$clause=implode(",",$temp);
	$sql="INSERT INTO track_time_updates set $clause";
	$result = mysqli_query($connection,$sql) or die("50 $sql ".mysqli_error($connection));
	
	if(!empty($_FILES))
		{
		$ticket_id=$insert_id;
		include("track_time_file_upload.php");
		}
	}
	
if($_POST['submit_form']=="Update")
	{
	$skip_action=array("ticket_id","submit_form","time_in_hours","send_email");
	
		if($_POST['resolution']=="complete")
			{
			$_POST['notes'].=" Completed";
// 			echo "<pre>"; print_r($_POST); echo "</pre>";
			}
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_action)){continue;}
		$temp[]="$fld='$val'";
		}
	$clause=implode(",",$temp);

	$temp=array();
	$sql="UPDATE track_time set $clause WHERE ticket_id='$ticket_id'";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("46 $sql ".mysqli_error($connection));
	$pass_ticket_id=$ticket_id;
	
	if(!empty($send_email))
		{
		$insert_id=$ticket_id;
		include("send_email.php");
		}
		
	$temp=array();
	$insert_action=array("ticket_id", "time_in_hours", "notes", "user_id");
	foreach($_POST as $fld=>$val)
		{
		if(!in_array($fld, $insert_action)){continue;}
		$temp[]="$fld='$val'";
		}
	$clause=implode(",",$temp);
	$sql="INSERT INTO track_time_updates set $clause";
// 	echo "$sql";
	$result = mysqli_query($connection,$sql) or die("58 $sql ".mysqli_error($connection));
	$insert_id=$ticket_id;
	if(!empty($_FILES))
		{
		include("track_time_file_upload.php");
		}
	}

?>