<?php
// echo "This was used to test why the form wasn't properly working for orders > 76";
// exit;

$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

// ini_set('display_errors',1);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(empty($rep) AND empty($csv))
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	}
if($level<5)
	{
// 	echo "The Warehouse database is being modified. Try later today.";  exit;
	}
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;	

if(!empty($_POST['order']))
	{
echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	date_default_timezone_set('America/New_York');
// 	$com=mysqli_real_escape_string($connection, $_POST['comments']);
	if(empty($_POST['comments']) or empty($_POST['park_code']))
		{
		if(empty($_POST['comments']))
			{		
			echo "No commnets were entered. This order was not processed."; 
			}
		if(empty($_POST['park_code']))
			{		
			echo " There was an issue with the park_code This order was not processed."; 
			}
		exit;
		}
 	$com=$_POST['comments'];
	$pc=$_POST['park_code'];
	$d=date("Y-m-d");
	if(!empty($_POST['credit']))
		{
//		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		$credit=-abs($_POST['credit']);
		$id=$_POST['pass_id'];
		if(!is_numeric($id)){exit;}
		$credit_product_number=$_POST['credit_product_number'];
		$sql="SELECT funding_account from base_inventory where product_number='$credit_product_number'"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		$row=mysqli_fetch_assoc($result); $ck=mysqli_num_rows($result);
		if($ck<1){echo "No product with a  product number of $credit_product_number was found."; exit;}
		extract($row);
		$sql="SELECT park_code, center, ordered_date from park_order where id='$id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		$row=mysqli_fetch_assoc($result);
		extract($row);
		$sql="INSERT INTO park_order
		SET park_code='$park_code', center='$center', ordered_date='$ordered_date', sold_by_unit='(credit)', quantity='1', price='$credit', product_number='$credit_product_number', ordered='x', comments='credit given', account='$funding_account'
		"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		}
	if(empty($_POST['credit_submit']))
		{
		foreach($_POST['order'] as $id=>$v)
			{
			if(!is_numeric($id)){exit;}
			$sql="UPDATE park_order SET processed_date='$d', comments='$com' where id='$id'"; //echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
			}
		}
	$sql="SELECT t1.email
		FROM divper.empinfo as t1
		left join divper.emplist as t2 on t1.emid=t2.emid
		left join divper.position as t3 on t2.beacon_num=t3.beacon_num
		WHERE t3.park='$pc' and (t3.posTitle like '%park super%' or t3.posTitle like '%office assist%')
		order by t1.Lname
		"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$email_array[]=$row['email'];
		}
	if(empty($email_array))
		{
		$subject="Subject=Warehouse order from $pc is complete";
		date_default_timezone_set('America/New_York');
		$d=date("Y-m-d");
		$body="Body=Your Warehouse order has been completed on $d.";
		echo "The order for $pc has been fullfilled. However, we have not linked an email to the center_code $pc. Contact Tom Howard. You will need to manually enter the email address to acknowledge fulfilling their order. <a href='mailto:?$subject&$body'>email</a>";
		}
		else
		{
		if(empty($_POST['credit_submit']))
			{
			echo "<p>The $pc order has been completed.</p>
			<p>1. Click the link to review the order <a href='order_completed.php?park_code=$pc&processed_date=$d'>before creating the invoice</a>.</p>
			<p>2. After creating the invoice as a PDF you can attach it to the email created by the link below.</p>
			";
			strpos($_SERVER["HTTP_USER_AGENT"],"Mac OS X")>-1?$pass_os="Mac":$pass_os="Win";
			foreach($email_array as $ke=>$ve)
				{
				if($pass_os=="Win")
					{
					@$t.="$ve; "; // MS Outlook requires ; as a separator
					}
					else
					{
					@$t.="$ve, ";
					}
				}
			$email=rtrim($t,"; ");
			$email=rtrim($email,", ");
			$subject="Subject=Warehouse order from $pc is complete";
			date_default_timezone_set('America/New_York');
			$d=date("Y-m-d");
			$body="Body=Your Warehouse order has been completed on $d.";
			echo "You can email the staff at $pc here. <a href='mailto:$email?$subject&$body'>email</a>";
			}
		}
	if(empty($_POST['credit_submit']))
			{exit;}
	}
	
if(empty($level)){$level=3;}

@$multi_park=explode(",",$_SESSION['ware']['accessPark']);

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
	$park_code=$_SESSION['ware']['program_code'];
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
	$where.="and (";
	foreach($multi_park as $k=>$v)
		{
		$where.="park_code='$v' OR ";
		}
	$where=rtrim($where," OR ").")";
	if(!empty($_REQUEST['park_code']))
		{$where="park_code='$park_code'";}
	}

if($level>2 and !empty($id) and @$del=="x")
	{
	$sql="SELECT park_code from park_order 
	where id='$id'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_assoc($result); extract($row);
	$where.=" and park_code='$park_code'";
	$sql="DELETE FROM park_order 
	where id='$id'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	}	

$sql="SELECT t1.email
	FROM divper.empinfo as t1
	left join divper.emplist as t2 on t1.emid=t2.emid
	left join divper.position as t3 on t2.beacon_num=t3.beacon_num
	WHERE t3.park='WARE'
	order by t1.Lname
	"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$email_array[]=$row['email'];
	}
		
$t1_flds="t1.`id`, t1.`park_code`, t1.`center`, t1.`product_number`, t1.`sold_by_unit`, 
if(t3.in_stock>0,t3.in_stock,'out of stock') as in_stock, 
t1.`quantity`, t1.`price`,"; 
$t1_flds.="(t1.quantity*t1.price) as cost, ";
$t1_flds.="t1.`ordered_date`";

$sql="SELECT park_code
	FROM park_order as t1
	WHERE $where
	and t1.processed_date='0000-00-00' and ordered='x'
	"; 
// 	ECHO "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$park_order_list[$row['park_code']]="";
	}
if(empty($_REQUEST))
	{	
	@$_SESSION['ware']['park_order_list']=$park_order_list;
	}
	ELSE
	{
	@$park_order_list=$_SESSION['ware']['park_order_list'];
	}
$sql="SELECT  t2.sort_order, t2.item_group, $t1_flds, t2.product_title, t2.product_description
	FROM park_order as t1
	left join base_inventory as t2 on t1.product_number=t2.product_number
	left join stock as t3 on t1.product_number=t3.product_number
	WHERE $where
	and t1.processed_date='0000-00-00' and ordered='x'
	order by t2.sort_order, t1.product_number, t1.park_code

	";  // echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	@$t=$park_code.$rcc;
	!empty($t)?@$var=" for $park_code $rcc":$var="";
	ECHO "There are no Warehouse items on order$var.";
	exit;
	}
$c=count($ARRAY);

if(!empty($csv))
	{
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies

	function outputCSV($data) {
		$output = fopen("php://output", "w");
		foreach ($data as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		fclose($output);
	}

	outputCSV($ARRAY);

	exit;
	}

echo "<table border='1' cellpadding='5'>";

if(empty($rep))
	{
	$c==1?$it="item":$it="items";
	$c==1?$verb="has":$verb="have";
	if($level<3 and empty($_POST))
		{
		echo "<tr bgcolor='aliceblue'><th colspan='13'><font color='orange' size='+1'>Be sure to notify Warehouse of your order by sending an email. See bottom of this form.</font></th>";
		}
	echo "<tr bgcolor='yellow'><th colspan='3'>$c $it Ordered</th>";
	if(!empty($park_order_list))
		{
		ksort($park_order_list);
		echo "<th colspan='2'>
		<form action='test.php'>View Order Placed for Center: <select name='park_code' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($park_order_list as $k=>$v)
			{
			echo "<option value='$k'>$k</option>\n";
			}
			if(empty($park_code)){$park_code="";}
		echo "</select> <font color='red' size='+1'>$park_code</font></form>
		</th>";
		}

	if(empty($rcc)){$rcc="";}
	echo "<th colspan='3'>
	<form>RCC: <input type='text' name='rcc' value='' onchange=\"this.form.submit()\" size='5'> <font color='red' size='+1'>$rcc</font></form>
	</th>";
	
	if(!empty($park_code) or !empty($rcc))
		{
		echo "<th colspan='2' align='center'><A HREF=\"javascript:window.print()\">
		<IMG SRC=\"../inc/bar_icon_print_2.gif\" BORDER=\"0\"</A></th>";
		$var="rep=1&";
		if(!empty($park_code)){$var.="park_code=$park_code";}
		if(!empty($rcc)){$var.="center=$rcc";}
	$var="rep=1&";
		$var_csv="csv=1&";
		if(!empty($park_code))
			{
			$var_csv.="park_code=$park_code";
			$var.="park_code=$park_code";
			}
		if(!empty($rcc))
			{
			$var_csv.="center=$rcc";
			$var.="center=$rcc";
			}
// 	echo "<th colspan='4'>Excel <a href='test.php?$var'>export<a/></th>";
	echo "<th>Excel <a href='test.php?$var_csv'>CSV<a/></th>";
		}

	echo "</tr>";
	if(!empty($ARRAY))
		{
		echo "<tr bgcolor='aliceblue'><td colspan='12'>
		<font size='-1'>If you need to change a quanity, click the \"product number\" link. You may add additional items as long as the order has not been processed by the Warehouse. see link below</font></td></tr>";
		}
	echo "</table>";
	if(empty($park_code) and $level<2){$park_code=$_SESSION['ware']['select'];}
	if(empty($park_code) and empty($rcc) and $level>1)
		{
		echo "<p><font color='green'>Please select a Center from drop-down menu.</font></p>";
		exit;
		}
	}

$skip=array("in_stock");
echo "<form action='test.php' method='POST' name='frm'>";
echo "<table border='1' cellpadding='2'>";
// echo "<input type='hidden' name='park_code' value=\"$park_code\">";
if(!empty($rep))
	{
	echo "<tr><td colspan='7'>The items listed below have been placed on order from the Warehouse.</td>
	<td colspan='8'>Microsoft Excel no longer allows us to create a .xls file. Type Control-A to select all, copy, and then paste into a blank Excel spreasheet.</td>
	</tr>";
	}
	
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
	//	echo "<td>Yes</td>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(!empty($rep) and $fld=="id"){continue;}
			$var_fld=str_replace("_"," ",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	$name="order[".$array['id']."]";
	
//	@$v=$_POST['order'][$array['id']];
//	if(!empty($v)){$ck="checked";}else{$ck="";}
	echo "<tr>";
	
//	echo "<td><input type='checkbox' name='$name' value=\"x\" $ck></td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$id=$ARRAY[$index]['id'];
		if($fld=="id")
			{
			$pass_id=$value;
			$park_code=$array['park_code'];
			if($level<3){$pp="&pass_park=$park_code";}else{$pp="";}
			$temp="<a href='test.php?del=x&id=$value$pp' onclick=\"return confirm('Are you sure you want to remove this Item?')\">Remove</a>";
			if(empty($rep))
				{
				$value=$temp."<input type='hidden' name='order[$id]' value=\"$id\">";
				}
				else{continue;}
			}
		if($fld=="product_number")
			{
			$temp="<a href='edit_park_purchase.php?id=$id'>$value</a>";
			if(empty($rep)){$value=$temp;}
			}
		
		if($fld=="cost")
			{
			@$tot+=$value;
			$value=number_format($value,2);
			}
		
		echo "<td>$value</td>";
			
		}
	echo "</tr>";
	}
	
$f_tot=number_format($tot,2);
if(empty($rcc)){$rcc=substr($ARRAY[0]['center'],4,4);}
if(empty($rep))
	{
	echo "<tr><td colspan='3'>Add another item 
	<a href='base_inventory.php?park_code=$park_code&rcc=$rcc&submit=Submit'>here</a>.
	</td><td colspan='6' align='right'>
	<div id='grand_sum' style=\"color:magenta; font-size:28px;\">$f_tot</div>
	</td></tr>";
	}
	else
	{
	echo "<tr><td colspan='3'> 
	</td><td colspan='6' align='right'>
	<div id='grand_sum' style=\"color:magenta; font-size:28px;\">$f_tot</div>
	</td></tr>";
	}
if(!empty($it))
	{
	echo "<tr><td colspan='12' align='left'>
	The $it listed above $verb been placed on order from the Warehouse. <font color='red'>If any item is NOT to be ordered, click the \"Remove\" link.</font>
	</td></tr>";
	}

strpos($_SERVER["HTTP_USER_AGENT"],"Mac OS X")>-1?$pass_os="Mac":$pass_os="Win";
foreach($email_array as $ke=>$ve)
		{
		if($pass_os=="Win")
			{
			@$t.="$ve; "; // MS Outlook requires ; as a separator
			}
			else
			{
			@$t.="$ve, ";
			}
		}

if($level<3)
	{
	$email=rtrim($t,"; ");
	$email=rtrim($email,", ");
	date_default_timezone_set('America/New_York');
	$d=date("Y-m-d");
	$subject="Subject=Warehouse order from $park_code on $d";
	$body="Body=$park_code has placed an order of $c $it costing $$f_tot on $d.";
	echo "<tr><td colspan='12' align='left'>
	<font color='green'>If everything is correct, send an email to the Warehouse notifying them of your order.</font>
	<a href='mailto:$email?$subject&$body'>email</a>
	</td></tr>";
	}
	else
	{

	if(empty($rep))
		{

		echo "<tr><td colspan='13' align='center'><font color='red'>Warehouse Only</font> Clicking this button marks the order as complete.
		<input type='hidden' name='park_code' value=\"$park_code\">
		<input type='submit' name='submit' value=\"Order Processed for Listed Items\" style=\"background-color:#0c0; color:#fff;  font-size:14px;\">
		</td></tr>";
		}
	}

echo "</table></form>";	
	
	
	
?>