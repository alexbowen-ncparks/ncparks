<?php
echo "<html><head><title>NC DPR CITE</title>";
include("css/TDnull.inc");
date_default_timezone_set('America/New_York');

$today=date("l, j F Y");
$menuArray_disposition=array("Guilty","Not Guilty","PJC","Failure_to_Appear","Deferred_Prosecution","G.S. 90-96 Referral Program","Pending","Dismissed","Unknown","Other");

$menuArray1=array("Search Page"=>"index.php");
$menuArray2=array("Add an Item"=>"cite_new.php","Edit an Item"=>"edit.php");

$testLevel=$_SESSION['cite']['level'];
//IF($testLevel==5){$testLevel=2;}
switch ($testLevel) {
		case "1":
			break;	
		case "2":			
//$menuArray3=array("District Approval"=>"approvDist.php");
			break;		
		case "3":			
//$menuArray3=array("Section Approval"=>"approvSect.php");
			break;		
		case "4":			
$menuArray3=array("Edit Locations"=>"location.php","Edit Users"=>"users.php","Actual Delete"=>"delete.php");
			break;			
		case "5":			
$menuArray3=array("Edit Locations"=>"location.php","Edit Users"=>"users.php","Actual Delete"=>"delete.php");
			break;	
	}

echo "<body><div align='center'><font size='3' color='#006600'><b><font face='Verdana, Arial, Helvetica, sans-serif'>NC DPR CITATION Database<hr>

<table cellpadding='5'><tr>";
// ******** Menu 1
echo "Today is $today<td><form><select name=\"citeFind\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>View CITE:</option>";
foreach($menuArray1 as $name=>$page)
	{
	echo "<option value='$page'>$name\n";
	}
   echo "</select></form></td>";

// ******** Menu 2
echo "<td><form><select name=\"citeEdit\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Modify CITE:</option>";
foreach($menuArray2 as $name=>$page)
	{
	echo "<option value='$page'>$name\n";
	}
   echo "</select></form></td>";


if($testLevel > 3){
   
// ******** Menu 3
echo "<td><form><select name=\"citeEdit\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Admin CITE:</option>";
foreach($menuArray3 as $name=>$page)
	{
	echo "<option value='$page'>$name\n";
	}
   echo "</select></form></td>";

   
echo "</tr></table></div>";
}
?>