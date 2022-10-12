<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
//print_r($_SESSION);//exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;

echo "<html><head><title>NC DPR Division Personnel</title>";

include("css/TDnull.php");

ini_set('display_errors',1);

echo "<body>
<div align='center'>
<table border='1' cellpadding='5'>";
echo "<tr>";

$tempLevel=$_SESSION['divper']['level'];

// ******** Menu 1 *************
$menuArray=array("/divper/position_desc.php"=>"Position Description","/divper/print_matter/listing.php"=>"Publication Inventory","/divper/formEmpInfo_reg.php?q=name"=>"Find Employee by Last  Name");

	
echo "<form><td><select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Database</option>";
foreach($menuArray as $file=>$title)
	{
	echo "<option value='$file'>$title</option>\n";
	}
   echo "</select></td></form>";


   echo "</tr></table>";

?>