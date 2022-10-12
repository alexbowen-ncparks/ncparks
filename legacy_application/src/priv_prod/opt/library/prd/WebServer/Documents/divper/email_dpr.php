<?php
$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

include("menu.php");
$sql="SELECT * FROM  dpr_email";
$result=mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table cellpadding='5'><tr><td>$c</td></tr>";
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
		if($fld=="email_address")
			{
			$value="<a href=mailto:$value>$value</a>";
			}
		echo "<td height='25'>$value</td>";
		}
	echo "</tr>";
	}    
echo "</table>";
?>