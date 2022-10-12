<?php

session_start();
$myusername=$_SESSION['myusername'];
$level=$_SESSION['level'];


if(!isset($myusername)){
header("location:index.php");
}
if(($level < '5')){header("location:index.php");
} 
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//$user_id=$_REQUEST['user_id'];

//echo "project_category='$project_category' ";
//echo "project_name='$project_name' ";
//echo "user_id='$user_id' ";




include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="members"; // Table name



////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 order by id desc";

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
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	

</head>";

//echo "<body bgcolor=>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Notebook Users:-($num Records)</i> </font></H1>";
echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";




echo "<br/><br/>";
echo "<table border=1>";
 
      echo "<tr>"; 
     
	   echo   "<td><form method='post' action='add_player1.php'>
	<input type='submit' name='submit' value='Add New User'>
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
       
       <th><font color=blue>id</font></th>   
	   <th><font color=blue>username</font></th>
       <th><font color=blue>pass</font></th>
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

       
       <td>$id</td>
       <td>$username</td>
	   
	   <td>$password</td>";
	     
	      
	  echo "

	   <td>	   
	   <form method='post' action='edit_user.php'>
	   <input type='hidden' name='user_id' value='$id'>	   
	   <input type='submit' name='submit' value='Edit'>	   
	   </form>
	   <form method='post' action='edit_users_delete_verify.php'>
	   <input type='hidden' name='user_id' value='$id'>	   
	   <input type='submit' name='submit' value='Delete'>
	   </form>	   
	   </td>
	   
	    
	      
	   
</tr>";



}

 echo "</table></body></html>";
 

 
 ?>




















