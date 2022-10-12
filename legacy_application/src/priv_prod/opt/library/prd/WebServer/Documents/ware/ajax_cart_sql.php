<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
$database="ware";
$title="Warehouse Application";
include("../../include/iConnect.inc");
//date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);
// strpos($_SERVER["HTTP_USER_AGENT"],"Mac OS X")>-1?$pass_os="Mac":$pass_os="Win";

extract($_GET);
// park_order_ajax
$sql="UPDATE park_order
SET quantity='$q'
where id='$id'"; //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysql_error($connection));

?>
