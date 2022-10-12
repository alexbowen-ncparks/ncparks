<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//$today=date("Ymd", time() );
//$yesterday=date("Ymd", time() - 60 * 60 * 24);
//$dayb4yesterday=date("Ymd", time() - 60 * 60 * 24*2);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
$checkmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

echo "<table border='1' cellpadding='20'>";

echo "<tr>";



echo "<td><font color='brown' size='5'>Group</td>";

if($category3==''){$category3="all";}

if($category3=='all')
{
echo "<td><a href='vendor_fees_menu.php?category3=all'>ALL</a>$checkmark</td>"; 
}

if($category3!='all')
{
echo "<td><a href='vendor_fees_menu.php?category3=all'>ALL</a></td>"; 
}


if($category3=='434150920')
{
echo "<td><a href='vendor_fees_menu.php?category3=434150920'>Food & Vending</a>$checkmark</td>"; 
}


if($category3!='434150920')
{
echo "<td><a href='vendor_fees_menu.php?category3=434150920'>Food & Vending</a></td>"; 
}


if($category3=='434196001')
{
echo "<td><a href='vendor_fees_menu.php?category3=434196001'>Marina</a>$checkmark</td>"; 
}


if($category3!='434196001')
{
echo "<td><a href='vendor_fees_menu.php?category3=434196001'>Marina</a></td>"; 
}


if($category3=='434196002')
{
echo "<td><a href='vendor_fees_menu.php?category3=434196002'>Special Attractions</a>$checkmark</td>"; 
}


if($category3!='434196002')
{
echo "<td><a href='vendor_fees_menu.php?category3=434196002'>Special Attractions</a></td>"; 
}


 
 
echo "</tr>";
 echo "</table>";
// echo "</body>";
//echo "</html>";
 



 



	  
  

 ?>




















