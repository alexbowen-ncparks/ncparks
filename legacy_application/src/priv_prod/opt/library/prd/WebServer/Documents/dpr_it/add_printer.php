<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";

include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

if(!empty($submit_form))
	{
	session_start();
	include("../../include/get_parkcodes_dist.php");
	mysqli_select_db($connection,$dbName);

	IF(in_array($location, $adm_region))
		{$_POST['district_section']="DPR ADM";}
		ELSE
		{
		$var=substr($location,0,4);
		$_POST['district_section']=$district[$var];
		}
	
	$skip=array("submit_form", "select_table", "alt_printer", "alt_site_id", "alt_location");
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
// 		if(empty($value)){continue;}
		
		if($fld=="printer" and !empty($_POST['alt_printer']))
			{
			$value=$_POST['alt_printer'];
			$temp[]="`printer`='".$value."'";
			continue;
			}
			
		if($fld=="site_id" and !empty($_POST['alt_site_id']))
			{
			$value=$_POST['alt_site_id'];
			$temp[]="`site_id`='".$value."'";
			continue;
			}
			
		if($fld=="location" and !empty($_POST['alt_location']))
			{
			$value=$_POST['alt_location'];
			$temp[]="`location`='".$value."'";
			continue;
			}
			
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
.ui-datepicker {
  font-size: 80%;
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
$search_printers_dropdown=array("site_id","printer", "location","printer_status");
include("form_arrays.php");

include("ARRAY_computer_status_rename.php");

$skip=array("id", "district_section", "region_section");
$alt_value_array=array("make","printer","site_id","location");
echo "<form method='POST' action='add_printer.php'>";
echo "<table><tr><td><h3><font color='#8cd9b3'>Add to the DPR Inventory of $select_table</h3></td></tr>";
foreach($search_fields as $index=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	$value="";
	if($fld=="name"){$value="DPR Printer";}
	if($fld=="network_view"){$value="Internal";}
	if($fld=="match_option"){$value="MAC_ADDRESS";}
	if($fld=="header_fixedaddress"){$value="fixedaddress";}
	$line="<tr><td><strong>$fld</strong></td>
		<td><input type='text' name='$fld' value=\"$value\"></td></tr>";
	if(in_array($fld, $search_array))  // search_array created in form_arrays.php
		{
		$drop_down_array=${"ARRAY_".$fld};
		$line="<td><strong>$fld</strong></td><td><select name='$fld'><option value=\"\" selected></option>\n";
		foreach($drop_down_array as $k=>$v)
			{
// 			$line.="<option value='$v'>$v</option>\n";

			if(empty($v)){continue;}
			$v1=$v;

			if($fld=="printer_status")
				{
					IF ($v1 == "surplus"
						OR $v1 == "surp_process"
						OR $v1 == "surp_tobe")
					{
						continue;
					}
				$v1=$ARRAY_printer_status_rename[$v];
				}
			$line.="<option value='$v'>$v1</option>\n";
			}
		$line.="</select>";
		
		if(in_array($fld, $alt_value_array))
			{
			$name="alt_".$fld;
			$line.=" add if not in drop-down==><input type='text' name='$name' value=\"\">";
			}
		
		echo "</td></tr>";
		}
	
		if($fld=="change_over_dates")
			{
			$line="<tr><td><strong>$fld</strong></td>
		<td><input id=\"datepicker1\" type='text' name='$fld' value=\"$value\"></td></tr>";
			}
	echo "$line";

	}
	
echo "<tr><td colspan='2' align='center'><input type='hidden' name='select_table' value=\"$select_table\">";
echo "<input type='submit' name='submit_form' value=\"Add\">";
echo "</td></tr></table>";
echo "</form>";

?>
