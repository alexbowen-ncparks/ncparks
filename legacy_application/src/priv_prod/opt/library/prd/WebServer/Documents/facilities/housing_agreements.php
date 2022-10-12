<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/iConnect.inc");

mysqli_select_db($connection,$database); // database

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$level=$_SESSION[$database]['level'];

if($level<3)
	{
	echo "No access";
	exit;
	}

$sql="SELECT file_id, gis_id, link, title as agreement from housing_attachment where housing_agreement='x'";
$result = @MYSQLI_QUERY($connection, $sql);
while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

$skip=array("link");
$c=count($ARRAY);
echo "<table border='1'><tr><td colspan='2'>$c agreements</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if($fld=="link"){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="link"){continue;}
		if($fld=="gis_id")
			{$value="<a href='edit.php?gis_id=$value'>$value</a>";}
		if($fld=="agreement")
			{
			$link=$array['link'];
			$value="<a href='$link'>$value</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";

?>