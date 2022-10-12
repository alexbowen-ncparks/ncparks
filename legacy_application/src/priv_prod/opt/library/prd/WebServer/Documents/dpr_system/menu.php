<?php
//include("../../include/authBUDGET.inc");
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;

if(empty($_SESSION)){session_start();}

	echo "<div align='left'>
	<table bgcolor='#ABC578' cellpadding='3'>";
	
	
$level=$_SESSION['dpr_system']['level'];

// Temporary for testing.
//$level=5;	
//	echo "<tr><td bgcolor='#ABC578'><a href='home.php'>Home</a></td></tr>";

echo "<tr><td bgcolor='#ABC578'><a href='search.php'>Search Parking</a></td></tr>";

echo "<tr><td bgcolor='#ABC578'><a href='request_list.php'>View Requests</a></td></tr>";

echo "<tr><td bgcolor='#ABC578'><a href='request.php'>Make Request</a></td></tr>";

//	echo "<tr><td bgcolor='#ABC578'><a href='work_order_form.php'>Submit Request</a></td></tr>";

//	echo "<tr><td bgcolor='#ABC578'><a href='search.php'>Search Requests</a></td></tr>";

//	echo "<tr><td bgcolor='#ABC578'><a href='logout.php'>Logout</a></td></tr>";

/*	
if($level==5)
	{
	$append=array("____________________"=>"","Voided Requests"=>"/denr_parking/view_voids.php","Manage Users"=>"/denr_parking/manage_users.php","Manage Locations"=>"/denr_parking/manage_locations.php");
	}
*/	

if($level==5)
	{
	$append=array("____________________"=>"","Voided Requests"=>"/denr_parking/view_voids.php","Manage Users"=>"/denr_parking/manage_users.php","Manage Locations"=>"/denr_parking/manage_locations.php","-----------------"=>"","Reports"=>"/denr_parking/reports.php");
	}

	
if($level>4)
	{
	echo "<tr><td bgcolor='#ABC578'><select id='menu_select' name='admin' onChange=\"MM_jumpMenu('parent',this,0)\">";
	echo "<option selected>Admin Functions</option>";
	foreach($append as $k=>$v)
		{
		echo "<option value=$v>$k</option>";
		}
	
	echo "</select></td></tr>";
	
	}


echo "</table></div>";

?>