<?php

session_start();
$myusername=$_SESSION['myusername'];
$level=$_SESSION['level'];

if(!isset($myusername)){
header("location:index.php");
}
if(($level < '5')){header("location:index.php");
} 

include("../../include/connect.php");


//$project_note_id=$_POST['project_note_id'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$user=$_POST['user_id'];

//$user=$myusername;


//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "user=$user";






//$database="mamajone_cookiejar";
//$table="members";

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

//$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name' and user='$user'  group by project_note_id";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
//$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
//$num=mysqli_num_rows($result);

// frees the connection to MySQL


//////mysql_close();

//$row=mysqli_fetch_array($result);
// extract($row);
 
 
echo "<html>";
echo "<head>";
echo "<title>Add Record</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Add Player</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";


echo "<form name='form1' method='post' action='add_player2.php'>";
echo "<font color=blue size=5>";
echo  "Player<input name='player' type='text' id='player'>";
echo  "Pass<input name='pass' type='text' id='pass'>";

echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='ADD New Player'>";

echo "</form>";


echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";



?>