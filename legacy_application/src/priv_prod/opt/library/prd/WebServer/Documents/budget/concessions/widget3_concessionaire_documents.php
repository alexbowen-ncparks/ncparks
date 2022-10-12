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

//concessions mgr-gallagher, budget officer-dodd, Environmental Specialist-Smith Raynor, Community Planner III-David Head, Deputy Director-Tingley
echo "<br />beacnum=$beacnum<br />";
if($beacnum=='60033162' or $beacnum=='60032781' or $beacnum=='60092634' or $beacnum=='60033166' or $beacnum=='60033202')  
{
$query1e="select distinct category2 from concessions_documents where 1 order by category2 ";
}

if($beacnum!='60033162' and $beacnum!='60032781' and $beacnum!='60092634' and $beacnum!='60033166' and $beacnum!='60033202')  //concessions manager Tara Gallagher
{
$query1e="select distinct category2 from concessions_documents where 1 and category2='$concession_location' order by category2 ";
}

echo "<br />query1e=$query1e<br />";


$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query1e.  $query1e");

$num1e=mysqli_num_rows($result1e);
//echo "<html><body>";
//echo "<table><tr><td>Records: $num1e</td></tr></table>";
echo "<br />";

$checkmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
if($category3 == ''){$category3 = 'all';}
echo "<table border='1' cellpadding='20'>";

echo "<tr>";


echo "<td><font color='brown' size='5'>Group</td>";
/*
if($beacnum=='60033162')  //concessions manager Tara Gallagher
{
if($category3=='all')
{
 echo "<td><a href='documents_personal_search.php?category3=all'>ALL</a>$checkmark</td>"; 
 }
 
 if($category3!='all')
{
 echo "<td><a href='documents_personal_search.php?category3=all'>ALL</a></td>"; 
 }
} 
*/ 
 
while ($row1e=mysqli_fetch_array($result1e)){

extract($row1e);

if($category3==$category2)
{
 echo "<td><a href='documents_personal_search.php?category3=$category2'>$category2</a>$checkmark</td>"; 
 }
 
 if($category3!=$category2)
{
 echo "<td><a href='documents_personal_search.php?category3=$category2'>$category2</a></td>"; 
 }
 
 
 
 
 }
 
 
 
 //echo "<td><a href='documents_personal_search.php?category3=all'>All</a></td>";
 
echo "</tr>";
 echo "</table>";
// echo "</body>";
//echo "</html>";
 



 



	  
  

 ?>




















