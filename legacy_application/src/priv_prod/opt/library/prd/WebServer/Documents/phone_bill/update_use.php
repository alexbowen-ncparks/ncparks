<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	
$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

extract($_REQUEST);

		$sql="REPLACE alt_lines set alt_lines='$pn', location='$location'"; //echo "$sql";
		 $result = MYSQL_QUERY($sql,$connection);

header("Location: https://www.ncstateparks.net/divper/parse_phone/phone_parse.php");
?>