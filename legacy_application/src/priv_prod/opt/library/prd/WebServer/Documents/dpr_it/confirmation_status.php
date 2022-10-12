<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$ARRAY_select_table=array("printers"=>"Printers","computers"=>"Computers");

include("_base_top.php");

echo "<style>
.head {
padding: 5px;
font-size: 22px;
color: #999900;
}
th{
padding: 5px;
    border: 1px solid #8e8e6e; 
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

table.alternate{
border: 1px solid #8e8e6e; 
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
  font-size: 70%;
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

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

echo "<table class='search_box'><tr><td class='head' colspan='8'>Inventory Confirmation</td></tr>
<tr>
<td><form method='POST' action='confirmation_status.php?select_table=computers'>
<input type='submit' name='submit_form' value=\"Computers\">
</form></td>
<td><form method='POST' action='confirmation_status.php?select_table=printers'>
<input type='submit' name='submit_form' value=\"Printers\">
</form></td>
<td width='50%'></td>
<td><form method='POST' action='confirmation_status.php?select_table=computers' onclick=\"return confirm('Are you sure you want to remove ALL Computer Confirmations?')\">
<input type='submit' name='submit_form' value=\"Clear All Computer Confirmations\">
</form></td>
<td><form method='POST' action='confirmation_status.php?select_table=printers' onclick=\"return confirm('Are you sure you want to remove ALL Printer Confirmations?')\">
<input type='submit' name='submit_form' value=\"Clear All Printer Confirmations\">
</form></td>


</tr></table>";

if(empty($submit_form))
	{exit;}

if($submit_form=="Clear All Computer Confirmations")
	{
	$sql="DELETE FROM confirmation
	where item='$select_table'
	"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql");
	}
	
if($submit_form=="Clear All Printer Confirmations")
	{
	$sql="DELETE FROM confirmation
	where item='$select_table'
	"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql");
	}
	
$sql="SELECT distinct location
from computers
where 1 
order by location
"; 
$result = mysqli_query($connection,$sql) or die("$sql");
while($row=mysqli_fetch_assoc($result))
	{$ARRAY_location_computers[]=$row['location'];}
// echo "<pre>"; print_r($ARRAY_location_computers); echo "</pre>"; // exit;
$sql="SELECT distinct location
from printers
where 1 
order by location
"; 
$result = mysqli_query($connection,$sql) or die("$sql");
while($row=mysqli_fetch_assoc($result))
	{$ARRAY_location_printers[]=$row['location'];}


$order_by=" order by date desc, location";
// if(!empty($pass_order_by))
// 	{
// 	$order_by=" order by $date $location";
// 	}
$sql="SELECT t1.*, t2.Lname
from confirmation as t1
left join divper.empinfo as t2 on t1.emid=t2.emid
where 1 and item='$select_table'
$order_by
"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql");
$c=mysqli_num_rows($result);
IF($c>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_check_location[]=$row['location'];
		$ARRAY[]=$row;
		}
	}
if(empty($ARRAY_check_location))
	{
	echo "No one has confirmed their inventory of $select_table.";
	exit;
	}
	
$ck_ARRAY=${"ARRAY_location_".$select_table};
foreach($ck_ARRAY as $index=>$location)
	{
	if(!in_array($location, $ARRAY_check_location))
		{
		$ARRAY[]['location']=$location;
		}
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(empty($ARRAY))
	{echo "No confirmation of inventory indicated."; exit;}
	
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array("id","emid");
echo "<div><table class='alternate'><tr><td colspan='13'></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			@$pass_order_by=="asc"?$pob="desc":$pob="asc";
					echo "<th bgcolor='#ffc266'>";
					echo "$fld";
// 					echo "<form method='POST' action='computer_status.php'>
// 					<input type='hidden' name='select_table' value=\"$select_table\">
// 					<input type='hidden' name='pass_order_by' value=\"$pob\">
// 					<input type='submit' name='submit_form' value=\"$fld\">";
					echo "</form></th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
// 		if($fld=="id")
// 			{$value="<form method='POST' action='edit.php' target='_blank' style=\"background-color: #E3E1B8; text-align:center\">
// 					<input type='hidden' name='select_table' value=\"computers\">
// 					<input type='hidden' name='id' value=\"$value\">
// 					<input type='submit' name='submit_form' value=\"$value\">
// 					</form>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}