<?php

/*  *** INCLUDE file inventory ***
include("../../include/authBUDGET.inc")
include("/opt/library/prd/WebServer/include/iConnect.inc")
*/


// Make f_year
/*
if(@$f_year=="")
	{
	ini_set('date.timezone', 'America/New_York');
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<9){$year2=date('Y')-1;}
	if($testMonth >8){$year2=date('Y');}
	$yearNext=$year2+1;
	$yx=substr($year2,2,2);
	$year3=$yearNext;$yy=substr($year3,2,2);
	$f_year=$yx.$yy;
	
	if(@$prev_year=="prev")
		{
		$yx=substr(($year2-1),2,2);
		$yy=substr(($year3-1),2,2);
		$f_year=$yx.$yy;
		}
	
	$pf_year=$yx=substr(($year2-1),2,2);
	$yy=substr(($year3-1),2,2);
	$pf_year=$yx.$yy;
	}
*/	
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
}

//These are placed outside of the webserver directory for security
include("../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database	
	
$query1="SELECT report_year as 'f_year' from fiscal_year where active_year='y' ";
         
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);	
	

//echo "<br />Line 26: f_year=$f_year<br />";
?>