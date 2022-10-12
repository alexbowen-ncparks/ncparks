<?php
$database="fixed_assets";
mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
date_default_timezone_set('America/New_York');

echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

foreach($_POST['fas_num'] as $id=>$value)
	{
	if(is_array($value)){continue;}
	
	$ts=time();
	$fas_num=$value;
	$fn_unique=$fas_num;
	if(strtoupper($value)=="NA")
		{
		$var_fn=$_POST['fn_unique'][$id];
		$sql="UPDATE surplus_track
		set ts='$ts' WHERE  fn_unique='$var_fn'
		";
		$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
		continue;
		}
		
	$sn=$_POST['serial_num'][$id];
	$mn=$_POST['model_num'][$id];
	$qty=$_POST['qty'][$id];
	$desc=addslashes($_POST['description'][$id]);
	$con=$_POST['condition'][$id];
	$photo_upload=$_POST['photo_upload'][$id];
	
	$pasu_date=$_POST['pasu_date'];
	$disu_date=$_POST['disu_date'];
	$chop_date=$_POST['chop_date'];
	$location=$_POST['location'];
	
	$pasu_name=$_POST['pasu_name'];
	$disu_name=$_POST['disu_name'];
	$chop_name=$_POST['chop_name'];
	
	$sql="REPLACE surplus_track
	set ts='$ts', fn_unique='$fn_unique', fas_num='$fas_num', serial_num='$sn', model_num='$mn', qty='$qty', description='$desc', `condition`='$con', pasu_date='$pasu_date', disu_date='$disu_date', chop_date='$chop_date', location='$location', pasu_name='$pasu_name', disu_name='$disu_name', chop_name='$chop_name', photo_upload='$photo_upload'
	";
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
//	echo "$sql<br />";
	}
//exit;

// *************  Misc. *******************
	$misc_array=array("fas_num","serial_num","model_num","qty","description","condition");
	$count=count($_POST['fas_num']['misc']);
	
	for($j=1;$j<=$count;$j++)
		{
		$clause="set ";
		$ts_x=$ts."_".$j;
				$clause.="`fn_unique`='$ts_x', ";
		$check="";
		foreach($misc_array as $index=>$fld)
			{
			$value=$_POST[$fld]['misc'][$j];
				
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
	
		$sql="REPLACE	surplus_track
		$clause ts='$ts', pasu_date='$pasu_date', disu_date='$disu_date', chop_date='$chop_date', location='$location', pasu_name='$pasu_name', disu_name='$disu_name', chop_name='$chop_name', photo_upload=photo_upload";
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());

		}
		
// *********************** Upload Photo(s) *****************
include("upload_photo.php");
//	exit;
?>

