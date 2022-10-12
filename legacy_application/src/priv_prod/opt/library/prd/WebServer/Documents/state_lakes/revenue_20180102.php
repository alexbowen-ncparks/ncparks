<?php
$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

$tab="Revenue Summary";
include("menu.php");
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


$sql="SELECT distinct year from piers"; ////echo "$sql";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
		$year_array[]=$row['year'];
		}
		
if(!isset($object)){$object="";}
if(!isset($year)){$year="";}

$JOIN_1="";

if($object=="buoy_fee" OR $object=="all")
	{
	$table="buoy";
	$key_field="buoy_fee";
	$fields="year, park, buoy_id,check_number, buoy_receipt, sum(fee) as $key_field";
	$where1="and (buoy_receipt!='' OR check_number!='')";
	$group_by="buoy_id";
	$total_name="Buoy";
	$form="buoy.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects[$table]=$row[$key_field];
			}
		}
	}

if($object=="ramp_fee" OR $object=="all")
	{
	$table="ramp";
	$key_field="ramp_fee";
	$fields="year, park, ramp_id,check_number, ramp_receipt, sum(fee) as $key_field";
	$where1="and (ramp_receipt!='' OR check_number!='')";
	$group_by="ramp_id";
	$total_name="Ramp";
	$form="ramp.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects[$table]=$row[$key_field];
			}
		}
	}

if($object=="pier_mod_fee" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_mod_fee";
	$fields="year, park, pier_number, pier_id, mod_pay_date, pier_mod_check, sum(mod_fee_amt) as $key_field";
	$where1="and (mod_pay_date!='' OR pier_mod_check!='')";
	$group_by="pier_id";
	$total_name="Pier Modification";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects[$table]=$row[$key_field];
			}
		}
	}
	
if($object=="pier_fee_50" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id,pier_payment, pier_mod_check, sum(fee) as $key_field";
	$where1="and (fee>1 and fee<16) and (check_number!='' OR pier_payment!='')";
	$group_by="pier_id";
	$total_name="Pier Fee";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['pier_50']=$row[$key_field];
			}
		}
	}
if($object=="pier_fee_51" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id, pier_payment, pier_mod_check, sum(fee) as $key_field";
	$where1="and (fee>29 and fee<31) and (check_number!='' OR pier_payment!='')";
	$group_by="pier_id";
	$total_name="Pier Fee";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['pier_51']=$row[$key_field];
			}
		}
	}
if($object=="pier_fee_101" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id, pier_payment, pier_mod_check, sum(fee) as $key_field";
	$where1="and (fee>44 and fee<46) and (check_number!='' OR pier_payment!='')";
	$group_by="pier_id";
	$total_name="Pier Fee";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['pier_101']=$row[$key_field];
			}
		}
	}
if($object=="pier_fee_151" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id, pier_payment, pier_mod_check, sum(fee) as $key_field";
	$where1="and (fee>59 and fee<61) and (check_number!='' OR pier_payment!='')";
	$group_by="pier_id";
	$total_name="Pier Fee";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['pier_151']=$row[$key_field];
			}
		}
	}
if($object=="commercial_fee_225" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id, pier_payment, check_number,pier_length, sum(fee) as $key_field";
	$where1="and (fee<76) and (check_number!='' OR pier_payment!='') and pier_type='c'";
	$group_by="pier_id";
	$total_name="Commercial Pier";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['commercial_225']=$row[$key_field];
			}
		}
	}
if($object=="commercial_fee_226" OR $object=="all")
	{
	$table="piers";
	$key_field="pier_fee";
	$fields="year, park, pier_number, pier_id, pier_payment, check_number,pier_length, sum(fee) as $key_field";
	$where1="and (fee>75) and pier_type='c' and (check_number!='' OR pier_payment!='')";
	$group_by="pier_id";
	$total_name="Commercial Pier";
	$form="piers.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['commercial_226']=$row[$key_field];
			}
		}
	}
if($object=="commercial_ramp" OR $object=="all")
	{
	$table="contacts as t1";
	$JOIN_1="LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$year')";
	$key_field="ramp_fee";
	$fields="year, t4.park, pier_number, ramp_id, check_number, ramp_receipt, sum(fee) as $key_field";
	$where1="and t1.entity='c' and (check_number!='' OR ramp_receipt!='')";
	$where1.=" and (t4.ramp_id is not NULL)";
	$group_by="ramp_id";
	$total_name="Commercial Ramp";
	$form="ramp.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		$JOIN_1
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['commercial_ramp']=$row[$key_field];
			}
		}
	}
if($object=="commercial_buoy" OR $object=="all")
	{
	$table="contacts as t1";
	$JOIN_1="LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$year') ";
	$key_field="buoy_fee";
	$fields="year, t5.park, pier_number, buoy_id, check_number, buoy_receipt, sum(fee) as $key_field";
	$where1="and t1.entity='c' and (check_number!='' OR buoy_receipt!='')";
	$where1.=" and (t5.buoy_id is not NULL)";
	$group_by="buoy_id";
	$total_name="Commercial Buoy";
	$form="buoy.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		$JOIN_1
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['commercial_buoy']=$row[$key_field];
			}
		}
	}
if($object=="swim_line" OR $object=="all")
	{
	$table="contacts as t1";
	$JOIN_1="LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$year')";
	$key_field="swim_line_fee";
	$fields="year, t6.park, swim_line_id, check_number, swim_line_receipt, sum(fee) as $key_field";
//	$where1="and t1.entity='c'";
$where1="";
	$where1.=" and (t6.swim_line_id is not NULL)";
	$group_by="swim_line_id";
	$total_name="Swim Line";
	$form="swim_line.php";
	if($object=="all")
		{
		$sql="SELECT $fields
		FROM $table
		$JOIN_1
		where year='$year' $where1
		group by year
		"; //echo "$sql";
		 $result = @MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result))
			{
			$all_objects['swim_line']=$row[$key_field];
			}
		}
	}
echo "<div align='center'>";


if($object=="all")
	{
	echo "<table align='center' border='1'><tr>";
	foreach($all_objects as $k=>$v)
		{
		if($k=="pier_151"){echo "</tr><tr>";}
		@$tot+=$v; $v=number_format($v,0);
		echo "<td>$k = <b>$$v</b></td>";
		}
		$tot=number_format($tot,0);
	echo "<td align='right'><b>$$tot</b></td></tr></table>";
	}

echo "<table align='center' border='1' cellpadding='3'><tr>
<td><form action='revenue.php'>
<select name='year' onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<option selected=''>Select a Year</option>";
foreach($year_array as $k=>$v)
	{
	if($year==$v){$s="selected";}else{$s="value";}
	echo "<option $s='revenue.php?year=$v'>$v</option>";
	}
	
echo "</select></form>";
if($year)
	{
	echo "<form action='revenue.php'>
	<input type='hidden' name='object' value='all'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Total Revenue for Year'>
	</form>";
	}
echo "</td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=buoy_fee'>Buoy Fee</a></td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=ramp_fee'>Ramp Fee</a></td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=pier_mod_fee'>Pier Modification Fee</a></td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=pier_fee_50'>Annual Pier Fee <51</a> feet</td>
</tr>
<tr>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=pier_fee_51'>Annual Pier Fee >50</a> feet</td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=pier_fee_101'>Annual Pier Fee >100</a> feet</td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=pier_fee_151'>Annual Pier Fee >150</a> feet</td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=commercial_fee_225'>Commercial Pier Fee <226</a> feet</td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=commercial_fee_226'>Commercial Pier Fee >225</a> feet</td>
</tr>
<tr>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=commercial_ramp'>Commercial Ramp Fee</a></td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=commercial_buoy'>Commercial Buoy Fee</a></td>
<td valign='top' align='center'><a href='revenue.php?year=$year&object=swim_line'>Swim Line Fee</a></td>
</tr></table>";
if($object=="" OR $object=="all"){exit;}

	$sql="SELECT $fields
	FROM $table
	
	where year='$year' $where1
	group by $group_by
	order by park,$group_by";  //echo "$sql";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=@mysql_fetch_assoc($result))
		{
		$allFields[]=$row;
		}
	@$num=count($allFields);
	
	if($num<1){echo "No $table payments were found for $year."; exit;}
	
	$var=explode(",",$fields);
	$col=count($var);
	echo "<table border='1'><tr><td colspan='$col' align='center'>$num $total_name payments for $year</td></tr>";
	
	echo "<tr>";
	foreach($allFields[0] as $key=>$value)
		{
		$key=str_replace("_"," ",$key);
		echo "<th>$key</th>";
		}
		echo "</tr>";
		
		foreach($allFields as $num=>$array)
			{
				echo "<tr>";
				foreach($array as $key=>$value)
					{
					$td="";
					if($key==$key_field)
						{
						@$total+=$value;
						}
					
					if($key==$group_by)
						{
						$value="<form action='$form' method='POST' target='_blank'>
						<input type='hidden' name='$group_by' value='$value'>
						<input type='submit' name='submit' value='Find $value'></form>";
						}
					echo "<td$td>$value</td>";
					}
				echo "</tr>";			
			}
			$col=$col-1;
echo "<tr><td colspan='$col' align='right'>$total_name Fees:</td><td>$total</td></tr>";
echo "</table></div></body></html>";
?>