<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

include("../../include/connect.php");
////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="project_messages_community";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from projects_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Notes</title>";

include ("css/test_style.php");


echo "</head>";
include("widget1.php");


$query="SELECT *
FROM $table
WHERE 1 
and project_category='$project_category'
ORDER BY user,project_category,project_name,project_note ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr>";
//echo "<th align=left><font color=brown>Download from Community</font></th>";
echo "<th bgcolor='yellow' align='left'><font color='brown'>Community</font></th>";

 
 
 
echo "</tr>";		  
echo "</table>";
echo "<br />";

echo "<table border=1>";
 

echo 

"<tr> 
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>title</font></th>
       <th align=left><font color=brown>description</font></th>
       
       
       
       
	   
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       
	   <td>$project_category</td>
       <td>$project_name</td>
       <td>$project_note</td>
       <td><a href='messages_community2private_insert.php?&project_note_id=$project_note_id&project_category=$project_category'>Download </a></td>
       
            
           
           
      
           
              
           
</tr>";




}

 echo "</table></body></html>";
 ?>














