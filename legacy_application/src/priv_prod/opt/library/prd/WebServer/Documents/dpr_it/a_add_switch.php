<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";

include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql="SELECT * FROM switch_ports"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	$port_array[$row['id']]=$row['port_name'];
	}
// echo "<pre>"; print_r($port_array); echo "</pre>"; // exit;
	
// $alt_value_array=array("vlan","gateway");
$alt_value_array=array();
if($select_table=="switches")
	{
	$alt_value_array=array("location","make","model","os","site_id","host_name");
	$date_field_array=array("date_deployed");
	}

if(!empty($submit_form))
	{
// echo "I'm working on adding the ability to track port assignments.<pre>"; print_r($_POST); echo "</pre>";  exit;
	session_start();
	include("../../include/get_parkcodes_reg.php");
	mysqli_select_db($connection,$dbName);
	
	if(!empty($_POST['alt_location']))
		{
		$_POST['location']=strtoupper($_POST['alt_location']);
		$location=$_POST['location'];
		}
		
	IF(in_array($location, $adm_region))
		{$_POST['region_section']="DPR ADM";}
		ELSE
		{$_POST['region_section']=$region[$location];}
	
	$skip=array("submit_form", "select_table");
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		if(in_array($fld,$alt_value_array))
			{
			$alt_fld="alt_".$fld;
			if(!empty($_POST[$alt_fld]))
				{
				$value=strtoupper($_POST[$alt_fld]);
				$temp[]="`$fld`='".$value."'";
				$skip[]=$alt_fld;
				continue;
				}
				else
				{
				$skip[]=$alt_fld;
				}		
			}
// 		
// 		if($fld=="vlan" and substr($_POST[$fld],0,4)=="VLAN")
// 			{
// 			$value=substr($_POST[$fld],0, -5);
// 			$temp[]="`$fld`='".$value."'";
// 			continue;
// 			}
			
		$temp[]="`".$fld."`='".$value."'";
	
		}
	$clause=implode(", ",$temp);

	$sql="INSERT INTO $select_table set $clause"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if($result)
		{
		$location=$_POST['location'];
		header("Location: search_form.php?select_table=$select_table&location=$location&submit_form=add");
		exit;
		}
	}

include("_base_top.php");


echo "<style>
.head {
padding: 5px;
font-size: 22px;
color: #999900;
}

td
{
padding: 3px;
}
 tr.d0 td {
  background-color: #ddddbb;
  color: black;
}
.table {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}

table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
table.alternate tr:nth-child(even) td{
background-color: #eeeedd;
}

.search_box {
    border: 1px solid #8e8e6e;
	background-color:#f2e6ff;
	border-collapse:collapse;
  color: black;
}
.table_uno {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#e0ebeb;
	border-collapse:collapse;
  color: black;
}

</style>";

$sql = "SHOW COLUMNS FROM $select_table";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$search_fields[]=$row['Field'];
	}
// echo "<pre>"; print_r($search_fields); echo "</pre>";  //exit;

$search_computers_dropdown=array("region_section","location","type","os","make","model");
$search_subnets_dropdown=array( "location", "site_name", "type", "current_service_provider");
$search_switches_dropdown=array("make", "model","location","os","site_id","host_name");
include("form_arrays.php");

$skip=array("id", "district_section", "region_section");
// $port_array=array("vlan1", "vlan2", "vlan3", "vlan4", "vlan5", "vlan6", "vlan6");

echo "<form method='POST' action='add_switch.php'>";
echo "<table><tr><td><h3><font color='#8cd9b3'>Add to the DPR Inventory of $select_table</h3></td></tr>";
foreach($search_fields as $index=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	$value="";
	if($fld=="division"){$value="DPR";}
// 	if($fld=="network_view"){$value="Internal";}
	$line="<tr><td><strong>$fld</strong></td>
		<td><input type='text' name='$fld' value=\"$value\"></td></tr>";
	if(in_array($fld, $search_array))  // search_array created in form_arrays.php
		{
		$drop_down_array=${"ARRAY_".$fld};
		$line="<td><strong>$fld</strong></td><td><select name='$fld'><option value=\"\" selected></option>\n";
		foreach($drop_down_array as $k=>$v)
			{
			$line.="<option value='$v'>$v</option>\n";
			}
		$line.="</select>";
		
		if(in_array($fld, $alt_value_array))
			{
			$name="alt_".$fld;
			$line.=" add if not in drop-down==><input type='text' name='$name' value=\"\">";
			}
		
		echo "</td></tr>";
		}
	if($fld=="ports")
		{
		$line="<tr><td><strong>$fld</strong></td><td>Configure Ports after adding switch.</td></tr>";
		}
	if(in_array($fld, $date_field_array))
		{
		$line="<tr><td><strong>$fld</strong></td>
	<td><input id=\"datepicker1\" type=\"text\" name='$fld' value=\"$value\"></td></tr>";
			}
			
	echo "$line";

	}
	
echo "<tr><td colspan='2' align='center'><input type='hidden' name='select_table' value=\"$select_table\">";
echo "<input type='submit' name='submit_form' value=\"Add\">";
echo "</td></tr></table>";
echo "</form>";

?>
