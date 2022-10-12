<?php
extract($_REQUEST);

$database="dprcoe";
include("../../include/connectROOT.inc");
//include("../../include/get_parkcodes.php");
date_default_timezone_set('America/New_York');

$today=date("Y-m-d");
$where="where dateE>='$today'";
$content="";

mysql_select_db($database,$connection); 
	$sql2 = "SELECT DISTINCT park FROM event $where
	order by park";
	$result = @mysql_query($sql2, $connection) or die();
	//    echo "$sql2";exit;
	$numrow = mysql_num_rows($result);
	while($row = mysql_fetch_assoc($result))
		{
		extract($row);
		
		@$content.=$park."*";
		
		}
	$content=rtrim($content,"*");
	echo "$content";
	
?>