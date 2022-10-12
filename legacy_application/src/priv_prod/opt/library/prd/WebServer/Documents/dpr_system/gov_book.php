<?php
//ini_set('display_errors',1);

$database="dpr_system";
include("../../include/iConnect.inc");

mysqli_select_db($connection,'dpr_system');

$title="NC DPR Databases";
include("gov_request.php");

?>
