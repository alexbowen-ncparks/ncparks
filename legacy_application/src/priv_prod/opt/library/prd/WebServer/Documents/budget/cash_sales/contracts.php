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
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");

//$database2="fuel";
//////mysql_connect($host,$username,$password);
//@mysql_select_db($database2) or die( "Unable to select database");
//echo "Budget Database";

/*
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/

//

/*
$query_tagN="SELECT vehicle.license as 'tag'
FROM vehicle
where 1
and center_code='$concession_location'
ORDER BY tag";
*/

/*
$query_tagN="SELECT vehicle.license as 'tag'
FROM vehicle
where 1
and center_code='lawa'
ORDER BY tag";
*/

if($concession_location=='ADM'){$concession_location='ADMI';}


$query_tagN="
SELECT DISTINCT contract_num as 'contract_num'
FROM purchase_contracts
WHERE 1 
AND active =  'y'
ORDER BY contract_num
";


echo "query_tagN=$query_tagN<br /><br />";


//echo "query_tagN=$query_tagN";


$result_tagN = mysqli_query($connection, $query_tagN) or die ("Couldn't execute query_tagN. $query_tagN");
while ($row_tagN=mysqli_fetch_array($result_tagN))
	{
	$contractArray[]=$row_tagN['contract_num'];
	}

//array_push($tagArray,'pk4396');	

//sort($tagArray);

//echo "<pre>"; print_r($tagArray); echo "</pre>";//exit;	


echo  "<form method='post' autocomplete='off' action=''>";

echo "<td>";
 
 echo "<select name=\"contract_num[]\"><option value=''></option>";

for ($n=0;$n<count($contractArray);$n++){
$con=$contractArray[$n];
if($contract_num==$con){$s="selected";}else{$s="value";}
//$s="value";
		echo "<option $s='$con'>$contractArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>";

echo "</form>";










	
//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";

 // unset $tagArray[];

?>
