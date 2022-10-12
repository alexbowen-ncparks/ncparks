<?php
//echo "hello world";exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$imprest_cash2=$imprest_cash;
$imprest_cash2=str_replace(",","",$imprest_cash2);
$imprest_cash2=str_replace("$","",$imprest_cash2);

//echo "<br />imprest_cash2=$imprest_cash2<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

$query1a="update cash_imprest_authorized_centers set grand_total='$imprest_cash2' where park='$park' ";

//echo "<br />query1a=$query1a<br />";	

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");	


$query2a="update cash_imprest_authorized set grand_total='$imprest_cash2' where fyear='$fiscal_year' and park='$park' ";

//echo "<br />query2a=$query2a<br />";	

$result2a=mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");	

//exit;

header("location: procedures_crj.php?park=$park");





?>