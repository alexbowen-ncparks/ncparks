<?php
$database="public_contact";
$title="DPR Public Contact Tracking Application";
include("../_base_top_1.php");  
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$beacon_num=$_SESSION[$database]['beacon_num'];
$submitted_by=$_SESSION['public_contact']['emid'];

include("../../include/iConnect.inc");

date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);

$sql="SELECT * FROM records where void=''";
$result=mysqli_query($connection, $sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	echo "No entries.";
	exit;
	}
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td>$c</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="id"){$value="<a href='contact.php?record_id=$value'>$value</a>";}
		if($fld=="edited_by")
			{
			if(strlen($value)>16)
			{$value=substr($value,0,16)."...";}
			
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</div></body></html>";
mysqli_close ($connection);
?>