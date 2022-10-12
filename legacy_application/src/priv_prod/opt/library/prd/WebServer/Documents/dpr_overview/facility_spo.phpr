<?php

// echo "hello"; exit;
// ini_set('display_errors',1);

$database="dpr_overview";
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);
// $sql="SELECT * from infra_structure where 1 ";
$sql="SELECT * from infra_structure_class where 1 ";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);
	{
	$ARRAY[]=$row;
	}

include("../_base_top.php");

$skip=array("id");
$c=count($ARRAY);
echo "<table><tr><td>Infrastructure Relationships</td></tr>";
foreach($ARRAY AS $index=>$array)
	{	
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(!empty($value))
			{$array_type[]=$fld;}
		$exp=explode(",",$value);
		$temp=array();
		foreach($exp as $k=>$v)
			{
			if(empty($v)){continue;}
			$temp[]="$v";
			}
		$clause=implode(" OR ",$temp);
		$array_clause[$fld]=$clause;
		echo "<tr><td>$fld</td><td>$clause</td></tr>";
		}
	}
echo "</table>";	

// echo "<pre>"; print_r($array_clause); echo "</pre>";  exit;

mysqli_select_db($connection,"facilities");

$park_array=array("CABE", "CACR", "CHRO");
foreach($park_array as $index=>$park_code)
	{
		echo "<table border='1'><tr><td><strong>$park_code</strong></td><td>Number</td><td>Area</td></tr>";
	foreach($array_clause as $k=>$v)
		{
		if(empty($v)){continue;}
		$target=$v;

		$sql="SELECT t1.park_abbr, t1.fac_type, count(t1.fac_type) as num, sum(t1.area) as area 

			from facilities.spo_dpr as t1 

			left join dpr_overview.fac_class as t2 on t1.fac_type=t2.fac_type 
			
			where 1 and  t2.fac_class='$target' and t1.park_abbr='$park_code'

			group by t1.park_abbr, t1.fac_type

			order by t1.park_abbr";
// 		echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$ARRAY_fac_type=array();
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY_fac_type[$park_code][$target]['num'][]=$row['num'];
			$ARRAY_fac_type[$park_code][$target]['area'][]=$row['area'];
			}
		$num=array_sum($ARRAY_fac_type[$park_code][$target]['num']);
		$area=array_sum($ARRAY_fac_type[$park_code][$target]['area']);
// 		echo "<pre>"; print_r($ARRAY_fac_type[$park_code]); echo "</pre>"; // exit;
		foreach($ARRAY_fac_type[$park_code] as $fac_class=>$array)
			{
			$num=array_sum($array['num']);
			$area=number_format(array_sum($array['area']));
			echo "<tr><td>$fac_class</td><td>$num</td><td>$area</td></tr>";
			}
		}
		echo "</table>";
	}

?>