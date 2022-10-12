<?php
session_start();

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//$database="budget";
$table="table_updates";
$myusername=$_SESSION['budget']['tempID'];

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
////mysql_connect($host,$user,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT step_group,step_number,status
FROM $table
WHERE 1 
ORDER BY step_group,step_number ";

//echo "$query"; 

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);
//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

 
echo "<html>";

echo "<body bgcolor=#FFFFb4>";
echo " <font color=red size=5><i>UPDATE TABLES</i> </font>";
echo "<br />";
echo "<br />";

echo "<H3 ALIGN=LEFT > <font color=blue>Search Results=$num </font></H3>";
 



//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";



 echo "<table border=1>";
 
echo 

"<tr> 
       <th>step_group</th>
       <th>step_number</th>
       <th>status</th>
	   <th>submit</th>
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);




echo 

"<tr>

       <td>$step_group</td>
	   <td>$step_number</td>
	   <td>$status</td>
	   <td>
	   <form method='post' action='update_tables_a10_1.php'>
	   <input type='submit' name='submit' value='submit'>
	   </form>
	   </td>
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>






















