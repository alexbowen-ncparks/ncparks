<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$user_id=$_REQUEST['user_id'];

//echo "value='$project_category' ";
//echo "value='$project_name' ";

//exit;



$table="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name'  and user='$tempid'  order by note_number,system_entry_date,project_note_id asc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


// frees the connection to MySQL
 ////mysql_close();
//echo $num;
 
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

//echo "<body bgcolor=>";

echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>ProjectName:$project_category $project_name-($num Notes)</i> </font></H1>";



//echo "<br/><br/>";


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




















