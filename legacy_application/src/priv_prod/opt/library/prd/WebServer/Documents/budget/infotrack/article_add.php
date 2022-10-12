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

//$table="projects";
//$table2="project_notes";
//$table3="project_notes_count";
//$table4="members";

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";

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
echo "<html>";
echo "<head>
<title>Articles</title>";

include ("css/test_style.php");
/*
<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>
*/
echo "</head>";
include("widget1.php");//exit;

//echo "<body bgcolor=#FFF8DC>";
//echo "<H1 ALIGN=left > <font color=brown><i>Articles-$project_category</i></font></H1>";
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";


/*echo "Category<input name='project_category' type='text' id=project_category size='30'>";
echo "<br />";
echo "Topic&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_name' type='text' id=project_name size='30'>";
echo "<br />";
//echo "Name&nbsp&nbsp&nbsp&nbsp&nbsp<input name='project_note' type='text' id=project_note>";
echo "Note&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name= 'project_note' rows='1' cols='40'</textarea>";

echo "<br />";

echo "Weblink<textarea name= 'weblink' rows='1' cols='40'></textarea>";

echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";
*/

if($add_your_own !='y') {exit;}
 

if($add_your_own =='y')
{

echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr>";
//echo "<th align=left><font color=brown>Download from Community</font></th>";
echo "<th align=left><font color=brown>Add your own</font></th>";
/*
echo "<th><input type=\"button\" value=\"View Categories\" onClick=\"return popitup('acctNum.php')\"></th>";

echo "var newwindow;
function poptastic(url)
{
	newwindow=window.open(url,'name','height=400,width=200');
	if (window.focus) {newwindow.focus()}
}";

echo "<a href='javascript:poptastic(poppedexample.html)'>Pop it</a>"; 
*/




if($message != ""){echo "<th align=left><font color=red>$project_category Article added</font></th>";}
//echo $message;
 
 
 
echo "</tr>";		  
echo "</table>";
echo "<br />";

//echo "<h3>Enter info in form & click Update Button</h3>";
echo
"<form method=post action=article_add2.php>";



echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Category</font></th><th><font color='brown'>Group</font></th><th><font color='brown'>Description</font></th><th><font color='brown'>Web Address</font></th><th><font color='brown'>Update</font></th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='project_category' type='text' size='30' id='project_category' value='$project_category' ></td>
             <td><input name='project_name' type='text' size='30' id='project_name'></td>
             <td><textarea name= 'project_note' rows='2' cols='20' ></textarea></td>
             <td><textarea name= 'web_address' rows='2' cols='20'></textarea></td>
			 <td><input type=submit name=submit value=Personal update><input type=submit name=submit value=Community update></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 echo "</form>";
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 

     echo "</body>";
     echo "</html>";

}
else {exit;}	 
	 
	 
?>





