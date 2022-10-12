<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}


$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

if(@$access=="Hemmer")
	{
	$_SESSION['budget']['level']=4;
	$level=$_SESSION['budget']['level'];
	$_SESSION['budget']['tempID']="Hemmer";
	}

//echo $concession_location;

//if($level=='5' and $tempID !='Dodd3454')
//{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//}
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="energy";
$db="energy";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$table="energy_reports_1213";

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
/*
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
*/
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Energy Reports</title>";

//include ("test_style.php");
//include ("test_style.php");
echo "<link rel='stylesheet' type='text/css' href='/budget/home2.css' />";
echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>";




echo "</head>";

if(!@$access=="Hemmer")
	{
	
	echo "<a href='/budget/home.php'>";

echo "<img width='50%' height='20%' src='/budget/nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>";
		
include ("fiscal_year_header3.php");	
	//include ("widget1.php");
	}
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

if($level>1)
/*
	{
	$level=1;
	$query5="SELECT *
	FROM $table
	WHERE 1 and f_year='$f_year'
    order by report_name ";	
	}
*/	
{
	$level=1;
	$query5="SELECT *
	FROM $table
	WHERE 1 
    order by report_name ";	
	}	
	
	
	
	
	
/*
if($level==1) 

{

$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by category,park,vendor_name ";

}

*/
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";
echo "<h2 ALIGN=left><font color=brown>Energy Reports:$num5</font></h2>";

echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Report Name</font></th>
       <th align=left><font color=brown>Link</font></th>
              
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">

           <td>$report_name</td>
           <td><a href='$link' target='_blank'>View</a></td>
                    
      
           
              
           
</tr>";




}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














