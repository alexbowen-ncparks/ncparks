<?php

if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION['ware']['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);


echo "
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='welcome.php'>Welcome</a></td></tr>";
echo "<tr><td><a href='/ware/base_inventory.php'>Search Inventory</a></td></tr>";
echo "<tr><td><a href='/ware/cart.php'>Your Cart</a></td></tr>";
echo "<tr><td><a href='/ware/order_placed.php'>Pending Order</a></td></tr>";
echo "<tr><td><a href='/ware/order_completed.php'>Completed Order</a></td></tr>";
echo "<tr><td><a href='/ware/invoices.php'>Invoices</a></td></tr>";
echo "<tr><td><a href='/ware/msds.php'>SDS Items</a></td></tr>";
//echo "<tr><td><a href='search.php'>Search</a></td></tr>";
//echo "<tr><td><a href='feedback.php'>Comments</a></td></tr>";

if($level>3) // 1
	{
	$append['------- Admin -------']="";
	$append['Purchases']="/ware/purchase.php";
	$append['Add Item']="/ware/add_it.php";
	$append['Edit Item']="/ware/base_inventory.php?act=edit";
	$append['Add Supplier']="/ware/add_supplier.php";
	$append['Edit Supplier']="/ware/base_supplier.php";
	$append['Edit Welcome']="/ware/welcome_edit.php";
	$append['Losses']="/ware/loss.php";
	$append['Users']="/ware/db_users.php";
	}
	

if($level>3) // 0
	{
//	echo "<tr><td>";
	foreach($append as $k=>$v)
		{
		echo "<tr><td><a href='$v'>$k</a></td></tr>";
	//	echo "<a href='$v'>$k</a><br />";
		}
//	echo "</td></tr>";
	}


echo "</table>";


?>