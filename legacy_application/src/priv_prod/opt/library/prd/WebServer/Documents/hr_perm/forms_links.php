<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

include_once("../_base_top.php");
echo "
<style>
/* Header Buttons */
 input[name=submit_form] {
  color:#08233e;
  font:2.1em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size:100%;
  padding:2px;
 
  background-color: #b3e6cc;
  border:1px solid #39ac73;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px;
  border-bottom:1px solid #9f9f9f;
  -moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  cursor:pointer;
 }
 input[type=submit]:hover {
  background-color:rgba(255,204,0,0.8);
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
background-color: #ffd7b3;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
 </style>
 ";

include("../../include/iConnect.inc"); // includes no_inject.php

if(@$_POST["submit_form"]=="Update")
	{
// 	include("display_data_action.php");
	}


echo "<div class='list'>";
echo "<table>
<tr>";

//"notes"=>"Notes", "political_info"=>"Political Info",  no separate tables - date fields in land_assets
//"balance"=>"Balance",  not used
$abstract_table_array=array("hiring_forms.php"=>"Hiring Forms", "le"=>"Law Enforcement");

foreach($abstract_table_array as $k=>$v)
	{
	echo "<td><form method='POST' action='select_table.php'>
	<input type='hidden' name='select_table' value=\"$k\">
	<input type='submit' name='submit_form' value=\"$v\">
	</form></td>";
	}
echo "</tr>";
if(empty($var))
	{
	echo "<tr><th colspan='10'>Select an item to view.</th></tr>";
	if(!empty($message))
		{
	echo "<tr><th colspan='10'>$message</th></tr>";}
	}

echo "</table>";
echo "</div>";

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

if(empty($select_table))
	{
	exit;
	}
include($select_table);


?>