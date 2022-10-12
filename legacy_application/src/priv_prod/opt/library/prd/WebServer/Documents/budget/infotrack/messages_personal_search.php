<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}

$system_entry_date=date("Ymd");
extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="project_messages";
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
<title>article search</title>";

include ("css/test_style.php");


echo "</head>";
include("widget1.php");

$query5="SELECT *
FROM $table
WHERE 1 and user='$myusername'
and (project_category like '%$search_term%' or project_name like '%$search_term%')
ORDER BY user,project_category,project_name ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<tr><th><A href='message_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";
echo "<h2 ALIGN=left><font color=brown>$search_term messages:$num5</font></h2>";

echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>group</font></th>
       <th align=left><font color=brown>description</font></th>
       <th align=left><font color=brown>date_saved</font></th>
       <th align=left><font color=brown>id</font></th>
       <th><font color=brown>rename</font></th>
	   <th><font color=brown>share</font></th>	   
       <th><font color=brown>delete</font></th>
              
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

"<tr$t>

           <td>$project_category</td>
           <td>$project_name</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
           <td>$system_entry_date</td>
           <td>$project_note_id</td>
		   <td><a href='rename_message.php?&project_note_id=$project_note_id&search_term=$search_term' target='_blank'>rename</a></td>
		   <td><a href='copy_message.php?&project_note_id=$project_note_id&project_category=$project_category' target='_blank'>share</a></td> 
		   <td><a href='delete_message_verify.php?&project_note_id=$project_note_id' target='_blank'>delete</a></td>
           
           
      
           
              
           
</tr>";




}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














