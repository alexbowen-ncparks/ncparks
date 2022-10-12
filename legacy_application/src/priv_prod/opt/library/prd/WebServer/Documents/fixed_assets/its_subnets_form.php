<?php
if(!EMPTY($_REQUEST['rep']))
	{
	
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
	}
$sql="SHOW COLUMNS from its_subnets"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}

$c=0;

// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}

// UPDATE
if(!empty($_POST) AND @$_POST['update']=="Update")
	{
   	$skip_update=array("update","id");
   	$id=$_POST['id'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
// 		$val=mysqli_real_escape_string($connection, $val);
		$val=html_entity_decode(htmlspecialchars_decode($val));
		@$clause.=$fld."='".$val."', ";
		}
	$clause=rtrim($clause, ", ");
	$sql="update its_subnets set $clause 
	where id='$id'"; //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	unset($_POST);
	$_POST['submit']="Search";
	$_POST['id']="$id";
	}

// SEARCH **************************************
   	$like=array("current_service_provider","subnet_mask","gateway","ending_ip_of_range","park_code");
   	
if((!empty($_POST) AND $_POST['submit']=="Search") OR @$_POST['pass_submit']=="Find" OR @$_REQUEST['rep']==1)
	{
	$database="fixed_assets";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection, $database)
	   or die ("Couldn't select database $database");
   	
   	$skip=array("submit","op","park_code_1","current_service_type_1","sort","direction","pass_submit","pass_query");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	$op=@$_POST['op'];
	if(!empty($_POST['park_code_1']))
		{
		$_POST['park_code']=$_POST['park_code_1'];
		}
	if(!empty($_POST['current_service_type_1']))
		{
		$_POST['current_service_type']=$_POST['current_service_type_1'];
		}
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
		if($val=="blank_current_service_type")
			{
			$clause.="current_service_type = '' $op ";
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
	$sql="select * from its_subnets where 1 $clause $order_by"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	

if(!empty($_REQUEST['rep']))
	{
	$filename="dpr_it_subnets_".date("Y-m-d").".xls";
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=$filename");
	}	

$size_array=array("id"=>"2","county_office"=>"18","current_service_type"=>"12","current_service_provider"=>"12","make"=>"5","site_id"=>"5","park_code"=>"8");
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
	echo "<form method='POST' action='its_subnets.php'><tr>";
	foreach($COLS[0] AS $fld=>$val)
		{  // search fields
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
		//$val
		echo "$th<input type='text' name='$fld' value='' size='$size'></th>";
		}

		echo "<tr><td colspan='2'>$c items</td>
		<td colspan='6' align='center'>";
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
//		echo "<td colspan='1'><input type='submit' name='submit' value='ADD'></td>";
		echo "<td colspan='3'>Excel <a href=\"its_form.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	

	 // Headers
	$rename=array();

	if(empty($sort_fld_array)){$sort_fld_array=array();}
	if(empty($skip)){$skip=array();}
	echo "<tr>";
	foreach($COLS[0] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
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


	
	if(!empty($_GET['id']))
		{
		$id=@$_GET['id'];
		$readonly=array("id");
		$sql="select * from its_subnets where id='$id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		echo "<form method='POST' action='its_subnets.php'>";
		echo "<tr>";
		foreach($row as $fld=>$val)
			{
			if(array_key_exists($fld, $size_array))
				{$size=$size_array[$fld];}
				else
				{$size='12';}
			if(in_array($fld, $readonly)){$ro="readonly";}else{$ro="";}
			if($fld=="entered_service"){$elem_id="datepicker1";}else{$elem_id=$fld;}
			
			if($fld=="county_office")
				{
				echo "<td><select name='$fld'><option value=\"\"></option>\n";
				foreach($county_office_array as $k=>$v)
					{
					if($val==$v){$s="selected";}else{$s="";}
					echo "<option value='$v' $s>$v</options>\n";
					}
				echo "</td></select>";
				continue;
				}
			if($fld=="park_code")
				{
				echo "<td><select name='$fld'><option value=\"\"></option>\n";
				foreach($park_array as $k=>$v)
					{
					if($val==$v){$s="selected";}else{$s="";}
					echo "<option value='$v' $s>$v</options>\n";
					}
				echo "</td></select>";
				continue;
				}
			if($fld=="current_service_type")
				{
				echo "<td><select name='$fld'><option value=\"\"></option>\n";
				foreach($current_service_type_array as $k=>$v)
					{
					if($val==$v){$s="selected";}else{$s="";}
					echo "<option value='$v' $s>$v</options>\n";
					}
				echo "</td></select>";
				continue;
				}
			echo "<td><input id=\"$elem_id\" type='text' name='$fld' value=\"$val\" size='$size' $ro></td>";
			}
		echo "</tr>";
		echo "<tr><td colspan='11' align='center'><input type='submit' name='update' value='Update'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Delete'></td></tr>";
		echo "</form>";
		}
	}
	else
	{
	echo "<tr>";
	foreach($COLS[0] AS $fld=>$val)
		{  
		echo "<th>$fld</th>";
		}
	echo "</tr>";
	}
	
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="id" and empty($_REQUEST['rep']))
				{
				$value="<a href='its_subnets.php?id=$value'>[&nbsp;$value&nbsp;]</a>";
				}
			if($fld=="park_code" and empty($_REQUEST['rep']))
				{
		//		$dpr_value="DPR".substr($value,0,4);
		//		$value="<a href='find_inventory.php?location=$dpr_value' target='_blank'>$value</a>";
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	}
echo "</table>";
?>