<?php
$database="hr_perm"; 
$dbName="hr_perm";

session_start();
$level=$_SESSION[$dbName]['level'];
if($level<1){exit;}

include_once("../../include/iConnect.inc");
// extract($_GET);
$sql="SELECT form_link from separation_forms 
where employee_forms_id='$efi' and employee_id='$pass_emp_id'"; 
// echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die();
$row=mysqli_fetch_assoc($result);
extract($row);
if(!empty($form_link))
	{	
	$sql="DELETE from separation_forms where employee_forms_id='$efi'"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die();
	unlink($form_link);
	}
$_POST['v']="separations";
$_POST['var_menu_item']="separations";
$_POST['pass_emp_id']=$pass_emp_id;
$_POST['submit_form']="Separation Forms";
include("menu_target.php");
?>