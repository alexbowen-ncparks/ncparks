<?php
ini_set('display_errors',1);
$database="dprcoe";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
mysql_select_db($database, $connection); // database

extract($_REQUEST);
// **********************************************

if(empty($pass_fid))
	{
	echo "No file specified.";
	exit;
	}
	

$sql="SELECT *
from file_upload
where fid = '$pass_fid'
";
$result = @mysql_query($sql, $connection) or die(mysql_error());
$row=mysql_fetch_assoc($result);
extract($row);

$path_to_file="/opt/library/prd/WebServer/Documents/dprcoe/".$link;
unlink($path_to_file);


$sql="DELETE
from file_upload
where fid = '$pass_fid'
";
$result = @mysql_query($sql, $connection) or die(mysql_error());

header("Location:/dprcoe/new_entry.php?eid=$eid");

?>