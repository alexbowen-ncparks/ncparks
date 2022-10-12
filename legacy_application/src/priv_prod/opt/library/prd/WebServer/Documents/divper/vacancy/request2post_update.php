<?php

//echo "<pre>"; print_r($_FILES);  print_r($_POST);echo "</pre>";  //exit;

include("../../../include/iConnect.inc");// database connection parameters
$database="divper";
mysqli_select_db($connection,$database)
       or die ("Couldn't select database");

EXTRACT($_REQUEST);
// ********* DELETE A FILE ***************************

if ($_POST['Delete'] == "Delete")
	{
	$mid=$_POST['mid'];
		if($mid!="")
			{
			$sql="SELECT link from file_upload where mid='$mid'";
			//		$result=mysqli_QUERY($sql);
			while ($row=mysqli_fetch_array($result)){
			extract($row);unlink($link);
			}
			
			$sql="DELETE FROM file_upload where mid='$mid'";
			//	$result=mysqli_QUERY($sql);
			//	header("Location: /trails/RTP/rtp_file_upload.php");
			}
	exit;
	}

$skip=array("submit");
if ($_POST['submit'] == "Update")
	{

// remove any previous upload links
$sql="SELECT addendum_file, skills_file from request_to_post 
where beacon_num='$beacon_num'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
$existing_addendum=$row['addendum_file']; //echo " $sql   ef=$existing_addendum"; exit;
$existing_skills=$row['skills_file'];

	// convert tempID into names
	$test_r=substr($_POST['request_by'],-1);
	$test_a=substr($_POST['approve_by'],-1);
	if($test_r>0)
		{
		$sql="SELECT concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as requester, t1.working_title as requester_title
		FROM divper.`empinfo` as t3
		LEFT JOIN divper.emplist as t2 on t2.emid=t3.emid
		LEFT JOIN divper.position as t1 on t1.beacon_num=t2.beacon_num
		where t3.tempID='$_POST[request_by]'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
		$_POST['request_by']=$row['requester']." - ".$row['requester_title'];
		}
	if($test_a>0)
		{
		$sql="SELECT concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as requester, t1.working_title as requester_title
		FROM divper.`empinfo` as t3
		LEFT JOIN divper.emplist as t2 on t2.emid=t3.emid
		LEFT JOIN divper.position as t1 on t1.beacon_num=t2.beacon_num
		where t3.tempID='$_POST[approve_by]'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
		$_POST['approve_by']=$row['requester']." - ".$row['requester_title'];
		}

	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
// 		$value=mysqli_real_escape_string($value);
		$clause.=$fld."='".$value."',";
		}
	$clause=rtrim($clause,",");
	if($_POST['addendum_ck']=='n' AND empty($_FILES['file_upload']['name']['addendum']))
		{$clause.=",addendum_file=''";}
		else
		{$clause.=",addendum_file='$existing_addendum'";}
	if($_POST['skills_ck']=='n' AND empty($_FILES['file_upload']['name']['skills']))
		{$clause.=",skills_file=''";}
		else
		{$clause.=",skills_file='$existing_skills'";}
	$sql = "REPLACE request_to_post SET $clause";
//	echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$id=mysqli_insert_id($connection);

// add any file uploads
	include("request2post_upload.php");

	header("Location: request2post.php?beacon_num=$beacon_num");
	exit;
	}
	
?>