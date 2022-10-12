<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");
$project_status=$_POST['project_status'];
$database="mamajone_cookiejar";
$table="projects";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT user_id,project_category,project_name,project_status,project_id 
FROM $table
WHERE 1 and user_id='$myusername' and project_status='archive'
and project_type='private'
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

echo "<head>

<title>Welcome</title>
<style>

body { background-color: #FFF8DC; }
form { background-color: white; font-color: blue; font-size: 15;}
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}


//h1 { background-color: white; font-color: red; }



</style>

</head>";

//echo "<body bgcolor=#FFFFb4>";



//echo "<H1 ALIGN=left><font color=brown><i>ProjectManager: $myusername </i></font></H1>";
echo "<H1 ALIGN=left><font color=brown><i>Notebook</i></font></H1>";

//echo "<H1 ALIGN=left> <font color=red>Archived Projects-$num </font></H1>";
//echo "<br />";
//echo "<A href=project_status_reports_open.php><i>View Open Projects</i> </A>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H2 ALIGN=left><font color=red><i>Private Notebooks (Archived)</i>-$num </font></H2>";
//echo "<H3 ALIGN=LEFT > <font color=blue>Search Results=$num </font></H3>";



//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";



 echo "<table border=1>";
 
echo 

"<tr> 
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>topic</font></th>
	   <th align=left><font color=brown>change_status</font></th>
       
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}

//echo $category;
//exit;


//echo 

//"<tr>
  //     <td >$category</td> 
  //     <td >$topic</td> 
  //     <td>$view_records</td>
       
//</tr>";

echo 

"<tr$t>

       <td>$project_category</td>
	   <td>$project_name</td>
	   <td><a href='update_project_status_open.php?&project_id=$project_id'>re-open</a></td>
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>






















