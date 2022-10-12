<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo "welcome to account_listing.php";
$table="report_budget_history_multiyear";
$query1="SELECT body_bgcolor
from format_custom
WHERE 1 and user_id='tony'
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

$body_bg=$body_bgcolor;
echo "<html>";
echo "<head>
<title>centers</title>";

//include ("css/test_style.php");



echo "
<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";


echo "</head>";


echo "<br />";



if($account_selected !='y') 
 
{

$query2="select distinct center,parkcode,center_description,district,section from $table where 1 
         and cash_type='receipt' order by parkcode";
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


echo "<H1 ALIGN=left><font color=brown><i>Receipt Centers-$num2</i></font></H1>";
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Center</font></th>"; 
echo "<th align=left><font color=brown>ParkCode</font></th>"; 
echo "<th align=left><font color=brown>Description</font></th>"; 
echo "<th align=left><font color=brown>District</font></th>"; 
echo "<th align=left><font color=brown>Section</font></th>"; 

while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>$center</td> 	
           <td>$parkcode</td> 	
           <td>$center_description</td> 
           <td>$district</td> 
           <td>$section</td> 
	          
		  
		  
			  
			  
</tr>";

}
 exit;
} 

 
 echo "</table></html>";
 
 
 

?>





















	














