<?php

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

include("../css/TDnull.php");
include("menu.php");

echo "<form method='POST' action='forms_not_vacant.php'><table align='center'><tr>
<td>Enter the BEACON Position Number</td>
<td><input type='text' name='beacon_num' value=\"\"></td>
<td><input type='submit' name='submit_form' value=\"Find\"></td>
</tr></table></form>";
	
if(empty($beacon_num))
	{exit;}
$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query select. $sql ");
$row=mysqli_fetch_assoc($result); extract($row);

echo "<table align='center'><tr>
<td>BEACON Position Number: $beacon_num <b>$posTitle</b> @ $parkcode</td></tr></table>";
	
	
echo "<hr><table align='center' cellpadding='5'>";

$sql="Select *  From `permanent_uploads` where beacon_num='$beacon_num'";

$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$ARRAY[]=$row;
	}

if(empty($ARRAY))
	{
	echo "This position is either vacant or never had any files uploaded for it.";
	exit;
	}
$skip=array();
$c=count($ARRAY);
echo "<table>";
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
		if($fld=="file_link")
			{
			$value="<a href='$value'>$value</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";	
?>