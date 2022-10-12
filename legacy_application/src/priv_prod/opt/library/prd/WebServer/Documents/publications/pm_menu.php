<?php
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

ini_set('display_errors',1);
echo "<html><head><title>NC DPR Publications</title>";

include("/opt/library/prd/WebServer/Documents/css/TDnull.php");
date_default_timezone_set('America/New_York');

echo "<body>";

$menu1=array("List Publication Inventory");
$menu2=array("/publications/listing.php");

include_once("../../include/get_parkcodes_i.php");

if($level==2)
	{
	$distCode=$_SESSION['publications']['select'];
	$menuList="array".$distCode; $distList=${$menuList};
	//echo "$distCode"; print_r($distList);exit;
	}


if($level>3){
$menu1[]="Modify Tracked Pubs";
$menu2[]="/publications/modify.php";
// $menu1[]="Upload Steward";
// $menu2[]="/publications/steward.php";
}

echo "<table><tr><td><form><select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
for ($n=0;$n<count($menu1);$n++){
$con=$menu2[$n];
		echo "<option $s='$con'>$menu1[$n]\n";
       }

echo "</select></form></td>";

$parkList=explode(",",@$_SESSION['publications']['accessPark']);

if($parkList[0]!=""){
if($parkcode AND in_array($parkcode,$parkList)){$_SESSION['publications']['select']=$parkcode;}
echo "<td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\">";
foreach($parkList as $k=>$v){
$con1="listing.php?parkcode=$v";
	if($v==$_SESSION['publications']['select']){$s="selected";}else{$s="value";}
		echo "<option $s='$con1'>$v\n";
       }
   echo "</select></td></form>";
}
echo "</tr></table>";
?>