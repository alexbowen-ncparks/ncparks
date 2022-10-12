<?php
if(!EMPTY($_REQUEST['rep']))
	{
	$database="fixed_assets";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");
	}

/*	
$sql="SHOW COLUMNS from its_items"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[]=$row['Field'];
	@$col++;
	}

$c=0;
*/
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

// DELETE
if(!empty($_POST) AND @$_POST['submit']=="Delete")
	{
   	$id=$_POST['id'];
	$sql="DELETE FROM its_items 
	where id='$id'"; 
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['id']="$id";
	}

// SET Fields **************************************
$table_1=array("id", "type", "date_received", "make", "model", "sn_or_service_tag", "fas", "PO_num", "purchase_price", "item_comment");
$table_2=array("id", "district", "location", "user_name", "computer_name", "entered_service", "os", "site_id", "use_comment");
$table_3=array("id", "county_office", "current_service_type", "current_service_provider", "site_id", "park_code", "vlan", "gateway", "subnet_mask", "ending_ip_of_range", "subnet_comment");

$join_2="LEFT JOIN its_users as t2 on t1.id=t2.id ";
$join_3="LEFT JOIN its_subnets as t3 on t2.site_id=t3.site_id ";

// base = t1 = its_items flds
$flds_2="t2.district, t2.location, t2.site_id, t2.os, t2.computer_name, t2.user_name, ";
$flds_2_1=", t2.use_comment";  // t2.user_name,
$flds_3=", t3.subnet_mask, t3.id as subnet_id, t3.park_code as subnet_park_code";
			
$COLS=array("district", "location", "site_id", "os", "computer_name", "user_name", "id", "type", "date_received", "make", "model", "sn_or_service_tag", "fas", "PO_num", "purchase_price", "item_comment", "use_comment", "subnet_mask", "subnet_id", "subnet_park_code");
$c=0;


// UPDATE
if(!empty($_POST) AND @$_POST['update']=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
   	$skip_update=array("update","id");
   	$id=$_POST['id'];

// its_items
   	$clause="";
	foreach($_POST as $fld=>$val)  // update its_items
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		$val=html_entity_decode(htmlspecialchars_decode($val));
		if(in_array($fld,$table_1))
			{$clause.=$fld."='".$val."', ";}	
		}
		$clause=rtrim($clause, ", ");
		$sql="update its_items set $clause 
		where id='$id'"; 
	//	echo "$sql<br /><br />"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

// its_users
   	$clause="";
	foreach($_POST as $fld=>$val)  // update its_users
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		$val=html_entity_decode(htmlspecialchars_decode($val));
		if(in_array($fld,$table_2))
			{$clause.=$fld."='".$val."', ";}	
		}
		$clause=rtrim($clause, ", ");
		$sql="update its_users set $clause 
		where id='$id'"; 
	//	echo "$sql<br /><br />"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

// its_subnets updates are ignored here
   	
   	
	$sql="update fixed_assets.its_users as t1, dpr_system.parkcode_names as t2
	set t1.district=t2.district
	where t2.park_code=t1.location and t1.location not like 'adm%'"; 
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql="update fixed_assets.its_users as t1
	set t1.district='ADM'
	where t1.location like 'adm%'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql="update fixed_assets.its_users as t1
	set t1.district='WEDI'
	where t1.location = 'WEDO'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql="update fixed_assets.its_users as t1
	set t1.district='EADI'
	where t1.location = 'EADO'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql="update fixed_assets.its_users as t1
	set t1.district='SODI'
	where t1.location = 'SODO'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	$sql="update fixed_assets.its_users as t1
	set t1.district='NODI'
	where t1.location = 'NODO'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['id']="$id";
	}

// SEARCH **************************************
   	$like=array("user_name","make","model","sn_or_service_tag","entered_service","date_received");

	$sql="select distinct type from its_items where 1 and type!='' order by type";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$type_array[]=strtolower($row['type']);
		}
   	
	$sql="select distinct make from its_items where 1 and make!='' order by make";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$make_array[]=$row['make'];
		}
	$sql="select distinct district from its_users where 1 and district!='' order by district";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$district_array[]=$row['district'];
		}


if((!empty($_POST) AND $_POST['submit']=="Search") OR @$_POST['pass_submit']=="Find" OR @$_REQUEST['rep']==1)
	{
	$database="fixed_assets";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");
   	
   	$skip=array("submit","op","location_1","os_1","sort","direction","pass_submit","pass_query");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	$op=@$_POST['op'];
	if(!empty($_POST['location_1']))
		{
		$_POST['location']=$_POST['location_1'];
		}
	if(!empty($_POST['os_1']))
		{
		$_POST['os']=$_POST['os_1'];
		}
	
	$fld_table=array("site_id"=>"t2", "id"=>"t1");
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
		$val=html_entity_decode(htmlspecialchars_decode($val));
		if(array_key_exists($fld,$fld_table))
			{$fld=$fld_table[$fld].".".$fld;}
		if($val=="blank_os")
			{
			$clause.="os = '' $op ";
			continue;
			}
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
			$sort_fld="id";
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
		$order_by="";
		}
		
	// ************* Query ************
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		
	$sql="select $flds_2 t1.* $flds_2_1 $flds_3
	from its_items as t1
	$join_2
	$join_3
	where 1 $clause 
	group by t1.id
	$order_by"; 
//	echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		$message="<tr><td colspan='17'><font color='red'>No records found</font>: $clause</td></tr>";
		}
		else
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	

if(!empty($_REQUEST['rep']))
	{
	$filename="dpr_it_inventory_".date("Y-m-d").".xls";
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$filename");
	}	

$size_array=array("id"=>"3","make"=>"5","location"=>"5","os"=>"3","district"=>"5");
echo "<table border='1' cellpadding='3'>";
if(!empty($message))
	{echo "$message";}
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

//	$skip_these=array("subnet_park_code","subnet_id","subnet_mask");	
	$skip_these=array();	
if(empty($_REQUEST['rep']))
	{
//	echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	echo "<form method='POST' action='its_inventory.php'><tr>";
	foreach($COLS AS $index=>$fld)
		{  // search fields
		if(in_array($fld, $skip_these)){continue;}
		if($fld=="type")
			{
			echo "<th><select name='$fld'><option value=\"\"' selected></option>\n";
			foreach($type_array as $k=>$v)
				{
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="make")
			{
			echo "<th><select name='$fld'><option value=\"\"' selected></option>\n";
			foreach($make_array as $k=>$v)
				{
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="district")
			{
			echo "<th><select name='$fld'><option value=\"\"' selected></option>\n";
			foreach($district_array as $k=>$v)
				{
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
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
		//	if($fld=="id"){$val="";}
		//	$val
		echo "$th<input type='text' name='$fld' value='' size='$size'></th>";
		}

		echo "<tr><td colspan='2'>$c items</td>
		<td colspan='8' align='center'>";
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
		echo "<td colspan='1'><a href='add_it.php'>Add</a></td>";
		echo "<td colspan='3'>Excel <a href=\"its_form.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	

	 // Headers
	$rename=array();

	if(empty($sort_fld_array)){$sort_fld_array=array();}
	if(empty($skip)){$skip=array();}
	echo "<tr>";
	foreach($COLS as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(in_array($fld,$skip_these)){continue;}
		if(!empty($rep) and in_array($fld,$skip_excel)){continue;}
		$pass_sort=$fld;
		if(array_key_exists($fld,$rename)){$fld=$rename[$fld];}
		if(!in_array($pass_sort,$sort_fld_array))
			{
			if(empty($rep))
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
				if(@$direction=="ASC")
					{
					$direct="DESC";
					$tab_color="#407340";
					}
				if(@$direction=="DESC")
					{
					$direct="ASC";
					$tab_color="#007A99";
					}
				if(empty($direction))
					{
					$direct="DESC";
					$tab_color="#407340";
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


	
	if(!empty($_GET['id']))
		{
		$id=@$_GET['id'];
		$readonly=array("id");
	//	$sql="select * from its_items where id='$id'"; 
		$sql="select $flds_2 t1.* $flds_2_1 $flds_3
	from its_items as t1
	$join_2
	$join_3
	where t1.id='$id'
	group by t1.id";
	
//	echo "459 $sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		
	$readonly_these=array("subnet_park_code","subnet_id","subnet_mask");	
		echo "<form method='POST' action='its_inventory.php'>";
		echo "<tr>";
		foreach($row as $fld=>$val)
			{		
			if($fld=="type")
				{
				echo "<th><select name='$fld'><option value=\"\"' selected></option>\n";
				foreach($type_array as $k=>$v)
					{
					if(strtolower($val)==$v){$s="selected";}else{$s="";}
					echo "<option value=\"$v\" $s>$v</option>\n";
					}
			
				echo "</select></th>";
				continue;
				}
			
			if(array_key_exists($fld, $size_array))
				{$size=$size_array[$fld];}
				else
				{$size='12';}
			if(in_array($fld, $readonly_these)){$ro="readonly";}else{$ro="";}
			if($fld=="entered_service"){$elem_id="datepicker1";}else{$elem_id=$fld;}
			
			echo "<td><input id=\"$elem_id\" type='text' name='$fld' value=\"$val\" size='$size' $ro></td>";
			}
		echo "</tr>";
		echo "<tr><td colspan='14' align='center'><input type='submit' name='update' value='Update'>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='submit' name='submit' value='Delete' onclick=\"return confirm('Are you sure you want to delete this Item?')\"></td></tr>";
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

//	$skip_these=array("subnet_park_code","subnet_id","subnet_mask");	
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip_these)){continue;}
			
			if($fld=="id" and empty($_REQUEST['rep']))
				{
				$value="<a href='its_inventory.php?id=$value'>[&nbsp;$value&nbsp;]</a>";
				}
			if($fld=="site_id" and empty($_REQUEST['rep']))
				{
				$subnet_id=$array['subnet_id'];
				if(empty($subnet_id))
					{
					$value="No subnet for <b>$value</b>";
					}
					else
					{
					$value="Subnet for <form name='subnet' action='its_subnets.php' method='POST' target='_blank'>
					<input type='hidden' name='id' value='$subnet_id'>
					<input type='hidden' name='pass_submit' value='Find'>
					<input type='submit' name='submit' value='$value' style='background-color:yellow'><br />
					$array[subnet_park_code]
					</form>";
					}
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	}
echo "</table>";
?>