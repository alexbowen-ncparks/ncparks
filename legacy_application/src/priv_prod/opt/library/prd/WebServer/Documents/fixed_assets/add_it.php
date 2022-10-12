<?php
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
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
   	$skip_update=array("add","alt_make","alt_model");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
		if($fld=="make")
			{
			if(!empty($_POST['alt_make']))
				{$val=$_POST['alt_make'];}
			}
		if($fld=="model")
			{
			if(!empty($_POST['alt_model']))
				{$val=$_POST['alt_model'];}
			}
// 		$val=mysqli_real_escape_string($connection, $val);
		$val=html_entity_decode(htmlspecialchars_decode($val));
		$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into its_items set $clause"; //echo "$sql"; exit;
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

/*
$sql="select distinct type from its_items where 1 and type!='' order by type";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$type_array[]=$row['type'];
	}
*/
$type_array=array("desktop","laptop","printer_color","printer_b/w","printer_multi_function","scanner","router");

$sql="select distinct make from its_items where 1 and make!='' order by make";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$make_array[]=$row['make'];
	}
	
$sql="select distinct model from its_items where 1 and model !='' order by model";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$model_array[]=$row['model'];
	}
	
echo "<div align='center'><table border='1' cellpadding='5'>";
echo "<tr><td colspan='6' align='center'>NC DPR ITS Inventory </td></tr>";

echo "<tr>";
echo "<td><a href='its_inventory.php'>Search Page</a></td>";

echo "</tr>";
echo "</table></div>";


	include("add_its_form.php");

?>