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
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];

//echo $project_category;
//echo $project_name;




$table1="weekly_updates";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query1="SELECT max(end_date)as 'max_date' from weekly_updates where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) from table=weekly_updates as variable=$max_date

//echo $max_date;
$query2="SELECT * from weekly_updates where end_date='$max_date'";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);//brings back 4 variables: $fiscal_year,$start_date,$end_date,$complete from 
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
echo "<H1 ALIGN=LEFT > <font color=brown><i>Weekly Updates</font></i></H1>";
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
echo "</form>";

echo "<br /><br />";


$query3="SELECT * FROM project_notes2 where 1 and project_category='$project_category' and project_name='$project_name'  order by note_number,system_entry_date,project_note_id asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
////mysql_close();
echo "<table border=1>";
 
echo 

"<tr> 
       
       <th>Date</th>   
	   <th>author</th>
       <th>Description</th>
       <th<font color=red>Document</font></th>
       <th<font color=red>WebLink</font></th>
       <th<font color=red>Status</font></th>
       
                
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_assoc($result3)){
$weekly_update[]=$row3;
}

//echo "<pre>weekly update  ";print_r($weekly_update);echo "<pre>";exit;

$includeArray=array("project_note","link","weblink","status");

foreach($weekly_update[0] as $k=>$v){
	if(!in_array($k,$includeArray)){continue;}
		$headerArray[]=$k;
		//$k=str_replace("_"," ",$k);
		//$header.="<th>$k</th>";
		}

echo "<pre>";print_r($headerArray);echo "</pre>";exit;






if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo 
	
"<tr$t>	

       
       <td>$system_entry_date</td>
       <td>$author</td>
	   
	   <td>$project_note</td>
	   <td>
	   <form method='post' action='view_link.php'>
	   <input type='hidden' name='link' value='$link'>	   
	   <input type='submit' name='submit' value='View'>
	   </form>
	   </td>
	   <td>
	   <form method='post' action='view_weblink.php'>
	   <input type='hidden' name='weblink' value='$weblink'>	   
	   <input type='submit' name='submit' value='visit'>
	   </form>
       </td>";
   
echo "<td> <font color=$fcolor1>$status</font></td>
	   
	      
</tr>";





echo "</table></body></html>";

?>

























