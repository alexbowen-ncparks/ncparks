<?php
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

// Form
extract($_REQUEST);
if(empty($year_with))
	{
	date_default_timezone_set('America/New_York');
	$year_with=date('Y')-1;
	$year_without="";
	}
$park_array=array("BATR","LAWA","PETT","WHLA");
echo "<form>";
echo "Park <select name='park'><option selected=''></option>\n";
foreach($park_array as $k=>$v)
	{
	if($v==$park){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select>";

echo "<br />Year with records<input type='text' name='year_with' value='$year_with'><br />";
echo "<br />Year without records<input type='text' name='year_without' value='$year_without'><br />";
$object_array=array("buoy","piers","ramp","seawall","swim_line");
echo "Object <select name='object'><option selected=''></option>\n";
foreach($object_array as $k=>$v)
	{
	if($v==@$object){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select>";
echo "
<input type='hidden' name='report' value='$report'>
<input type='submit' name='submit' value='Submit'>
</form>";

// Make tables
if(empty($park) OR empty($year_with) OR empty($year_without) OR empty($object)){exit;}
$var_p=$park;
//$var_y=$year;
//$object=$object;

$table1=$var_p."_".$object."_".$year_with;
$sql="create TEMPORARY table $table1 select * from $object where park='$park' and year='$year_with'";  //echo "$sql";exit;
$result = @mysqli_QUERY($connection,$sql);


$table2=$var_p."_".$object."_".$year_without;
$sql="create TEMPORARY table $table2 select * from $object where park='$park' and year='$year_without'";  //echo "$sql";exit;
$result = @mysqli_QUERY($connection,$sql);


// Find any Difference
echo "<table>";
$sql="SELECT t3.billing_last_name, t1.* 
FROM $table1 as t1
LEFT JOIN $table2 as t2 ON t2.contacts_id = t1.contacts_id
LEFT JOIN contacts as t3 ON t3.id = t1.contacts_id
WHERE t2.contacts_id IS NULL"; //echo "$sql";
$result = @mysqli_QUERY($connection,$sql);

if(mysqli_num_rows($result)<1)
	{
	echo "$year_with and $year_without have the same number of $park $object records.<br /><br />";
	}
else
	{echo "$object records in $year_with but NOT in $year_without.<br /><br />";}

$show=array("contacts_id","billing_last_name","park","year","buoy_id","ramp_id","pier_id","seawall_id","swim_line_id");

echo "<td>last name</td><td>park</td><td>year</td><td>$object id</td><td>contact id</td></tr>";
while($row=mysqli_fetch_assoc($result))
	{
	echo "<tr>";
	foreach($row as $fld=>$value)
		{
		if(!in_array($fld,$show)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";	
	}
echo "</table>";
		
?>