<?php

include("../../include/get_center.php"); exit;
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
mysql_select_db('divper', $connection); // database


$sql="SELECT * from donor_donation
			where id='859'";
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());
			while($row=mysql_fetch_assoc($result))
			{
			$donation_result_array[]=$row;
			}
//echo "<pre>"; print_r($donation_result_array); echo "</pre>"; // exit;
$num=count($donation_result_array);

echo "<table border='1'><tr>";

echo "<td>
<table border='1'>";
foreach($donation_result_array[0] as $fld=>$array)
	{
	echo "<tr><td><b>$fld</b></td></tr>";
	}
echo "</table>
</td>";

foreach($donation_result_array as $index=>$array)
{
echo "<td>
<table border='1'>";
	foreach($array as $fld=>$val)
{echo "<tr><td>$val</td></tr>";}
echo "</table>
</td>";
}


echo "</tr></table>";

?>