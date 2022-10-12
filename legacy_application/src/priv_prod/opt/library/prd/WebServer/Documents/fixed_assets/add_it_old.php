<?php
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['fixed_assets']['level'];

if($level<1){exit;}
	
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

// ADD
if(!empty($_POST) AND $_POST['add']=="Add")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
   	$skip_update=array("add");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
		$val=mysqli_real_escape_string($connection, $val);
		$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into its_inventory set $clause"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$id=mysqli_insert_id($connection);
	header("Location: its_inventory.php?submit=Search&id=$id");
	exit;
	}
	

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


echo "<title>NC DPR IT Tracking System</title><body>";


$sql="select distinct location as park_code from its_inventory where 1 order by location";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$location_array[]=$row['park_code'];
	}
$sql="select distinct os from its_inventory where 1 and os!='' order by os";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$os_array[]=$row['os'];
	}
$sql="select distinct type from its_inventory where 1 and type!='' order by type";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$type_array[]=$row['type'];
	}
$sql="select distinct make from its_inventory where 1 and make!='' order by make";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$make_array[]=$row['make'];
	}
$sql="select distinct xp_upgrade from its_inventory where 1 and xp_upgrade!='' order by xp_upgrade";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$xp_upgrade_array[]=$row['xp_upgrade'];
	}
$sql="select distinct xp_replace from its_inventory where 1 and xp_replace!='' order by xp_replace";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$xp_replace_array[]=$row['xp_replace'];
	}

echo "<form action='its_inventory.php' method='POST'>";
echo "<div align='center'><table border='1' cellpadding='5'>";
echo "<tr><td colspan='6' align='center'>NC DPR ITS Inventory </td></tr>";

echo "<tr>";
echo "<td><a href='its_inventory.php'>Search Page</a></td>";

echo "</tr>";
echo "</table></div>";


	include("add_its_form.php");

?>