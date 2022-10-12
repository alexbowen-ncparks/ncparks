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

$table="seawall";

	$sql="SELECT year, park, contacts_id, seawall_number, lat, lon
	FROM  $table where year='$this_year'";
 	$result = @MYSQL_QUERY($sql,$connection) or die(mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		extract($row);
		$sql="SELECT year, park, contacts_id
	FROM  $table where year='$next_year' and park='$park' and contacts_id='$contacts_id'";
 	$result1 = @MYSQL_QUERY($sql,$connection) or die(mysql_error());
 	if(mysql_num_rows($result1)>0){continue;}    // skip previously entered record for year, park, contact_id
			$add_records[]=$row;
		}
//$c=count($add_records);
//echo "$c<pre>"; print_r($add_records); echo "</pre>"; exit;

	foreach($add_records as $k=>$array)
		{
		extract($array);
		$sql="INSERT ignore into $table set park='$park', year='$next_year', contacts_id='$contacts_id', seawall_number='$seawall_number', lat='$lat',lon='$lon'";
		@MYSQL_QUERY($sql,$connection) or die(mysql_error());
		}

	
?>