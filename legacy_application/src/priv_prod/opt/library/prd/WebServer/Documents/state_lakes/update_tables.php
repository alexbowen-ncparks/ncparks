<?php
ini_set('display_errors',1);

$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

if(@$rep==""){include("menu.php");}

$table="piers";

//$this_year=date('Y');  echo "t=$this_year";
//$next_year=date('Y')+1;  echo "n=$next_year";

$this_year=2014;
$next_year=2015;


	$sql="SELECT year, park, contacts_id, pier_number, fee, pier_type, pier_length, boatstall, non_conforming, lat, lon
	FROM  $table where year='$this_year'";
 	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
			$add_records[]=$row;
		}
echo "<pre>"; print_r($add_records); echo "</pre>"; exit;

	foreach($add_records as $k=>$array)
		{
		extract($array);
		$sql="INSERT into $table set park='$park', year='$next_year', contacts_id='$contacts_id', pier_number='$pier_number',fee='$fee',pier_type='$pier_type', pier_length='$pier_length',boatstall='$boatstall',non_conforming='$non_conforming',lat='$lat',lon='$lon'";
	//	@mysqli_QUERY($connection,$sql);
		}

	
?>