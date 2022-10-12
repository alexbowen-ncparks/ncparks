<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_note_id=$_POST['project_note_id'];

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_note_id='$project_note_id'  group by project_note_id";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL
 ////mysql_close();
 
 $row=mysqli_fetch_array($result);
 extract($row);
   
echo "<html>";
echo "<head>";
echo "<title>Edit Record</title>";
echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Notebook:$project_category $project_name</i>-<font color=red>(Edit Record)</font> </font></H1>";
//echo "<H1 ALIGN=CENTER > <font color=red>Update project_note_id $project_note_id</font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br/>";


echo "<form name='form1' method='post' action='edit_notes_update.php'>";

echo "<font color=blue size=5>";



//echo "<br />user:<input name='user' type='text' id=user value=\"$user\">";
//echo "system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />project_category:<input name='project_category' type='text' id=category size=50 value=\"$project_category\">";
//echo "<br />project_name:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";
echo "<br />Note&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name='project_note' cols='80' rows='10'>$project_note</textarea>";
echo "<br />Weblink<textarea name='weblink' cols='80' rows='2' >$weblink</textarea>";
//echo "<br />project_note_id:<input name='project_note_id' type='text' id=project_note_id value=\"$project_note_id\">";

echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	
echo "<input type='hidden' name='user' value='$user'>";	
echo "<input type='hidden' name='system_entry_date' value='$system_entry_date'>";	

echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='UPDATE'>";

echo "</form>";

echo "</font>";

echo "</body>";
echo "</html>";

?>

 
 
 
  















