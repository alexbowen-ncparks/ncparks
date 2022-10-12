<?php
$database="ware";
include("../../include/auth.inc");
$level=$_SESSION[$database]['level'];

include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	


extract($_REQUEST);

if(empty($rep))
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	}
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

	
//if(empty($level)){$level=3;}

@$multi_park=explode(",",$_SESSION['ware']['accessPark']);

$where="";

if($level==1)
	{
	$park_code=$_SESSION[$database]['select'];
	$pc_where="  1 and park_code='$park_code'";
	}
if($level>1 and !empty($park_code))
	{
	$where=" where 1 and park_code='$park_code'";
	}
if($level>2 and !empty($rcc))
	{
	$center="1280".$rcc;
	$where=" where 1 and center='$center'";
	}
if($level>2 and !empty($invoice_number))
	{
	$where=" where 1 and invoice_number like '%$invoice_number%'";
	}
if($level<2 and count($multi_park)<2)
	{
	$park_code=$_SESSION['ware']['select'];
	$where=" where park_code='$park_code'";
	}
if($level<2 and count($multi_park)>1)
	{
	$pc_where="1 and (";
	foreach($multi_park as $k=>$v)
		{
		$pc_where.="park_code='$v' OR ";
		}
	$pc_where=rtrim($pc_where," OR ").")";
	}	
if($level==2)
	{
	include("../../include/get_parkcodes_i.php");
	$dist=$_SESSION['ware']['select'];
	$var_array=${"array".$dist};
	$pc_where="1 and (";
	foreach($var_array as $k=>$v)
		{
		$pc_where.="park_code='$v' OR ";
		}
	$pc_where=rtrim($pc_where," OR ").")";
	//echo "<pre>"; print_r($var_array); echo "</pre>"; // exit;
	}	
if($level>2)
	{
	$pc_where="";
	}
			
$t1_flds="t1.`id`, t1.`park_code`, t1.`center`, t1.`product_number`, t1.`sold_by_unit`, 
if(t3.in_stock>0,t3.in_stock,'out of stock') as in_stock, 
t1.`quantity`, t1.`price`,"; 
$t1_flds.="(t1.quantity*t1.price) as cost, ";
$t1_flds.="t1.`ordered_date`";
$t1_flds.=", t1.`processed_date`";

$sql="SELECT park_code
	FROM invoices as t1
	WHERE $pc_where
	"; 
if($level==2)
	{
	$sql="SELECT park_code
	FROM invoices as t1
	WHERE $pc_where
	";
	}
if($level>2)
	{
	$sql="SELECT park_code
	FROM invoices as t1
	WHERE 1
	";
	}
// echo "$sql<br /><br />";
mysqli_select_db($connection,"ware");
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$park_invoice_list[$row['park_code']]="";
	}

if(empty($park_invoice_list))
	{
	ECHO "There are no Warehouse invoices.";
	exit;
	}
$sql="SELECT  t1.*
	FROM invoices as t1
	$where
	order by processed_date desc
	";  
// echo "$sql";
if(!empty($where))
	{
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	if(empty($ARRAY))
		{
		@$t=$park_code.$rcc.$invoice_number;
		!empty($t)?@$var=" for $park_code $rcc $invoice_number":$var="";
		ECHO "There are no invoices$var.";
		exit;
		}
	}
	else
	{$ARRAY=array();}

$c=count($ARRAY);

if(!empty($rep))
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=warehouse_invoices.xls');
	}
echo "<table border='1' cellpadding='5'>";

$c==1?$it="Invoice":$it="Invoices";
if(empty($rep))
	{
	echo "<tr bgcolor='#0CC'><th colspan='3'>$c $it</th>";
	if(!empty($park_invoice_list))
		{
		ksort($park_invoice_list);
		echo "<th colspan='2'><form>View Invoices for Center Code: <select name='park_code' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($park_invoice_list as $k=>$v)
			{
			echo "<option value='$k' $s>$k</option>\n";
			}
			if(empty($park_code)){$park_code="";}
		echo "</select> <font color='red' size='+1'>$park_code</font></form></th>";
		}

	if(empty($rcc)){$rcc="";}
	if(empty($invoice_number)){$invoice_number="";}
	echo "<th colspan='3'><form>RCC: <input type='text' name='rcc' value='' onchange=\"this.form.submit()\" size='5'> <font color='red' size='+1'>$rcc</font></th>";
	
	echo "<th colspan='3'><form>Invoice Number: <input type='text' name='invoice_number' value='' onchange=\"this.form.submit()\" size='5'> <font color='red' size='+1'>$invoice_number</font></form></th>";

	echo "<th colspan=2' align='center'><A HREF=\"javascript:window.print()\">
	<IMG SRC=\"../inc/bar_icon_print_2.gif\" BORDER=\"0\"</A></th>
	<th>Excel <a href='invoices.php?rep=1'>export<a/></th>";

		
	echo "</tr></table>";
	if(empty($park_code) and $level<2){$park_code=$_SESSION['ware']['select'];}
	if(empty($park_code) and empty($rcc) and empty($invoice_number) and $level>2)
		{
		echo "Please select a Center Code from drop-down menu.";
		exit;
		}
	}

//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array("in_stock","id");
echo "<table border='1' cellpadding='5'>";
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
		if($fld=="link")
			{
			$temp="<a href='$value'>Invoice</a>";
			if($level>3)
				{
				$var_invoice=$array['invoice_number'];
				$temp.="&nbsp;&nbsp;&nbsp;<a href='del_invoice.php?inv_num=$var_invoice'  onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a>";
				}
			if(empty($rep)){$value=$temp;}
			}
		
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

echo "</table>";	
	
	
	
?>