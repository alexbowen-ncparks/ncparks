<?php
//echo "hello";

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$username=$_POST['user'];
//echo "hello2";

//echo "user=";echo $user;//exit;
$system_entry_date=$_POST['system_entry_date'];
$project_category=$_POST['project_category'];
$project_name=$_POST['project_name'];
$project_note=$_POST['project_note']; //$project_note=addslashes($project_note);
$weblink=$_POST['weblink']; //$weblink=addslashes($weblink);
$project_note_id=$_POST['project_note_id']; //$project_note_id=addslashes($project_note_id);


//echo $question;
//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$table="project_notes";


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo $user;
$query="update $table set user='$username', 
system_entry_date='$system_entry_date',project_category='$project_category', project_name='$project_name',
project_note='$project_note',
weblink='$weblink'
where project_note_id='$project_note_id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

$query2="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name' and user='$username'  order by project_note_id asc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num2=mysqli_num_rows($result2);

 ////mysql_close();

 
echo "<html>";

echo "<head>
<style>

TABLE { background-color: #B4CDCD }
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";


//echo "<body bgcolor=#FFFFb4>";

echo "<H1 ALIGN=LEFT > <font color=red><i>$project_category $project_name</i> </font></H1>";



echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br/><br/>";


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
while ($row=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

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
	   <input type='submit' name='submit' value='Delete_File'>
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
	   <input type='submit' name='submit' value='Delete $project_note_id'>
	   </form>
	   
	   
	   </td>    
	      
	   
</tr>";



}

 echo "</table></body></html>";

 ?>















