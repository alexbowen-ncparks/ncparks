<?php

if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION['work_comp']['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);


echo "<div align='center'>
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='welcome.php'>Welcome</a></td></tr>";

echo "<tr><td><a href='forms.php'>WC Forms</a></td></tr>";

//echo "<tr><td><a href='instructions.php'>Instructions</a></td></tr>";

echo "<tr><td><a href='start.php'>WC Submit Request</a></td></tr>";

echo "<tr><td><a href='hr_review.php'>Review Submissions</a></td></tr>";

echo "<tr><td><a href='search.php'>Search</a></td></tr>";

// echo "<tr><td><a href='feedback.php'>Comments</a></td></tr>";

if($level>0) // 1
	{
//	$append['Species List']="/moths/species_list.php";
	}
	
if($level>2) // 3
	{
//	$append['Enter Record']="/moths/private_submit.php";
	}


if($level>4) // 1
	{
	$append['Manage Forms']="/work_comp/manage_forms.php";
	$append['Form Instructions']="/work_comp/instructions.php";
	}
	

if($level>4) // 0
	{
	echo "<form><td align='center' bgcolor='#ABC578'><select name='admin' onChange=\"MM_jumpMenu('parent',this,0)\">";
	echo "<option selected>Admin Functions</option>";
	foreach($append as $k=>$v)
		{
		echo "<option value=\"$v\">$k</option>\n";
		}
	
	echo "</select></td></form></tr>";
	
	}


echo "</table></div>";


?>