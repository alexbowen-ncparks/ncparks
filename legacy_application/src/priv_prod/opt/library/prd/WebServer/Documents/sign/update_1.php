<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
$database="sign";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
  if($_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM sign_list_1 where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
		echo "Record was successfully deleted.";
		echo "Return to <a href='menu.php'>main page</a> of Sign database.";
		
		exit;
		}
		
if($_POST['submit']=="Update")
	{
//  echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
// 	$skip1=array("year","month","day","submit","id","category_standard","pass_category");
	$skip1=array("submit","id","category_standard","pass_category");
	$skip2=array("submit","id");
	if(@$_POST['category_standard']!="")
		{
		$_POST['category']=$_POST['category_standard'];
		}
		foreach($_POST AS $k=>$v)
			{
			if(in_array($k,$skip1))
	//		if(in_array($k,$skip1) OR $v=="")
				{continue;}
			
			$test=explode("-",$k);
			if(in_array($test[0],$skip1)){continue;}
			
			if($k=="dpr"){$pass_dpr=$v;}
			if($k=="PASU_approv")
				{
				foreach($v as $ind1=>$val1)
					{
					@$value1.=$val1.",";
					}
				$v=rtrim($value1,",");
				$value1="";
			
				}
// 			$v=mysqli_real_escape_string($v);		
			$v=html_entity_decode(htmlspecialchars_decode($v));		
			@$clause.=$k."='".$v."',";
			}
		
	$clause="set ".rtrim($clause,",");
	$sql = "UPDATE sign_list_1 $clause WHERE id='$id'";
//  echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection)); 
	$clause="";
	
	// ****** uploads
	include("upload_code_1.php");
	//exit;
	$file="edit_".$pass_category.".php";
	header("Location: $file?id=$id");
	}
?>