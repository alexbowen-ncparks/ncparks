<?php
extract($_REQUEST);
if(empty($citation))
	{
	// We use index.php as the search form for edit
	// varEdit is the trigger to specify edit mode
	$varEdit=1;
	include("index.php");
	exit;
	}
$database="cite";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

//echo "<pre>";print_r($_SESSION);echo "</pre>"; 
if($_SESSION['cite']['level']<2)
	{
	$thisPark=$_SESSION['cite']['parkS'];
	if($thisPark=="MOJE"||$thisPark=="NERI")
		{$thisPark = "and (park = 'MOJE' or park='NERI')";}
		else
		{
		$thisPark="and park='$thisPark'";
		}
	}
else
	{
	$thisPark="";
	}
$sql = "SELECT * FROM report WHERE citation = '$citation' $thisPark order by id";
//echo " 1=$sql";exit;
$total_result = @mysqli_query($connection,$sql) or die($sql);
if(mysqli_num_rows($total_result)<1)
	{
	echo "Citation $citation for $thisPark was not found.";
	exit;
	}
while ($row = mysqli_fetch_array($total_result))
	  {
	  extract($row);
	  $chargeArray[]=$charge;
	  $chargeOtherArray[]=$charge_other;
	  $disposArray[]=$disposition;
	  $disposOtherArray[]=$disposition_other;
	  }
include("edit_form.php");
?>
