<?php
	
$sql="SHOW COLUMNS from purchase"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}
$sql="SELECT * from purchase order by purchase_id desc limit 1"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$limit=1;
	}


$like=array("product_title","product_description","comments");

	$sql="select distinct vendor from purchase where 1 and vendor!='' order by vendor";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$vendor_array[]=$row['vendor'];
		}
	$sql="select distinct ware_product_title from purchase where 1 and ware_product_title!='' order by ware_product_title";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$ware_product_title_array[]=$row['ware_product_title'];
		}
		
$t1_flds="t1.`purchase_id`, t1.`purchase_date`, t1.`purchase_number`, t1.`purchase_by`, t1.`receive_date`, t1.`receive_by`, t1.`vendor`, t1.`ware_product_title`, t1.`supplier_id`, t1.`ware_product_number`, t1.`vendor_product_price`, t1.`order_quantity`, t1.`receive_quantity`, t1.`line_amount_ordered`, t1.`line_amount_received`, t1.`receipt_complete`, t1.`purchase_comments`";


$like=array("purchase_number","purchase_by","receive_by","purchase_comments");

// get fiscal year using file from budget
include("../budget/~f_year.php");
//	echo "p=$f_year $pf_year";

// SEARCH **************************************
if((!empty($_POST) AND $_POST['submit']=="Search") )
	{
   	$skip=array("submit","op","sort","direction","pass_submit","pass_query","status","pass_f_year");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	$op=@$_POST['op'];
	$clause.="t1.fiscal_year='".$_POST['pass_f_year']."' and ";
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
// 		$val=mysqli_real_escape_string($connection,$val);
		if(!empty($val))
			{
			if(in_array($fld, $like))
				{$clause.="t1.".$fld." like '%".$val."%' $op ";}
				else
				{$clause.="t1.".$fld."='".$val."' $op ";}			
			}
		}
	$clause=rtrim($clause, " $op ");
	if(!empty($clause)){$clause="and ".$clause;}
	if(!empty($_POST['status']))
		{
		if($_POST['status']=="receive"){$clause.=" and receive_date!='0000-00-00'";}
		if($_POST['status']=="not_receive"){$clause.=" and receive_date='0000-00-00'";}
		}
	if(!empty($_POST['sort']) or @$_REQUEST['rep']==1)
		{
		$clause=$_REQUEST['pass_query'];
		$sort_fld=@$_POST['submit'];
		$direction=@$_POST['direction'];
		if(empty($sort_fld))
			{
			$sort_fld="product_number";
			$direction="";
			}
		if($sort_fld=="user_name")
			{
			$sort_fld="substring_index(user_name,' ',-1)";
			}
		$order_by="order by $sort_fld $direction";
		}
		else
		{
		$order_by="order by purchase_id desc";
		}
		
	// ************* Query ************
	$sql="select $t1_flds
	from purchase as t1
	where 1 $clause $order_by"; 
//	echo "$sql<br /><br />c=$clause<br />";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	unset($ARRAY);
	
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$new_flds=array_keys($row);
		}
	
if(empty($ARRAY)){echo "No records found using $clause"; exit;}

	$COLS=$new_flds;
	//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	
 mysqli_free_result($result);

$c=count($ARRAY);

echo "<form method='POST' action='purchase.php'><tr>";
echo "<table><tr><td colspan='3'>Fiscal Year: <select name='pass_f_year'>\n
<option value=\"$f_year\">$f_year</option>\n
<option value=\"$pf_year\">$pf_year</option>\n
</select></td></tr></table>";

echo "<table border='1' cellpadding='3' align='center'><tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		foreach($array as $fld=>$val)
			{
			if($fld=="fiscal_year")
				{continue;}
			$size=12;
			$fld_name=$fld;
			$th="<th>";
			if(in_array($fld,$like)){$th="<th bgcolor='lightgreen'>";}
			if($fld=="purchase_id")
				{
				$val="";
				$fld_name="id";
				$size=4;
				}
			
		if($fld=="vendor")
			{
			echo "<th>$fld_name<select name='$fld'><option value=\"\"' selected></option>\n";
			foreach($vendor_array as $k=>$v)
				{
				$v=htmlspecialchars($v);
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="ware_product_title")
			{
			echo "<th>$fld_name<select name='$fld'><option value=\"\"' selected></option>\n";
			foreach($ware_product_title_array as $k=>$v)
				{
				$v=htmlspecialchars($v);
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="purchase_date")
			{
			echo "<th>$fld_name<input id='datepicker1' type='text' name='$fld' value=\"\" size='$size'></th>";
			continue;
			}
		if($fld=="receive_date")
			{
			echo "<th>$fld_name<input id='datepicker2' type='text' name='$fld' value=\"\" size='$size'></th>";
			continue;
			}

		$val=@$_POST[$fld];
		if(empty($val))
			{
			$val=@$query_val[$fld];
			$val=str_replace("%","",$val);
			}
	
		echo "$th $fld_name<input type='text' name='$fld' value=\"\" size='$size'></th>";
		}
		
		echo "</tr><tr><td colspan='3'>DPR Warehouse Purchases: ";
	if(!empty($c))
		{
		$items="items";
		if($c==1){$items="item";}
		if($limit==1 and empty($_POST)){$items="most recent item";}
		echo "<font color='brown'>$c $items</font>";
		}
			
		echo "</td>
		<td colspan='5'>";
		if(@$op=="and" or empty($op))
			{$cka="checked";$cko="";}
			else
			{$cka="";$cko="checked";}
			if(!empty($_POST['pass_query']))
				{
				if(strpos($_POST['pass_query'],"OR")>0)
					{$cka="";$cko="checked";}
					else
					{$cka="checked";$cko="";}
				}
		
	//	echo "<input type='radio' name='op' value='and' $cka>AND
	//	<input type='radio' name='op' value='OR' $cko>OR";
	if(empty($clause)){$clause="";}
	$clause=str_replace("t1.","",$clause);
	$clause=str_replace("%","",$clause);
	echo "<input type='radio' name='status' value='receive'>Received";
	echo "<input type='radio' name='status' value='not_receive'>Not Received";
		echo "<input type='hidden' name='op' value='and'>";
		echo " &nbsp;<input type='submit' name='submit' value='Search'> $clause </td>
		";
		@$excel_query=urlencode($clause);
	
	//	echo "<td colspan='8'>Excel <a href=\"view_purchase_form.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	
		
		}
		
		
// Display results
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="fiscal_year")
			{continue;}
		if($fld=="purchase_id")
			{$value="<a href='purchase.php?purchase_id=$value&submit=Edit Purchase'>[&nbsp;$value&nbsp;]</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";
?>