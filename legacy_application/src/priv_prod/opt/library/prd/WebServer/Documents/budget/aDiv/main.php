<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";

echo "<br /><br />";
$query1="SELECT distinct(project_name) FROM project_steps where 1  order by project_name asc";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$num1=mysqli_num_rows($result1);


//echo "<br /><br />";






$query3="SELECT * FROM project_steps where 1  order by project_name,step_group asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
////mysql_close();
echo "<font color='red'>Records: $num3</font>";
echo "<table border=1>";
      echo "<tr>"; 
     
	   echo   "<td><form method='post' action='duplicate_notes.php'>
	 <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>  
	<input type='submit' name='submit' value='Add_Record'>
	 </form></td>";
echo"<td><form method=post action=main.php>";
echo "<font size=5>"; 

echo "<select name=project_name>";

 
while ($row1 = mysqli_fetch_array($result1)) {
extract($row1);

 
    echo "<option value=$row1[project_name]> 
$row1[project_name]
</option>"; 
 
}  

echo "</select></td></tr>";  
echo "<tr>";
echo "<td colspan='2' align='center>";
echo "<input type=submit value=Submit>";
echo "</td>";
echo "</form>";






	 
	 echo "</tr></table>";
	 
	   //echo "<br />";


echo "<table border=1>";
 
echo 

"<tr> 
       <th><font color=blue>fiscal year</font></th>
       <th><font color=blue>start date</font></th>
       <th><font color=blue>end date</font></th>
       <th><font color=blue>project category</font></th>
       <th><font color=blue>project name</font></th>
       <th><font color=blue>step group</font></th>
       <th><font color=blue>step</font></th>
       <th><font color=red>link</font></th>
       <th><font color=red>weblink</font></th>
       <th><font color=red>status</font></th>
       <th><font color=red>cid</font></th>";
                
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo 
	
"<tr$t>	

	   
	   <td>$fiscal_year</td>
	   <td>$start_date</td>
	   <td>$end_date</td>
	   <td>$project_category</td>
	   <td>$project_name</td>
	   <td>$step_group</td>
	   <td>$step</td>
	   
	   
	   
	   <td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>	   
	   <input type='submit' name='submit' value='View'>
	   </form>
	   </td>
	   
	   <td>
	   <form method='post' action='step_group.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='submit' name='submit' value='Update'>
	   </form>
       </td> 
       <td> <font color=$fcolor1>$status</font></td>
	   
	   <td>	   
	   <form method='post' action='edit_notes.php'>
	   <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>   
	   <input type='submit' name='submit' value='Edit'>	   
	   </form>
	   <form method='post' action='edit_notes_delete_verify.php'>
	   <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>  
	   <input type='submit' name='submit' value='Delete'>
	   </form>	   
	   </td>
  	   
       </tr>";



}

echo "</table></body></html>";

?>

























