<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}
$system_entry_date=date("Ymd");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//$project_note_id=$_POST['project_note_id'];
//echo $project_note_id;
//exit; 
include("../../include/connect.php");

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="project_documents";

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


echo "<html>";
echo "<head> <title>document_add</title></head>";

if($record_insert == ""){

echo "record_insert=$record_insert";
echo "<br />";
echo "project_note_id=$project_note_id";
echo "<br />";
echo "project_category=$project_category";
echo "<br />";
echo "project_name=$project_name";
echo "<br />";
echo "project_note=$project_note";



echo "<body>";
echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr bgcolor='yellow'>";
//echo "<th align=left><font color=brown>Download from Community</font></th>";
echo "<th align=left ><font color=brown>Add your own</font></th>";
echo "</tr>";		  
echo "</table>";
echo "<br />";
//echo "<h1>Document Description</h1>";
echo "<form  method='post' action='document_add.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Category</font></th><th><font color='brown'>Group</font></th><th><font color='brown'>Description</font></th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='project_category' type='text' size='30' id='project_category' value='$project_category' ></td>
             <td><input name='project_name' type='text' size='30' id='project_name'></td>
             <td><textarea name= 'project_note' rows='2' cols='20' ></textarea></td>
             <td><input type=submit name=record_insert submit value=add></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
echo "</form>";
echo "</body>";
exit;}

if($record_insert != "")
{

if($project_category==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_name==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}
if($project_note==""){echo "<font color='red' size='5'>Error Message:</font> <font color='blue'>Form is missing Values. Please enter Values for all Form boxes</font><br />Click the BACK button on your Browser to return to the Form";exit;}


$query12="insert into project_documents(user,system_entry_date,project_category,project_name,project_note)
values('$myusername','$system_entry_date','$project_category','$project_name','$project_note')";


$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="select max(project_note_id) as 'project_note_id' from project_documents where user='$myusername' ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$row13=mysqli_fetch_array($result13);

extract($row13);

echo "record_insert=$record_insert";
echo "<br />";
echo "project_note_id=$project_note_id";
echo "<br />";
echo "project_category=$project_category";
echo "<br />";
echo "project_name=$project_name";
echo "<br />";
echo "project_note=$project_note";
echo "<body>";


echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";

exit;
}

/*
if($project_note_id != ""){
echo "<body>";


echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";
exit;}
*/
echo "</html>";

?>