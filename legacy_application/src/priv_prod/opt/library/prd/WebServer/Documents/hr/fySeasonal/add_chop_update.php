<?php
echo "Contact Tom<pre>"; print_r($_POST); echo "</pre>"; exit;
include("../../../include/connectBUDGET.inc");

foreach($_POST as $row=>$array){
	$clause="";
	if($array['beacon_posnum']==""){continue;}
	foreach($array as $fld=>$val){
		$clause.=$fld."='".$val."',";
		}
		$clause=rtrim($clause,",");
		if($clause){//echo "set $clause<br>";
		$sql = "REPLACE seasonal_payroll_chop set $clause"; echo "$sql<br>"; //exit;
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		}
	}
	header("Location: park_seasonals_chop.php")
?>