<?php
ini_set('display_errors',1);

include("page_scores_header.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
 
include("../../include/iConnect.inc");
	
mysqli_select_db($connection,$dbName);


include("scoring_arrays.php");

if(empty($var))
	{exit;}

if($var=="objective")
	{
	include("view_objective_score.php");
	}
?>