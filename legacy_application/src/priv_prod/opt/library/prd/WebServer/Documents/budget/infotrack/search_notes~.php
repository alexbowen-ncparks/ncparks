<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];

//echo "value='$project_category' ";
//echo "value='$project_name' ";

//exit;


include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name'  and user='$myusername' order by project_note_id asc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL
 ////mysql_close();

 
echo "<html>";
echo "<body bgcolor=#FFFFb4>";
echo "<H1 ALIGN=LEFT > <font color=red><i>Search Results=$num</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br/><br/>";


 echo "<table border=1>";
 
echo 

"<tr> 
       <th>user</th>
       <th>system_entry_date</th>
       <th>project_category</th>
	   
	   <th>project_name</th>
	   
       <th>project_note</th>
       <th>audiovisual</th>
	   <th<font color=red>weblink</font></th>
       <th>project_note_id</th>
                
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);


echo 

"<tr>
       <td >$user</td> 
       <td>$system_entry_date</td>
       <td>$project_category</td>
	   <td>$project_name</td>
	   <td>$project_note</td>";
	   
	   if(!empty($link)){ 
  	   
	   echo "<td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>	   
	   <input type='submit' name='submit' value='View_audio-visual'>
	   </form>
	   <form method='post' action='document_delete_verify.php'>	   
	   <input type='hidden' name='project_note_id' value='$project_note_id'>
	   <input type='hidden' name='project_category' value='$project_category'>
	   <input type='hidden' name='project_name' value='$project_name'>
	   <input type='submit' name='submit' value='Delete_audio-visual'>
	   </form>

       </td>";
	}
	
	else {
	echo "<td>
	   <form method='post' action='document_add.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Add_audio-visual'>
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
	   <input type='submit' name='submit' value='Duplicate $project_note_id'>
	   </form>
	   
	   <form method='post' action='edit_notes.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Update $project_note_id'>
	   </form>
	   
	   <form method='post' action='edit_notes_delete_verify.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='submit' name='submit' value='Delete $project_note_id'>
	   </form>
	   
	   
	   </td>    
	      
	   
</tr>";



}

 echo "</table></body></html>";
 ?>




















