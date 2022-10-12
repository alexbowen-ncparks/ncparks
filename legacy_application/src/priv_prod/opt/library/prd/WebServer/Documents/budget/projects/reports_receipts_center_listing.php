<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=='5' and $tempID !='Dodd3454')


{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}

if($level=='5' and $tempID !='Dodd3454')

{
echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}



$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

if($level=='5' and $tempID !='Dodd3454')

{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

$table="report_budget_history_multiyear";

if($account_selected !='y') 
 
{

$query2="select distinct center,parkcode,center_description,district,section from $table where 1 
         and cash_type='receipt' order by parkcode";
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


echo "<H1 ALIGN=left><font color=brown><i>Receipt Centers-$num2</i></font></H1>";
echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Center</font></th>"; 
echo "<th align=left><font color=brown>ParkCode</font></th>"; 
echo "<th align=left><font color=brown>Description</font></th>"; 
echo "<th align=left><font color=brown>District</font></th>"; 
echo "<th align=left><font color=brown>Section</font></th>"; 

echo "</tr>";

while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


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





















	














