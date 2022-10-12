<?php
if(@$_REQUEST['rep']=="")
	{
	$file="update";
	include("inventory.php");
	}
	
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");

if(@$_POST['submit']=="Submit Update")
	{
	include("update.php");
	unset($_REQUEST);
	$_REQUEST['location']=$location;
	$_REQUEST['table']=$table;
	}
//echo "$sql"; exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
 
  if($_REQUEST)
	{
	$location=$_REQUEST['location'];
	$skip=array("rep","submit","sort","table","action");
	foreach($_REQUEST as $k=>$v)
		{
		if(!$v OR in_array($k,$skip)){continue;}
			$oper1="='";
			$oper2="' and ";
			if($k=="asset_description")
				{
				$oper1=" like '%";
				$oper2="%' and ";
				}
			if($k=="asset_number")
				{
				$oper1=" like '";
				$oper2="%' and ";
				$v="00".$v;
				}
			@$pass_query.=$k."=$v&";
			@$clause.="t1.".$k.$oper1.$v.$oper2;
		}
		$clause=rtrim($clause," and ");
		$pass_query=rtrim($pass_query,"&");
	}
 
$order_by="order by t1.location";
$new_clause="";

if($_SERVER['QUERY_STRING'])
		{
		$skip=array("rep","table","action");
		$exp1=explode("&",$_SERVER['QUERY_STRING']);
		$pass_query=$_SERVER['argv'][0];
		foreach($exp1 as $k=>$v)
			{
				$exp2=explode("=",$v);
				if(in_array($exp2[0],$skip)){continue;}
				if($exp2[0]=="sort"){$sort=$exp2[1];continue;}
				if($exp2[0]=="ncas_number"){$pass_ncas_number=$exp2[1];}
				if($exp2[0]=="asset_description")
 					{
 					$new_clause.=$exp2[0]." like '%".$exp2[1]."%' and ";
 					}
 					else
 					{
					$new_clause.=$exp2[0]."='".$exp2[1]."' and ";
					}
			}
			$clause=rtrim($new_clause," and ");
			$clause=urldecode($clause);
			if(!empty($sort))
				{
				$order_by="order by $sort";
				}
		}
	
	if(!$clause){exit;}
	
if($level==1)
	{
	$var=$_REQUEST['location'];
	$dpr_park="DPR".$_SESSION['fixed_assets']['select'];
	if(!empty($_SESSION['fixed_assets']['accessPark']))
		{
		$exp=explode(",",$_SESSION['fixed_assets']['accessPark']);
		foreach($exp as $k=>$v)
			{
			if($v=="WARE"){$v="WAHO";}
			$exp1[]="DPR".$v;}
		if(!in_array($var,$exp1))
			{		
			exit;
			}
		}
		else
		{
		if($dpr_park != $var)
			{
			exit;
			}
		}
	}
	
if(!isset($join)){$join="";}
if(!isset($t2)){$t2="";}
$sql="select t1.* $t2
from $table as t1
$join
where 1 and $clause
$order_by
"; //echo "$sql<br />";

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 93. $sql".mysqli_error($connection));

if(mysqli_num_rows($result)<1)
		{
			echo "No items for $ncas_number were found.";exit;
		}

while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$count_records=count($ARRAY);

//$sql="SELECT *
//FROM `dpr_codes` order by codes"; //missing DPRCACRB

$sql="SELECT dpr_codes as codes
FROM `all_codes` order by codes"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 2. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$code_array[]=$row['codes'];
	}


$sql="SELECT *
FROM `standard_description`"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 2. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$var_array=explode(" ",$row['a']);
	$desc_num=array_shift($var_array);
	$new_desc=implode(" ",$var_array);
	$desc_array[$desc_num]=$new_desc;
	}

$status_code_array=array("U","M","R","S");
	
echo "<div align='center'><table border='1' cellpadding='5'>";

if(@$_REQUEST['rep']=="")
	{
	if(!isset($count_flds)){$count_flds="";}
	echo "<tr><th colspan='2'><font color='brown'>$count_records items</font></th></tr>";
	echo "<tr>";
	}

echo "<form method='POST' action='update_inventory.php' name='assetForm'>";
	
foreach($ARRAY[0] as $k=>$v)
	{
	@$i++;
	if($k=="cost"){$pass_col_num=$i;}
	$k1=str_replace("_"," ",$k);
	@$header.="<th>$k1</th>";
	if(@$rep=="")
		{
		if(!empty($pass_query)){$k1="<a href='update_inventory.php?$pass_query&sort=$k'>$k1</a>";}
		else
		{$k1="<a href='update_inventory.php?sort=$k'>$k1</a>";}
		}
	if($k=="corrected_status_code")
		{
		$k1.="<br />U=>In Use, M=>Missing, R=>Retire, 2nd year missing, S=>Surplus, copy of SSP document required";
		}
	echo "<th>$k1</th>";
	}
	echo "</tr>";
	

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
foreach($ARRAY as $num=>$value_array)
	{
	if($num!=0 AND fmod($num,15)==0){echo "<tr>$header</tr>";}
	echo "<tr>";
	foreach($value_array as $k=>$v)
		{
		$v=str_replace("\"","",$v);
		$input=$v;
		$id=$value_array['id'];
		if($k=="corrected_location")
			{
			$name=$k."[$id]";
			$input="<select name='$name'><option selected=''></option>\n";
			foreach($code_array as $k1=>$v1)
				{
				$s="value";
				if($value_array['corrected_location']==$v1)
					{$s="selected";}else{$s="value";}
				$input.="<option $s='$v1'>$v1</option>\n";
				}
			$input.="</select>";
			}
			
		if($k=="corrected_asset_description")
			{
			$value=$value_array['corrected_asset_description'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\">";
			}
		
		if($k=="corrected_object_code")
			{
			$value=$value_array['corrected_object_code'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\">";
			}
			
		if($k=="corrected_standard_description")
			{
			$value=$value_array['standard_description'];
			
			$arr_value=explode(" ",$value);
			$name=$k.$id;  
			//$name=$k."[$id]"; // unable to use because of pick_desc.php
			// also see line 14 $csd_fld="corrected_standard_description".$id; of update.php
			if(in_array($value,$desc_array))
				{
				$array_key=array_search($value,$desc_array);
				if($v==$value)
					{$value=$array_key." ".$value;}
					else
					$value=$v;				
				}
				else
				{
				if(substr($value,0,5)>"00001")
					{$value=$v;}
					else
					{$value="";}					
				}
			$input="<input type='button' value='Find' onclick=\"openChild('pick_desc.php?name=$name&alpha=$arr_value[0]')\"><br /><input type='text' name='$name' value=\"$value\">";
			}
		
		if($k=="corrected_make")
			{
			$value=$value_array['corrected_make'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\">";
			}
		
		if($k=="corrected_budget_code")
			{
			/*
			$value=$value_array['budget_code'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"\" size='7'>";
			*/
			}
		
		if($k=="corrected_cntr_code")
			{
			/*
			$value=$value_array['center'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"\" size='8'>";
			*/
			}
		
		if($k=="corrected_serial_number")
			{
			$value=$value_array['corrected_serial_number'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\" size='18'>";
			}
		
		if($k=="corrected_status_code")
			{
			$name=$k."[$id]";
			$input="<select name='$name'><option selected=''></option>\n";
			foreach($status_code_array as $k1=>$v1)
				{
				$s="value";
				if($value_array['corrected_status_code']==$v1)
					{
					$s="selected";
					}
					else
					{
					$s="value";
					}
				if($value_array['status_code']==$value_array['corrected_status_code'])
					{
					$s="value";
					}
				$input.="<option $s='$v1'>$v1</option>\n";
				}
			$input.="</select>";
			}
		if($k=="corrected_model")
			{
			$value=$value_array['corrected_model'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\" size='10'>";
			}
		if($k=="person_responsible_taking_inventory")
			{
			$value=$value_array['person_responsible_taking_inventory'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\" size='10'>";
			}
		if($k=="comments")
			{
			$value=$value_array['comments'];
			$value=str_replace("\"","",$value);
			$name=$k."[$id]";
			$input="<input type='text' name='$name' value=\"$value\" size='10'>";
			}
		echo "<td>$input</td>";
		}
	echo "</tr>";
	}
	echo "<tr><td colspan='9' align='right'>
	<input type='hidden' name='location' value='$location'>
	<input type='hidden' name='table' value='$table'>
	<input type='submit' name='submit' value='Submit Update'>
	</td></tr>";
	echo "</table></form>";

?>