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

$query2="SELECT xtnd_day from pcard_report_days where id='3' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);

//echo "xtnd_day=$xtnd_day";exit;

//echo "username=$username";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

//echo $project_category;
//echo $project_name;




//$table1="weekly_updates";
//$table2="project_notes2";

//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");


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
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-Day3</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/pcard_updates/step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group> Return Pcard Updates-HOME </A></font></H2>";

echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "XTND_day:<input name='fiscal_year' type='text' value='$xtnd_day' readonly='readonly'>";
echo "<br />";
//echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
//echo "<br />";
//echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";

echo "<br /><br />";




$query3="SELECT * FROM project_substeps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' and step_num='$step_num'  order by substep_num asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

////mysql_close();
echo "<table border=1>";
 
echo 

"<tr> 
       
       
       <th>SubStep_Num</th>
       <th>SubStep_Name</th>
       <th><font color=red>Action</font></th>";
    //  echo " <th<font color=red>TimeStart</font></th>
     //  <th<font color=red>TimeEnd</font></th>
     //  <th<font color=red>TimeElapsed</font></th>
    echo "<th><font color=red>Status</font></th>";
                
       
 

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

       
       
	   
	   <td align='center'>$substep_num</td>
	   <td>$substep_name</td>
	   <td>
	   <form method='post' action='step$step_group$step_num$substep_num.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>	   
	   <input type='hidden' name='substep_name' value='$substep_name'>	   
	   <input type='hidden' name='substep_num' value='$substep_num'>	   
	   <input type='submit' name='submit1' value='Update'>
	   </form>
       </td>";
	   
 	echo "<td> <font color=$fcolor1>$status</font></td>
	      
</tr>";



}

echo "</table></body></html>";

?>

























