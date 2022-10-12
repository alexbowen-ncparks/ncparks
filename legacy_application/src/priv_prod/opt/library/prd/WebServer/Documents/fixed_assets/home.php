<?php
session_start();
$pass_park=$_SESSION['fixed_assets']['select'];
$ck_tempID=strtoupper($_SESSION['fixed_assets']['tempID']);

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="divper";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['fixed_assets']['level'];

if($level<1){exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<html><head>";
?>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });

function validateFormSEF(z)
	{
	var check=z;
	if(check==1)
		{
		var x=document.forms["sef"]["pasu_date"].value;
		if (x==null || x=="")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	if(check==2)
		{
		var x=document.forms["sef"]["disu_date"].value;
		if (x==null || x=="" || x=="0000-00-00")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	if(check==3)
		{
		var x=document.forms["sef"]["chop_date"].value;
		if (x==null || x=="" || x=="0000-00-00")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	}
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
include("../css/TDnull.php");

echo "<title>NC DPR Fixed Asset Tracking System</title><body>";

echo "Since the move to DNCR, we are no longer using the database to track fixed assets. Contact Heide Rumble (heide.rumble@ncparks.gov) if you need to check your park's inventory.";
exit;

echo "<div align='center'><table border='1' cellpadding='15'>";
echo "<tr><td colspan='6' align='center'>NC DPR Fixed Asset Inventory</td></tr>";

$code_id=str_rot13($ck_tempID);
echo "<tr><td>Verify Inventory - <a href='inventory.php?action=inventory'>link</a></td></tr>";

if($level>4)
	{
	echo "<tr><td>Surplus Vehicle(s) - <a href='/fuel/menu.php?form_type=pasu_decide&code_id=$code_id'>link</a></td></tr>";
	}
if($level>4)
	{
	echo "<tr><td>Testing Change of Location workflow - <a href='change_location.php'>link</a></td></tr>";
	echo "<tr><td>Testing ITS Item workflow - <a href='its_inventory.php'>link</a></td></tr>";
	}
if($level>4)
	{
	echo "<tr><td>Testing Surplus Item workflow - <a href='fa_home.php?action=surplus'>link</a></td></tr>";
	}
	
if($ck_tempID=="HARRISON1234")
	{
	echo "<tr><td>Testing ITS Item workflow - <a href='its_inventory.php'>link</a></td></tr>";
	}
echo "<table>";


echo "</div></html>";
?>