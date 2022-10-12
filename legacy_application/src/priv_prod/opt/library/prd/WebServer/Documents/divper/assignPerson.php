<?php
ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
//print_r($_SESSION);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;

extract($_REQUEST);
// ***********Add Position Vacancy to Track ****************
if($posNum !="Pick a Vacant Position" and $emid!="")
	{
	$ex=explode("~",$posNum);
	$sql = "REPLACE emplist SET `beacon_num`='$ex[0]',`currPark`='$ex[1]', `tempID`='$tempID',`emid`='$emid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	// get Title
	$sql = "SELECT posTitle, rcc from position where beacon_num='$ex[0]'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result); extract($row);
	
	header("Location: formEmpInfo_reg.php?submit=Submit&parkS=$ex[1]");
	exit;
	}
	else
	{
	echo "Incomplete info entered. Click your back button.";
	exit;
	}

		// *********************** Update
$val = strpos($submit, "Update");
if($val > -1){  // strpos returns 0 if Update starts as first character
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

$formType="Update";

$sql = "UPDATE emplist SET `beacon_num`='$beacon_num',`currPark`='$currPark', `Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname'
WHERE `emid`='$emid'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//$test=mysqli_affected_rows($connection);
//echo "$sql $test"; exit;

switch ($v) {
		case "1":
			$_SESSION[v]=2;break;	
		case "2":
			$_SESSION[v]=1;break;	
		default:
			$_SESSION[v]=1;
	}
//header("Location: formPosInfo.php?v=$_SESSION[v]&submit=Find&emid=$emid");
exit;
} // end Update
?>