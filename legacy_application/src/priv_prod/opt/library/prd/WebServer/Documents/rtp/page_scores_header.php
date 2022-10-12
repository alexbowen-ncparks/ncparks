<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$curr_year=date("Y");
$next_year=$curr_year+1;

$database="rtp"; 
$dbName="rtp";


if(empty($_SESSION))
	{
	session_start();
	}
$level=$_SESSION['rtp']['level'];

if(!empty($_POST['set_year']))
	{
	$_SESSION[$database]['set_year']=$_POST['set_year'];
	$set_year=$_POST['set_year'];
	}
	else
	{
	if(empty($_SESSION[$database]['set_year']))
		{
		$_SESSION[$database]['set_year']=$curr_year;
		}
	$set_year=$_SESSION[$database]['set_year'];
	}

if(!empty($_POST['set_cycle']))
	{
	$_SESSION[$database]['set_cycle']=$_POST['set_cycle'];
	$set_cycle=$_POST['set_cycle'];
	}
	else
	{
	if(empty($_SESSION[$database]['set_cycle']))
		{
		$_SESSION[$database]['set_cycle']=$set_cycle;
		}
	$set_cycle=$_SESSION[$database]['set_cycle'];
	}	

include_once("_base_top.php");

include("../../include/iConnect.inc");


$ARRAY_use=array("ohv_use","paddle_use","equine_use","hike_use","mtb_use");
	
	
echo "<style>
h3 {
font-size: 18px;
color: #999900;
}
.search {
font-size: 11px;
color: #009900;
}
.head {
font-size: 22px;
color: #999900;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

// extract($_POST);

// also these lines in page_list_summary.php
// if($level<1)
// 	{
// 	if($set_cycle=="fa")
// 		{
// 		$ARRAY_year=array("2016");
// 		$set_year="2016";
// 		}
// 	if($set_cycle=="pa")
// 		{
// 		$ARRAY_year=array("2017");
// 		$set_year="2017";
// 		}
// 	}		
$set_cycle=="pa"?$cycle="Pre-Application":$cycle="Final Application";
echo "<div>";
echo "<table><tr><td colspan='3'><h3>Project Scores for $project_file_name $cycle</h3></td></tr>

<tr>
<td><form method='POST' action='scores.php'>
<input type='submit' name='submit_form' value=\"All Project Scores\">
</form></td>";

$temp_table_array=array("objective"=>"Objective Scores", "rtp_subjective"=>"Staff Subjective Scores", "nctc_subjective"=>"NCTC Subjective Scores");

if($level<1)
	{
$temp_table_array=array("rtp_subjective"=>"Staff Subjective Scores", "nctc_subjective"=>"NCTC Subjective Scores");
	}

foreach($temp_table_array as $k=>$v)
	{
	if($k=="objective"){$action="view_objective_score.php";}
	if($k=="rtp_subjective"){$action="view_subjective_score.php";}
	if($k=="nctc_subjective"){$action="view_nctc_subjective_score.php";}
	echo "
	<td><form method='POST' action='$action'>
	<input type='hidden' name='var' value=\"$k\">
	<input type='hidden' name='project_file_name' value=\"$project_file_name\">
	<input type='submit' name='submit_form' value=\"$v\">
	</form></td>";
	}

echo "</tr>";
if(empty($var))
	{echo "<tr><th colspan='10'>Select an item to view.</th></tr>";}

echo "</table>";
echo "</div>";




?>