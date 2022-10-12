<?php

// echo "hello"; exit;
// ini_set('display_errors',1);

$database="dpr_overview";
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);
$sql="SELECT fac_type from fac_class where 1 and fac_class='Building' and visitor_fac!='no'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['fac_type'];
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
include("../_base_top.php");

$skip=array("id");
$c=count($ARRAY);

foreach($ARRAY AS $k=>$v)
	{	
	$temp[]="`fac_type`='$v'";
	}
		$clause=implode(" OR ",$temp);
// 		$array_clause[$fld]=$clause;
// 		echo "<tr><td>$clause</td></tr>";


// echo "<pre>"; print_r($array_clause); echo "</pre>"; // exit;

mysqli_select_db($connection,"dpr_system");

// $park_array=array("CABE", "CACR", "CHRO");
$sql="SELECT parkcode
	from dprunit_region where 1 and staffed_park='Yes'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['parkcode'];
		}
// echo "<pre>"; print_r($park_array); echo "</pre>"; // exit;	

?>