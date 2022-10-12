<?php
if(empty($_SESSION)){session_start();}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


//if(!$no)
//	{
	
	echo "<div align='left'>
	<table bgcolor='#ABC578' cellpadding='3'>";
	
	
$level=$_SESSION['exhibits']['level'];

// Temporary for testing.
//$level=5;	
	echo "<tr><td bgcolor='#ABC578'><a href='home.php'>Home</a></td></tr>";
	
	echo "<tr><td bgcolor='#ABC578'><a href='work_order_form.php'>Submit Request</a></td></tr>";
	
	echo "<tr><td bgcolor='#ABC578'><a href='search.php'>Search Requests</a></td></tr>";
	
	echo "<tr><td bgcolor='#ABC578'><a href='logout.php'>Logout</a></td></tr>";
	

	
	if($level==5)
		{
		$append=array("--------------"=>"","Voided Requests"=>"/exhibits/view_voids.php","Manage Users"=>"/exhibits/manage_users.php","Manage Locations"=>"/exhibits/manage_locations.php","--------------"=>"","Reports"=>"/exhibits/reports.php");
		}


	if($level>4)
		{
		echo "<tr><td bgcolor='#ABC578'><select id='menu_select' name='admin' onChange=\"MM_jumpMenu('parent',this,0)\">";
		echo "<option selected>Admin Functions</option>";
		foreach($append as $k=>$v)
			{
			echo "<option value='$v'>$k</option>";
			}
		
		echo "</select></td></tr>";
		
		}
	
	
	echo "</table></div>";
//	}

?>