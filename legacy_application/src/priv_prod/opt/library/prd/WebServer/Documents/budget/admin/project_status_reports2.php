<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$project_status=$_POST['project_status'];
$database="mamajone_cookiejar";
$table="projects";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT project_category,project_name,project_status 
FROM $table
WHERE 1 and project_status='$project_status' and user_id='$myusername' and user_id='$myusername'
ORDER BY project_category,project_name ";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);
//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

 
echo "<html>";
echo "<body bgcolor=#FFFFb4>";
echo " <font color=red size=5><i>PROJECTS $project_status</i> </font>";
echo "<br />";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H3 ALIGN=LEFT > <font color=blue>Search Results=$num </font></H3>";



//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";



 echo "<table border=1>";
 
echo 

"<tr> 
       <th>project_category</th>
       <th align=left>project_name</th>
       <td>project_status</td>
       <td>search_notes</td>
       <td>add_notes</td>
       <td>update_status</td>
       
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);


//echo $category;
//exit;


//echo 

//"<tr>
  //     <td >$category</td> 
  //     <td >$topic</td> 
  //     <td>$view_records</td>
       
//</tr>";

echo 

"<tr>

       <td>$project_category</td>
	   <td>$project_name</td>
	   <td>$project_status</td>
	   <td><a href='search_notes.php?&project_category=$project_category&project_name=$project_name'>search_notes</a></td>
	   <td><a href='add_notes.php?&project_category=$project_category&project_name=$project_name'>add_notes</a></td>
	   <td><a href='update_project_status.php?&project_category=$project_category&project_name=$project_name'>update_project_status</a></td>
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>






















