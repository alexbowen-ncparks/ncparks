<?php
$database="dpr_land";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);

$path="/dpr_land/";

echo "
<table bgcolor='#ABC578' cellpadding='3'>";
$home=$path."home.php";
$manage_tables=$path."search_form.php";
echo "<tr><td><a href='$home'>Welcome</a></td></tr>";
echo "<tr><td><a href='$manage_tables'>Manage Tables</a></td></tr>";


$append_table=array();

if($level>3) // 1
	{
// 	$append_displays[]['Data Displays']=$path."edit_data_display.php";
	}

if($level>0) // 1
	{
	$append_displays[]['Reports']=$path."reports.php";
	$append_displays[]['County/Acres']=$path."edit_county_display.php";
	}
	
if($level>3) // 1
	{
// 	$append_table[]['Manage Tables']=$path."search_form_tables.php";
	}	

if($level>1) // 0
	{
	echo "<tr><td>------ Admin ------</td></tr>";
	
	foreach($append_displays as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			echo "<tr><td> <form action='$v' method='post'>
			<input type='submit' name='submit_admin' value='$k'>
			</form> </td></tr>";
			}
		}

	foreach($append_table as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			echo "<tr><td> <form action='$v' method='post'>
			<input type='submit' name='submit_admin' value='$k'>
			</form> </td></tr>";
			}
		}

	}
echo "</table>";


?>