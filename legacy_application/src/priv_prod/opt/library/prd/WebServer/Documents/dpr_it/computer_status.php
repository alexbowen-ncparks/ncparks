<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$ARRAY_computer_status=array("bwo" => "Being Worked On",
							"rec_p" => "Received at Park",
							"sent_r" => "Sent to Raleigh",
							"rec_r" => "Received in Raleigh",
							"sent_p" => "Sent to Park",
							//"surp_tobe" => "To be Surplused",
							//"surp_process" => "Surplus Process",
							//"surplus" => "Surplused"
						);

include("_base_top.php");

echo "<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 20px;
}
#myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  left: 30px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: #ABC578;
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 4px;
}

#myBtn:hover {
  background-color: purple;
}
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

echo "<table class='search_box'><tr><td class='head' colspan='8'>Search the DPR IT Equipment database for Computer Status</td></tr>
<tr>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"\">
<input type='submit' name='submit_form' value=\"No Status Indicated\">
</form></td>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"rec_p\">
<input type='submit' name='submit_form' value=\"Received at Park\">
</form></td>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"sent_r\">
<input type='submit' name='submit_form' value=\"Sent to Raleigh\">
</form></td>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"rec_r\">
<input type='submit' name='submit_form' value=\"Received in Raleigh\">
</form></td>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"sent_p\">
<input type='submit' name='submit_form' value=\"Sent to Park\">
</form></td>
<td><form method='POST' action='computer_status.php?select_table=computers'>
<input type='hidden' name='computer_status' value=\"bwo\">
<input type='submit' name='submit_form' value=\"Being Worked On\">
</form></td>
<!--
	<td><form method='POST' action='computer_status.php?select_table=computers'>
	<input type='hidden' name='computer_status' value=\"surp_tobe\">
	<input type='submit' name='submit_form' value=\"To Be Surplused\">
	</form></td>
	<td><form method='POST' action='computer_status.php?select_table=computers'>
	<input type='hidden' name='computer_status' value=\"surp_process\">
	<input type='submit' name='submit_form' value=\"Surplus Process\">
	</form></td>
	<td><form method='POST' action='computer_status.php?select_table=computers'>
	<input type='hidden' name='computer_status' value=\"surplus\">
	<input type='submit' name='submit_form' value=\"Surplused\">
	</form></td>
-->

</tr></table>";

if(empty($submit_form))
	{exit;}

$order_by="";
if(!empty($pass_order_by))
	{
	$order_by=" order by $submit_form $pass_order_by";
	}
$sql="SELECT id, location, site_id, user_name, `type`, `os`, `make`, `model`, `sn_service_tag`, `fas`,  `date_deployed`, `computer_name`, `computer_status` 
from computers
where 1 and computer_status='$computer_status'
$order_by
"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql");
$c=mysqli_num_rows($result);
IF($c>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$ARRAY[]=$row;}
	}

if(empty($computer_status))
	{$var_computer_status="No computer status indicated.";}
	else
	{$var_computer_status=$computer_status;}
	
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip=array();
echo "<div><table class='alternate'><tr><td colspan='13'>$c computers <font color='red'>$var_computer_status</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			@$pass_order_by=="asc"?$pob="desc":$pob="asc";
					echo "<th bgcolor='#ffc266'><form method='POST' action='computer_status.php'>
					<input type='hidden' name='select_table' value=\"$select_table\">
					<input type='hidden' name='computer_status' value=\"$computer_status\">
					<input type='hidden' name='pass_order_by' value=\"$pob\">
					<input type='submit' name='submit_form' value=\"$fld\">
					</form></th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="id")
			{$value="<form method='POST' action='edit.php' target='_blank' style=\"background-color: #E3E1B8; text-align:center\">
					<input type='hidden' name='select_table' value=\"computers\">
					<input type='hidden' name='id' value=\"$value\">
					<input type='submit' name='submit_form' value=\"$value\">
					</form>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}