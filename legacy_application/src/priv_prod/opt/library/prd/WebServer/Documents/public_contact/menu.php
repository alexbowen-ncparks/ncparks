<?php
$database="public_contact";
if(!isset($_SESSION))
	{
	session_start();
	//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

ini_set('display_errors',1);


echo "<div align='center'>
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='overview.php'>Overview</a></td></tr>";

echo "<tr><td><a href='contact.php'>Add Contact</a></td></tr>";

echo "<tr><td><a href='find.php'>Find Contact</a></td></tr>";

if($level>0) // 1
	{
// 	echo "<tr><td><a href='find.php'>Find Communication</a></td></tr>";
	}
	

echo "</table></div>";


?>