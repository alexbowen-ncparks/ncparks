<?php
//include("../../include/authBUDGET.inc");
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;

if(!isset($_SESSION)){session_start();}

if(!@$no)
	{
	
	echo "<div align='center'>
	<table bgcolor='#ABC578' cellpadding='3'>";
	
$level=@$_SESSION['eeid']['level'];  // echo "l=$level";
	
	//echo "<tr><td><a href='accounts.php'>Mammals of NC Home</a></td></tr>";
	
	echo "<tr><td><a href='field_trip.php'>List of Field Trips</a></td></tr>";
	
	if($level>1) 
		{
		echo "<tr><td><a href='add_field_trip.php'>Enter Field Trip</a></td></tr>";
		}

	echo "<tr><td><a href='search_field_trip.php'>Search</a></td></tr>";

	

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
		
//	echo "<tr><td><a href='login.html?db=mammals'>Login</a></td></tr>";
	
	
	echo "</table></div>";
	}

?>