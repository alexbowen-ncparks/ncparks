<?php
//include("../../include/authBUDGET.inc");
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;

//session_start();

if(empty($no))
	{
	
	echo "<div align='left'>
	<table bgcolor='#ABC578' cellpadding='3'>";
	
	
$level=$_SESSION['rtp']['level'];

// Temporary for testing.
///$level=5;	
$_SESSION['rtp']['level']=$level;



	echo "<tr><td bgcolor='#ABC578'><a href='home.php'>Home</a></td></tr>";
	
//	echo "<tr><td bgcolor='#ABC578'><a href='work_order_form.php'>Submit Request</a></td></tr>";
	
// 	echo "<tr><td bgcolor='#ABC578'><a href='search_form.php'>Search Applications</a></td></tr>";
	
	echo "<tr><td bgcolor='#ABC578'><a href='summary.php'>Projects</a></td></tr>";
	
	echo "<tr><td bgcolor='#ABC578'><a href='scores.php'>Scores</a></td></tr>";
	
//	echo "<tr><td bgcolor='#ABC578'><a href='rtp_login_form.php?db=rtp'>Login being tested</a></td></tr>";
	
//	echo "<tr><td bgcolor='#ABC578'><a href='logout.php'>Logout</a></td></tr>";
	


	
	if($level>3)
		{
		$append=array("____________________"=>"","Import Pre-Applications"=>"/rtp/import_pa.php","Import Final Applications"=>"/rtp/import_fa.php");
		$append["NCTC Summary"]="nctc_scores_summary.php";
		}

	if($level==5)
		{
		}
		
	if($level>1)
		{
//		$append['Edit Counties']="/work_order/county_form.php";
		}
		
	if($level>3)
		{
//		$append['Edit Home Page']="/work_order/home.php?edit=home";
		}
	if($level>3)
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
	}

?>