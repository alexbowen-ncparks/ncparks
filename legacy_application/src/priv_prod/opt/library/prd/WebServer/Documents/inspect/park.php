<?php

$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);

// *********** Display ***********
$where="where parkcode='$parkcode'";
if(!empty($id_inspect))
	{
	$where.=" and subunit='$id_inspect'";
	}
	
$subunit="blank";
include("park_entry.php");

?>