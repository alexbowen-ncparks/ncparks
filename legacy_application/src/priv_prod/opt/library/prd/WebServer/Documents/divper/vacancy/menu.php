<?php
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("/opt/library/prd/WebServer/include/auth.inc"); // used to authenticate users
//print_r($_SESSION);//exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;

echo "<html><head><title>NC DPR Division Personnel</title>";
echo "<script language=\"JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>";

include("css/TDnull.php");

ini_set('display_errors',1);

echo "<body bgcolor='beige'>
<div align='center'>
<table border='1' cellpadding='5'>";
echo "<tr>";

$tempLevel=$_SESSION['divper']['level'];

// ******** Menu 1 Positions *************
$menu_array=array("Request to Post Vacancy"=>"/vacancy/request2post.php");

echo "<td><form><select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Actions</option>";$s="value";
foreach($menu_array as $k=>$v)
	{
	echo "<option $s='$v'>$k</opton>\n";
	}
   echo "</select></form></td>";


   echo "</td></tr></table>";
echo "</div>";
?>