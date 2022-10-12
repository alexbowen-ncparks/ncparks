<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

ini_set('display_errors',1);
$title="PARTF";
include("../inc/_base_top_dpr.php");
$database="partf";

if(@isset($_SESSION[$database]['level']))
	{
	include("../../include/auth.inc"); // used to authenticate users
	}


//$level=$_SESSION[$database]['level'];
//$tempID=$_SESSION[$database]['tempID'];
date_default_timezone_set('America/New_York');

include("../../include/connectROOT.inc");// database connection parameters

$db = mysql_select_db($database,$connection)
   or die ("Couldn't select database");

echo "<table cellpadding='5'>";

echo "<tr><th colspan='8' valign='top'><font color='gray'>Welcome to the NC Division of Parks and Recreation - <font color='brown'>P</font>arks <font color='brown'>A</font>nd <font color='brown'>R</font>ecreation <font color='brown'>T</font>rust <font color='brown'>F</font>und Database</font></th>";

include("menu.php");

echo "</table>";


echo "<hr /><table><tr><td>
<form action='import_csv.php' method='POST'>Click the \"Replace Grants\" button if you wish to replace the information in the existing <b>Grants table</b> with new data from a CSV file.</td><td align='center'>
<input type='hidden' name='csv' value='grants'>
<input type='submit' name='submit' value='Replace Grants'>
</form></td></tr>";

echo "<tr><td>
<form action='import_csv.php' method='POST'>Click the \"Replace Inspections\" button if you wish to replace the information in the existing <b>Inspections table</b> with new data from a CSV file.</td><td>
<input type='hidden' name='csv' value='inspections'>
<input type='submit' name='submit' value='Replace Inspections'>
</form></td></tr></table>";

extract($_REQUEST);
	
if(@$submit=="Replace")
	{
	$file=$csv_file;
	include("import_csv.php");
	}


?>