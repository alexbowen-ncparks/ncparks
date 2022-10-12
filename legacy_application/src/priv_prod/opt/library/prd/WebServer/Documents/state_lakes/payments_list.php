<?php
$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

extract($_REQUEST);

$tab="Reports";
if(@$rep=="")
	{
	include("menu.php");
	}
	else
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=cash_receipts.xls');
	session_start();
	$rcc=$_SESSION['state_lakes']['rcc'];
	}

//session_start();
$level=$_SESSION['state_lakes']['level'];
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;


if($park==""){echo "You must select a park.";exit;}

if(@$unpaid=="x")
	{
	$pass_query="&unpaid=x&park=$park";
	}
	else
	{
	$pass_query="&start_date=$start_date&end_date=$end_date&park=$park";
	}
	
if($park=="WHLA" OR $park=="BATR")
	{
	$clause="and (t1.park='WHLA' OR t1.park='BATR')";
	}
	ELSE
	{
	$clause="and t1.park='$park'";
	}

if($end_date=="")
	{
	$end_date=$start_date;
	$date_range="for $start_date";
	}
	else
	{
	$date_range="from $start_date to $end_date";
	}

$default_fields="t1.park,
t1.entity,
t1.id,
t1.billing_title,
t1.billing_last_name,
t1.billing_first_name,";


include("payments_pier.php");
include("payments_buoy.php");
include("payments_ramp.php");
include("payments_seawall.php");
include("payments_swim_line.php");

$num_pay=count($ARRAY);
if($num_pay<1){echo "No payments found $date_range $clause.";exit;}

foreach($HEADERS as $k=>$v)
{
	foreach($v as $i=>$var_field)
		{
		$headers[$var_field]=$i;
		}
}
$h1=array_keys($headers);

foreach ($ARRAY as $key => $row) {
    $id[$key]  = $row['id'];
}
array_multisort($id, SORT_ASC, $ARRAY);

//echo "<pre>"; print_r($h1); print_r($id); print_r($ARRAY);echo "</pre>";  exit;

$fee_array=array("pier_fee","buoy_fee","mod_fee_amt","transfer_fee","ramp_fee","swim_line_fee","buoy_app_fee","seawall_fee");

if(@$show_journal=="")
	{
	if(@$unpaid=="x")
		{
		$phrase="Owner/Agents with outstanding fees for this Fiscal Year";
		}
		else
		{
		$phrase="Payments received <font color='red'>$date_range</font>";
		}
	
	$skip=array("pier_payment","buoy_receipt","mod_pay_date","ramp_receipt","app_date","swim_line_receipt","trans_pay_date");
	
	echo "<table border='1' cellpadding='2'><tr><th colspan='19'>$num_pay $phrase $clause</th></tr><tr>";
		foreach($h1 as $i=>$fld)
			{
			if(in_array($fld,$skip)){continue;}
			$fld=str_replace("_"," ",$fld);
			echo "<th>$fld</th>";
			}
		echo "<th>Total</th></tr>";
	//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;	
		foreach($ARRAY as $num=>$array)
		{
			echo "<tr>";
			foreach($h1 as $k=>$v)
					{
					if(in_array($v,$skip)){continue;}
					if(@$array[$v]!="")
						{
						//$td
						echo "<td>$array[$v]</td>";
						if(in_array($v,$fee_array))
							{
							@$subtotal+=$array[$v];
							@$total+=$array[$v];
							}
						}
					else 
						{
						//$td
						echo "<td></td>";
						}
					}
					
			echo "<td align='right'>$total</td></tr>";
			if($ARRAY[$num]['id']!=@$ARRAY[$num+1]['id'])
				{
				echo "<tr bgcolor='aliceblue'><th colspan='19' align='right'>$subtotal</th></tr>";
				unset($subtotal);}
			@$grand_total+=$total;
			unset($total);
		}
		$gt=number_format($grand_total,2);
	echo "<tr><td colspan='19' align='right'><b>$gt</b></td></tr>";
	
	$journal="<a href='payments_list.php?show_journal=1&pass_query=$pass_query'>Journal</a>";
	
	echo "<tr><td colspan='19' align='right'>$journal <a href='payments_received.php?pass_query=$pass_query&rep=x'>Excel</a></td></tr>";
	
	//echo "<tr><td colspan='19' align='right'>Late Fee Letter(s) <a href='http://149.168.1.196/state_lakes/print_letters_unpaid.php?pass_query=$pass_query'>PDF</a> (For now this is presently limited to 20 letters while we are testing this function.)</td></tr>";
		
	echo "</table></body></html>";
	}
else
	{
	
	$columns=array("CHECK<br />NO.","PAYOR/VENDOR<br />NAME","AMOUNT","Description");
	$skip=array("pier_payment","buoy_receipt","mod_pay_date","ramp_receipt","app_date","swim_line_receipt","trans_pay_date","entity","id","num_buoys");
	
if(@$rep=="x")
	{
	@$gt=$grand_total;
	if($level<5)
		{include("cash_journal_sheet_1.php");}
		else
		{include("cash_journal_sheet_2.php");}
	
	echo "<table border='1' cellpadding='2'>";
	}
	else
	{
	if(!isset($phrase)){$phrase="";}
	echo "<table border='1' cellpadding='2'><tr><th colspan='4'>$num_pay $phrase $clause</th></tr><tr>";
	}
		foreach($columns as $i=>$fld)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
	//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;	
		foreach($ARRAY as $num=>$array)
		{
			foreach($h1 as $k=>$v)
					{
					if(in_array($v,$skip)){continue;}
					if(@$array[$v]!="")
						{
						if(in_array($v,$fee_array))
							{
							@$desc.="[".$v."] ";
							@$subtotal+=$array[$v];
							@$total+=$array[$v];
							}
						}
					
					}
					
			if($ARRAY[$num]['id']!=@$ARRAY[$num+1]['id'])
				{
				if($ARRAY[$num]['billing_title'])
					{
					$name=$ARRAY[$num]['billing_title'];
					}
				else
					{
					$name=$ARRAY[$num]['billing_last_name'].", ".$ARRAY[$num]['billing_first_name'];
					}
					
				@$check_number=$ARRAY[$num]['check_number'];
				if(!empty($ARRAY[$num]['pier_mod_check']))
					{$check_number=$ARRAY[$num]['pier_mod_check'];}
				if(!empty($ARRAY[$num]['trans_check']))
					{$check_number=$ARRAY[$num]['trans_check'];}
					
				echo "<tr>
				<td>$check_number</td>
				<td>$name</td>
				<th align='right'>$subtotal</th>
				<td>$desc</td>
				</tr>";
				unset($subtotal);
				unset($desc);
				}
			@$grand_total+=$total;
			unset($total);
		}
		$gt=number_format($grand_total,2);
	echo "</table><table>
	<tr><td></td><td></td><td align='LEFT'>$</td><td>DETAIL TOTAL DEBITS</td></tr>
	<tr><td></td><td></td><td align='LEFT'>$&nbsp;&nbsp;<b>$gt</b></td><td>DETAIL TOTAL CREDITS</td></tr></table><table>";
if(@$rep=="")
		{
			echo "<tr><td colspan='19' align='right'><a href='payments_list.php?show_journal=1&pass_gt=$grand_total&pass_query=$pass_query&rep=x'>Excel</a></td></tr>";
		}		
	echo "</table></body></html>";
	}
?>