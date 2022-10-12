<?php
$database="dpr_tests";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);

$path="/$database/";

echo "
<table bgcolor='#ABC578' cellpadding='3'>";
$home=$path."home.php";
$search_form=$path."test.php?page=search";
echo "<tr><td><a href='$home'>Welcome</a></td></tr>";
echo "<tr><td><a href='$search_form'>Take Test</a></td></tr>";


$append_table=array();
$append_displays=array();

if($level>2) // 2
	{
	$append_displays[]['Completed Tests']=$path."view_tests.php";
	}

if($level>4) 
	{
	$append_displays[]['Add Test']=$path."test.php?page=add";
	$append_displays[]['Add/Edit Question']=$path."test.php?page=edit_question";
	$append_displays[]['Add nonDPR']=$path."test.php?page=nondpr";
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
// echo "<tr><td>
// <button onclick=\"topFunction()\" id=\"myBtn\" title=\"Go to top\">Go to top</button>
// </td></tr>";
echo "</table>";


?>