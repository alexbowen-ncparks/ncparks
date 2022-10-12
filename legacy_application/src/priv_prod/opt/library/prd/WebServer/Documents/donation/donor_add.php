<?php
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 

include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'divper'); // database

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
extract($_REQUEST);

$database="donation";
$level=$_SESSION[$database]['level'];


if(@$rep=="")
	{
	include("menu.php");
	mysqli_select_db($connection,'divper'); // database
	include("/opt/library/prd/WebServer/Documents/divper/dpr_labels_base_i.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

// ****** Show Input form **********
if(empty($submit_label) OR @$submit_label=="Go to Find")
	{
	$go_file="/donation/donation_find.php";
	$action="Find";
	$phrase="First, check to make sure the person is not already in our affiliation database.<br />If they are, we will simply designate them as a \"Donor\".<br /><br /><font color='red'>Enter their last name and/or other search criteria and click \"Find\".</font>";
	}

if(isset($submit_label))
	{
	if($submit_label=="Add a Donor")
		{
		$_REQUEST['submit_label']="Add";
		include("donor_update.php");
		exit;
		}
	}


$how_contact_array=array("Phone","Email","Letter","Meeting");
$donor_typeArray=array("Individual/Family","Civic Group/Club","Non-Profit","Foundation","General Public","Sponsor");
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","Friends Group");
$recognition_array=array("Public Recognition","Anonymous");
$fund_array=array("1280"=>"State Parks","2235"=>"PARTF");

echo "<form action='$go_file' method='POST'><table border='1' cellpadding='5'>";

$calling_app=$database;
$calling_page=$_SERVER['PHP_SELF'];
include("base_form.php");

echo "<table align='center'><tr>
<td>$phrase</td>
<td>
<input type='hidden' name='db_source' value='$database'>";

echo "<input type='submit' name='submit_label' value='$action' style=\"background-color:lightgreen;width:65;height:35\">
</td></form>
</tr></table>";

echo "</body></html>";

?>