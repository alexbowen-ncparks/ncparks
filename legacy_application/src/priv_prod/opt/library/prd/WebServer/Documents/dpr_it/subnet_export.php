<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

// $sql="SELECT  `vlan` FROM `subnets` GROUP BY `vlan` ORDER BY `vlan` ";
// $result = mysqli_query($connection,$sql) or die("$sql Error 1#");
// while($row=mysqli_fetch_assoc($result))
// 	{
// 	$vlan_array[]=$row['vlan'];
// 	}
$array_vlan_1_gateway=array();
$array_vlan_150_HVAC_gateway=array();
$array_vlan_210_Employee_Wireless_gateway=array();
$array_vlan_410_Guest_Wifi_gateway=array();
$array_vlan_510_DIT_Mgmt_gateway=array();
$array_vlan_600_Public_Wired_gateway=array();
$array_vlan_unk_gateway=array();

$sql="select id,division,district_section,region_section,location, group_concat(site_name separator '***') as site_name,type,current_service_provider,site_id, vlan, group_concat(gateway separator '***') as gateway, subnet_mask, last_useable_ip
from subnets 
where 1 
group by location,vlan,subnet_mask, last_useable_ip
order by site_name,site_id, vlan";


$result = mysqli_query($connection,$sql) or die("$sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$location=$row['location'];
	$ARRAY[$id]=$row;
	}

$skip=array();
$c=count($ARRAY);

// get first site_id in ARRAY
foreach($ARRAY as $index=>$array)
		{
		$first=$index;
		break;
		}
$first_site_id=$ARRAY[$first]['location'];
$new_ARRAY[$first_site_id]=array();

foreach($ARRAY AS $index=>$array)
	{
	extract($array);
	if($vlan=="100 State Net"){$vlan="1 State Net";}
	$new_ARRAY[$location]['park_info']['park_code']=$location;
	$new_ARRAY[$location]['park_info']['site_name']=$site_name;
	$new_ARRAY[$location]['park_info']['site_id']=$site_id;
	$ARRAY_site_id[$site_id]=$site_id;
	$new_ARRAY[$location][$vlan]['gateway']=$gateway;
	$new_ARRAY[$location][$vlan]['subnet_mask']=$subnet_mask;
	$new_ARRAY[$location][$vlan]['last_useable_ip']=$last_useable_ip;
	}
	
$skip=array();
$ARRAY=$new_ARRAY;
$c=count($ARRAY);
$s=count($ARRAY_site_id);
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
// insert column headers
$field_array=array("vlan_1","150_HVAC","210_Employee_Wireless","410_Guest_Wifi","510_DIT_Mgmt","600_Public_Wired","?","PCI_for_CRS");
echo "<table border='1'><tr><td colspan='3'>$c Locations - $s Site IDs</td><td colspan='2'>Copy and Paste into Excel</td></tr>";
$i=0;
foreach($ARRAY AS $location=>$array1)
	{
	if($location==$first_site_id)
		{
		echo "<tr>";
		echo "<td>Location</td>";
		echo "<td>Site ID</td>";
		echo "<td>Location Name</td>";
		echo "<th>vlan1 or vlan100 gateway</th>";
		echo "<th>vlan1 or vlan100 subnet_mask</th>";
		echo "<th>vlan1 or vlan100 last useable IP</th>";
		echo "<th>150 HVAC gateway</th>";
		echo "<th>150 HVAC subnet_mask</th>";
		echo "<th>150 HVAC  last useable IP</th>";
		echo "<th>210 Employee Wireless gateway</th>";
		echo "<th>210 Employee Wireless subnet_mask</th>";
		echo "<th>210 Employee Wireless last useable IP</th>";
		echo "<th>410 Guest WiFi gateway</th>";
		echo "<th>410 Guest WiFi subnet_mask</th>";
		echo "<th>410 Guest WiFi last useable IP</th>";
		echo "<th>510 DIT Mgmt gateway</th>";
		echo "<th>510 DIT Mgmt subnet_mask</th>";
		echo "<th>510 DIT Mgmt last useable IP</th>";
		echo "<th>600 Public Wired gateway</th>";
		echo "<th>600 Public Wired subnet_mask</th>";
		echo "<th>600 Public Wired last useable IP</th>";
		echo "<th>PCI for CRS gateway</th>";
		echo "<th>PCI for CRS subnet_mask</th>";
		echo "<th>PCI for CRS last useable IP</th>";
		echo "<th>? gateway</th>";
		echo "<th>? subnet_mask</th>";
		echo "<th>? last useable IP</th>";
		echo "</tr>";
		}

		$i++;
	echo "<tr valign='top'>";
// 	echo "<pre>"; print_r($array1); echo "</pre>";  exit;
		extract($array1['park_info']);
		echo "<td>$park_code</td><td>$site_id</td><td>$site_name</td>";
		$gateway="";
		$subnet_mask="";
		$last_useable_ip="";
		
		$line="";
		$empty_values="<td>n/a</td><td>n/a</td><td>n/a</td>";
		if(!empty($array1['1 State Net']))
			{
			extract($array1['1 State Net']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['150 HVAC']))
			{
			extract($array1['150 HVAC']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['210 Employee Wireless']))
			{
			extract($array1['210 Employee Wireless']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['410 Guest Wifi']))
			{
			extract($array1['410 Guest Wifi']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['510 DIT Mgmt']))
			{
			extract($array1['510 DIT Mgmt']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['600 Public Wired']))
			{
			extract($array1['600 Public Wired']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['PCI (for CRS)']))
			{
			extract($array1['PCI (for CRS)']);
			$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";
			}
			else
			{$line.=$empty_values;}
		if(!empty($array1['?']))
			{
			extract($array1['?']);
			if(!empty($gateway))
				{$line.="<td>$gateway</td><td>$subnet_mask</td><td>$last_useable_ip</td>";}
				else
				{
				$line.="<td>?</td><td>?</td><td>?</td>";
				}
			}
			else
			{$line.=$empty_values;}
		echo "$line";
	echo "</tr>";
		
	}
echo "</table>";
?>