<?php
ini_set("display_errors",1);
extract($_REQUEST);

$dbTable="permits";
$file=$dbTable.".php";
$fileMenu=$dbTable."_menu.php";

$database="divper";
include("../../include/iConnect.inc");// database connection parameters

include("../../include/get_parkcodes_reg.php");// database connection parameters

mysqli_select_db($connection,$database)
       or die ("Couldn't select database");
	$query = "SELECT park FROM position where 1";
	$result = @mysqli_QUERY($connection,$query);
	
$wedi=0;
$nodi=0;
$sodi=0;
$eadi=0;
//$arrayNODI[]="NODI";
	while($row = mysqli_fetch_assoc($result))
		{
		extract($row);
		IF(in_array($park,$arrayWEDI)){$wedi++;}
		IF(in_array($park,$arrayNODI)){$nodi++;}
		IF(in_array($park,$arraySODI)){$sodi++;}
		IF(in_array($park,$arrayEADI)){$eadi++;}
		}

echo "EADI = $eadi<br />";
echo "SODI = $sodi<br />";
echo "NODI = $nodi<br />";
echo "WEDI = $wedi<br />";
$total=$wedi+$nodi+$sodi+$eadi;
echo "Total = $total<br />";
echo "$query";

?>