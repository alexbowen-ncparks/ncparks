<?php

$database="dpr_system";
include("../../include/iConnect.inc");

mysqli_select_db($connection,'divper');

$title="NC DPR Databases";

ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}

if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

if(empty($rep))
	{
	$database="divper";
	include("../_base_top.php");
	}


$sql="SELECT funding_source, position, left(position,4) as type
FROM divper.B0149 as t1
where 1
order by type, funding_source
";
// $sql="SELECT currPark, funding_source, position, left(position,4) as type
// FROM divper.B0149 as t1
// left join emplist as t2 on t1.position=t2.beacon_num
// where 1 and currPark is not NULL
// order by type, currPark, funding_source
// ";
$sql="SELECT park, funding_source, position, left(position,4) as type
FROM divper.B0149 as t1
left join position as t2 on t1.position=t2.beacon_num
where 1 and park is not NULL
order by type, funding_source
";
echo "$sql<br /><br />";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$BO149_division[$row['type']][$row['position']]=$row['funding_source'];
	}
// echo "<pre>"; print_r($BO149_division); echo "</pre>";  exit;
$temp_personnel_div=array();
$array_6003=array();
$array_6009=array();
$array_6502=array();
$array_6500=array();
$array_6501=array();
$array_66503=array();
foreach($BO149_division as $type=>$array)
	{
	$temp_personnel_div[$type]=array_count_values($array);
	}
	

// 	echo "<pre>"; print_r($temp_personnel_div); echo "</pre>";  exit;
	if(!empty($temp_personnel_div))
		{
		$tot_per=0;
		$temp="<table>";
		foreach($temp_personnel_div as $p_k=>$array)
			{
			extract($array);
			$val_p="";
			if($p_k==6003)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6009)
				{
				if(!empty($Appropriated))
					{
					$val_p="Temporary Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Temporary Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6500)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6501)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6502)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6503)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
				
			$temp.="<tr valign='top'><td>$p_k</td>
			<td>$val_p</td></tr>";
			}
		$temp.="</table>";
		}

$line="<tr><td colspan='2'><b><font color='green'>DPR Personnel</font></b> (db=divper.BO149) Total=$tot_per</td></tr><tr><td></td><td>$temp";
	$line.="</td>
	</tr></table>";
	echo "$line";

$fy_start="201906";
$fy_end="202007";
$fy="FY1920";

$sql = "SELECT sum(`admin_hours` + `camp_host_hours` + `trail_hours` + `ie_hours` + `main_hours` + `research_hours` + `res_man_hours` + `other_hours`) as vol_hours
FROM park_use.`vol_stats` 
where  `year_month`>='$fy_start' and `year_month`<'$fy_end'
";
echo "$sql"; //exit;

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	@$temp_vol_hours[$park_code]=$row['vol_hours'];
	}
echo "<pre>"; print_r($temp_vol_hours); echo "</pre>"; // exit;
?>