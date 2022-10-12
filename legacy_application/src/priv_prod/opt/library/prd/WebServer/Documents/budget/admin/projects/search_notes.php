<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$user_id=$_REQUEST['user_id'];

//echo "project_category='$project_category' ";
//echo "project_name='$project_name' ";
//echo "user_id='$user_id' ";




include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name'  and user='$user_id'  order by project_note_id desc";

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
body { background-color: cornsilk; }
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	

</head>";

//echo "<body bgcolor=>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Notebook:$project_category $project_name-($num Records)</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";




//echo "<br/><br/>";
//echo "<table border=1>";
 


//echo "<tr> 
//<td>
	//echo   "<form method='post' action='duplicate_notes.php'>
	   //<input type='hidden' name='project_note_id' value='project_note_id'>	   
	   //<input type='submit' name='submit' value='Add'>
	   //</form>";
	  echo "<table border=1>";
      echo "<tr>"; 
     
	   echo   "<td><form method='post' action='duplicate_notes.php'>
	<input type='hidden' name='project_category' value='$project_category'>	   
	<input type='hidden' name='project_name' value='$project_name'>	   
	<input type='hidden' name='user_id' value='$user_id'>	   
	<input type='submit' name='submit' value='Add_Record'>
	 </form></td>";
	  
	//    echo   "<td><form method='post' action='add_spreadsheet1.php'>
//	<input type='hidden' name='project_category' value='$project_category'>	   
//	<input type='hidden' name='project_name' value='$project_name'>	   
//	<input type='hidden' name='user_id' value='$user_id'>	   
//	<input type='submit' name='submit' value='Add_Spreadsheet'>
//	 </form></td>";
	 
	 echo "</tr></table>";
	 
	   echo "<br />";
	   
	   
	   //</td>
	  // </tr>";
	//echo "</table>";
 echo "<table border=1>";
 
echo 

"<tr>
       
       <th><font color=blue>Date</font></th>   
	   <th><font color=blue>Name</font></th>
       <th><font color=blue>Note</font></th>
       <th><font color=blue>Weblink</font></th>
	   <th><font color=blue>Document</font></th>
       <th><font color=blue>Record</font></th>
       
                
       
 

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
	   if(!empty($weblink)){ 
  	   
	   echo "<td>
	   <form method='post' action='view_weblink.php'>
	   <input type='hidden' name='weblink' value='$weblink'>	   
	   <input type='submit' name='submit' value='visit'>
	   </form>
       </td>";
	}
	
	else {
	echo "<td>
	   <form method='post' action='edit_notes.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Add'>
	   </form>
	   
       </td>";	
	
	};
	   if(!empty($link)){ 
  	   
	   echo "<td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>	   
	   <input type='submit' name='submit' value='View'>
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
	   <input type='submit' name='submit' value='Add'>
	   </form>
	   
       </td>";	
	
	};
	
	
	
	      
	  echo "

	   <td>	   
	   <form method='post' action='edit_notes.php'>
	   <input type='hidden' name='project_note_id' value='$project_note_id'>	   
	   <input type='submit' name='submit' value='Edit'>	   
	   </form>
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
 

 
 ?>
















