<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//ini_set('display_errors', 1);
$db="exhibits";
include("../../include/iConnect.inc"); // database connection parameters

extract($_REQUEST);
$ar=explode("/",$var);
$tv="ztn.".array_pop($ar);
$tn=implode("/",$ar)."/".$tv;
//echo "t=$tn"; exit;

$sql="DELETE from file_upload where link='$var'";
$result = mysqli_query($connection, $sql);

unlink($var);
unlink($tn);
@mysqli_free_result($result);
mysqli_close($connection);
header("Location: work_order_form.php?pass_id=$id");
?>