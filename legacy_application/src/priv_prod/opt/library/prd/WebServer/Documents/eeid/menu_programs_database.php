<?php

if(!isset($_SESSION)){session_start();}

$level=@$_SESSION['eeid']['level'];  // echo "l=$level";

echo "<div align='center'>
<table bgcolor='#ABC578' cellpadding='3'>";

echo "<tr><td><a href='landing.php'>EEID / IEPD</a></td></tr>";


if($level>0) 
	{
	echo "<tr><td><a href='add_program.php'>Add IEPD Program</a></td></tr>";
	}

echo "<tr><td><a href='search_programs_database.php'>Search IEPD Programs</a></td></tr>";



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