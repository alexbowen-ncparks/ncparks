<?php 
//extract ($_REQUEST);
/*
echo "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";
EXIT;
*/

ini_set('display_errors',1);
//include_once("../../include/get_parkcodes.php");

$database="wiys";
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

include("../../include/auth.inc");
extract($_REQUEST);
date_default_timezone_set('America/New_York');

// Update input
if($Submit =="Update")
	{	
	// ********** In *********
	if(@$status[0]=="i")
		{
		$query = "REPLACE status SET statusInOut='i',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		header("Location: status14.php?tempID=$tempID&u=1"); exit;
		}
	
	if(@$status[0]=="u")
		{
		$query = "REPLACE status SET statusInOut='u',statusUnavail='$status1[0]',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		// Check for completeness 
		if($status1[0]==""){
		header("Location: status14.php?tempID=$tempID&e=0&u=1"); exit;}
		}// end if status = u
	
	// ********** Out *********
	if(@$status[0]=="b")
		{
		$query = "REPLACE status SET statusInOut='b',statusUnavail='',statusCus='',statusBack='$status1[1]',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		// Check for completeness 
		if($status1[1]=="")
			{
			$query = "REPLACE status SET statusInOut='o',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
			header("Location: status14.php?tempID=$tempID&e=1&u=1"); exit;}
		}// end if status = b
	
	if(@$status[0]=="o")
		{
		$query = "REPLACE status SET statusInOut='o',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	if(@$status[0]=="b")
		{
		$query = "REPLACE status SET statusInOut='b',statusUnavail='',statusCus='',statusBack='$status1[1]',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	if(@$status[0]=="n")
		{
		$query = "REPLACE status SET statusInOut='n',statusUnavail='',statusCus='',statusBack='',statusBus='$status1[2]' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	if(@$status[0]=="t")
		{
		$query = "REPLACE status SET statusInOut='t',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='$status1[3]',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	if(@$status[0]=="l")
		{
		$query = "REPLACE status SET statusInOut='l',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='$status1[4]',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	if(@$status[0]=="c")
		{
		$query = "REPLACE status SET statusInOut='c',statusUnavail='',statusCus='$status1[5]',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID',offHour='$offHour'";
		$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	
	header("Location: status14.php?tempID=$tempID&u=1&statusUpdate=$statusUpdate"); exit;
	}
?>