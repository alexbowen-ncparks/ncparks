<?php
//include("../../include/authBUDGET.inc");
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;

if(empty($_SESSION)){session_start();}

$title="NC DPR Databases";
$database="dpr_system";
include("../_base_top.php");
	echo "<div align='left'>
	<table bgcolor='#ABC578' cellpadding='3'>";
	
	
$level=$_SESSION['dpr_system']['level'];
if($level<0){exit;}
// Temporary for testing.
//$level=5;	
//	echo "<tr><td bgcolor='#ABC578'><a href='home.php'>Home</a></td></tr>";
if($level>2)
	{
	echo "<tr><td bgcolor='#ABC578'><a href='site_survey.php' target='_blank'>2013 Legislative Site Survey</a></td></tr>";
	echo "<tr><td bgcolor='#ABC578'><a href='gov_book.php' target='_blank'>2015 Governor Briefing Book</a></td></tr>";
	echo "<tr><td bgcolor='#ABC578'><a href='ppl.php' target='_blank'>Project Priority List (PPL)</a></td></tr>";
}

if($level>0)
	{echo "<tr><td bgcolor='#ABC578'><a href='land_acres_report.php'>System Size</a></td></tr>";
}



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