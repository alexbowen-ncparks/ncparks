<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$fiscal_year=$_REQUEST['fiscal_year'];
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
$step_group=$_REQUEST['step_group'];
//echo "fiscal_year=$fiscal_year";
//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "start_date=$start_date";
//echo "end_date=$end_date";
//echo "step=$step";
//exit;




$table1="weekly_updates_steps_detail";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

//$query2="UPDATE weekly_updates_steps_detail where step='$step' and end_date='$end_date'";
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysqli_fetch_array($result2);
//extract($row2);//brings back 4 variables: $fiscal_year,$start_date,$end_date,$complete from 
               //table=weekly_updates for record with max(end_date) to be displayed on Form Header
//echo $start_date."to".$end_date."for".$fiscal_year;
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
echo "<H1 ALIGN=LEFT > <font color=brown><i>Weekly Updates-StepGroup A </font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";

echo "<br /><br />";


$query3="SELECT * FROM weekly_updates_steps_detail where 1 and project_category='$project_category' 
        and project_name='$project_name' and step_group='$step_group'";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

////mysql_close();
echo "<table border=1>";
 
echo 

"<tr> 
       
       
       
       <th>StepNum</th>
       <th>StepName</th>
       <th>Action</th>
       <th>Status</th>
                
       
 

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

       
       
	   
	   
	   <td align='center'>$step_num</td>
	   <td>$step_name</td>
	   <td>
	   <form method='post' action='stepa$step_num.php'>
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='submit' name='submit' value='Update'>
	   </form>
	   </td>
	   <td>$status</td>
	   ";
/*	   
	 echo  "<td>
	   <form method='post' action='view_weblink.php'>
	   <input type='hidden' name='weblink' value='$weblink'>	   
	   <input type='submit' name='submit' value='visit'>
	   </form>
       </td>
   
      
 
	 <form method='post' action='time_update.php'>
	 <font color=$fcolor1>
	 <input type='text' name='step_num' value='$step_num'>
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
	 <input type='text' name='step_name' value='$step_name'>
	 <input type='hidden' name='project_category' value='$project_category'>
	 <input type='hidden' name='project_name' value='$project_name'>
	 <input type='hidden' name='end_date' value='$end_date'>	 
	 <input type='hidden' name='id' value='$id'>
	 <input type='submit' name='submit' value='edit'>
	 </font>
	 </form>
	 </td>	 
	 
     
     <td> <font color=$fcolor1>$time_elapsed</font></td>
	 <td> <font color=$fcolor1>$status</font></td>";
	 
	*/      
echo "</tr>";



}

echo "</table></body></html>";

?>

























