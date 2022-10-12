<?php

// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$skip=array("submit_form","action_type");
	$require_array=array("Lname","Fname","ssn_last4");
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(in_array($fld,$require_array) and empty($value)){$empty_array[]=$fld;}
		if($fld=="track")
			{
			$var_date=date("Y-m-d H:i:s");
			$value="concat('[','$value',' @ ', '$var_date',']')";		
			$temp[]=$fld."=".$value;
			continue;
			}
		$temp[]=$fld."='".$value."'";
		}
	
	$tempID=$_POST['Lname'].$_POST['ssn_last4'];
	$temp[]="tempID='".$tempID."'";
	$clause=implode(",",$temp);

	if(empty($empty_array))
		{
		$sql="INSERT INTO applicants SET $clause";
	// 	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die( mysqli_errno($connection)=="1062"?"Action could not be completed since it would create a duplicate record.":"");
		$ci_num=mysqli_insert_id($connection);
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
	if(!empty($ci_num) and empty($empty_array))
		{
		$id=$ci_num;
		$sql="SELECT * from applicants WHERE id='$id'"; //echo "w $sql";
		$result = mysqli_query($connection,$sql) or die(mysqli_errno($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row);
// 		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		}
	
?>