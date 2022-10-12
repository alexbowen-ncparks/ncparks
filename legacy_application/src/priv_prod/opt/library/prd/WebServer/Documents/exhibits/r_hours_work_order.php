<?php
session_start();
if($_SESSION['work_order']['level']<4){exit;}
//ini_set('display_errors',1);
extract ($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$_POST['work_order_number']=$work_order_number;
include("search.php");
	
?>