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
$tempID=$_SESSION['dpr_system']['tempID'];
$beacon_num=$_SESSION['beacon_num']; //add for specific menu items for specific level and beacon numbers 

$beacon_array = array('60032778','60032788','60033178','60033160','60033018','65027689');
// Div Dir, PIO, GIS, DD-NRnPl, DD of Ops



if($level<0){exit;}

if($level > 4)
	{
	echo "<tr><td bgcolor='#ABC578'><a href='track_time_home.php' target='_blank'>Track Time</a></td></tr>";
	// Cole G added this analytics page to track logins to all dpr apps 9/14/2022
	echo "<tr><td bgcolor='#ABC578'><a href='/dpr_system/userAnalytics.html'>User Analytics</a></td></tr>";
	}
	
if($level>4)
	{
	echo "<tr><td bgcolor='#ABC578'><a href='site_survey.php' target='_blank'>2013 Legislative Site Survey</a></td></tr>";
	echo "<tr><td bgcolor='#ABC578'><a href='gov_book.php' target='_blank'>2015 Governor Briefing Book</a></td></tr>";
// 	echo "<tr><td bgcolor='#ABC578'><a href='land_acres_report.php' target='_blank'>Old System Size</a></td></tr>";
	}

if(($level>=3) AND in_array($beacon_num, $beacon_array))
	{
		echo "
				<tr>
					<td bgcolor='#ABC578'>
						<a href='february_2021_request.php'>
							February 2021 Request
						</a>
					</td>
				</tr>
			";
	}

if($level>0)
	{
	echo "<tr><td bgcolor='#ABC578'><a href='ppl.php' target='_blank'>Project Priority List (PPL)</a></td></tr>";
	echo "<tr><td bgcolor='#ABC578'><a href='dncr_request.php' target='_blank'>FY 1920 DNCR Request</a></td></tr>";
	echo "<tr><td bgcolor='#ABC578'><a href='/system_plan/system_summary.php' target='_blank'>System Size</a></td></tr>";
	}


echo "</table></div>";

?>