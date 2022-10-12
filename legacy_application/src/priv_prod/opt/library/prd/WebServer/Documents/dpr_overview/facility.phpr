<?php

// echo "hello"; exit;
// ini_set('display_errors',1);

$database="dpr_overview";
include("../../include/iConnect.inc");

$fac_class="Building";
include("get_fac_class.php");

mysqli_select_db($connection,"dpr_system");

// $park_array=array("CABE", "CACR", "CHRO");
$sql="SELECT parkcode
	from dprunit_region where 1 and staffed_park='Yes'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['parkcode'];
		}
			
mysqli_select_db($connection,"facilities");

$skip=array("park_abbr","park_code");
$ck_park="";
$target="structures";
// echo "<pre>"; print_r($array_type); echo "</pre>"; // exit;

foreach($ARRAY as $k=>$v)
	{
	$temp[]="`fac_type`='$k'";
	}
$clause=implode(" OR ",$temp);
// echo "$clause"; exit;
foreach($park_array as $index=>$park_code)
	{
		$sql="SELECT fac_type, count(fac_type) as number, park_abbr
		from spo_dpr 
		where 1 and status='active' and park_abbr='$park_code' and (".$clause.")
		group by fac_type";
// 		echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			if($row['number']<1){continue;}
			$fac_type=ucfirst(strtolower($row['fac_type']));
			$ARRAY_park_fac_type[$park_code][$fac_type]=$row['number'];
			@$ARRAY_fac_type[$fac_type]+=$row['number'];
// 			$display_array[$park_code][$target][]="<b>$park_code $target</b>";
			
			}
// 		if($ARRAY_fac_type[$park_code]['number']>0)
// 			{
// // 			if($ck_park!=$park_code and $index>0)
// // 				{$display_array[$park_code][$target][]="-------";}
// 			$display_array[$park_code][$target][]="<b>$park_code $target</b>";
// 			foreach($ARRAY_fac_type as $park_code=>$array)
// 				{
// 				foreach($array as $fld=>$value)
// 					{
// 					if(in_array($fld,$skip)){continue;}
// 					@$array_total[0][$target][$fld]+=$value;
// 					$display_array[$park_code][$target][]="$fld = $value";
// 					}
// 				}
// 		$ck_park=$park_code;
// 			}
		
	}
ksort($ARRAY_fac_type);
$fac_type_sum=array_sum($ARRAY_fac_type);
// echo "$fac_type_sum<pre>"; print_r($ARRAY_fac_type); echo "</pre>";  exit;
// echo "<pre>"; print_r($ARRAY_park_fac_type); echo "</pre>";  exit;
$ARRAY=$ARRAY_fac_type;
$skip=array();
$c=count($ARRAY);
echo "<table border='1'><tr><td colspan='7' bgcolor='#ecffb3'>Totals for all State Parks - $fac_type_sum Structures</td></tr></table>";
echo "<a onclick=\"toggleDisplay('fac_type');\" href=\"javascript:void('')\">Show/Hide specifics.</a>
<div id=\"fac_type\" style=\"display: none\">
<table>";

foreach($ARRAY AS $fac_type=>$number)
	{
	echo "<tr bgcolor='#f2ffcc'>";
	echo "<td>$fac_type</td><td>$number</td>";
	echo "</tr>";
	}
echo "</table>";
echo "</div>";

echo "<hr /><table border='1'><tr><td colspan='3' bgcolor='#ecffb3'>Totals for each State Park</td></tr></table>";

// echo "<pre>"; print_r($ARRAY_park_fac_type); echo "</pre>"; // exit;

foreach($ARRAY_park_fac_type as $park_code=>$array)
	{
	$num=array_sum($array);
	echo "<table><tr bgcolor='#ecffb3'><td>$park_code</td><td>$num";
	echo "<a onclick=\"toggleDisplay('$park_code');\" href=\"javascript:void('')\"> &plusmn;</a></td></tr></table>
<div id=\"$park_code\" style=\"display: none\">
<table border='1'>";
	foreach($array as $fac_type=>$number)
		{
		echo "<tr><td>&nbsp;&nbsp;&nbsp;$fac_type</td><td>$number</td></tr>";
		}
echo "</table>
</div>";
	}
echo "</body></html>";
?>