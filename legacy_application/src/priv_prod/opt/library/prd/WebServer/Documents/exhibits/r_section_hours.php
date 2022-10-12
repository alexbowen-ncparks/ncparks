<?php
session_start();
if($_SESSION['work_order']['level']<4){exit;}
//ini_set('display_errors',1);
extract ($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$_POST['section']=str_replace("_"," ",$section);
include("search.php");
	
?>