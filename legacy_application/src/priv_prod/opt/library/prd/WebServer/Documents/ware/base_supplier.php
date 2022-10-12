<?php
//if(!EMPTY($_REQUEST['rep']))
//	{
	$database="ware";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");
//	}
	

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

// DELETE
if(!empty($_POST) AND @$_POST['submit']=="Delete")
	{
   	$product_number=$_POST['product_number'];
	$sql="DELETE FROM base_supplier 
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
   	$skip_update=array("update","supplier_id");
   	$supplier_id=$_POST['supplier_id'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		@$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="update base_supplier set $clause 
	where supplier_id='$supplier_id'"; 
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['supplier_id']="$supplier_id";
	}

// SEARCH **************************************
   	$like=array("supplier_name","supplier_comments");
   	
if((!empty($_POST) AND $_POST['submit']=="Search") OR @$_POST['pass_submit']=="Find" OR @$_REQUEST['rep']==1)
	{
   	$skip=array("submit","op","location_1","os_1","sort","direction","pass_submit","pass_query");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
		
		if(!empty($val))
			{
			if(in_array($fld, $like))
				{$clause.=$fld." like '%".$val."%' $op ";}
				else
				{$clause.=$fld."='".$val."' $op ";}			
			}
		}
	$clause=rtrim($clause, " $op ");
	if(!empty($clause)){$clause="and ".$clause;}
	
	if(!empty($_POST['sort']) or @$_REQUEST['rep']==1)
		{
		$clause=$_REQUEST['pass_query'];
		$sort_fld=@$_POST['submit'];
		$direction=@$_POST['direction'];
		if(empty($sort_fld))
			{
			$sort_fld="supplier_name";
			$direction="";
			}
		$order_by="order by $sort_fld $direction";
		}
		else
		{
		$order_by="";
		}
		
	// ************* Query ************
		
	$sql="select t1.* 
	from base_supplier as t1
	where 1 $clause $order_by"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$new_flds=array_keys($row);
		}
	$COLS=$new_flds;
	//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	

if(!empty($_REQUEST['rep']))
	{
	$filename="warehouse_inventory_".date("Y-m-d").".xls";
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$filename");
	}
	else
	{
	$title="Warehouse Inventory";
	include("../_base_top.php");
	
	echo "<title>NC DPR Warehouse Inventory</title><body>";
	}

$size_array=array("supplier_id"=>"3","see_also"=>"5");
echo "<table border='1' cellpadding='3'>";

if(!empty($_POST['pass_query']))
		{
		$temp=str_replace(" and ","*", $_POST['pass_query']);
		$temp=str_replace("and ","", $temp);
		$temp=str_replace(" or ","", $temp);
		$temp=str_replace(" like ","=", $temp);
//		echo "<br /><br />t=$temp";
		$skip_explode=array("os");
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

if(empty($_REQUEST['rep']))
	{
	if(empty($COLS))
		{
		$join_2="";
		$flds_2="";
		$sql="select t1.* $flds_2
		from base_supplier as t1
		$join_2
		where 1 limit 1"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		if(mysqli_num_rows($result)<1)
			{
			$sql="SHOW COLUMNS from base_supplier";// echo "$sql";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
			while ($row=mysqli_fetch_assoc($result))
				{
				$COLS[]=$row['Field'];
				}
				//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
			}
			else
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$new_flds=array_keys($row);
				}
			$COLS=$new_flds;
			}
		}
		
	echo "<form method='POST' action='base_supplier.php'><tr>";
	foreach($COLS AS $index=>$fld)
		{  // search fields
	//	echo "f=$fld<br />";
		if(array_key_exists($fld, $size_array))
			{$size=$size_array[$fld];}
			else
			{$size='12';}
		$val=@$_POST[$fld];
		if(empty($val))
			{
			$val=@$query_val[$fld];
			$val=str_replace("%","",$val);
			}
	
			$th="<th>";
			if(in_array($fld,$like)){$th="<th bgcolor='lightgreen'>";}
			if($fld=="supplier_id"){$val="";}
		echo "$th<input type='text' name='$fld' value='$val' size='$size'></th>";
		}

		echo "<tr><td colspan='3'>DPR Warehouse Inventory Suppliers ";
		if(!empty($c))
			{echo "<font color='brown'>$c shown</font>";}
			
		echo "</td>
		<td colspan='5' align='center'>";
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
		
		echo "<input type='radio' name='op' value='and' $cka>AND
		<input type='radio' name='op' value='OR' $cko>OR
		<input type='submit' name='submit' value='Search'>
		<input type='submit' name='reset' value='Reset'></td>
		";
		@$excel_query=urlencode($clause);
	//	echo "<td colspan='1'><a href='add_it.php'>Add</a></td>";
		echo "<td colspan='8'>Excel <a href=\"its_form.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	

	 // Headers
	$rename=array();

	if(empty($sort_fld_array)){$sort_fld_array=array();}
	if(empty($skip)){$skip=array();}
	echo "<tr>";
	foreach($COLS as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(!empty($rep) and in_array($fld,$skip_excel)){continue;}
		$pass_sort=$fld;
		if(array_key_exists($fld,$rename)){$fld=$rename[$fld];}
		if(!in_array($pass_sort,$sort_fld_array))
			{
			if(empty($rep) and !empty($_POST))
				{
				$temp="\n<form method='POST'>";
				if(!empty($pass_criteria))
					{
					foreach($pass_criteria as $k=>$v)
						{
						if(is_array($v))
							{
							foreach($v as $k1=>$v1)
								{
								$name=$k."[]";
								$temp.="<input type='hidden' name='$name' value=\"$v1\">";
								}
							}
							else
							{$temp.="<input type='hidden' name='$k' value=\"$v\">";}
				
						}
					}
				if(empty($direction) OR $direction=="DESC")
					{
					$direct="ASC";
					$tab_color="#407340";
					}
					else
					{
					$direct="DESC";
					$tab_color="#007A99";
					}
				if(!isset($clause)){$clause="";}
				$temp.="<input type='hidden' name='sort' value='$pass_sort'>
				<input type='hidden' name='direction' value='$direct'>
				<input type='hidden' name='pass_query' value=\"$clause\">
				<input type='hidden' name='pass_submit' value='Find'>
				<input type='submit' name='submit' value='$fld' style=\"background:$tab_color; color: #FFFFFF;\">
				</form>\n";
				$fld=$temp;
				}
				else
				{
				// excel export 
				}
			}
		echo "<th bgcolor='beige' align='center'>$fld</th>";
		}
	echo "</tr>";


	
	if(!empty($_GET['supplier_id']))
		{
$size_array=array("supplier_id"=>"3","supplier_name"=>"80", "supplier_add_1"=>"50","supplier_add_2"=>"50" ,"supplier_website"=>"80", "supplier_city"=>"50", "supplier_state"=>"3");
		
		$link_flds=array("product_link_1","product_link_2","material_safety_data_sheets");
		$supplier_id=@$_GET['supplier_id'];
		$readonly=array("supplier_id");
		$sql="select * from base_supplier where supplier_id='$supplier_id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		echo "<form method='POST' action='base_supplier.php'>";
		echo "</table><table>";
		foreach($row as $fld=>$val)
			{
			$var_fld=str_replace("supplier_","",$fld);
			if(in_array($fld, $link_flds) and !empty($val))
				{
				$var_fld="<a href='$val' target='_blank'>$fld</a>";
				}
			echo "<tr><td><b>$var_fld</b></td>";
			if($fld=="supplier_comments")
				{
				echo "<td><textarea name='$fld' cols='80' rows='3'>$val</textarea></td>";
				continue;
				}
				
			if(array_key_exists($fld, $size_array))
				{$size=$size_array[$fld];}
				else
				{$size='12';}
			if(in_array($fld, $readonly)){$ro="readonly";}else{$ro="";}
			if($fld=="entered_service"){$elem_id="datepicker1";}else{$elem_id=$fld;}
			echo "<td><input id=\"$elem_id\" type='text' name='$fld' value=\"$val\" size='$size' $ro></td>";
		echo "</tr>";
			}
		echo "<tr><td colspan='14' align='center'><input type='submit' name='update' value='Update'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Delete' onclick=\"return confirm('Are you sure you want to delete this Item?')\"></td></tr>";
		echo "</form>";
		}
	}
	else
	{
	echo "<tr>";
	foreach($COLS[0] AS $fld=>$val)
		{ 
		if(in_array($fld,$skip_these)){continue;}
		echo "<th>$fld</th>";
		}
	echo "</tr>";
	}

	$skip_these=array("subnet_park_code","subnet_id");	
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip_these)){continue;}
			
			if($fld=="supplier_id" and empty($_REQUEST['rep']))
				{
				$supplier_id=$array['supplier_id'];
				$value="<a href='base_supplier.php?supplier_id=$supplier_id'>[ $value ]</a>";
				}
			if($fld=="supplier_website")
				{
				if(!empty($value))
					{$value="<a href='$value' target='_blank'>website</a>";}
				}
			if($fld=="material_safety_data_sheets")
				{
				if(!empty($value))
					{
					$value="<a href='$value' target='_blank'>MSDS</a>";
					}
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	}
echo "</table>";
?>