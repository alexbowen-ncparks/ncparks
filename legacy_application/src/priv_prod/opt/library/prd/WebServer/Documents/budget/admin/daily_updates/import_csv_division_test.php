<?php
//echo "hello world";
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//date_default_timezone_set('America/New_York');



$query18e="update crs_tdrr_division_history set record_id=concat(center,'_',ncas_account,'_',amount,'_',transdate_new) where 1";

echo "<br /><br />query18e=$query18e<br /><br />";

$result18e = mysqli_query($connection, $query18e) or die ("Couldn't execute query 18e.  $query18e ");


$query18f = "select record_id from crs_tdrr_division_history_adjust where 1 order by id";

echo "<br />Line 637: query18f=$query18f<br />";

$result18f = mysqli_query($connection, $query18f) or die ("Couldn't execute query18f.  $query18f ");


while($row18f = mysqli_fetch_array($result18f)){
extract($row18f);

$query18g="update crs_tdrr_division_history set valid_record='n' where record_id='$record_id' limit 1 ";
echo "<br /><br />query18g=$query18g<br /><br />";


//$result18g = mysqli_query($connection, $query18g) or die ("Couldn't execute query18g.  $query18g ");


}// end 


?>