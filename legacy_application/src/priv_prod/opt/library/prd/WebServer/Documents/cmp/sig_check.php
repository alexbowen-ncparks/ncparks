<?php
ini_set('display_errors',1);
		include("../../include/get_parkcodes_i.php");
$database="cmp";
include("../../include/iConnect.inc");// database connection parameters
$database="cmp";
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
// also in edit_sig.php
$add_code=array("EADI","NODI","SODI","WEDI","BUOF","DEDE","WARE","DIRO","OPS1","OPS2","PACR","NARA","REMA","LAND","TRAI","PAR3");

		$parkCode=array_merge($parkCode,$add_code);
		sort($parkCode);
		 


$sql = "SELECT park_code, prime_beacon_num, sec_beacon_num, update_on from sig
	WHERE 1 order by park_code";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");      		
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$park_list[]=$row['park_code'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;

foreach($parkCode as $k=>$v)
	{
	if(!in_array($v,$park_list))
		{$no_sig[]=$v;}
	}

include("menu.php");

		
echo "<table>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

if(!empty($no_sig))
	{
echo "<br /><br />No signature for:<pre>"; print_r($no_sig); echo "</pre>"; // exit;
	}

echo "</html>";
?>