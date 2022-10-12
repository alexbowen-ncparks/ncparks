<?php
session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location: http://mamajo.net/blogs/login.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<html>";
//echo "Hello";
include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_blogs";
$table="code_editor";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

//include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

echo "<html>";






//include("report_header1.php");
echo "<br />";

echo "<body>";
 


$query4d="select * from code_editor 
         where 1 and id='$id'
         
		 ";
		 
		 
//echo "and comment_id='$project_note_id'  $order2 ";

//echo $query4c;exit;		 
$result4d = mysqli_query($connection, $query4d) or die ("Couldn't execute query 4d.  $query4d");
$num4d=mysqli_num_rows($result4d);
if($num4d > '0')

{


//echo "<table>";
//echo "good bye 1720";exit;
//echo "<tr><td><font color='brown'>Member</font></td><td><font color='brown'>Comment</font></td></tr>";
//echo "<form method='post' action='code_edit_update.php'>";
//echo "<tr><td><input type='submit' name='submit' value='Update_Note'></td></tr>";
while ($row4d=mysqli_fetch_array($result4d)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4d);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


//echo "<tr$t>"; 
//echo "<td>$rank</td>"; 
 //echo "<td><font color='brown'>$user</font></td>";
 /*
if($id==$note_edit)

{
echo "<form method='post' action='code_edit_update.php'>";
echo "<td><textarea name= 'comment_note' rows='5' cols='80' >$comment_note</textarea></td>";
echo "<td><input type='submit' name='submit' value='Update_Note'>
          <input type='hidden' name='id' value='$id'>
          <input type='hidden' name='project_category' value='$project_category'>
          <input type='hidden' name='project_name' value='$project_name'>
          <input type='hidden' name='note_group' value='web'>
          <input type='hidden' name='project_note' value='$project_note'></td>";
echo "</form>";
echo "</tr>";
}

else
*/
{ 
//echo "hello line 205";

//echo "<td>$code</td>";

echo $code;

       
}

}

 //echo "</table>";
 }

 
 /*
 
 echo "<br /><br />";
 echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
echo "</tr>";

//echo "<td></td>";
echo "<form method=post action=comment_add.php>";
echo "<td><textarea name= 'comment_note' rows='5' cols='50' ></textarea></td>";            
      
	  
	 echo "<td><input type=submit name=submit value=Add_Note></td>";
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "</form>";
echo "</tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	 // echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 
echo "</table>"; 
 */
 //echo "color=$color";
 //echo "<a href='$location' target='_blank'>Page</a>";
 echo "</body>";
echo "</html>";
 
exit;
?>