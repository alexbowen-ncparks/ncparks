<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; EXIT;
$level=$_SESSION['crs']['level'];
if($level<4){exit;}
$title="NC State Parks System - Rental Facilities";
ini_set('display_errors',1);

$database="crs";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

extract($_REQUEST);

if(@$submit=="Delete")
	{
	$id=$_POST['id'];
	$sql = "DELETE from rental_facility where id='$id'
	"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	echo "That facility was deleted. <a href='rental.php'>Click here</a> to return to main listing."; 
	exit;
	}

if(@$submit=="Update")
	{
	$id=$_POST['id'];
	$skip=array("id","submit");
	//echo "<pre>"; print_r($_POST); echo "</pre>";
	$clause="set ";
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		$clause.="`$fld`='".$value."',";
		}
	$clause=rtrim($clause,",");
	$sql = "UPDATE rental_facility 
	$clause
	where id='$id'
	"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	header("Location: rental.php"); exit;
	}

$sql = "SELECT t2.park_name, t1.* 
from rental_facility as t1
LEFT JOIN dpr_system.parkcode_names as t2 on t1.park=t2.park_code
where t1.id='$id'
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; //exit;


//$skip=array("id","park");
$edit=array("capacity/size","price","amenities_include");

echo "<form method='POST' action='edit.php'>";
echo "<table border='1' cellpadding='3' align='center'>";
echo "<tr bgcolor=lightblue><th>Field Name</th><th>Value</th>
</tr>";

foreach($ARRAY as $index=>$row)
	{
	foreach($row as $fld=>$value)
		{
		if(in_array($fld,$edit))
			{
			$content="<input type='text' name='$fld' value=\"$value\" size='65'>";
			if($fld=="amenities_include")
				{
				$content="<textarea name='$fld' cols='48' rows='3'>$value</textarea>";
				}
			}
			else
			{$content=$value;}
		echo "<tr><td>$fld</td><td>$content</td></tr>";	
		}
	}
$id=$ARRAY[0]['id'];
echo "<tr><td align='center'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Delete'>
</td>";
echo "<td align='center'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form>";
?>