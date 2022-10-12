<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$today=date("Ymd");
//echo $today;exit;
if($start_date==""){$start_date=$today;}
if($end_date==""){$end_date=$today;}	

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters

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

echo "<table border=1>";
echo "<tr><td><H3><font color=blue>Current View:</font> <font color=red>User_Activity_summary_by_daterange</font></H3></td></tr>";
echo "<tr><td></td></tr>";
echo "<tr><td>Other Views</td></tr>";
	 
//echo "<tr><td><A href=/budget/admin/user_activity/user_activity_detail.php> User Activity by Level </A></td></tr>";
//echo "<tr><td><A href=/budget/admin/user_activity/user_activity_detail_day.php> User Activity by Day </A></td></tr>";
echo "<tr><td><A href=/budget/admin/user_activity/user_activity_detail_by_daterange.php> User Activity Detail by Daterange </A></td></tr>";
echo "</table>";

echo "<br /><br />";
//$query1="SELECT distinct(project_name) FROM project_steps where 1  order by project_name asc";
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);


//echo "<br /><br />";


//if($project_name !=""){$query3="SELECT * FROM project_substeps_detail where 1 and project_name='$project_name' order by project_name,step_group,step_num,substep_num asc";}
//else {$query3="SELECT * FROM project_substeps_detail where 1  order by project_name,step_group,step_num,substep_num asc ";}



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.

//////mysql_close();

	// echo "</table>";
	
	//echo "start_date=$start_date <br />end_date=$end_date";exit;
	echo"<form method=post action=user_activity_summary_by_daterange.php>";
	 echo "<table border=1>";
	 echo "<tr><td>start_date</td><td>end_date</td></tr>";
	 echo "<tr>";

echo"<td><input type='text' name='start_date' value='$start_date'>";
echo"<td><input type='text' name='end_date' value='$end_date'>";
echo"<td><input type='submit' name='submit' value='Submit'>";
echo "</form></td>";
echo "</table>";
/*echo "<tr>";
echo "<td colspan='2' align='center>";
echo "<input type=submit value=Submit>";
echo "</td>";
echo "</tr>";
echo "</form>";
 */
echo	"</table>";

echo "<br /><br />"; 


$query2a="truncate table activity2";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

$query2b="insert into activity2(tempid,user_level,location,filename,time1,time2)
          select tempid,user_level,location,filename,time1,time2
		  from activity where 1 and tempid != '' group by tempid,user_level,location,filename,time1";
$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");

$query2c="select count(id) as 'pages_used' from activity2 where 1 and 
time2>='$start_date' and time2<= '$end_date' ";
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c");
$row2c=mysqli_fetch_array($result2c);
extract($row2c);







$query3="SELECT tempid, user_level, location, count( id ) as 'count'
FROM `activity2`
WHERE 1 AND time2>='$start_date' and time2<='$end_date'
GROUP BY tempid
ORDER BY `tempid` ASC ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<font color='red'>Users: $num3</font>";
echo "<br />";
echo "<font color='red'>Pages Used: $pages_used</font>";
/*echo "<tr>"; 
     
	   echo   "<td><form method='post' action='duplicate_project_substeps_detail.php'>
	 <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>  
	<input type='submit' name='submit' value='Add_Record'>
	 </form></td></tr>";*/
echo "<table border=1>";
 
echo 

"<tr> 
       <th><font color=blue>tempid</font></th>
       <th><font color=blue>user_level</font></th>
       <th><font color=blue>location</font></th>
       <th><font color=blue>count</font></th>
       </tr>";
	   




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

	   
	   <td>$tempid</td>
	   <td>$user_level</td>
	   <td>$location</td>
	   <td>$count</td>
</tr>";
	   	   
/*	   
	echo"<td>	   
	   <form method='post' action='edit_project_substeps_detail.php'>
	   <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>   
	   <input type='submit' name='submit' value='Edit$cid'>	   
	   </form>
	   <form method='post' action='edit_project_substeps_detail_delete_verify.php'>
	   <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>  
	   <input type='submit' name='submit' value='Delete$cid'>
	   </form>	
       <form method='post' action='edit_project_substeps_detail_duplicate.php'>
	   <input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>  
	   <input type='hidden' name='link' value='$link'>  
	   <input type='hidden' name='weblink' value='$weblink'>  
	   <input type='hidden' name='status' value='$status'>  
	   <input type='submit' name='submit' value='Duplicate$cid'>
	   </form>	 	   
	   </td>";
  	  */ 
     



}
echo "</table></body></html>";
//}
//else {exit;}


?>

























