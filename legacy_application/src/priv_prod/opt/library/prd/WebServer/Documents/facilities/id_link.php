<?php
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users

//$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");

mysql_select_db($database, $connection); // database

extract($_REQUEST);

$level=$_SESSION[$database]['level'];

if($level<1)
	{exit;}

$sql = "INSERT INTO `facilities`.`fac_photos` (`id`, `gis_id`, `pid`) VALUES (NULL, '$gis_id', '$ID_pid')";
//echo "$sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	
header("Location: edit_fac.php?file=park_abbr&gis_id=$gis_id");
	
?>