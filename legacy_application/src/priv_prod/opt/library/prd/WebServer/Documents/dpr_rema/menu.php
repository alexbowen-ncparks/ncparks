<?php

if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION['dpr_rema']['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	ini_set('display_errors',1);


echo "<div align='center'>
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='overview.php'>Overview</a></td></tr>";

echo "<tr><td><a href='project.php'>Add Project</a></td></tr>";

echo "<tr><td><a href='find.php'>Find Project</a></td></tr>";

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
//	$append['Enter Records']="/work_comp/new_wc_request.php";
	}
	

if($level>10) // 9 is highest as of 20141230
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