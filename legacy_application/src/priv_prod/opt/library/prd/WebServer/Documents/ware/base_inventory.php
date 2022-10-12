<?php
$database="ware";
include("../../include/auth.inc");
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

$level=$_SESSION[$database]['level'];
if($level>3)
	{ini_set('display_errors',1);}
//echo "$rcc<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if(!empty($rcc))
	{if(!is_numeric($rcc)){exit;}}


// echo "POST<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "GET<pre>"; print_r($_GET); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

$browser=$_SERVER['HTTP_USER_AGENT'];
$var_brow="";
if(strpos($browser,"Trident")>-1)
	{
	$var_brow="win";
	}

// RESET
if(@$_POST['submit']=="Reset")
	{
	if(!empty($_POST['park_code'])){$_GET['park_code']=$_POST['park_code'];}
	if(!empty($_POST['rcc'])){$_GET['rcc']=$_POST['rcc'];}
	unset($_POST);
	}

// Add to Cart - Single
if(@$_POST['cart']=="Add to Cart")
	{
	//echo "<pre>"; print_r($_POST); echo "</pre>"; 
	date_default_timezone_set('America/New_York');
	extract($_POST);
	if(empty($park_code))
		{
		echo "You did not specify a park code. Click your back button.";
		exit;
		}
	if(empty($quantity))
		{
		echo "You did not specify a quantity. Click your back button.";
		exit;
		}
	$sql="SELECT center FROM budget.center 
		where parkCode='$park_code' and center like '1280%'
		"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$ordered_date=date("Y-m-d");
	$sql="INSERT INTO park_order 
		set park_code='$park_code', center='$center',  product_number='$product_number', sold_by_unit='$sold_by_unit', quantity='$quantity', price='$price', ordered_date='$ordered_date'
		"; 
	//	echo "$sql"; exit;
		if (!mysqli_query($connection,$sql))
			{
			$e=mysqli_errno($connection);
			if($e=="1062"){echo "There is already an order for $park_code, center = $center, and product number = $product_number for $ordered_date. Return to <a href='cart.php?park_code=$park_code'>cart</a>";} exit;
			}
	
		header("Location: cart.php?park_code=$park_code");
	exit;
	}

// Add to Cart - Multi - from search_results.php
if(@$_POST['cart_items']=="Place the Indicated Items in Your Cart")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; 
	date_default_timezone_set('America/New_York');
	extract($_POST);
	if(empty($park_code))
		{
		echo "You did not specify a park code. Click your back button.";
		exit;
		}
	foreach($_POST['prod_num'] as $k=>$v)
		{
		$value=${"quantity_".$k};
		$var_cost=$_POST['cost'][$k];
		if(!empty($value))
			{
			$order_quantity[$v]=$value;
			$order_cost[$v]=$var_cost;
			}
		}
//		echo "<pre>"; print_r($order_quantity); print_r($order_cost); echo "</pre>";  exit;
	if(empty($order_quantity))
		{
		echo "You did not specify a quantity. Click your back button.";
		exit;
		}
	$sql="SELECT center FROM budget.center 
		where parkCode='$park_code' and center like '1280%'
		"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$ordered_date=date("Y-m-d");
		foreach($order_quantity as $product_number=>$quantity)
			{
			$price=$order_cost[$product_number];   $sold_by_unit="";
			$sql="INSERT INTO park_order 
			set park_code='$park_code', center='$center',  product_number='$product_number', sold_by_unit='$sold_by_unit', quantity='$quantity', price='$price', ordered_date='$ordered_date'
			";    //	echo "$sql"; exit;
			if (!mysqli_query($connection,$sql))
				{
				$e=mysqli_errno($connection);
				if($e=="1062"){echo "There is already an order for $park_code, center = $center, and product number = $product_number for $ordered_date. Return to <a href='cart.php?park_code=$park_code'>cart</a>";} exit;
				}
			}
	
		header("Location: cart.php?park_code=$park_code");
	exit;
	}

// DELETE
if(!empty($_POST) AND @$_POST['submit']=="Delete")
	{
   	$product_number=$_POST['product_number'];
	$sql="DELETE FROM base_inventory 
	where product_number='$product_number'"; 
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['product_number']="$product_number";
	}
// UPDATE
if(!empty($_POST) AND @$_POST['update']=="Update")
	{
	if($_FILES['files']['error'][0]==0)
		{
	//	echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
		include("ware_photo.php");
		}
	if($_FILES['msds']['error'][0]==0)
		{
	//	echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
		include("msds_file.php");
		}
	
   	$skip_update=array("update","id");
   	$id=$_POST['id'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		@$clause.=$fld."='".$val."', ";
		}
	if(empty($_POST['hide'])){$clause.="`hide`=''";}
	$clause=rtrim($clause, ", ");
	$sql="update base_inventory set $clause 
	where id='$id'"; 
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['id']="$id";
//	$_GET['id']="$id";
	}



if(!empty($_REQUEST['rep']))
	{
// 	date_default_timezone_set('America/New_York');
// 	$filename="warehouse_inventory_".date("Y-m-d").".xls";
// 	header('Content-Type: application/vnd.ms-excel');
// 	header("Content-Disposition: attachment; filename=$filename");
	}
	else
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	}

	if((empty($_GET) or !empty($_POST['place_order'])) and (empty($_POST['submit'])))
		{
		include("ajax_rcc_form.php");
		exit;
		}
		else
		{
			if($level<2)
			{
			if(!empty($_SESSION['ware']['accessPark']))
				{
				$exp=explode(",",$_SESSION['ware']['accessPark']);
				if(in_array($_REQUEST['park_code'],$exp))
					{
					$_SESSION[$database]['temp_parkCode']=$_REQUEST['park_code'];
					}
					else
					{
					$_SESSION[$database]['temp_parkCode']=$exp[0];
					$_GET['park_code']=$exp[0];
					}
				}
				else
				{
				$_SESSION[$database]['temp_parkCode']=$_SESSION[$database]['select'];
				$_GET['park_code']=$_SESSION[$database]['select']; //echo "hello";
				}
			}
		}

	// SEARCH **************************************
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	include("search_query.php");

	//echo "<pre>"; print_r($COLS); echo "</pre>";  exit;

		$edit_level=3;
			if(empty($_SESSION['ware']['temp_level']))
				{$_SESSION['ware']['temp_level']=$level;}
			
		$temp_level=$level;
		$park_code=$_SESSION['ware']['select'];
		if($level>3)
			{
			if(!empty($_REQUEST['act']))
				{
				$_SESSION['ware']['temp_level']=4;
				}
				else
				{$_SESSION['ware']['temp_level']=0;}
			}
		echo "<title>NC DPR Warehouse Inventory</title><body>";
	
$temp_level=$_SESSION['ware']['temp_level'];
$cart_level=$_SESSION['ware']['cart'];
//echo "t=$temp_level";

$size_array=array("id"=>"3","see_also"=>"5");

if(!empty($_POST['pass_query']))
		{
		$temp=str_replace(" and ","*", $_POST['pass_query']);
		$temp=str_replace("and ","", $temp);
		$temp=str_replace(" or ","", $temp);
		$temp=str_replace(" like ","=", $temp);
//		echo "<br /><br />t=$temp";
		$exp=explode("*",trim($temp," "));
//		echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
		foreach($exp as $k=>$v)
			{
			if(empty($v)){continue;}
			$exp1=explode("=",$v);
			$query_val[$exp1[0]]=trim(@$exp1[1],"'");
			}
//		echo "$temp<pre>"; print_r($query_val); echo "</pre>"; // exit;
		}
//	echo "261<pre>"; print_r($COLS); echo "</pre>";  exit;
if(empty($_REQUEST['rep']))
	{
	  // includes UPDATE for item
echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	if($_SESSION['ware']['select']=="WARE" and empty($_GET['rcc']) and empty($_GET['park_code']))
		{
		$_SESSION[$database]['temp_rcc']="2802";
		$_SESSION[$database]['temp_parkCode']="WARE";
		}
	if($_SESSION['ware']['select']=="YORK" and empty($_GET['rcc']) and empty($_GET['park_code']))
		{
		$_SESSION[$database]['temp_rcc']="2902";
		$_SESSION[$database]['temp_parkCode']="FALA";
		}
	if(!empty($_GET['rcc']))
		{$_SESSION[$database]['temp_rcc']=$_GET['rcc'];}
	if(!empty($_POST['rcc']))
		{$_SESSION[$database]['temp_rcc']=$_POST['rcc'];}
	if(!empty($_GET['park_code']))
		{$_SESSION[$database]['temp_parkCode']=$_GET['park_code'];}
	if(!empty($_POST['park_code']))
		{$_SESSION[$database]['temp_parkCode']=$_POST['park_code'];}
		
		$temp_rcc=$_SESSION[$database]['temp_rcc'];
		$temp_parkCode=$_SESSION[$database]['temp_parkCode'];
		
	echo "<table border='1' cellpadding='3' width='180%'>";
	echo "<tr><td colspan='3'><font color='red'>RCC = $temp_rcc - $temp_parkCode</font></td><td bgcolor='yellow'>Search for items by Product Title, Description, Item Group, Sub-Group, etc. Green box searches are \"contains\", e.g., searching for \"soap\" returns 3 items with soap in their Product Title.</td></tr></table>";
	
	//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	echo "<table border='1'>";
	include("search_form.php");   // includes Update for item
	
//	echo "</table>";
	}
	else
	{
	$skip_these=array();
	echo "<table>";
	echo "<tr>";
	foreach($ARRAY[0] AS $fld=>$val)
		{ 
		if(in_array($fld,$skip_these)){continue;}
		echo "<th>$fld</th>";
		}
	echo "</tr>";
	echo "</table>";
	}

//$skip_these=array("subnet_park_code","subnet_id");	
$skip_these=array();
//echo "284<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

if(@$_POST['act']=="edit")
	{
	include("mod_search_results.php");
	exit;
	}
// $ARRAY created in search_query.php - line 93
if(!empty($ARRAY))
	{
	include("search_results.php");
	}
?>