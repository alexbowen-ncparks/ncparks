<?php
ini_set('display_errors',1);

$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

if(@$rep==""){include("menu.php");}


//$this_year=date('Y');  echo "t=$this_year";
//$next_year=date('Y')+1;  echo "n=$next_year";

$this_year=2014;
$next_year=2015;

$table="buoy";

	$sql="SELECT park, contacts_id, buoy_number, pier_number, buoy_assoc, lat, lon, fee
	FROM  buoy where year='$this_year'";
 	$result = @MYSQL_QUERY($sql,$connection);
	while($row=mysql_fetch_assoc($result))
		{
		$add_records[]=$row;
		}
		
//$c=count($add_records);
//echo "$c<pre>"; print_r($add_records); echo "</pre>"; exit;

	foreach($add_records as $k=>$array)
		{
		extract($array);
		$sql="INSERT ignore into buoy set park='$park', year='$next_year', contacts_id='$contacts_id', pier_number='$pier_number', buoy_number='$buoy_number', buoy_assoc='$buoy_assoc',lat='$lat', lon='$lon',fee='$fee'";
		@MYSQL_QUERY($sql,$connection) or die(mysql_error());
		}
?>