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

$table="swim_line";

$sql="SELECT swim_line_id as id, park, contacts_id, pier_number FROM  swim_line where year='$this_year'";
 	$result = @MYSQL_QUERY($sql,$connection);
	while($row=mysql_fetch_assoc($result))
		{
			$add_records[]=$row;
		}
		
//echo "<pre>"; print_r($add_records); echo "</pre>"; exit;

	foreach($add_records as $k=>$array)
		{
		extract($array);
		$sql="INSERT ignore into swim_line set park='$park', year='$next_year', contacts_id='$contacts_id', pier_number='$pier_number',fee='35.00'";
		@MYSQL_QUERY($sql,$connection) or die(mysql_error());
		}
	
?>