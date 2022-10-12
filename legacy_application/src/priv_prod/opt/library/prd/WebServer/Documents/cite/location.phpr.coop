<?php
ini_set('display_errors',1);

$database="cite";
include("../../include/auth.inc"); // used to authenticate users

include ("../../include/iConnect.inc");

// include_once("menu.php");
include_once("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,$database);
$level=$_SESSION['cite']['level'];
include_once("menu.php");
if($level<4){echo "No access.";exit;}

extract($_REQUEST);

if(@$del=="y")
	{
	$sql="DELETE FROM location where loc_code='$loc_code'";
	$result = @mysqli_query($connection,$sql) or die($sql);
	header("Location: location.php?testPark=$testPark");exit;
	}

if(@$submit=="Add")
	{
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	for($j=0;$j<count($loc_code);$j++){
	$lc=strtoupper($loc_code[$j]);
	$sql="INSERT INTO location SET parkcode='$park',loc_code='$lc',location='$location[$j]'";
	if($loc_code[$j]!="" and $location[$j]!="")
		{
		$result = @mysqli_query($connection,$sql) or die($sql." error ".mysqli_error($connection));
		}
	}
	header("Location: location.php?testPark=$park");
	exit;
	}

echo "<div align='center'><table><form><tr><td align='right'><b>Park Name: </b></td><td><select name='park' onChange=\"MM_jumpMenu('parent',this,0)\">
<option selected=''></option>\n";
foreach($parkCode as $k=>$v)
	{
	if($v==@$testPark){$s="selected";}else{$s="value";}
		 echo "<option $s='location.php?testPark=$v'>$v</opton>\n";
	}
echo "</select></td>";


if(@$testPark)
	{
	if(!isset($numLoc)){$numLoc="";}
	echo "<td>Add <input type='text' name='numLoc' value='$numLoc' size='3'> New Locations</td>
	<td><input type='hidden' name='testPark' value='$testPark'><input type='submit' name='submit' value='Now'></td></tr></form>";
	$sql="SELECT * FROM location where parkcode='$testPark' order by loc_code";
	$result = @mysqli_query($connection,$sql) or die($sql." ");
	while ($row=mysqli_fetch_array($result))
		{
		$menuArray[$row['loc_code']]=$row['location'];
		}

	$n=1;
	echo "<tr height='25' valign='bottom'><td></td><td><b>Location Code</b></td><td><b>Location Name</b></td></tr>";
	if(!empty($menuArray))
		{
		foreach ($menuArray as $k=>$v)
			{
			echo "<tr height='20'><td align='right'>$n &nbsp;</td><td>$k</td><td>$v</td><td><a href='location.php?loc_code=$k&del=y&testPark=$testPark'>Delete</a></td></tr>";
			   $n++;
			}	
		}
	}

if(@$numLoc)
	{
	echo "<form>";
	for($i=0;$i<$numLoc;$i++)
	{echo "<tr height='20'><td></td><td><input type='text' name='loc_code[]' size='4' MAXLENGTH='4'></td>
	<td><input type='text' name='location[]'></td></tr>";}
	
	echo "<tr><td colspan='3' align='center'>
	<input type='hidden' name='park' value='$testPark'>
	<input type='submit' name='submit' value='Add'></td></tr></form>";
	}

echo "</table></div>";
?>
