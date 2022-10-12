<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="project_notes";
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
<title>Games</title>";

include ("css/test_style.php");


echo "</head>";
include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
/*
$query4="select distinct project_category from $table where 1 
         and user='$myusername' and weblink != ''
         order by project_category";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

//echo "<html>";

 if($category_selected !='y') 
 
{
//echo "<h2 ALIGN=left><font color=green>WebGroups:$num4</font></h2>";

//

*/
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr>
          <th align=left><font color=brown>Favorite Games</font></th><th><A href='game_add.php?&add_your_own=y'>ADD</A></th>

</tr>";		  
echo "</table>";
/*
echo "<table border=1>";

while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='pages_menu.php?&project_category=$project_category&category_selected=y'>$project_category</a></td> 
	          
</tr>";

}

 echo "</table>";
 echo "<h3><A href='webpage_add.php'>ADD</A></h3>";
 exit;
}

if($category_selected =='y')
{

$query5="SELECT *
FROM $table
WHERE 1 and user='$myusername'
and project_category='$project_category'
and weblink != ''
ORDER BY user,project_category,project_name ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

echo "<h3 ALIGN=left><font color=green>$project_category articles:$num5</font></h3>";

echo "<table border=1>";

echo 

"<tr> 
       
       <th align=left><font color=brown>title</font></th>
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

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       
           <td>$project_name</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
           <td>$system_entry_date</td>
           <td>$project_note_id</td>
		   <td><a href='rename_webpage.php?&project_note_id=$project_note_id' target='_blank'>rename</a></td>
		   <td><a href='copy_webpage.php?&project_note_id=$project_note_id' target='_blank'>share</a></td> 
		   <td><a href='delete_webpage_verify.php?&project_note_id=$project_note_id' target='_blank'>delete</a></td>
           
           
      
           
              
           
</tr>";




}

 echo "</table>";
  echo "<h3><A href='webpage_add.php?&add_your_own=y'>ADD</A></h3>";
 
 echo "</body></html>";


 


}
else {exit;}
*/
echo "</html>";

?>



















	














