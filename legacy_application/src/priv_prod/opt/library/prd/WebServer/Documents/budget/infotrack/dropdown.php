<?php
//lines 2 thru 10 from menuSelections.php
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$centerS=$_SESSION['budget']['centerSess'];
//echo "centerS=$centerS";


include("../../include/connectBUDGET.inc");// database connection parameters
include("../../include/activity.php");// database connection parameters

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo "welcome to account_listing.php";

$table="dropdown";

$query1="SELECT menu,web_address
from $table
WHERE 1 order by menu";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

//echo "<table border=1>";

//echo "<th align=left><font color=brown>menu</font></th>"; 
//echo "<th align=left><font color=brown>web_address</font></th>"; 

while ($row1=mysqli_fetch_array($result1))

{

extract($row1);   
$menuArray0[$menu]=$web_address;
}     



echo "<html><head><script language='JavaScript'>

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

";

echo "</script>";
echo "</head>";



// ******** CID Main Menu *************   Non-Admin  Invoices

//Added by me
//echo "<html>";
echo "<table>";
echo "<tr>";

//echo "<pre>"; print_r($menuArray0); echo "</pre>"; // exit;
//lines 81 thru 85 from menuSelections.php

echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Menu</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
//added by me
echo "</tr>";
echo "</table>";
echo "</html>";

?>