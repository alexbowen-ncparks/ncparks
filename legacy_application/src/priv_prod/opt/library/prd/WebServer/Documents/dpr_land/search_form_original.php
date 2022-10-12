<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include("../_base_top.php");


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

include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql = "SELECT * FROM park_name order by park_name";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_name[$row['park_id']]=$row;
	}
//echo "<pre>"; print_r($ARRAY_park_name); echo "</pre>"; // exit;
	
$sql = "SELECT * FROM project_status order by project_status_id";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_status[$row['project_status_id']]=$row['project_status'];
	}
//echo "<pre>"; print_r($ARRAY_project_status); echo "</pre>"; // exit;
	
// $sql = "SELECT * FROM county_name order by county_name";  // all counties
// only counties with assets
$sql = "SELECT distinct t1.county_id, t2.county_name
FROM land_assets as t1
left join county_name as t2 on t1.county_id=t2.county_id
order by t2.county_name";  //echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_county_name[$row['county_id']]=$row['county_name'];
	}
//echo "<pre>"; print_r($ARRAY_park_name); echo "</pre>"; // exit;

$sql = "SELECT * FROM park_classification order by park_classification_id";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park_classification[$row['park_classification_id']]=$row['classification'];
	}
	
echo "<div><form method='POST'>
<table class='search_box'><tr><td class='head' colspan='4'>Search the DPR Land database</td></tr>";

echo "<tr>
<td>Owner: <input type='text' name='last_name' value=\"\" size='15'></td>
<td>Year: <input type='text' name='purchase_date' value=\"\" size='5'></td>
<td>Business: <input type='text' name='business_name' value=\"\"></td>";
echo "<td>Common Name: <input type='text' name='common_name' value=\"\" size='15'></td>";
echo "<td>Asset ID: <input type='text' name='land_assets_id' value=\"\" size='7'></td>";
echo "<td>Status: <select name='project_status_id'><option value=\"\" selected></option>\n";
foreach($ARRAY_project_status as $project_status_id=>$project_status)
	{
	echo "<option value='$project_status_id'>$project_status</option>\n";
	}
// echo "<pre>"; print_r($park_code_array); echo "</pre>"; // exit;
echo "</select></td>";

echo "<td>Park Code: <select name='park_id'><option value=\"\" selected></option>\n";
foreach($ARRAY_park_name as $park_id=>$array)
	{
	$pa=$array['park_abbreviation'];
	//$_POST['park_id']==$park_id?$s="selected":$s="";
	echo "<option value='$park_id'>$pa</option>\n";
	}
// echo "<pre>"; print_r($park_code_array); echo "</pre>"; // exit;
echo "</select></td>";

echo "<td>County: <select name='county_id'><option value=\"\" selected></option>\n";
foreach($ARRAY_county_name as $county_id=>$county_name)
	{
	if(empty($county_name)){continue;}
	echo "<option value='$county_id'>$county_name</option>\n";
	}
// echo "<pre>"; print_r($ARRAY_county_name); echo "</pre>"; // exit;

echo "<td>Classification: <select name='park_classification_id'><option value=\"\" selected></option>\n";
foreach($ARRAY_park_classification as $park_classification_id=>$classification)
	{
	if(empty($classification)){continue;}
	echo "<option value='$park_classification_id'>$classification</option>\n";
	}
echo "</select></td>";

echo "<td>Critical: <input type='radio' name='critical' value=\"1\">Yes
<input type='radio' name='critical' value=\"\">No
";
echo "<td><input type='submit' name='submit_form' value=\"Search\"></td>

</tr>";



echo "
</table>
<hr />
</form>
</div>";

if(@$_POST["submit_form"]=="Search")
	{
//  	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	foreach($_POST AS $k=>$v)
		{
		if($k=="submit_form"){continue;}
		if($k=="critical" and empty($v)){$pass_critical=1;}
		if(empty($v)){continue;}
		$test[]=$v;
		}
		
	if(empty($test))
		{
		if(!empty($pass_critical))
			{
			echo "Entering \"No\" as the only search term would return too many records. Please add another term.";
			exit;
			}
			else
			{
			echo "No search term entered."; exit;
			}
		}
	include("search_action.php");
	if($c>0)
		{exit;}
	}

if(empty($select_table))
	{
	exit;
	}

// **********
$dropdown_file="values_".$select_table.".php";
include($dropdown_file);  // get values for various dropdowns

	
$sql = "SHOW COLUMNS FROM $select_table";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}


$skip=array();
$table_length=strlen($select_table);

include("form_arrays.php");

echo "<form action='search_form.php' method='POST'>";
echo "<table>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
//	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$ck_field=substr($fld,0,$table_length)."_id";
	if($fld==$ck_field){continue;}
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	echo "<tr>";
	echo "<td>$fld</td>";
//	if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	
	
if(in_array($fld,$drop_down))
		{
		$select_array=${$fld."_array"};
// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if(@${$fld}===$k){$s="selected";}else{$s="";}
			$val=$k;
			if(in_array($fld,$flip_key)){$val=$k;}
			$line.="<option value='$val' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Search\"></td>";
echo "</tr>";
echo "</table>";
echo "</form></html>";

?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
</script>