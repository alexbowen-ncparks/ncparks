<?php
$database="inspect";
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// include("pm_menu.php");

$level=$_SESSION[$database]['level'];
$parkcode=$_SESSION[$database]['select'];
//echo "<pre>"; print_r($_FILES); echo "</pre>"; //exit;
//These are placed outside of the webserver directory for security
if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

if ($_POST['submit_form'] == "Upload")
	{
echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;

	include("ems_emr_upload.php");
	
	mysqli_CLOSE($connection);
	header("Location: /inspect/inspection_record_EMS_EMR.php");
	exit;
	} 

echo "<html><head>";
include("../css/TDnull.php");
echo "<style>
tr {color:green; vertical-align: text-top;}
#ems {color:black; vertical-align: text-top;}
#emr {color:black; vertical-align: text-top;}

</style>";
echo "<body>";

echo "<table colspan='3'><tr>";
$menuInspect_EMS_EMR=array("Safety - EMS - EMR Home Page"=>"/inspect/home.php", "List of EMS Resources"=>"/inspect/ems_display.php","List of EMR Resources"=>"/inspect/emr_display.php","Enter EMS/EMR Resources"=>"/inspect/inspection_record_EMS_EMR.php");
echo "<td colspan='4'>Select Page: <form name='form2'>
<select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
$s="value";
foreach($menuInspect_EMS_EMR as $title=>$file)
	{
	echo "<option $s='$file'>$title\n";
       }
echo "</select></form></td>
<td width='30%'></td><td><h2><font color='blue'>EMS / EMR Activities and Resources</font></h2></td>
</tr></table>";

echo "<table style='margin-left: auto; margin-right: auto;'>
<tr>";
if($level>3)
	{
	include("ems_form.php");
	echo "<td width='5%'></td>";
	include("emr_form.php");
	}
echo "</tr></table>";
include("ems_display.php");
include("emr_display.php");

// echo "</tr></table>";


echo "</body></html>";

?>