<?php
mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
extract($_POST);
if(@$_POST["submit_form"]=="Delete Person")
	{
	$sql="SELECT link from web_links where track_id='$id'"; echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		unlink($link);
		$sql="DELETE from web_links where track_id='$id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	
	$sql="DELETE FROM applicants where id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	echo "That person has been removed."; exit;
	}

$skip=array("id","submit_form","track");	
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	$temp[]=$fld."='".$value."'";
	}
$temp[]="`track`=concat(`track`,'-','".$_POST['track']."')";
$clause=implode(",",$temp);
$id=$_POST['id'];

if(!isset($ARRAY_forms))
	{
	$sql="SELECT * from required_forms_2";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_forms[]=$row['form_name'];
		}
	}
	
$sql="UPDATE applicants set $clause where id='$id'"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));


?>