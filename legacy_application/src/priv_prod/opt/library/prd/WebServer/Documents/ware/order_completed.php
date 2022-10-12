<?php
$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
ini_set('display_errors',1);

extract($_REQUEST);

if(empty($rep))
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	}
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
if(!empty($_POST['order']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	date_default_timezone_set('America/New_York');
// 	$com=mysqli_real_escape_string($connection, $_POST['comments']);
	$pc=$_POST['park_code'];
	foreach($_POST['order'] as $id=>$v)
		{
		$d=date("Y-m-d");
		$sql="UPDATE park_order SET processed_date='$d', comments='$com' where id='$id'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
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
	echo "<p>The $pc order has been completed.</p>
	<p>1. Click the link to <a href='invoice_pdf.php?park_code=$pc&processed_date=$d'>create the invoice</a>.</p>
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
	exit;
	}
	
if(empty($level)){$level=3;}

@$multi_park=explode(",",$_SESSION['ware']['accessPark']);

$where=" 1 ";

if(!empty($processed_date))
	{
	$where.="and processed_date='$processed_date'";
	}
	
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
if(t3.in_stock>0,t3.in_stock,'out of stock') as in_stock, t1.`comments`,
t1.`quantity`, t1.`price`,"; 
$t1_flds.="(t1.quantity*t1.price) as cost, ";
$t1_flds.="t1.`ordered_date`";
$t1_flds.=", t1.`processed_date`";

//$where
$sql="SELECT distinct t1.park_code, t2.processed_date, t2.link 
	FROM park_order as t1 
	LEFT JOIN invoices as t2 on t1.park_code=t2.park_code and t1.processed_date=t2.processed_date 
	WHERE 1 and t1.processed_date!='0000-00-00' and t1.ordered='x'
	"; 
	//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$park_order_list[$row['park_code']]="";
	$park_invoice_list[$row['park_code']][$row['processed_date']]=$row['link'];
	}

$sql="SELECT  t2.sort_order, t2.item_group, $t1_flds, t2.product_title, t2.product_description
	FROM park_order as t1
	left join base_inventory as t2 on t1.product_number=t2.product_number
	left join stock as t3 on t1.product_number=t3.product_number
	WHERE $where
	and t1.processed_date!='0000-00-00' and ordered='x'
	order by processed_date desc, t2.sort_order, t2.item_group, t1.park_code
	";   //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{
	@$t=$park_code.$rcc;
	!empty($t)?@$var=" for $park_code $rcc":$var="";
	ECHO "There are no shipped Warehouse items$var.";
	exit;
	}
$c=count($ARRAY);
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
if(!empty($rep))
	{
	$filename="warehouse_order_completed_".$processed_date;
		if(!empty($park_code)){$filename.="_$park_code";}
		if(!empty($rcc)){$filename.="_$rcc";}
		$filename.=".xls";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	}
echo "<table border='1' cellpadding='5'>";

$c==1?$it="item":$it="items";
if(empty($rep))
	{
	echo "<tr bgcolor='lightgreen'><th colspan='3'>$c $it Shipped</th>";
	if(!empty($park_order_list))
		{
		ksort($park_order_list);
		echo "<th colspan='2'><form>View Order Completed for Center: <select name='park_code' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($park_order_list as $k=>$v)
			{
			echo "<option value='$k'>$k</option>\n";
			}
			if(empty($park_code)){$park_code="";}
		echo "</select> <font color='red' size='+1'>$park_code</font></form></th>";
		}

	if(empty($rcc)){$rcc="";}
	echo "<th colspan='3'><form>RCC: <input type='text' name='rcc' value='' onchange=\"this.form.submit()\" size='5'> <font color='red' size='+1'>$rcc</font></form></th>";
	
	if(!empty($park_code) or !empty($rcc))
		{
		unset($processed_date_array);
		if(!empty($park_code))
			{$where="and park_code='$park_code'";}
		if(!empty($rcc))
			{$where="and center like '%$rcc'";}
		$sql="SELECT park_code, processed_date
		FROM park_order as t1
		WHERE 1 $where
		and t1.processed_date!='0000-00-00' and ordered='x' 
		order by processed_date desc
		"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$processed_date_array[$row['processed_date']]="";
			}
		echo "<th colspan='2'><form>View Order by Processed Date: <select name='processed_date' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($processed_date_array as $k=>$v)
			{
			echo "<option value='$k'>$k</option>\n";
			}
			if(empty($processed_date)){$processed_date="";}
		echo "</select> <font color='red' size='+1'>$processed_date</font>";
		if(!empty($park_code))
			{
			echo "<input type='hidden' name='park_code' value=\"$park_code\">";
			}
		if(!empty($rcc))
			{
			echo "<input type='hidden' name='rcc' value=\"$rcc\">";
			}
		echo "</form></th>";
		}
	
	if(!empty($processed_date))
		{
		echo "<th colspan=2' align='center'><A HREF=\"javascript:window.print()\">
		<IMG SRC=\"../inc/bar_icon_print_2.gif\" BORDER=\"0\"</A></th>";
		$var="rep=1&processed_date=$processed_date&";
		if(!empty($park_code)){$var.="park_code=$park_code";}
		if(!empty($rcc)){$var.="center=$rcc";}
		echo "<th>Excel <a href='order_completed.php?$var'>export<a/></th>";
		}
	if($level>3 and !empty($park_code))
		{
		@$link=$park_invoice_list[$park_code][$processed_date];
		if(!empty($link))
			{
			echo "<th>View  <a href='$link' target='_blank'>Invoice<a/></th>";
			if($level>3)
				{
				echo "<th>Delete  <a href='del_completed_order.php?park_code=$park_code&processed_date=$processed_date' target='_blank'  onclick=\"return confirm('Are you sure you want to delete this Completed Order?')\">Completed Order<a/></th>";
				}
			}
			else
			{
			
		if(!empty($processed_date))
				{
				echo "<th>Create  <a href='invoice_pdf.php?park_code=$park_code&processed_date=$processed_date'>Invoice<a/></th>";
				if($level>3)
					{
					echo "<th>Delete  <a href='del_completed_order.php?park_code=$park_code&processed_date=$processed_date' target='_blank'  onclick=\"return confirm('Are you sure you want to delete this Completed Order?')\">Completed Order<a/></th>";
					}
				}
			}
		}
		
	echo "</tr></table>";
	if(empty($park_code) and $level<2){$park_code=$_SESSION['ware']['select'];}
	if(empty($park_code) and empty($rcc) and $level>2)
		{
		echo "<p><font color='brown'>Please select a Center from drop-down menu.</font></p>";
		exit;}
		
	if(empty($processed_date))
		{
		@$t=$park_code.$rcc;
		!empty($t)?@$var=" for $park_code $rcc":$var="";
		ECHO "<p align='center'><font color='brown'>Select a specific Processed Date from menu above$var.</font>";
		exit;
		}
	}

	
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array("in_stock","id");
echo "<form action='order_placed.php' method='POST' name='frm'>";
echo "<table border='1' cellpadding='2'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
	//	echo "<td>Yes</td>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
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
		if($fld=="id")
			{
			$park_code=$array['park_code'];
			if($level<3){$pp="&pass_park=$park_code";}else{$pp="";}
			$temp="<a href='order_placed.php?del=x&id=$value$pp' onclick=\"return confirm('Are you sure you want to remove this Item?')\">Remove</a>";
			if(empty($rep)){$value=$temp;}
			}
/*		
		if($fld=="park_code")
			{
			$rcc=substr($array['center'],-4,4);
			$temp="<font color='magenta'>".$value."</font> <font size='-2'><a href='base_inventory.php?park_code=$value&rcc=$rcc&submit=Submit' target='_blank'>add</a></font>";
			if(empty($rep)){$value=$temp;}
			}
			
		if($fld=="product_number")
			{
			$park_code=$array['park_code'];
			$rcc=substr($array['center'],-4,4);
			$temp="<a href='base_inventory.php?rcc=$rcc&park_code=$park_code&product_number=$value' target='_blank'>$value</a>";
			if(empty($rep)){$value=$temp;}
			}
*/		
		if($fld=="cost"){@$tot+=$value;}
		if(!empty($rep))
			{echo "<td>$value</td>";}
			else
			{
			$id=$ARRAY[$index]['id'];
			echo "<td>$value
			<input type='hidden' name='order[$id]' value=\"$id\">
			</td>";
			}
		
		}
	echo "</tr>";
	}
$f_tot=number_format($tot,2);
echo "<tr><td colspan='8' align='right'>
<div id='grand_sum'>$f_tot</div>
</td>";
if(!empty($ARRAY[0]['comments']))
	{
	$t=$ARRAY[0]['comments'];
	echo "<td colspan='8'>Comment: $t</td></tr>";
	}

echo "</tr>";


echo "<tr><td colspan='14' align='left'>
The $it listed above have been shipped from the Warehouse. <font color='red'>If any item was NOT received, contact the Warehouse.</font>
</td></tr>";

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
	$subject="Subject=Warehouse order from $park_code";
	date_default_timezone_set('America/New_York');
	$d=date("Y-m-d");
	$body="Body=$park_code has placed an order of $c $it on $d.";
	echo "<tr><td colspan='12' align='left'>
	<font color='green'>If everything is correct, send an email to the Warehouse notifying them of your order.</font>
	<a href='mailto:$email?$subject&$body'>email</a>
	</td></tr>";
	}
/*
	else
	{
	echo "<tr><td colspan='13'><textarea name='comments' cols='80' rows='2'></textarea> Enter any comments regarding this order.</td>
	<input type='hidden' name='complete' value=\"x\">
	</tr>";
	echo "<tr><td colspan='13' align='center'><font color='red'>Warehouse Only</font> Clicking this button marks the order as complete.
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Order Processed for Listed Items\" style=\"background-color:#0c0; color:#fff;  font-size:14px;\">
	</td></tr>";
	}
*/
echo "</table></form>";	
	
	
	
?>