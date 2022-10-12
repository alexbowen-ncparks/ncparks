<?php

if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION['lo_fo']['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);


echo "
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='home.php'>Welcome</a></td></tr>";
echo "<tr><td><a href='/lo_fo/search_form.php'>Search</a></td></tr>";
echo "<tr><td><a href='add_form.php'>Add Item</a></td></tr>";
echo "<tr><td><a href='/staffdir/graphics/SD16-02-Lost&FoundPolicy-5-2-16.pdf'>Policy Statement</a></td></tr>";
echo "<tr><td><a href='/staffdir/graphics/SD16-02-Lost&FoundPolicy-5-2-16.pdf'>Policy Statement</a></td></tr>";

if($level>6) // 1
	{
	$append['------- Admin -------']="";
	$append['Purchases']="/lo_fo/purchase.php";
	}
	

if($level>6) // 0
	{
//	echo "<tr><td>";
	foreach($append as $k=>$v)
		{
		echo "<tr><td><a href='$v'>$k</a></td></tr>";
	//	echo "<a href='$v'>$k</a><br />";
		}
//	echo "</td></tr>";
	}


echo "</table>";


?>