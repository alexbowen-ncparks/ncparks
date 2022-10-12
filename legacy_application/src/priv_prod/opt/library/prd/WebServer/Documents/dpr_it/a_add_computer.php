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
	include("../../include/get_parkcodes_reg.php");
	mysqli_select_db($connection,$dbName);

// 	echo "<pre>"; print_r($region); echo "</pre>"; // exit;
	IF(in_array($location, $adm_region))
		{$_POST['region_section']="DPR ADM";}
		ELSE
		{$_POST['region_section']=$region[$location];}
	
	$skip=array("submit_form", "select_table", "alt_make", "alt_model", "alt_os");
// 	echo "<pre>"; prints_r($_POST); echo "</pre>"; // exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
// 		if(empty($value)){continue;}
		
		if($fld=="make" and !empty($_POST['alt_make']))
			{
			$value=$_POST['alt_make'];
			$temp[]="`make`='".$value."'";
			continue;
			}
			
		if($fld=="model" and !empty($_POST['alt_model']))
			{
			$value=$_POST['alt_model'];
			$temp[]="`model`='".$value."'";
			continue;
			}
		if($fld=="os" and !empty($_POST['alt_os']))
			{
			$value=$_POST['alt_os'];
			$temp[]="`os`='".$value."'";
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
$search_printers_dropdown=array("site_id","printer", "location");
include("form_arrays.php");

$skip=array("id", "district_section", "region_section");
$alt_value_array=array("make","model","os");
echo "<form method='POST' action='add_computer.php'>";
echo "<table><tr><td><h3><font color='#8cd9b3'>Add to the DPR Inventory of $select_table</h3></td></tr>";
foreach($search_fields as $index=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	if($fld=="division"){$value="DPR";}else{$value="";}
	$line="<tr><td>$fld</td>
		<td><input type='text' name='$fld' value=\"$value\"></td></tr>";
	if(in_array($fld, $search_array))  // search_array created in form_arrays.php
		{
		$drop_down_array=${"ARRAY_".$fld};
		$line="<td>$fld</td><td><select name='$fld'><option value=\"\" selected></option>\n";
		foreach($drop_down_array as $k=>$v)
			{
			if(empty($v)){continue;}
			$line.="<option value='$v'>$v</option>\n";
			}
		if($fld=="location")
			{
			$line.="<option value='LOANER'>LOANER</option>\n";
			$line.="<option value='UNKN'>UNKN</option>\n";
// 			$line.="<option value='SURPLUS'>SURPLUS</option>\n";
			}
		$line.="</select>";
		
		if(in_array($fld, $alt_value_array))
			{
			$name="alt_".$fld;
			$line.="</td><td> add if not in drop-down==><input type='text' name='$name' value=\"\">";
			}
		
		echo "</td></tr>";
		}
	
	echo "$line";

	}
	
echo "<tr><td colspan='2' align='center'><input type='hidden' name='select_table' value=\"$select_table\">";
echo "<input type='submit' name='submit_form' value=\"Add\">";
echo "</td></tr></table>";
echo "</form>";

?>
