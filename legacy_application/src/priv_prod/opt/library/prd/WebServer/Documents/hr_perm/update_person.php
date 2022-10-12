<?php
ini_set('display_errors',1);
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("submit_form","id","action_type","submit_form");
	$require_array=array("Lname","Fname","ssn_last4");
if(empty($_POST['page_source']))
	{
// 	echo "8<pre>"; print_r($_POST); echo "</pre>";  //exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(in_array($fld,$require_array) and empty($value)){$empty_array[]=$fld;}
		if($fld=="track")
			{
			$value=substr($_SESSION['hr_perm']['tempID'],0, -4);
			$var_date=date("Y-m-d H:i:s");
			$value="concat('[','$value',' @ ', '$var_date',']*', `track`)";		
			$temp[]=$fld."=".$value;
			continue;
			}
		$temp[]=$fld."='".$value."'";
		}
	}
// echo "temp<pre>"; print_r($temp);  print_r($_POST); echo "</pre>"; // exit;
if(!empty($_POST['page_source']))
	{
	$sql="SELECT * from applicants WHERE id='$id'"; //echo "w $sql"; //exit;
		$result = mysqli_query($connection,$sql) or die(mysqli_errno($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row);
	}
	
	if(!empty($temp))
		{
		$tempID=$_POST['Lname'].$_POST['ssn_last4'];
		$temp[]="tempID='".$tempID."'";
		$clause=implode(",",$temp);
		
		if(empty($empty_array))
			{
			$sql="UPDATE applicants SET $clause where id='$id'";
// 		echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die( mysqli_errno($connection)=="1062"?"Action could not be completed since it would create a duplicate record.":"");
// 		if($result){echo "yes"; exit;}
			}
		}
		

	if(!empty($empty_array))
		{
// 		echo "33<pre>"; print_r($empty_array); echo "</pre>";  exit;
		echo "<font color='red'>";
		foreach($empty_array as $k=>$v)
			{
			echo "Information for $v must be entered.<br />";
			}
		echo "</font>";
		}
	if(empty($empty_array))
		{
		$sql="SELECT * from applicants WHERE id='$id'"; //echo "w $sql"; //exit;
		$result = mysqli_query($connection,$sql) or die(mysqli_errno($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
	
?>