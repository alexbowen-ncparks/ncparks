<?php 
	
$database="divper";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

extract($_REQUEST);
if($_POST['tempID']!="" AND $_POST['phone_type']!=""){
			if($_POST['phone_type']=="cell"){
				$clause="work_cell='".$_POST['phone_num']."'";}
			if($_POST['phone_type']=="land"){
				$clause="phone='".$_POST['phone_num']."'";}
		}
		$sql="UPDATE divper.empinfo set $clause where tempID='$_POST[tempID]'"; //echo "$sql";
		 $result = MYSQL_QUERY($sql,$connection);
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

header("Location: https://www.ncstateparks.net/divper/parse_phone/phone_parse.php");
?>