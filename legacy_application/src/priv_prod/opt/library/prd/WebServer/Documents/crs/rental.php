<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$level=@$_SESSION['crs']['level'];
$title="NC State Parks System - Rental Facilities";
ini_set('display_errors',1);

$db="crs";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

extract($_REQUEST);

$sql = "SELECT t2.park_name, t1.* 
from rental_facility as t1
LEFT JOIN dpr_system.parkcode_names_district as t2 on t1.park=t2.park_code
order by t1.park";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$park_array[$row['park']]=$row['park_name'];
	$fac_array[$row['facility']]="";
	$amenity_array[]=$row['amenities_include'];
	}
//echo "<pre>"; print_r($amenity_array); echo "</pre>";

echo "<form method='POST'><table align='center'>";
echo "<tr>";
echo "<td>Limit Facilities to this Park:<br /><select name='park'><option selected=''></option>\n";
foreach($park_array as $k=>$v)
	{
	echo "<option value='$k'>$v</option>\n";
	}
echo "</select></td>";

ksort($fac_array);
echo "<td>Limit to this Facility:<br /><select name='facility'><option selected=''></option>\n";
foreach($fac_array as $k=>$v)
	{
	echo "<option value=\"$k\">$k</option>\n";
	}
echo "</select></td>";

$aa=array_unique($amenity_array);
//echo "<pre>"; print_r($aa); echo "</pre>";
foreach($aa as $k=>$v)
	{
	$var1=str_replace("&",",",$v);
	$var1=str_replace("/",",",$var1);
	$var1=str_replace(" and",",",$var1);
	$var1=str_replace(" the ",",",$var1);
	$var2=explode(",",$var1);
	foreach($var2 as $k1=>$v1)
		{
		$v1=str_replace("court","",$v1);
		$v1=str_replace("area","",$v1);
		$v1=str_replace("spaces","",$v1);
		$var3=explode(":",$v1);
		foreach($var3 as $k3=>$v3)
			{		
			$var4[]=strtolower(trim($v3));
			}
		}
	}

//echo "<pre>"; print_r($aa); echo "</pre>";
$var5=array_unique($var4);
sort($var5);
//echo "<pre>"; print_r($var5); echo "</pre>";

$exclude=array("(seasonal)","exclusive use of","their amenities","this space is a combination of");
echo "<td>Limit to this Amenity:<br /><select name='amenity'>\n";
foreach($var5 as $k=>$v)
	{
	if(in_array($v,$exclude)){continue;}
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

echo "<td>
<input type='submit' name='submit' value='Submit'>
</td></form>";
echo "<form><td><input type='submit' name='submit' value='Show All'></td></form>";

if($level>3)
	{	
	echo "<form action='add_fac.php'><td><input type='submit' name='submit' value='Add Facility'></td></form>";
	}
echo "</tr></table>";

if(@$submit=="Submit")
	{
	$am="";
	$clause="";
	foreach($_POST as $fld=>$value)
		{
		if($fld=="submit"){continue;}
		if($fld=="amenity" and !empty($value))
			{
			$fld="amenities_include";
			$am=" OR t1.facility like '%$value%'";
			}
		if($value!="")
			{
			$clause="t1.".$fld." like '%$value%'";
			}
		}

	if(!empty($clause))
		{
		unset($ARRAY);
		$sql = "SELECT t2.park_name, t1.* 
		from rental_facility as t1
		LEFT JOIN dpr_system.parkcode_names_district as t2 on t1.park=t2.park_code
		where $clause $am
		order by t1.park"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	}


$skip=array("id","park");
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr bgcolor=lightblue><th>State Park</th><th>Facility</th><th>Capacity/Size</th><th>Price</th><th>Amenities</th><th>Contact Link</th>
</tr>";
$check="";
foreach($ARRAY as $index=>$row)
	{
/*	if(!empty($park) AND $row['park']!=$park){continue;}
	if(!empty($facility) AND $row['facility']!=$facility){continue;}
	$ai=strtolower($row['amenities_include']);
	$test=@strpos($ai,$amenity);
	if(!empty($amenity) AND $test===false){continue;}
*/
	if($ARRAY[$index]['park_name']==$check)
		{$tr=" bgcolor=aliceblue";}
		else
		{$tr=" bgcolor=beige";}
	echo "<tr$tr>";
	foreach($row as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="park_name" AND $value==$check){$value="&nbsp;";}
		if($fld=="facility" and $level>3)
			{
			$id=$ARRAY[$index]['id'];
			$value="<a href='edit.php?id=$id'>$value</a>";
			}
		echo "<td>$value</td>";
		}
	$pc=strtolower($row['park']);
	$link="http://www.ncparks.gov/Visit/parks/".$pc."/facilities.php";
	echo "<th><a href='$link' target='_blank'>Go</a></th>";
	echo "</tr>";
	$check=$row['park_name'];
	}

echo "</table>";
?>