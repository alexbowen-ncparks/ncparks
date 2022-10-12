<?php
$title="Photo Point Application";
$add_cal=1;
include("../inc/_base_top_photo_point.php");
ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
extract($_REQUEST);

include("../../include/get_parkcodes_dist.php");

$database="photo_point";
@$level=$_SESSION[$database]['level'];
@$tempID=$_SESSION[$database]['tempID'];
@$emid=$_SESSION[$database]['emid'];
date_default_timezone_set('America/New_York');

if(empty($connection))
	{
	include("../../include/iConnect.inc");
	}
mysqli_select_db($connection, $database);

if($level<1)
	{
	echo "You do not have access to this database."; exit;
	}

$menu_array_1=array( "Photo Points"=>"/$database/pp_units.php", "Search Photo Points"=>"/$database/search_form.php");

$menu_array=$menu_array_1;

if($level>3)
	{
//	$menu_array_3=array("------------"=>"","Fireline Prep"=>"/fire/fireline_prep.php");
//	$menu_array=array_merge($menu_array_1,$menu_array_3);
	}

if($level>4)
	{
//	$menu_array_4=array("------------"=>"","Fireline Prep"=>"/fire/fireline_prep.php");
//	$menu_array=array_merge($menu_array,$menu_array_4);
	}


$calling_file=$_SERVER['PHP_SELF'];

$file_array=array("/$database/pp_units.php","/$database/search_form.php");

echo "<table>
<tr><td colspan='2'><font color='gray' size='+1'>Welcome to the NC State Parks System <font color='blue'>Photo Point</font> Application</font></td></tr>";

if(empty($_SERVER['QUERY_STRING']))
	{
	echo "<tr><td colspan='3'>The objective is to document resource/cultural management activities (fire, restoration, invasive species, visitor impacts, etc.) using photos.</td></tr>";
	}

echo "<tr><td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a Function:</option>";
foreach($menu_array as $item=>$file)
	{
	if($calling_file==$file){$s="selected";}else{$s="value";}	
	echo "<option value='$file' $s>$item</option>";
	}
echo "</select></form></td>";

$location=$_SESSION[$database]['select'];

if(in_array($calling_file,$menu_array))
	{		
	if($level==1)
		{
		$photo_point_park[]=$location;
		}
		
	if(!empty($_SESSION[$database]['accessPark']) AND $level==1)
		{
		unset($photo_point_park);
		$var=explode(",",$_SESSION[$database]['accessPark']);
		foreach($var as $k=>$v)
			{
			$photo_point_park[]=$v;
			}
		}
		
	if($level==2)
		{
		$dist_array=${"array".$location};
		foreach($dist_array as $k=>$v)
			{
			$photo_point_park[]=$v;
			}
		}
	
	if($level>2)
		{
		$photo_point_park=$parkCode;
		}

if($calling_file!="/$database/search_form.php")
	{
	echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a Park:</option>";
	foreach($photo_point_park as $k=>$v)
		{
		if(@$park_code==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$calling_file?park_code=$v'>$v</option>\n";
		}
	echo "</select></form></td>";
	
	if($calling_file=="/$database/fire_plans.php")
		{
		if(!empty($park_code)){echo "<td><a href='fire_plans.php?park_code=$park_code'>Reset</a></td>";}
		}
	}
}

echo "</tr></table>";

?>