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

$table="projects";
$table2="project_notes";
$table3="project_notes_count";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

/*$setopen2closed="update $table set project_status='closed' where project_status='open' ";
mysqli_query($connection, $setopen2closed) or die ("Couldn't execute query. $setopen2closed");
*/

$query6="truncate table project_notes_count";
 mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
 
$query6a="insert into project_notes_count(user,project_category,project_name,note_count) 
select user,project_category,project_name,count(project_note_id) 
from project_notes where 1 group by user,project_category,project_name";

mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");
 
$query7="update projects
set projects.notes=''
where 1";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");




$query7a="update projects,project_notes_count 
set projects.notes=project_notes_count.note_count 
where projects.user_id=project_notes_count.user 
and projects.project_category=project_notes_count.project_category 
and projects.project_name=project_notes_count.project_name";

mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

$query="SELECT user_id,project_category,project_name,notes,share_provider,project_id
FROM $table
WHERE (user_id= '$tempid'or shared_users like '%$tempid%')
and project_type = 'share'
ORDER BY user_id,project_category,project_name ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


$query2="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
and project_status='open'
";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$num2=mysqli_num_rows($result2);

$query3="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
and project_status='closed'
";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$num3=mysqli_num_rows($result3);

$query4="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
and project_status='archive'
";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$num4=mysqli_num_rows($result4);

$query5="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$num5=mysqli_num_rows($result5);

//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

 
echo "<html>";

echo "<head>

<title>Welcome</title>
<style>

body { background-color: #FFF8DC; }
form { background-color: white; font-color: blue; font-size: 15;}
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}


//h1 { background-color: white; font-color: red; }



</style>

</head>";


//echo "<H1 ALIGN=left > <font color='red' bgcolor='white'>Projects-$myusername </font></H1>";
//echo "<H1 ALIGN=left><font color=red>$myusername Projects</font></H1>";
echo "<H1 ALIGN=left><font color=brown><i>ProjectManager: $myusername </i></font></H1>";
//echo "<H1 ALIGN=left> <font color=red>Archived Projects-$num </font></H1>";
//echo "<br />";
//echo "<A href=project_status_reports_open.php><i>View Open Projects</i> </A>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H2 ALIGN=left><font color=red><i>Shared Project list-$num </i></font></H2>";
//echo "<H3 ALIGN=LEFT > <font color=blue>Search Results=$num </font></H3>";
//echo "<h2 ALIGN=center>";
//echo "<table border='1' cellspacing='10'>";

//echo "<tr>";
//echo "<td>";
//echo "<font size=4><b>Current</b>$num2 </font>";
//echo "</td>";
//echo "<td>";

//echo "<font size=4><b>Archived </b><A href=project_status_reports_archive.php>$num4 </A></font>";
//echo "</td>";
//echo "<td>";
//echo "<font color=red size=5><b>Active $num</b></font>";
//echo "</td>";

//echo "</tr>";
//echo "</table>";
//echo "</h2>";

//echo "<br /> <br />";


 echo "<table border=1>";
 
 
echo 

"<tr> 
       <th>manager</th>
       <th>category</th>
       <th align=left>name</th>	   
	   <th>notes</th>	   
	   <th>open</th>
	   <th>rename</th>
	   <th>Un-Share</th>
	   
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>
       <td>$user_id</td>
       <td>$project_category</td>
	   <td>$project_name</td>	   
	   <td>$notes</td>
	   <td><a href='search_notes.php?&project_category=$project_category&project_name=$project_name&user_id=$user_id'>open</a></td>
	   <td><a href='rename_project.php?&project_category=$project_category&project_name=$project_name'>rename</a></td>
	   <td><a href='unshare_project.php?&project_category=$project_category&project_name=$project_name&user_id=$user_id'>Un-share</a></td>
	   
	   
	   
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>
