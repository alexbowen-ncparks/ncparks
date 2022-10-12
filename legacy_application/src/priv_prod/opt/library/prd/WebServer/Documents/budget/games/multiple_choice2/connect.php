<?php
include("../../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);


$database="mamajone_games";
$db="mamajone_games";


@mysql_select_db($database) or die( "Unable to select database");

//include("../../../include/activity.php");//exit;
//echo "1021";exit;
include("../../../include/salt.inc"); // salt phrase
//include("../../../budget/~f_year.php");
?>