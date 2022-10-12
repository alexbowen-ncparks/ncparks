<?php
$database="dashboard";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	$var_temp=substr($_SESSION[$database]['tempID'], 0, -4);
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);

$path="/$database/";

echo "
<table bgcolor='#ABC578' cellpadding='3'>";
$home=$path."track.php";
$search_form=$path."search_form.php";
echo "<tr><td><a href='$home'>$var_temp</a></td></tr>";
echo "</table>";


?>