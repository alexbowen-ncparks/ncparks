<?php
ini_set("display_errors",1);
extract($_REQUEST);

$dbTable="permits";
$file=$dbTable.".php";
$fileMenu=$dbTable."_menu.php";

session_start();
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;

$p=@$_SESSION['sap']['select'];
$multi_park_array=explode(",",@$_SESSION['sap']['accessPark']);
$lev=@$_SESSION['sap']['level'];
if($lev<1){exit;}

include("../../include/connectROOT.inc");// database connection parameters
$database="sap";

include("$fileMenu");// necessary to place this AFTER update script

include("../../include/get_parkcodes.php");// database connection parameters

  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");


	$query = "SELECT park FROM permits where 1";
	$result = @MYSQL_QUERY($query,$connection);
	
$wedi=0;
$nodi=0;
$sodi=0;
$eadi=0;
//$arrayNODI[]="NODI";
	while($row = mysql_fetch_assoc($result))
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

?>