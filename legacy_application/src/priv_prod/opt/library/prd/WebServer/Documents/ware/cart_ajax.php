<?php
$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
ini_set('display_errors',1);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

$browser=$_SERVER['HTTP_USER_AGENT'];
$var_brow="";
if(strpos($browser,"Trident")>-1)
	{
	$var_brow="win";
	}

if(!empty($_POST))
	{

	if(!empty($_POST['order']))
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		foreach($_POST['order'] as $id=>$index)
			{
			$var="quantity_".$index;
			$q=$_POST[$var];
			$sql="UPDATE park_order as t1, base_inventory as t2
			SET t1.ordered='x', t1.quantity='$q', t1.sold_by_unit=t2.sold_by_unit, t1.account=t2.funding_account
			where t1.id='$id' and t2.product_number=t1.product_number"; //echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
			}
		$pc=$_POST['park_code'];
		header("Location:order_placed.php?park_code=$pc");
		exit;
		}
		else
		{
		$park_code=$_POST['park_code'];
		$message= "Order not placed. No item(s) was/were checked.";
		}
	}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
extract($_REQUEST);
	
if(empty($rep))
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	include("cart_function_plus_ajax.php");
	}
	else
	{
	session_start();
	$level=$_SESSION['ware']['level'];
	}

// if(empty($level)){$level=3;}

@$multi_park=explode(",",$_SESSION['ware']['accessPark']);
// echo "<pre>"; print_r($multi_park); echo "</pre>"; // exit;
$where=" 1 ";

if($level>2 and !empty($park_code))
	{
	$where.="and park_code='$park_code'";
	}
if($level>2 and !empty($rcc))
	{
	$center="1280".$rcc;
	$where.="and center='$center'";
	}
if($level<2 and count($multi_park)<2)
	{
	$park_code=$_SESSION['ware']['select'];
	if(@$del=="x" and @$pass_park==$park_code)
		{
		$sql="DELETE FROM park_order 
		where park_code='$park_code' and id='$id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		}
	$where="park_code='$park_code'";
	}
if($level<2 and count($multi_park)>1)
	{
	if(@$del=="x" and in_array($pass_park,$multi_park))
		{
		$sql="DELETE FROM park_order 
		where park_code='$pass_park' and id='$id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		}
	if(empty($park_code))
		{
		$message= "Select a park.";
		 $where.="and (";
		 	foreach($multi_park as $k=>$v)
		 		{
		 		$where.="park_code='$v' OR ";
		 		}
		 	$where=rtrim($where," OR ").")";
		}
		else
		{
		$where="park_code='$park_code'";
		}
	}

if($level>2 and !empty($id) and @$del=="x")
	{
	$sql="DELETE FROM park_order 
	where id='$id'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	}	
	
$t1_flds="t1.`id`, t1.`park_code`, t1.`center`, t1.`product_number`, t2.`sold_by_unit`,
if(t3.in_stock>0,t3.in_stock,'out of stock') as in_stock, 
t1.`quantity`, t1.`price`,"; 
$t1_flds.="(t1.quantity*t1.price) as cost, ";
$t1_flds.="t1.`ordered_date`";

$sql="SELECT park_code
	FROM park_order as t1
	WHERE 1
	and t1.processed_date='0000-00-00' and ordered=''
	"; 
// 	WHERE $where
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$park_order_list[$row['park_code']]=$row['park_code'];
	}
$sql="SELECT  t2.item_group, $t1_flds, t2.product_title, t2.product_description
	FROM park_order as t1
	left join base_inventory as t2 on t1.product_number=t2.product_number
	left join stock as t3 on t1.product_number=t3.product_number
	WHERE $where
	and t1.processed_date='0000-00-00' and ordered=''
	order by t2.sort_order, t1.product_number, t1.park_code
	"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(empty($ARRAY))
	{
	@$t=$park_code.$rcc;
	!empty($t)?@$var="for $park_code $rcc":$var="";
	ECHO "There are no Warehouse items in your cart $var.";
	exit;
	}
$c=count($ARRAY);

if(!empty($rep))
	{
	$filename="warehouse_order_cart_";
		if(!empty($park_code)){$filename.="_$park_code";}
		if(!empty($rcc)){$filename.="_$rcc";}
		$filename.=".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	}
echo "<table border='1' cellpadding='5'>";

if(!empty($message))
	{
	echo "<tr><td colspan='12' align='center'><font size='+2' color='red'>$message</font></td></tr>";
	}
	
if(empty($rep))
	{
	$c==1?$it="item":$it="items";
	echo "<tr bgcolor='cyan'><td colspan='3'>$c $it in cart</td>";
	if(!empty($park_order_list))
		{
		ksort($park_order_list);
// 		echo "<pre>"; print_r($park_order_list); echo "</pre>"; // exit;
		if(!empty($multi_park) and $level<3)
			{
			array_unshift($multi_park,"");
			$park_order_list=array_flip($multi_park);
			}
		echo "<th colspan='2'><form>View Cart for Center: <select name='park_code' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($park_order_list as $k=>$v)
			{
			if($park_code==$v){$s="selected";}else{$s="";}
			echo "<option value='$k' $s>$k</option>\n";
			}
			if(empty($park_code)){$park_code="";}
		echo "</select> <font color='red' size='+1'>$park_code</font></form></th>";
		}

	if(empty($rcc)){$rcc="";}
	echo "<th colspan='3'><form>RCC: <input type='text' name='rcc' value='' onchange=\"this.form.submit()\" size='5'> <font color='red' size='+1'>$rcc</font></form></th>";

	if(!empty($park_code) or !empty($rcc))
		{
		echo "<th colspan=2' align='center'><A HREF=\"javascript:window.print()\">
		<IMG SRC=\"../inc/bar_icon_print_2.gif\" BORDER=\"0\"</A></th>";
	
			$var="rep=1&";
			if(!empty($park_code)){$var.="park_code=$park_code";}
			if(!empty($rcc)){$var.="center=$rcc";}
		echo "<th colspan='4'>Excel <a href='cart.php?$var'>export<a/></th>";
		}
	echo "</tr></table>";
	}
// ECHO "$sql";
if(empty($park_code)){$message="<br />Select a park."; echo "$message";}
if(@$message=="<br />Select a park."){exit;}
		
$skip=array("in_stock","ordered_date");
echo "<form action='cart.php' method='POST' name='frm'>";
echo "<table border='1' cellpadding='2'>";
if(empty($rep))
	{
	echo "<tr><td colspan='12'><font color='red' size='+1'>Be careful when changing Quantity.</font> Pressing the \"Enter\" key submits the order. <font size='1'>Click outside the box or tab after changing any quantity.</font></td></tr>";
	}
	else
	{
	date_default_timezone_set('America/New_York');
	echo "Your cart as of ".date("Y-m-d");
	}

if(count($ARRAY)>10)
	{
	
	echo "<tr><td colspan='13' align='center'>";
	if($var_brow=="win")
		{
		echo "<a href='base_inventory.php?park_code=$park_code&rcc=$rcc&submit=Submit'>Continue Shopping</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else
		{
		echo "<a href='base_inventory.php?park_code=$park_code&rcc=$rcc&submit=Submit'><input name=\"btn\" type=\"button\" value=\"Continue Shopping\" style=\"background-color:#FFFF66; color:#000;  font-size:14px;\"></a>";
		}
	echo "<input name=\"btn\" type=\"button\" onclick=\"CheckAll()\" value=\"Check All\" style=\"background-color:#0c0; color:#fff;  font-size:14px;\">
	<input name=\"btn\" type=\"button\" onclick=\"UncheckAll()\" value=\"Uncheck All\"> 
	<input type='hidden' name='rcc' value=\"$rcc\">
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Order Checked Items\" style=\"background-color:#c00; color:#fff;  font-size:14px;\">
	
	</td></tr>";
	}
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		echo "<td>Yes</td>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace("_"," ",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	$name="order[".$array['id']."]";
	
	@$v=$_POST['order'][$array['id']];
	if(!empty($v)){$ck="checked";}else{$ck="";}
	echo "<tr><td><input type='checkbox' name='$name' value=\"$index\" $ck></td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="id")
			{
			$pass_id=$value;
			$park_code=$array['park_code'];
			if($level<3){$pp="&pass_park=$park_code";}else{$pp="";}
			if($level<3){$pp="&pass_park=$park_code";}else{$pp="&park_code=$park_code";}
			$temp="<a href='cart.php?del=x&id=$value$pp' onclick=\"return confirm('Are you sure you want to remove this Item?')\"><font size='-2'>Remove</font> &nbsp;&nbsp;<img src='../fam_icons/icons/delete.png'></a>";
			if(empty($rep)){$value=$temp;}
			}
		
		if($fld=="park_code")
			{
			$rcc=substr($array['center'],-4,4);
			$temp="<font color='magenta'>".$value."</font>";
			if(empty($rep)){$value=$temp;}
			}
			
		if($fld=="product_number")
			{
			$temp="<a href='view_item.php?product_number=$value' target='_blank'>".$value."</a>";
			if(empty($rep)){$value=$temp;}
			}
			
		if($fld=="quantity")
			{
			$new_fld="quantity_".$index;
			$price=$array['price'];
			$temp="<font size='-2'>If changing,</font><input type='text' id='$new_fld' name='$new_fld' value=\"$value\" size='3' onchange=\"item_tot_id($price,$index,$pass_id);\">
			<font size='-2'>don't press Enter.</font>";
			if(empty($rep)){$value=$temp;}
			}
		if($fld=="price")
			{
			$new_fld="price_".$index;
			$temp="<input type='text' id='$new_fld' name='$new_fld' value=\"$value\" size='6' readonly>";
			if(empty($rep)){$value=$temp;}
			}
		if($fld=="cost")
			{
			@$tot+=$value;
			$new_fld="cost_".$index;
			$temp="<input type='text' id='$new_fld' name='$new_fld' value=\"$value\" size='6' readonly>";
			if(empty($rep)){$value=$temp;}
			}
	
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
$f_tot=number_format($tot,2);
echo "<tr><td colspan='10' align='right'>
<div id='grand_sum' style=\"color:magenta; font-size:28px;\">$f_tot</div>
</td></tr>";

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// $var_position=$_SESSION['ware']['beacon_title'];
// if(strpos($var_position,"Supervisor")>-1 or strpos($var_position,"Office Assistant")>-1 or $level>1)
if($level>0)
	{
	echo "<tr><td colspan='13' align='center'>";
	if($var_brow=="win")
		{
		echo "<a href='base_inventory.php?park_code=$park_code&rcc=$rcc&submit=Submit'>Continue Shopping</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else
		{
		echo "<a href='base_inventory.php?park_code=$park_code&rcc=$rcc&submit=Submit'><input name=\"btn\" type=\"button\" value=\"Continue Shopping\" style=\"background-color:#FFFF66; color:#000;  font-size:14px;\"></a>";
		}
	
	echo "<input name=\"btn\" type=\"button\" onclick=\"CheckAll()\" value=\"Check All\" style=\"background-color:#0c0; color:#fff;  font-size:14px;\">
	<input name=\"btn\" type=\"button\" onclick=\"UncheckAll()\" value=\"Uncheck All\"> 
	<input type='hidden' name='rcc' value=\"$rcc\">
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Order Checked Items\" style=\"background-color:#c00; color:#fff;  font-size:14px;\">
	
	</td></tr>";
	}
	else
	{
	echo "<tr><td colspan='13' align='center'>Only the PASU can submit the order to the Warehouse.</td></tr>";
	}
echo "</table></form>";	
	
	
	
?>