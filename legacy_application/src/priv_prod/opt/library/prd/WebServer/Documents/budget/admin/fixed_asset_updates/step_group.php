<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="SELECT max(end_date)as 'end_date' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date


$query2="SELECT max(start_date)as 'start_date' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);//brings back max (start_date) as $start_date

$query3="SELECT max(fiscal_year)as 'fiscal_year' from project_steps where 1
         and project_category='$project_category' and project_name='$project_name' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
include("report_menu.php"); // salt phrase
if($project_name==pcard_updates){
$query4="select count(distinct transid_new) as 'pcu_count' from pcard_unreconciled where reconciled='n'";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
echo
"<form>";
echo "<font size=5>"; 
echo "<H3 align='left'><font color='red'>Pcard Unreconciled Count:</font><input name='pcu_count' type='text' value='$pcu_count' readonly='readonly' size='5'></H3>";
echo "<br />";
echo "</form>";
}
//echo "<br /><br />";


$query5="SELECT * FROM project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

////mysql_close();
echo "<table border=1>";
 
echo 

"<tr> 
       
       
       <th>StepNum</th>
       <th>StepName</th>
       <th><font color=red>Action</font></th>";
    //  echo " <th<font color=red>TimeStart</font></th>
     //  <th<font color=red>TimeEnd</font></th>
     //  <th<font color=red>TimeElapsed</font></th>
    echo "<th><font color=red>Status</font></th>";
                
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
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
	   <form method='post' action='step$step_group$step_num.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>	   
	   <input type='submit' name='submit1' value='Update'>
	   </form>
       </td>";
	   
 	echo "<td> <font color=$fcolor1>$status</font></td>
	      
</tr>";



}

echo "</table></body></html>";

?>

























