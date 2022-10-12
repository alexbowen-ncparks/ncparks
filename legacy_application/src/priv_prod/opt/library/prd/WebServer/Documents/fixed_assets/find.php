<?php
if(@$_REQUEST['rep']=="")
	{include("menu.php");}
	else
	{header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=fixed_assets.xls');
	}

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
 
 if($_POST)
 	{
 	if($_POST['ncas_number_2']){$_POST['ncas_number']=$_POST['ncas_number_2'];}
 	
 	if(!is_numeric($_POST['ncas_number']))
		{
			$_POST['ncas_number']=$FA_desc_array_flipped[$_POST['ncas_number']];
		}
		
		$skip=array("rep","submit","ncas_number_2","ex");
 		foreach($_POST as $k=>$v)
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
 				$pass_query.=$k."=$v&";
 				@$clause.="t1.".$k.$oper1.$v.$oper2;
 			}
 			$clause=rtrim($clause," and ");
 			$pass_query=rtrim($pass_query,"&");
 			$pass_ncas_number=$_POST['ncas_number'];
 	}
 
echo "<div align='center'><table border='1' cellpadding='5'>";


$order_by="order by t1.ncas_number,t1.location";

$vehicle_array=array("534541","534549"); //"534539",
//"534541",  on-road vehicles
//"534543",  boat, boat motor
//"534549",  mowers, atv, utv  Other Motorized Vehicles
$t2="";
if(in_array(@$_REQUEST['ncas_number'],$vehicle_array) and $_REQUEST['location']!="")
	{
	// first check fuel.vehicle against fixed_assets.fixed_assests to look for
	// mismatches
	$ncas_number=$_REQUEST['ncas_number'];
	if($ncas_number=="534541")
		{
		$cc=$_REQUEST['location'];
		$sql="select t1.center_code, t1.vehicle_id, t1.vin, t1.FAS_num
		from fuel.vehicle as t1
		where 1 and t1.center_code='$cc' 
		order by t1.center_code,t1.vehicle_id"; //echo "$sql<br />";
		}
/*	if($ncas_number=="534549")
		{
		$table1="atv";
		$table2="utv";
		$fld1=" t1.atv_id, t3.utv_id";
		$JOIN="LEFT JOIN fuel.$table2 as t2 on t1.center_code=t2.center_code ";
		$JOIN.="LEFT JOIN fixed_assets.fixed_assets as t3 on t1.serial_number=t3.serial_number";
		$order_by="order by t1.center_code,t1.atv_id, t2.utv_id";
		}
*/	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql<br />".mysqli_error($connection));
	
	if(mysqli_num_rows($result)>0)
		{
		while ($row=mysqli_fetch_assoc($result))
			{
			$ARRAY_vehicle[$row['vehicle_id']]=$row;
			}
		}
//		echo "<pre>"; print_r($ARRAY_vehicle); echo "</pre>";

	$t2=",t2.vehicle_id,t3.atv_id,t4.utv_id";
					$join="LEFT JOIN fuel.vehicle as t2 on t1.serial_number=t2.vin and t1.serial_number!=''";
					$join.=" LEFT JOIN fuel.atv as t3 on t1.serial_number=t3.serial_number and t1.serial_number!=''";
					$join.=" LEFT JOIN fuel.utv as t4 on t1.serial_number=t4.serial_number and t1.serial_number!=''";
	}

		
if($_SERVER['QUERY_STRING'])
		{
		$skip=array("rep","ex");
		$exp1=explode("&",$_SERVER['QUERY_STRING']);
		$pass_query=@$_SERVER['argv'][0];
		foreach($exp1 as $k=>$v)
			{
				$exp2=explode("=",$v);
				if(in_array($exp2[0],$skip)){continue;}
				if($exp2[0]=="sort"){$sort=$exp2[1];continue;}
				if($exp2[0]=="ncas_number"){$pass_ncas_number=$exp2[1];}
				if($exp2[0]=="asset_description")
 					{
 					$new_clause.=$exp2[0]." like '%".$exp2[1]."%' and ";}
 					else
 					{
					@$new_clause.=$exp2[0]."='".$exp2[1]."' and ";}
			}
			$clause=rtrim($new_clause," and ");
			$clause=urldecode($clause);
			$order_by="order by $sort";
		}
	
	if(!$clause){exit;}

/*	
if($level<3 and @$_REQUEST['ex']=="")
	{
	$getCenter=$_SESSION['fixed_assets']['center'];
//	$clause.=" and left(t1.center,8)='$getCenter'";
	}
*/
if(!isset($join)){$join="";}
if(!isset($t2)){$t2="";}
$sql="select t1.* $t2
from fixed_assets.inventory_2012 as t1
$join
where 1 and $clause
$order_by"; //echo "$sql<br />";

$total_fld=array("cost");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

if(mysqli_num_rows($result)<1)
		{
			$ncas_number=$_REQUEST['ncas_number'];
			echo "No items for $ncas_number were found.";exit;
		}

while ($row=mysqli_fetch_assoc($result))
	{
		$ARRAY[]=$row;
	}

$var=@$FA_desc_array[$pass_ncas_number];
$count_flds=count($ARRAY[0])-2;
$count_records=count($ARRAY);

if($_REQUEST['rep']=="")
	{
	echo "<tr><th colspan='$count_flds'><font color='brown'>$var = $count_records</font></th><th colspan='2'>Excel <a href='find.php?$pass_query&rep=1&sort=asset_num'>export</a></th></tr>";
	echo "<tr>";
	}
	
foreach($ARRAY[0] as $k=>$v)
		{	
			@$i++;
			if($k=="cost"){$pass_col_num=$i;}
			$k1=str_replace("_"," ",$k);
			if($_GET['rep']=="")
				{$k1="<a href='find.php?$pass_query&sort=$k'>$k1</a>";}
			echo "<th>$k1</th>";
		}
	echo "</tr>";
	
$link_array=array("vehicle_id","atv_id","utv_id","water_id");

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
foreach($ARRAY as $num=>$value_array)
		{
			echo "<tr>";
			foreach($value_array as $k=>$v)
				{
				if($k=="vehicle_id")
					{
					if(!empty($v))
						{$fixed_vehicle[]=$v;}
						else
						{$fixed_vehicle[]=$value_array['serial_number'];}
					if(!array_key_exists($v,$ARRAY_vehicle))
						{
						if(empty($v))
							{
							$v1=$value_array['serial_number'];
							}
						$check_vehicle[$v]=$v1;
						}
					}
				if(in_array($k,$total_fld))
					{
						${"tot_".$k}+=$v;
					}
				if($v==NULL){$v="<font color='red'>Not entered</font>";}
				ELSE
				{IF(in_array($k,$link_array))
					{
					$num_char=STRLEN($k); $num_char=$num_char-3;
					$new_table=substr($k,0,$num_char);
					if($k=="vehicle_id"){$new_table="inventory";}
					$v="<a href='/fuel/menu.php?search=Find&form_type=$new_table&$k=$v' target='_blank'>$v</a>";
					}
				}
				
				echo "<td>$v</td>";
				}
			echo "</tr>";
		}
		@$tot_cost=number_format($tot_cost,2);
	if(!isset($pass_col_num)){$pass_col_num="";}
	echo "<tr><th colspan='$pass_col_num' align='right'>$tot_cost</th></tr>";
	echo "</table>";

//echo "<pre>"; print_r($check_vehicle); echo "</pre>";	
//echo "<pre>"; print_r($fixed_vehicle); echo "</pre>";		
if(!empty($ARRAY_vehicle))
	{
	echo "<table border='1'><tr><td colspan='4'>Vehicles listed in the Fixed Assets Database that are NOT associated with $cc in the Fuel/Inventory Database.</td></tr>";
	foreach($check_vehicle as $k=>$v)
		{
		if(empty($v)){$v="Vehicle probably surplused. Needs to be removed from Fixed Assets.";}
		echo "<tr><td>$k</td><td>SN/VIN $v</td></tr>";
		}
		
	echo "</table><br />";
	echo "<table><tr><td colspan='4'>Vehicles listed in the Fuel/Inventory Database that are NOT associated with $cc in the Fixed Assets Database.</td></tr>";
//	sort($fixed_vehicle);
	foreach($ARRAY_vehicle as $index=>$array)
		{
		if(!in_array($index,$fixed_vehicle))
			{
			$fas="00".$ARRAY_vehicle[$index]['FAS_num']."00";
			$v="<a href='find.php?ex=1&asset_number=$fas&sort=location' target='_blank'>$index</a> ";
			$fn=$ARRAY_vehicle[$index]['FAS_num'];
			echo "<tr><td>$v</td><td>FAS Num = $fn</td></tr>";
			}
	
		}	
	echo "</table>";
//echo "<pre>"; print_r($ARRAY_vehicle); echo "</pre>";
	}
?>