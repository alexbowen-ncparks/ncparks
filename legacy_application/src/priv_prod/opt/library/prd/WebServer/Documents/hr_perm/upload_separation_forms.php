<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
date_default_timezone_set('America/New_York');

$database="hr_perm";
include("../../include/iConnect.inc"); // includes no_inject.php

foreach($_FILES['files']['tmp_name'] as $id=>$v)
	{
	if(empty($v)){continue;}
	
	$error=$_FILES['files']['error'][$id];
	if($error==0)
		{
		$pass_emp_id=$_POST['pass_emp_id'];
		$tempID=$_POST['tempID'];
		
		$temp_name=$_FILES['files']['tmp_name'][$id];

		$var_file_name=$_FILES['files']['name'][$id];
		$var_file_name=str_replace(" ","_",$var_file_name);
		$var_file_name=str_replace("&","_",$var_file_name);
		$var_file_name=str_replace("'","",$var_file_name);
		$exp=explode(".",$var_file_name);
		$ext=array_pop($exp);

		$form_name=$_POST['form_name'][$id];
		$form_name=str_replace(" ","_",$form_name);
		$form_name=str_replace("'","",$form_name);
		$form_name=str_replace("\\","",$form_name);
		$upload_form_name=$form_name.":".$tempID."_".time().".$ext";
// 		echo "$db_form_name $upload_form_name"; exit;

		$uploaddir = "hr_perm_separation_forms"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{
			mkdir ($uploaddir, 0777);
			}

		$year=date("Y");
	 	$uploaddir.="/".$year;
	 	if (!file_exists($uploaddir))
	 		{
	 		mkdir ($uploaddir, 0777);
	 		}

		$form_link = $uploaddir."/".$upload_form_name;

		move_uploaded_file($temp_name, $form_link);// create file on server

			$sql="REPLACE INTO separation_forms 
			set form_number='$id', employee_id='$pass_emp_id', form_name='$form_name', upload_form_name='$upload_form_name', form_link='$form_link'"; 
// 		echo "$sql"; //exit;
			$result = mysqli_query($connection,$sql) or die();
		}

	}
$_POST['v']="separations";
$_POST['var_menu_item']="separations";
$_POST['pass_emp_id']=$pass_emp_id;
$_POST['submit_form']="Separation Forms";
include("menu_target.php");
?>