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
$table4="members";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");



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

$query9="select * from $table4 where 1 and username='$myusername' ";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");


$row=mysqli_fetch_array($result9);

extract($row);

$level=$projects;



$query="SELECT user_id,project_category,project_name,project_type,created,share_provider,notes,project_id
FROM $table
WHERE 1 
and project_status = 'open'
and project_type='private'
ORDER BY user_id,project_category,project_name ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


$query2="SELECT project_id
from $table
WHERE 1 
and project_status='open'
and project_type='private'
";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$num2=mysqli_num_rows($result2);

$query8="SELECT project_id
from $table
WHERE 1 and project_type='share'";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$num8=mysqli_num_rows($result8);



$query4="SELECT project_id
from $table
WHERE 1 
and project_status='archive'
and project_type='private'
";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$num4=mysqli_num_rows($result4);

$query5="SELECT project_id
from $table
WHERE 1 
";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$num5=mysqli_num_rows($result5);

//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

if($rep==""){ 
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
echo "<H1 ALIGN=left><font color=brown><i>ProjectManager: Admin-$myusername &nbsp&nbsp Level($level) </i></font></H1>";
//echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";



//echo $level;exit;

if(($level=='5')){ 
  	   
	   echo "<font size=4><b><A href='admin1.php'>Administrator</b></A></font>";}
	   

echo "<br /><br />";

echo "<font size=4><b><A href='project_add.php'>Add New Project</A></b></font>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
//echo "<br /><br />";
echo "<font size=4><b><A href='project_status_reports_archive.php'>Go to Archive Projects </b></A></font>";




echo "<br /><br />";
echo "<font size=4><b><A href='project_share_add_admin.php'>Shared Projects-$num8</A></b></font>";

echo "<H2 ALIGN=left><font color=green><i>Private Projects (Active)-$num2 </i></font></H2>";
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

}
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=curren_year_budget.xls');
}

 echo "<table border=1>";
 
 
echo 

"<tr> 
       <th>manager</th>
	   <th>category</th>
       <th align=left>name</th>	
       <th align=left>type</th>		   
       <th>created</th>
	   <th>notes</th>
	   <th>open</th>
	   <th>rename</th>
	   <th>archive</th>
	   <th>share</th>
       <th>delete</th>
              
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
	   <td>$project_type</td>	   
	   <td>$created</td>
	   <td>$notes</td>
	   
	   <td><a href='search_notes.php?&project_category=$project_category&project_name=$project_name&user_id=$user_id'>open</a></td>
	   <td><a href='rename_project.php?&project_category=$project_category&project_name=$project_name'>rename</a></td>
	   <td><a href='archive_project.php?&project_id=$project_id'>archive</a></td>	   
	   <td><a href='copy_project.php?&project_id=$project_id&project_category=$project_category&project_name=$project_name&notes=$notes'>share</a></td>	   
	   <td><a href='delete_project_verify.php?&project_category=$project_category&project_name=$project_name'>delete</a></td>
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>




















