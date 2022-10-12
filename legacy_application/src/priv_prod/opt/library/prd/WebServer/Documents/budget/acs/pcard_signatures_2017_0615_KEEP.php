<?php

//session_start();


//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "approved_by=$approved_by";

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
//include("../../../budget/~f_year.php");
$query1="SELECT cashier,cashier_date,manager,manager_date
         from pcard_report_dates_compliance
         where admin_num='$parkcode' and report_date='$xtnd_end' ";
		 
//echo "query1=$query1<br />";	//exit;	 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);
//echo "<br />cashier:$cashier<br />cashier_date:$cashier_date<br />manager:$manager<br />manager_date:$manager_date<br />"; //exit;

$database="divper";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
//echo "cashier=$cashier<br />";

	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$cashier'";
	$result1a = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$row1a=mysql_fetch_array($result1a);
	extract($row1a);
	if($Nname){$Fname=$Nname;}
	$cashier_name=$Fname." ".$Lname;
	
	//echo "sql=$sql";
///echo "<br />cashier_name:$cashier_name<br />"; //exit;

$sql2 = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$manager'";
	$result2 = mysql_query($sql2) or die ("Couldn't execute query2. $sql2");
	$row2=mysql_fetch_array($result2);
	extract($row2);
	if($Nname){$Fname=$Nname;}
	$manager_name=$Fname." ".$Lname;
	
///echo "<br />manager_name:$manager_name<br />"; //exit;
$database="photos";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
	$sql3 = "SELECT link as 'cashier_signature' From signature where personID='$cashier'";
	//echo "sql3=$sql3<br />";
	$result3 = mysql_query($sql3) or die ("Couldn't execute query3. $sql3");
	$row3=mysql_fetch_array($result3);
	extract($row3);	

//$cashier_sig_location="/divper/".$cashier_signature;	
$cashier_sig_location="/opt/library/prd/WebServer/Documents/divper/".$cashier_signature;	
///echo "<br />cashier_sig_location:$cashier_sig_location<br />"; //exit;
///echo "<br /><img height='40' width='200' src='$cashier_sig_location' ></img><br />"; //exit;

$sql4 = "SELECT link as 'manager_signature' From signature where personID='$manager'";
	//echo "sql4=$sql4<br />";
	$result4 = mysql_query($sql4) or die ("Couldn't execute query4. $sql4");
	$row4=mysql_fetch_array($result4);
	extract($row4);
	

//$manager_sig_location="/divper/".$manager_signature;
$manager_sig_location="/opt/library/prd/WebServer/Documents/divper/".$manager_signature;	

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database


?>