<?php
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;

if($_GET['v']=="welcome")
	{
	header("Location: welcome.php");
	exit;
	}
if($_GET['v']=="admin")
	{
	header("Location: admin.php");
	exit;
	}

$exp=explode("/",$_SERVER['PHP_SELF']);
$file=$exp[2];
$exp=explode(".",$exp[2]);
$temp_menu=$exp[0];

// echo "f=$file t=$temp_menu";  exit;

// echo "f=$file<pre>"; print_r($_POST); echo "</pre>";  //exit;
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

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// echo "$v<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "<div class='list'>";
echo "<table>
<tr>";

foreach($ARRAY as $index=>$array)
	{
	if(in_array($v,$array))
		{
		$section_array[]=$array;
		}
	}
// echo "tm=$v<pre>"; print_r($section_array); echo "</pre>"; // exit;
$action_file_array=array("Add an Applicant"=>"person_action.php","Search for Applicant"=>"person_action.php","Search for Employee"=>"person_action.php");
$track_tab=array();
foreach($section_array as $k=>$array)
	{
	extract($array);
	if(in_array($tab_name,$track_tab)){continue;}
	$track_tab[]=$tab_name;
	$action="menu_target.php?v=$v";
	if(array_key_exists($tab_name,$action_file_array))
		{$action=$action_file_array[$tab_name];}
	echo "<td><form method='POST' action='$action'>
	<input type='hidden' name='action_type' value=\"$v\">
	<input type='hidden' name='var_menu_item' value=\"$menu_item\">
	<input type='submit' name='submit_form' value=\"$tab_name\">
	</form></td>";
	}
echo "</tr>";
if(empty($var_menu_item))
	{
	echo "<tr><th colspan='10'>Select an item to view.</th></tr>";
	if(!empty($message))
		{
		echo "<tr><th colspan='10'>$message</th></tr>";
		}
	exit;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "</table>
<hr />";

$page_display="<table cellpadding='5'>";
foreach($ARRAY as $index=>$array)
		{
		if(!in_array($submit_form,$array)){continue;}
		extract($array);
		$display=$tab_content;
		if(!empty($tab_content_link))
			{$display="<a href='$tab_content_link'>$tab_content</a>";}

		$page_display.="<tr><td>$display</td></tr>";
		}
	$page_display.="</table>";

// *********** upload applicant forms *************
if($submit_form=="Upload Forms")
	{
	include("list_applicant_forms.php");
	}

// *********** upload separation forms *************
if($submit_form=="Separation Forms")
	{
	include("list_separation_forms.php");
	}
echo "$page_display";
echo "</div>";

?>