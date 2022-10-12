<?php
$database="dpr_overview";
include("../../include/iConnect.inc");


mysqli_select_db($connection,$database);

if(!empty($fac_class) and empty($pass_park_code))
	{
	include("../_base_top.php");
	$sql="SELECT fac_type, visitor_fac 
	from fac_class 
	where 1 and fac_class='$fac_class'
	order by fac_type";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[$row['fac_type']]=$row['visitor_fac'];
		}
// 	echo "Close this tab when done.";
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	}

if(!empty($pass_park_code))
	{
	include("get_fac_type.php");
	
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
// 	echo "<pre>"; print_r($array_type); echo "</pre>";  //exit;
	$skip=array("park_code");
	$ck_park="";

	$park_array=array($pass_park_code);
	
	mysqli_select_db($connection,"facilities");
	foreach($park_array as $index=>$park_code)
		{
		foreach($array_type as $k=>$v)
			{
			if(in_array($v, $skip)){continue;}
			$target=$v;
			$ARRAY[$target]=array();
			$ARRAY_fac_type=$ARRAY[$target];

			$sql="SELECT count(*) as number
			from spo_dpr where 1 and park_abbr='$park_code' and (".$array_clause[$target].")";
	// 		echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$row=mysqli_fetch_assoc($result);
				{
				$ARRAY_fac_type[$park_code]=$row;
				}
			if($ARRAY_fac_type[$park_code]['number']>0)
				{

				$display_array[$park_code][$target][]="<b>$park_code $target</b>";
				foreach($ARRAY_fac_type as $park_code=>$array)
					{
					foreach($array as $fld=>$value)
						{
						if(in_array($fld,$skip)){continue;}
						@$array_total[$target][$fld]+=$value;
						$display_array[$park_code][$target][]="$fld = $value";
						}
					}
			$ck_park=$park_code;
				}
			}
		}
// echo "<pre>"; print_r($array_total); echo "</pre>";  //exit;
		$skip=array();
$ARRAY=$array_total;
$exp=explode("`fac_type`=",$array_clause[$pass_type]);
// echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
$clause="";
foreach($exp as $k=>$v)
	{
	if(empty($v)){continue;}
	$clause.=str_replace(" OR ","",$v)." ";
	}
		echo "<table><tr><td>Includes these structure types: $clause</td></tr>";
		foreach($ARRAY AS $index=>$array)
			{		
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				echo "<td>$index</td><td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
	}
?>
