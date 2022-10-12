<?php

/*
	session_start();

	if (!$_SESSION["budget"]["tempID"])
	{
		header("location: https://10.35.152.9/login_form.php?db=budget");
	}
*/

session_start();

if (!$_SESSION["budget"]["tempID"])
{
	echo "access denied";
	exit;
}

//	game id to be scored

//	$file = "articles_menu.php";
//	$lines = count(file($file));

$table = "infotrack_projects";
/*
	echo "<pre>";
			print_r($_REQUEST);
		"</pre>";
	//	exit;
*/

$active_file = $_SERVER['SCRIPT_NAME'];
$active_file_request = $_SERVER['REQUEST_URI'];

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempID = $_SESSION['budget']['tempID'];
$beacnum = $_SESSION['budget']['beacon_num'];
$playstation = $_SESSION['budget']['select'];
$playstation_center = $_SESSION['budget']['centerSess'];
//	$pcode=$_SESSION['budget']['select'];

if ($playstation == 'ADM')
{
	$playstation = 'ADMI';
}

$player = $tempID;
//	echo "playstation = $playstation<br />";
/*
	echo "player = $player<br />";
	//	exit;
*/
/*
	echo "<pre>";
			print_r($_SERVER);
		"</pre>";
*/
//	echo "active_file = $active_file<br />";
//	echo "active_file_request = $active_file_request<br />";

extract($_REQUEST);
/*
	echo "<pre>";
			print_r($_SERVER);
		"</pre>";
	//	exit;
*/

//	if ($level == '5 AND $tempID != 'Dodd3454')
//	echo "pcode = $pcode";
/*
	echo "<pre>";
			print_r($_SESSION);
		"</pre>";
	//	exit;
*/
/*
	echo "<pre>";
			print_r($_REQUEST);
		"</pre>";
	exit;
*/

//	include("../../../include/connectBUDGET.inc");		//	database connection parameters
//	include("../../../include/activity.php");			//	database connection parameters
//	include("../budget/~f_year.php");
//	include("../../budget/~f_year.php");

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");		//	connection parameters
mysqli_select_db($connection, $database);						//	database 

//	include("../../budget/menu1314_v3.php");

/*
	echo "<table>
			<tr>
				<th>
					\"Bright\" Idea under Development (Not ready for use)
				</th>
			</tr>
		</table>
		";
*/

//	Game to be scored
$gid = 14;

//	$gid 5 - total items to complete 

$query4 = "SELECT COUNT(cid) AS 'total'
			FROM project_steps_detail
			WHERE project_category = 'fms' 
				AND project_name = 'daily_updates'
		";
//	echo 		"AND fiscal_year = '$fiscal_year' ";
$result4 = mysqli_query($connection, $query4)
		OR
		die ("Couldn't execute query4 on Line 123:<br />  $query4");
$row4 = mysqli_fetch_array($result4);
extract($row4);
//	echo "total = $total";

$query5 = "SELECT COUNT(cid) AS 'complete'
			FROM project_steps_detail
			WHERE project_category = 'fms'
				AND project_name = 'daily_updates'
				AND status = 'complete' ";
//	echo 		"AND fiscal_year = '$fiscal_year' ";
$result5 = mysqli_query($connection, $query5)
		OR
		die ("Couldn't execute query5 on Line 136:<br />  $query5");
$row5 = mysqli_fetch_array($result5);
extract($row5);

//	echo "complete = $complete";
echo "completed $complete of $total";

$query6 = "UPDATE mission_scores
        	SET complete = '$complete',
         	total = '$total',
         	percomp = complete / total * 100
			WHERE gid = '14'
		 		AND playstation = 'admi'
		 ";
$result6 = mysqli_query($connection, $query6)
		OR
		die ("Couldn't execute query6 on Line 152:<br />  $query6");

 ?> 