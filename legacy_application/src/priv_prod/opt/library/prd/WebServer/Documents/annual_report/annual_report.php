<?php
if(empty($_SERVER['HTTP_COOKIE'])){exit;}
session_start();
include("../../include/iConnect.inc");
$database="annual_report";
include("../../include/auth.inc"); // used to authenticate users
$database="divper";
mysqli_select_db($connection,$database);
extract($_REQUEST);
$sql="SELECT annual_report as level, currPark, accessPark 
from emplist where emid='$emid'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql");
$row=mysqli_fetch_assoc($result);

$_SESSION['annual_report']['level']=$row['level'];
$_SESSION['annual_report']['tempID']=$tempID;
$_SESSION['annual_report']['select']=$row['currPark'];
$_SESSION['annual_report']['accessPark']=$row['accessPark'];
header("Location: menu.php");
// if this fails the query is rerun in menu.php to SELECT using tempID
?>