<?php
session_start();

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['ware']['level'];

if($level<1){exit;}
	
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

// ADD
if(!empty($_POST) AND $_POST['add']=="Add")
	{
	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
   	$skip_update=array("suppler_id","add");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into base_supplier set $clause"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$supplier_id=mysqli_insert_id($connection);
	header("Location: base_supplier.php?submit=Search&supplier_id=$supplier_id");
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
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
	$title="Warehouse Inventory";
	include("../_base_top.php");
	
	echo "<title>NC DPR Warehouse Inventory Suppliers</title><body>";
	
	
include("suppliers_form.php");

?>