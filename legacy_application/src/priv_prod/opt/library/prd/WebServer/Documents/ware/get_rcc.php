<?php
ini_set('display_errors',1);
$database="budget";
//$title="REMA Project Tracking Application";
//include("../_base_top.php");
include("../../include/iConnect.inc");
date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//strpos($_SERVER["HTTP_USER_AGENT"],"Mac OS X")>-1?$pass_os="Mac":$pass_os="Win";
$ck_session=strpos($_SERVER["HTTP_COOKIE"],"PHPSESSID");
if($ck_session==-1){ EXIT;}

// ********** Get fields from table **************
extract($_GET);

$sql="SELECT parkCode, rcc, center_desc
FROM budget.`center`
WHERE fund = '1280' AND actCenterYN = 'y' and (parkCode='$q' OR rcc='$q')
";
//echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysql_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$park_code=$row['parkCode'];
	$center_desc=$row['center_desc'];
	$rcc=$row['rcc'];
	}
if(empty($park_code))
	{echo "$q is not recognized"; exit;}
$return_text="Park Code:<input type='text' name='park_code' value=\"$park_code\" size='5' readonly>
RCC:<input type='text' name='rcc' value=\"$rcc\" size='5' readonly>
$center_desc";
$return_text.="<br /><br /><input type='submit' name='submit' value=\"Submit\">";

//$return_text.="__$park_code~$rcc";
//$return_text.="__$park_code";

echo "$return_text"; //exit;
?>