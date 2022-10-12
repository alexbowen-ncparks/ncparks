<?php
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>";print_r($_POST);  print_r($_FILES); echo "</pre>"; // exit;

$ts=time();

foreach($_POST['fas_num'] as $id=>$value)
	{
	if(is_array($value)){continue;}
	
	
	@$source=$_POST['source'][$id];
	$fas_num=$value;
	$fn_unique=$fas_num;
		
	if(empty($_POST['location'][$id]))
		{
		$location=$_POST['location'];
		}
		else
		{
		$location=$_POST['location'][$id];
		}
	if(empty($location))
		{echo "Contact Tom Howard and say that the LOCATION value is missing for the Surplus application."; exit;}
	$pass_location=$location;

	$center=$_POST['center'];

	$sn=$_POST['serial_num'][$id];
	$mn=$_POST['model_num'][$id];
	$qty=$_POST['qty'][$id];
// 	$desc=addslashes($_POST['description'][$id]);
	$desc=html_entity_decode(htmlspecialchars_decode($_POST['description'][$id]));
	$con=$_POST['condition'][$id];
	$photo_upload=$_POST['photo_upload'][$id];
	
	$pasu_date=$_POST['pasu_date'];
	$disu_date=$_POST['disu_date'];
	$chop_date=$_POST['chop_date'];
	
// 	$pasu_name=addslashes($_POST['pasu_name']);
	$pasu_name=html_entity_decode(htmlspecialchars_decode($_POST['pasu_name']));
// 	$disu_name=addslashes($_POST['disu_name']);
	$disu_name=html_entity_decode(htmlspecialchars_decode($_POST['disu_name']));
// 	$chop_name=addslashes($_POST['chop_name']);
	$chop_name=html_entity_decode(htmlspecialchars_decode($_POST['chop_name']));
// 	$comments=addslashes($_POST['comments'][$id]);
	$comments=html_entity_decode(htmlspecialchars_decode($_POST['comments'][$id]));
	$surplus_loc=$_POST['surplus_loc'];
	
	if(strtoupper($value)=="NA" or $source=="misc")
		{
		$var_fn=$_POST['fn_unique'][$id];
		$sql="UPDATE surplus_track
		set ts='$ts', fas_num='$fas_num', serial_num='$sn', model_num='$mn', qty='$qty', description='$desc', `condition`='$con', pasu_date='$pasu_date', disu_date='$disu_date', chop_date='$chop_date', location='$location', center='$center', pasu_name='$pasu_name', disu_name='$disu_name', chop_name='$chop_name', photo_upload='$photo_upload', source='misc', comments='$comments', surplus_loc='$surplus_loc'
		WHERE  fn_unique='$var_fn'
		";
	//	echo "misc $sql<br >"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		if($chop_date!="0000-00-00")
			{
			$pass_chop_approve_id=mysqli_insert_id($connection);
			}
		continue;
		}
		
		
	$sql="REPLACE surplus_track
	set ts='$ts', fn_unique='$fn_unique', fas_num='$fas_num', serial_num='$sn', model_num='$mn', qty='$qty', description='$desc', `condition`='$con', pasu_date='$pasu_date', disu_date='$disu_date', chop_date='$chop_date', location='$location', center='$center', pasu_name='$pasu_name', disu_name='$disu_name', chop_name='$chop_name', photo_upload='$photo_upload', source='FAS', comments='$comments', surplus_loc='$surplus_loc'
	";
//	echo "72 $sql<br />";  exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	if($chop_date!="0000-00-00")
		{
		$_POST['single_location']=$location;
		}
	}
//exit;

// *************  Misc. *******************
	$misc_array=array("fas_num","serial_num","model_num","qty","description","condition");
	$count=count($_POST['fas_num']['misc']);
	

	if(empty($location))
		{$location=$_POST['single_location'];}
	if(empty($center))
		{$center=$_POST['center'];}
	if(empty($pasu_date))
		{$pasu_date=$_POST['pasu_date'];}
	if(empty($pasu_name))
		{
// 		$pasu_name=addslashes($_POST['pasu_name']);
		$pasu_name=$_POST['pasu_name'];
		}
	if(empty($surplus_loc))
		{
// 		$surplus_loc=addslashes($_POST['surplus_loc']);
		$surplus_loc=$_POST['surplus_loc'];
		}
	
	$misc_photo=array();
	for($j=0;$j<$count;$j++)
		{
		$clause="set ";
		$ts_x="NA_".$ts."_".$j;
				$clause.="`fn_unique`='$ts_x', ";
		$check="";
		foreach($misc_array as $index=>$fld)
			{
			@$value=$_POST[$fld]['misc'][$j];
			$misc_photo[$j]="$ts_x";
				
			if($fld=="fas_num" and strtoupper($value)=="NA")
				{
				}
				else
				{
				$check.=$value;
				}			
			$clause.="`".$fld."`='$value', ";
			}
		if(empty($check)){continue;}
		if(empty($location))
			{
		//	echo "No Location was specified";
		//	exit;
			}
	
		$sql="REPLACE	surplus_track
		$clause ts='$ts', pasu_date='$pasu_date', disu_date='$disu_date', chop_date='$chop_date', location='$location', center='$center', pasu_name='$pasu_name', disu_name='$disu_name', chop_name='$chop_name', photo_upload='$photo_upload', source='misc', surplus_loc='$surplus_loc', comments='$comments'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	if($chop_date!="0000-00-00")
		{
		$_POST['single_location']=$location;
		}

//echo "129 $sql<br />"; 
		}
//echo "141 $sql<br />"; 
//exit;
// *********************** Upload Photo(s) *****************
include("upload_photo.php");
//	exit;
?>

