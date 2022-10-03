<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$level=$_SESSION['crs']['level'];
$title="NC State Parks System - Rental Facilities";
ini_set('display_errors',1);
include("../../include/get_parkcodes_i.php");// database connection parameters

include("../../include/iConnect.inc");// database connection parameters

$database="crs";
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$sql = "SELECT t2.park_name, t1.* 
from rental_facility as t1
LEFT JOIN dpr_system.parkcode_names as t2 on t1.park=t2.park_code
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

echo "<table align='center'>";
echo "<tr><td colspan='3'>Add a Facility to a Park.</td>
<form action='rental.php'><td><input type='submit' name='submit' value='Show All'></td></form></tr>";
echo "<form method='POST'><tr>";
echo "<td>Select Park:<br /><select name='park'><option selected=''></option>\n";
foreach($parkCode as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

ksort($fac_array);
echo "<td>Select Facility:<br /><select name='facility'><option selected=''></option>\n";
foreach($fac_array as $k=>$v)
	{
	echo "<option value=\"$k\">$k</option>\n";
	}
echo "</select></td>";

echo "<td>Enter a Facility here if NOT in drop-down:<br />
<input type='text' name='alt_facility' value=''>
</td>";

echo "<td>
<input type='submit' name='submit' value='Submit'>
</td></form>";

echo "</tr></table>";

if(@$_POST['submit']=="Submit")
	{
	extract($_POST);
	if(!empty($park) AND (!empty($facility) OR !empty($alt_facility)))
	{
		if(!empty($alt_facility))
			{$facility=$alt_facility;}
		$sql = "INSERT INTO rental_facility 
		set park='$park', facility='$facility'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$id=mysqli_insert_id($connection);
		}
echo "The addition of a <b>$facility</b> at <b>$park</b> was successful. <a href='edit.php?id=$id'>Click here</a> to complete Capacity/Size, Price, and Amenities.";
	}

?>