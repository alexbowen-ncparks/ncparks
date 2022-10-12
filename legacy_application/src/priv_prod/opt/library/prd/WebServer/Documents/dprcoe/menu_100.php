<?php
$database="dprcoe";
//include("../../include/auth.inc"); // used to authenticate users
include("/opt/library/prd/WebServer/include/auth.inc"); // used to authenticate users
//print_r($_SESSION);//exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;

echo "<html><head><title>NC DPR COE Database</title>";
?>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });

function validateForm()
	{
	var x1=document.forms["donor_form"]["donor_organization"].value;
	if (x1==null || x1=="")
		  {
	//	  alert("ORGANIZATION must be filled out. If not an organization, enter \"Individual\".");
	//	  return false;
		  }
	var dd1 = document.getElementById('dd2');
	if (dd1.selectedIndex == 0)
		  {
		  alert("DONOR TYPE must be filled out.");
		  return false;
		  }
	}

function confirmFile()
		{
		 bConfirm=confirm('Are you sure you want to delete this file?')
		 return (bConfirm);
		}
		
function confirmDonor()
		{
		 bConfirm=confirm('Are you sure you want to delete this Donor Record? All contact and dprcoe records will also be deleted.')
		 return (bConfirm);
		}
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
include("css/TDnull.php");


echo "<body>
<div align='center'>
<table border='1' cellpadding='5'>";
echo "<tr>";

$tempLevel=$_SESSION['dprcoe']['level'];
	$menuArray1=array("/dprcoe/ge_parks_today.php","/dprcoe/ge_parks_all_100.php?ann_100=x");
	$menuArray2=array("100th Map-Today's Events", "100th Map-All Events");
	
echo "<td><form><select name=\"park\" onChange=\"window.open(this.options[this.selectedIndex].value);\"><option selected>Menu</option>";
for ($n=0;$n<count($menuArray1);$n++)
	{
	//$con=urlencode($menuArray1[$n]);
	$con=($menuArray1[$n]);
			echo "<option value='$con'>$menuArray2[$n]\n";
	}
   echo "</select></form></td>";

echo "</tr></table>";
echo "</div>";
?>