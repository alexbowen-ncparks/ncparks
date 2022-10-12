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
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
   	$skip_update=array("id","add","alt_item_group","alt_sub_group_1","alt_sub_group_2","alt_sold_by_unit");
   	
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
		if($fld=="item_group")
			{
			if(!empty($_POST['alt_item_group']))
				{$val=$_POST['alt_item_group'];}
			}
		if($fld=="sub_group_1")
			{
			if(!empty($_POST['alt_sub_group_1']))
				{$val=$_POST['alt_sub_group_1'];}
			}
		if($fld=="sub_group_2")
			{
			if(!empty($_POST['alt_sub_group_2']))
				{$val=$_POST['alt_sub_group_2'];}
			}
		if($fld=="sold_by_unit")
			{
			if(!empty($_POST['alt_sold_by_unit']))
				{$val=$_POST['alt_sold_by_unit'];}
			}
// 		$val=mysqli_real_escape_string($connection, $val);
		$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="insert into base_inventory set $clause"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$id=mysqli_insert_id($connection);
	header("Location: base_inventory.php?submit=Search&id=$id");
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
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
	$title="Warehouse Inventory";
	include("../_base_top.php");
	
	echo "<title>NC DPR Warehouse Inventory</title><body>";

$sql="select product_number from base_inventory where 1  and product_number < 99999 order by product_number desc limit 1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);
	$new_product_number=$row['product_number']+1;
	
$sql="select distinct item_group from base_inventory where 1 and item_group!='' order by item_group";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$item_group_array[]=$row['item_group'];
	}
if($level>2)
	{$item_group_array[]="Enter new group in box to right.";}

if(!empty($_POST['item_group']))
	{
	$var=$_POST['item_group'];
	$item=" and item_group = '$var'";
	$sql="select max(sort_order) as sort_order_max, min(sort_order) as sort_order_min from base_inventory where 1 
	$item
	"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		}
	
	}else{$item="";}
	$sql="select distinct sub_group_1 from base_inventory where 1 
	and sub_group_1!='' $item
	order by sub_group_1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$sub_group_1_array[]=$row['sub_group_1'];
		}

if(!empty($_POST['sub_group_1']))
	{
	$var=$_POST['sub_group_1'];
	$sub1=" and sub_group_1 = '$var'";}else{$sub1="";}	
	$sql="select max(sort_order) as sort_order_max, min(sort_order) as sort_order_min from base_inventory where 1 
	$sub1
	"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		}

if(!empty($_POST['sub_group_2']))
	{
	$var=$_POST['sub_group_2'];
	$sub2=" and sub_group_2 = '$var'";}else{$sub2="";}	
	$sql="select max(sort_order) as sort_order_max, min(sort_order) as sort_order_min from base_inventory where 1 
	$sub2
	"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		}
$sql="select distinct sub_group_2 from base_inventory where 1 
and sub_group_2!='' $sub1
order by sub_group_2";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$sub_group_2_array[]=$row['sub_group_2'];
	}
	
$sql="select distinct sold_by_unit from base_inventory where 1 and sold_by_unit!='' order by sold_by_unit";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$sold_by_unit_array[]=$row['sold_by_unit'];
	}
   	
	
include("add_its_form.php");

?>