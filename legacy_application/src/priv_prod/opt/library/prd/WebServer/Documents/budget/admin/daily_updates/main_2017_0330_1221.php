<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

if($reset=='y')
{
//echo "write re-set query<br /><br />";

$query1="update project_steps set status_previous=status
         where project_category='$project_category' and project_name='$project_name' ";

//echo "query1=$query1<br /><br />";	
$result1 = mysql_query($query1) or die ("Couldn't execute query1. $query1");

$query1a="update project_steps_detail set status_previous=status
         where project_category='$project_category' and project_name='$project_name' ";

//echo "query1a=$query1a<br /><br />";

$result1a = mysql_query($query1a) or die ("Couldn't execute query1a. $query1a");

$query1b="update project_steps set status='pending'
         where project_category='$project_category' and project_name='$project_name' ";

//echo "query1b=$query1b<br /><br />";		 

$result1b = mysql_query($query1b) or die ("Couldn't execute query1b. $query1b");
	
$query1c="update project_steps_detail set status='pending'
         where project_category='$project_category' and project_name='$project_name' ";

//echo "query1c=$query1c<br /><br />";	

$result1c = mysql_query($query1c) or die ("Couldn't execute query1c. $query1c");



	
//$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

//$row2=mysql_fetch_array($result2);
//extract($row2);//brings back max (start_date) as $start_date

}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

//echo "project_category=$project_category<br /><br />";
//echo "project_name=$project_name<br /><br />";

/*
$query1="SELECT max(end_date)as 'end_date' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date


$query2="SELECT max(start_date)as 'start_date' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysql_fetch_array($result2);
extract($row2);//brings back max (start_date) as $start_date

$query3="SELECT max(fiscal_year)as 'fiscal_year' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysql_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year
*/
//include("../../../budget/menus2.php");
include("../../../budget/menu1314.php");
//echo $max_date;
//$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysql_fetch_array($result2);
//extract($row2);//brings back 4 variables: $fiscal_year,$start_date,$end_date,$complete from 
               //table=weekly_updates for record with max(end_date) to be displayed on Form Header
//echo $start_date."to".$end_date."for".$fiscal_year;

echo "<html>";
echo "<head>";
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to Start Over?')
 return (bConfirm);
}
";
echo "</script>";

echo "</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<h1> <font color=brown><i>$project_name</font></i></h1>";
echo "<br />";
//echo "<table align='center'><tr><th><i>$project_name</font></i></th></tr></table>";

echo "<table align='center'><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown' size='5'>Cash Handling<br /><br />Administrator Daily Update</b></font><a href=\"main.php?project_category=$project_category&project_name=$project_name&reset=y\" onClick='return confirmLink()'><img height='75' width='75' src='/budget/infotrack/icon_photos/mission_icon_photos_204.jpg' alt='picture of bank'></img></a></th></tr></table>";
echo "<br /><br />";













//echo "<h2><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></h2>";

echo "<br />";
//echo "<table>";
/*
echo
"<form align='center'>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:&nbsp&nbsp<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";

//echo "</table>";
*/
//echo "<br /><br />";
echo "<table align='center'>";
echo "<tr>";
echo "<td>";
echo"  <form method='post' action='add_stepgroup.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='submit' name='submit' value='Add_StepGroup'>
	   </form>";
echo "<br />";       
echo "</td></tr></table>";


/*
include("time_elapsed_project_steps.php");
*/

$query3="SELECT * FROM project_steps where 1 and project_category='$project_category'
         and project_name='$project_name' order by step_group asc";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

/*
$query19 = "select sum(time_elapsed_min) as 'total_elapsed_time' from project_steps
         where project_category='$project_category' and project_name='$project_name' ";

$result19 = mysql_query($query19) or die ("Couldn't execute query 19.  $query19");

*/

//$row19=mysql_fetch_array($result19);
//extract($row19);//brings back max (fiscal_year) as $fiscal_year

//echo "<br />total_elapsed_time=$total_elapsed_time";


mysql_close();
echo "<table border=1 align='center'>";
 
echo 

"<tr> 
       
       
       <th>StepGroup</th>
       <th>Step</th>
       <th><font color=red>Action</font></th>";
    //  echo " <th<font color=red>TimeStart</font></th>
     //  <th<font color=red>TimeEnd</font></th>
     //  <th<font color=red>TimeElapsed</font></th>
	 
	 
    echo "<th><font color=red>Status</font></th>";
   // echo "<th><font color=red>TimeComplete</font></th>";
   // echo "<th><font color=red>Time<br />Minutes</font></th>";
                
  
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3)){

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

       
       
	   
	   <td align='center'>$step_group</td>
	   <td>$step</td>";
/*
echo "<td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>";	   
//echo "<input type='submit' name='submit' value='View'>";
echo "</form>
	   </td>
*/	   
echo   "<td>
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
       </td>";
   
      
 /*  echo "<td> 
	 <form method='post' action='time_update.php'>
	 <font color=$fcolor1>
	 <input type='text' name='time_start' value='$time_start'>
	 <input type='hidden' name='project_category' value='$project_category'>
	 <input type='hidden' name='project_name' value='$project_name'>
	 <input type='hidden' name='end_date' value='$end_date'>	 
	 <input type='hidden' name='id' value='$id'>
	 <input type='submit' name='submit' value='edit'>
	 </font>
	 </form>
	 </td>
	 
	 <td> 
	 <form method='post' action='time_update.php'>
	 <font color=$fcolor1>
	 <input type='text' name='time_end' value='$time_end'>
	 <input type='hidden' name='project_category' value='$project_category'>
	 <input type='hidden' name='project_name' value='$project_name'>
	 <input type='hidden' name='end_date' value='$end_date'>	 
	 <input type='hidden' name='id' value='$id'>
	 <input type='submit' name='submit' value='edit'>
	 </font>
	 </form>
	 </td>	 
	 
     
     <td> <font color=$fcolor1>$time_elapsed</font></td>";
	 
*/ 
//	echo "<td> <font color=$fcolor1>$status</font></td>";
	echo "<td>$status</font></td>";	
//	echo "<td>$time_complete</td>";
//	echo "<td>$time_elapsed_min</td>";
	      
echo "</tr>";

}
/*
while ($row19=mysql_fetch_array($result19)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row19);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total Elapsed</td> 	
           <td>$total_elapsed_time</td> 
           
			  
			  
</tr>";

}

*/



echo "</table></div></body></html>";

?>


























