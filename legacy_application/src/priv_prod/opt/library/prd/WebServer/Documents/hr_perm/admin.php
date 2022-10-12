<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

include_once("../_base_top.php");
// $background_color="#b3e6cc";
$background_color="#99e6ff";

echo "
<style>
/* Header Buttons */
 input[name=submit_form] {
  color:#603960;
  font:2.1em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size:100%;
  padding:2px;
 
  background-color: $background_color;
  border:1px solid #553355;
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
  background-color:rgba(209, 224, 224,0.8);
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
	include("update_menu.php");
	}


echo "<div class='list'>";
echo "<table>
<tr>";

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY AS $index=>$array)
	{
	$admin_array[$array['menu_item']]=$array['menu_name'];
	}
// echo "<pre>"; print_r($admin_array); echo "</pre>"; // exit;

foreach($admin_array as $menu_item=>$menu_name)
	{
	echo "<td><form method='POST' action='admin.php'>
	<input type='hidden' name='var_menu_item' value=\"$menu_item\">
	<input type='submit' name='submit_form' value=\"$menu_name\">
	</form></td>";
	}
echo "</tr>";
if(empty($var_menu_item))
	{
	echo "<tr><th colspan='10'>Select an item to view.</th></tr>";
	}

echo "</table>";
echo "</div>";

if(empty($var_menu_item)){exit;}

// echo "var_menu_item=$var_menu_item<pre>"; print_r($var_menu_item); echo "</pre>"; echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $index=>$array)
	{
	if(in_array($var_menu_item,$array))
		{
		$sub_var_array[$array['tab_name']]=$array['menu_name'];
		}
	}
// echo "<pre>"; print_r($sub_var_array); echo "</pre>"; // exit;
if(empty($admin_array[$var_menu_item])){exit;}

$mn=$admin_array[$var_menu_item];
echo "<hr /><table><tr><td><h3><font color='#7700b3'>$mn</font></h3></td></tr><tr>";
foreach($sub_var_array as $tab_name=>$menu_name)
	{
	echo "<td><form method='POST' action='admin.php'>
	<input type='hidden' name='var_menu_item' value=\"$var_menu_item\">
	<input type='hidden' name='var_menu_name' value=\"$menu_name\">
	<input type='hidden' name='var_tab_name' value=\"$tab_name\">
	<input type='submit' name='submit_form' value=\"$tab_name\">
	</form></td>";
	}
echo "</tr>";

if(empty($var_tab_name)){echo "</table>";exit;}

echo "<tr><td colspan='8'><h3><font color='red'>$var_tab_name</font></h3></td></tr></table>";

// echo "var_tab_name=$var_tab_name<pre>"; print_r($var_tab_name); echo "</pre>"; 
// exit;

$skip=array();
$skip_edit=array("id");

$max_id=0;
$size_array=array("sort_order"=>"5","menu_item"=>"10","menu_name"=>"13", "tab_name"=>"15", "tab_content"=>"25", "tab_content_link"=>"70");

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "\n<form method='POST' action='admin.php'><table>";

foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	
	if(!in_array($var_tab_name,$array))
		{
// 		if(!in_array($var_menu_item,$array))
			{continue;}
		}
	$pass_menu_name=$array['menu_name'];
	$pass_tab_name=$array['tab_name'];
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
// 		if($sub_var=="Add Menu Item" and !empty($array['sort_order'])){continue;}
		$fld_list[$fld]=$fld;
		$id=$array['id'];
		if($id>$max_id){$max_id=$id;}
		if(in_array($fld,$skip)){continue;}
		$name=$id."[".$fld."]";
		if(array_key_exists($fld,$size_array))
			{
			$size=$size_array[$fld];
			}
			else
			{$size="";}
		
		$cell="<input type='text' name='$name' value='$value' size='$size'>";
		if(in_array($fld, $skip_edit)){$cell=$value;}
		echo "<td>$cell</td>";
		}
	echo "</tr>";
	}
	
// New menu item ********************

// echo "<pre>"; print_r($menu_array); echo "</pre>"; // exit;
foreach($menu_array as $k=>$v)
	{
	$menu_item_array[]=$k;
	foreach($v as $k1=>$v1)
		{
		$menu_name_array[]=$k1;
		
		foreach($v1 as $k2=>$v2)
			{
			$tab_name_array[$k1][$k2]=$k2;
			}
		}
	}
echo "<tr>";
// echo "<pre>"; print_r($tab_name_array); echo "</pre>"; // exit;
// echo "<pre>"; print_r($fld_list); echo "</pre>"; // exit;
$exclude_array=array("","tab_content","tab_content_link");

if(empty($fld_list)){exit;}

foreach($fld_list as $index=>$fld)
	{
	if(in_array($fld, $exclude_array) and $var_tab_name=="Add Menu Item")
		{continue;}
	$name="new[".$fld."]";
		if(array_key_exists($fld,$size_array))
			{
			$size=$size_array[$fld];
			}
			else
			{$size="";}
			
	$value=""; $ro="";	
		
	if($fld=="id")
		{
		$value=""; 
		$size=1; $ro="readonly";
		}
	
	if($fld=="sort_order")
		{
		$value=""; 
		$ro="readonly";
		}	
	if($fld=="menu_item")
		{
		$var_new="<select name='$name'><option value=\"\" selected></option>\n";
		foreach($menu_item_array as $k=>$v)
			{
// 			if($v==$var){$s="selected";}else{$s="";}
			$var_new.="<option value='$v'>$v</option>\n";
			}
		$var_new.="<option value='new_item'>new item</option>\n";
		$var_new.="</select>";
		$value=$var_new;
		echo "<td>$value</td>";
		continue;
		}	
	if($fld=="menu_name")
		{
		$var_new="<select name='$name'><option value=\"\" selected></option>\n";
		foreach($menu_name_array as $k=>$v)
			{
// 			if($v==$pass_menu_name){$s="selected";}else{$s="";}
			$var_new.="<option value='$v'>$v</option>\n";
			}
		$var_new.="<option value='new_name'>new name</option>\n";
		$var_new.="</select>";
		$value=$var_new;
		echo "<td>$value</td>";
		continue;
		}	
	if($fld=="tab_name")
		{
		$var_new="<select name='$name'><option value=\"\" selected></option>\n";
		foreach($tab_name_array[$menu_name] as $k=>$v)
			{
// 			if($v==$pass_tab_name){$s="selected";}else{$s="";}
			$var_new.="<option value='$v'>$v</option>\n";
			}
		$var_new.="<option value='new_tab'>new tab</option>\n";
		$var_new.="</select>";
		$value=$var_new;
		echo "<td>$value</td>";
		continue;
		}
	if($var_tab_name=="Add Menu Item"){$value="";}
	echo "<td><input type='text' name='$name' value=\"\" size='$size' $ro></td>";
	}
echo "</tr>";
echo "<tr><td colspan='7' align='center'>
<input type='hidden' name='var_menu_item' value=\"$var_menu_item\">
<input type='hidden' name='var_menu_name' value=\"$var_menu_name\">
<input type='hidden' name='var_tab_name' value=\"$var_tab_name\">
<input type='submit' name='submit_form' value=\"Update\">
</td></tr>";
echo "</table></form>";
?>