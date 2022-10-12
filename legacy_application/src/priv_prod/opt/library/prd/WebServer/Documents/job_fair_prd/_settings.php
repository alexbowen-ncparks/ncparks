<?php

mysqli_select_db($connection,$database);

// settings

if (isset($_GET['unitword']))
 {
  $unitword=$_GET['unitword'];
 } else {
  if (isset($_SERVER[$database]['unitword']))
  {
   // leave it
  } else {
   $unitword="candidate";  
  }
 }

if (isset($_GET['resperpage']))
 {
  $resperpage=$_GET['resperpage'];
 } else {
  if (isset($_SERVER[$database]['resperpage']))
  {
   // leave it
   $resperpage=$_SERVER[$database]['resperpage'];
  } else {
   $resperpage=50;  
  }
 }
			$_SESSION[$database]['unitword']=$unitword;

$hidelevel=4;		$_SESSION[$database]['hidelevel']=$hidelevel;
$editlevel=4;		$_SESSION[$database]['editlevel']=$editlevel;
$viewlevel=2;		$_SESSION[$database]['viewlevel']=$viewlevel;
$addnotelevel=3;	$_SESSION[$database]['addnotelevel']=$addnotelevel;
$viewallnoteslevel=4;	$_SESSION[$database]['viewallnoteslevel']=$viewallnoteslevel;
$sitewidth="88%";	$_SESSION[$database]['sitewidth']=$sitewidth;
$devlevel=5;		$_SESSION[$database]['devlevel']=$devlevel;
$buttonsz=15;		$_SESSION[$database]['buttonsz']=$buttonsz;
			$_SESSION[$database]['resperpage']=$resperpage;

?>
