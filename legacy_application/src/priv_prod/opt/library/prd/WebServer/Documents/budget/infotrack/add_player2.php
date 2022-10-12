<?php

session_start();
$myusername=$_SESSION['myusername'];
$level=$_SESSION['level'];
if(!isset($myusername)){
header("location:index.php");
}
if(($level < '5')){header("location:index.php");
} 
$player=$_POST['player'];
//$system_entry_date=date("Ymd");;
$pass=$_POST['pass'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note']; //$project_note=addslashes($project_note);
//$weblink=$_POST['weblink']; //$weblink=addslashes($weblink);

//echo "user=$user </br>";
//echo "system_entry_date=$system_entry_date </br>";
//echo "project_category=$project_category </br>";
//echo "project_name=$project_name </br>";
//echo "project_note=$project_note </br>";
//echo "weblink=$weblink </br>";





include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="members";
$table1="projects_customformat";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query1="insert into $table(username,password) 
values ('$player','$pass')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="insert into $table1(user_id,body_bgcolor) 
values ('$player','cornsilk')";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

////mysql_close();
header("location:players1.php");
//echo "Update Successful";

//echo "<br /><br />";
/*
$query2="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name' and user='$user' order by project_note_id desc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL
 ////mysql_close();

 
echo "<html>";

echo "<head>
<style>
body { background-color: #FFF8DC; }
form { background-color: white; font-color: blue; font-size: 15;}
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}



</style>
	


</head>";

//echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=LEFT > <font color=red><i>$project_category $project_name-($num Records)</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br/><br/>";


echo   "<form method='post' action='duplicate_notes.php'>
	<input type='hidden' name='project_category' value='$project_category'>	   
	<input type='hidden' name='project_name' value='$project_name'>	   
	<input type='hidden' name='user_id' value='$project_category'>	   
	<input type='submit' name='submit' value='Add_Record'>
	 </form>";

echo "<table border=1>";
 
echo 

"<tr> 
       
       <th>Date</th>
       <th>author</th> 
	   
       <th>Description</th>
       <th>file</th>
	   <th<font color=red>weblink</font></th>
       <th>Note</th>
       <th>Note</th>
       <th>Note</th>
                
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 
	
"<tr$t>	

      
       <td>$system_entry_date</td>
       <td>$author</td>
	   
	   <td>$project_note</td>";
	   
	   if(!empty($link)){ 
  	   
	   echo "<td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>	   
	   <input type='submit' name='submit' value='View_File'>
	   </form>
	   <form method='post' action='document_delete_verify.php'>	   
	   <input type='hidden' name='project_note_id' value='$project_note_id'>
	   <input type='hidden' name='project_category' value='$project_category'>
	   <input type='hidden' name='project_name' value='$project_name'>
	   <input type='submit' name='submit' value='Delete'>
	   </form>

       </td>";
	}
	
	else {
	echo "<td>
	   <form method='post' action='document_add.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Add_File'>
	   </form>
	   
       </td>";	
	
	};
	
	if(!empty($weblink)){ 
  	   
	   echo "<td>
	   <form method='post' action='view_weblink.php'>
	   <input type='hidden' name='weblink' value='$weblink'>	   
	   <input type='submit' name='submit' value='visit website'>
	   </form>
       </td>";
	}
	
	else {
	echo "<td>
	   NONE
	   
       </td>";	
	
	};
	
	      
	  echo "<td>
	   <form method='post' action='duplicate_notes.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Add'>
	   </form>
	   </td>

	   <td>	   
	   <form method='post' action='edit_notes.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Edit'>
	   </form>
	   </td>
	   
	   <td>
	   <form method='post' action='edit_notes_delete_verify.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='submit' name='submit' value='Delete'>
	   </form>
	   
	   
	   </td>    
	      
	   
</tr>";



}

 echo "</table></body></html>";
*/

 ?>



 