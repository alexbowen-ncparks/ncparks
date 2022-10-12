<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$search_fields=array("sn"=>"sn_service_tag","fas"=>"fas");

$var_search=$search_fields[$field];

include("_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";

$sql="SELECT COUNT( * ) AS  `Rows` ,  $var_search
FROM  `computers` 
GROUP BY  `sn_service_tag` 
having  `Rows` >1
ORDER BY  `Rows` DESC 
"; 
$result = mysqli_query($connection,$sql) or die("$sql");
IF(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		if($row[$var_search]=="NA" or $row[$var_search]==""){continue;}
		$ARRAY[]=$row;
		}
	}
	else
	{echo "No duplicate found."; exit;}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array();
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
		if(in_array($fld, $search_fields))
			{$value="<form method='POST' action='search_form.php' style=\"background-color: #E3E1B8; text-align:center\">
			<input type='hidden' name='select_table' value=\"computers\">
			<input type='hidden' name='$fld' value=\"$value\">
			<input type='submit' name='submit_form' value=\"$value\">
			</form>";
			}
		if(empty($value)){$value="blank value";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}