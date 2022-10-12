<?php
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$clause="";
$skip_update=array("submit","id","proj_type","review_code","how_done","proj_id","VAR");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_update)){continue;}
//	$value=mysqli_real_escape_string($connection,$value);
// 	values escaped in no_inject_i.php

	if($fld=="proj_name")
		{
		$value=str_replace("&", "and ", $value);
		}
	if($fld=="next_comment")
		{
		if(!empty($value))
			{
			$temp=substr($_SESSION['dpr_proj']['tempID'],0, -4)."@".date("Y-m-d H:i");
			$clause.="`proj_comments`=concat(`proj_comments`, '$value', ' -- ', '$temp', '\n\n'), ";
			}
		continue;
		}
	if($fld=="edits")
		{
		$temp=substr($_SESSION['dpr_proj']['tempID'],0, -4)."@".date("Y-m-d H:i");
		$clause.="`edits`=concat('$temp', ' -- ', edits), ";
		}
		else
		{
		if($fld=="park_code")
			{
			$value=str_replace(" ","",strtoupper($value));
			}
		if($fld=="proj_type")
			{
			$value=str_replace(" ","",strtoupper($value));
			}
		$clause.=$fld."='$value', ";
		}
	}
$clause=rtrim($clause,", ");	
if(!empty($_POST['proj_type'][0]))
	{
	$clause.=", proj_type='";
	foreach($_POST['proj_type'] as $k=>$v)
		{
		$clause.="$v,";
		}
	$clause=rtrim($clause,",")."'";
	}	


$clause.=", how_done='";
foreach($_POST['how_done'] as $k=>$v)
	{
	if(!empty($v))
		{
		$temp_v=$how_done_array[$k];
		$clause.="$temp_v*".$v.",";
		}
		else
		{$clause.=",";}
	}
$clause.="'";
//$clause=rtrim($clause,",")."'";
	
if(!empty($_POST['review_code']) and $_POST['review_code']!="Admin")
	{
	$clause.=", ".$_POST['review_code']."_date='".date('Y-m-d')."'";
	}
	
$this_r=$_SESSION['dpr_proj']['review_level'];
	$next_r=$_SESSION['dpr_proj']['next_reviewer'];
// echo "review_level=$this_r n=$next_r";
if($this_r=="chom")  // auto complete next level when reviewer is Chief of Maint. ENSU vacant.
	{
	include("get_emails.php");
	$next_r=$_SESSION['dpr_proj']['next_reviewer'];
	$ck_array=${$next_r."_email"};
	if(is_array($ck_array))
		{
		$is_vacant=strpos($ck_array[0], "vacant");
		if($is_vacant>0)
			{
			$next_recommend=$next_r."_recommend='Yes'";
			$next_date=$next_r."_date='".date("Y-m-d")."'";
			$next_comments=$next_r."_comments='Position vacant. Review auto_submitted by program.'";
			$clause.=", ".$next_recommend;
			$clause.=", ".$next_date;
			$clause.=", ".$next_comments;
			}
		}
// 	echo "$clause"; exit;
	// echo "<pre>"; print_r($ck_array); echo "</pre>";  exit;
	}

mysqli_select_db($connection, "dpr_proj");
$id=$_POST['id'];
$clause.=" WHERE id='$id'";
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$sql="UPDATE project set $clause";  
//echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));

$sql="SELECT * from project where id='$id'";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
?>