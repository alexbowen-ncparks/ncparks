<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

/*
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
*/

$database="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database





$query_PM="
SELECT DISTINCT manager AS  'project_manager'
FROM partf_projects
WHERE projyn='y' 
order by manager
";


echo "query_PM=$query_PM<br /><br />";


//echo "query_tagN=$query_tagN";


$result_PM = mysqli_query($connection, $query_PM) or die ("Couldn't execute query_PM. $query_PM");
while ($row_PM=mysqli_fetch_array($result_PM))
	{
	$PMArray[]=$row_PM['project_manager'];
	}

//array_push($tagArray,'pk4396');	

//sort($tagArray);
//if($beacnum=='60033016')
{
echo "<pre>"; print_r($PMArray); echo "</pre>"; //exit;
}
	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

?>
