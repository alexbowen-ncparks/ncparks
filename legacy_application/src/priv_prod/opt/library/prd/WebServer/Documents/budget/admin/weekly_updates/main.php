<?php

/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../budget/menu1314_tony.html")
[if $reset=='y']
  include("stepA1.php")
*/

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied {main.php}";exit;
}


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);


//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters


//include("../../../budget/menus2.php");
//include("../../../budget/menu1314.php");
include("../../../budget/menu1314_tony.html");



//echo "<h2><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></h2>";

$project_category='fms';
$project_name='weekly_updates';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


//echo "reset = $reset";


if($reset=='y')
{
include("stepA1.php"); // connection parameters

}



echo "<br />";
//echo "<table>";

echo
"<form align='center'>";
echo "<table align='center'>";
echo "<font size=4>";
echo "<tr>"; 
echo "<td>fiscal_year:</td><td><input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'></td>";
echo "</tr>";
echo "<br />";
echo "<tr>";
echo "<td>start_date (Extract Tables):&nbsp</td><td><input name='start_date' type='text' value='$start_date' readonly='readonly'></td>";
echo "</tr>";
//echo "<br />";
echo "<tr>";
echo "<td>end_date (Extract Tables):&nbsp&nbsp</td><td><input name='end_date' type='text' value='$end_date' readonly='readonly'></td>";
echo "</tr>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
echo "</table>";
//echo "</table>";
//echo "<br /><br />";
//echo "<table>";
//echo "<tr>";
//echo "<td>";

/*
echo"  <form method='post' action='add_stepgroup.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='submit' name='submit' value='Add_StepGroup'>
	   </form>";
*/
echo "<br />"; 
//echo "<table align='center'><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of Start Over Icon'></img><font color='brown' size='5'>Cash Handling<br /><br />Administrator Daily Update</b></font><a href=\"step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&reset=y\" onClick='return confirmLink()'><img height='75' width='75' src='/budget/infotrack/icon_photos/mission_icon_photos_204.jpg' alt='picture of bank'></img></a></th></tr></table>";
echo "<table align='center'><tr><th><a href=\"main.php?project_category=$project_category&project_name=$project_name&reset=y\" onClick='return confirmLink()'><img height='75' width='75' src='/budget/infotrack/icon_photos/mission_icon_photos_204.jpg' alt='picture of Start Over Icon'></img></a></th></tr></table>";
echo "<br /><br />";      
//echo "</td></tr></table>";

//include("time_elapsed_project_steps.php");


$query3="SELECT * FROM project_steps where 1 and project_category='$project_category'
         and project_name='$project_name' order by step_group asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query19 = "select sum(time_elapsed_min) as 'total_elapsed_time' from project_steps
         where project_category='$project_category' and project_name='$project_name' ";

$result19 = mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

//$row19=mysqli_fetch_array($result19);
//extract($row19);//brings back max (fiscal_year) as $fiscal_year

//echo "<br />total_elapsed_time=$total_elapsed_time";

// NOTE lines 119 and 120 can be "UN-Commented" to OPEN LINK which will allow "backdate mode" (Link Toggles between "Regular Mode" and "Backdate Mode"). 
// Backdate Mode allows Administrator to enter "previous fiscal year records" IF (and only if) Records exist in Current Year (ie. no reason to go to "backdate mode" if no records in current year)
// EXAMPLE: If records exist in TABLE=exp_rev for FY2122, "Backdate mode" will allow Records from FY2021 to be added to MoneyCounts (NOTE: 3 CSV Files MUST be from "previous year" when using "Backdate Mode"
//          In this example, 3 CSV Files must be FINAL CSV Files for FY2021

//if($back_date_yn=='n'){echo "<table align='center'><tr bgcolor='lightgreen'><td><a href='main.php?project_category=$project_category&project_name=$project_name&reset=y&reset_mode=backdate'>REGULAR MODE</a></td></tr></table>";}
//if($back_date_yn=='y'){echo "<table align='center'><tr bgcolor='lightpink'><td><a href='main.php?project_category=$project_category&project_name=$project_name&reset=y&reset_mode=regular'>BACK-DATE MODE</a></td></tr></table>";}



if($back_date_yn=='n'){echo "<table align='center'><tr bgcolor='lightgreen'><td>REGULAR MODE</td></tr></table>";}
if($back_date_yn=='y'){echo "<table align='center'><tr bgcolor='lightpink'><td>BACK-DATE MODE</td></tr></table>";}


//echo "<table align='center'><tr><td><font class='cartRow'>WARNING</font>: BEFORE First Update of Fiscal Year, Shift Columns for TABLE=report_budget_history_multiyear2 <a href='report_budget_history_multiyear2_year_end_adjustments.html' target='_blank'>Instructions</a></td></tr></table>";
echo "<br />";

////mysql_close();
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
    //echo "<th><font color=red>TimeComplete</font></th>";
    //echo "<th><font color=red>Time<br />Minutes</font></th>";
                
       
 

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

/*   
echo   "<td>
	   <form method='post' action='step_group.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='back_date_yn' value='$back_date_yn'>	   
	   <input type='submit' name='submit' value='Update'>
	   </form>
       </td>";
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
	   <input type='hidden' name='back_date_yn' value='$back_date_yn'>	   
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
	//echo "<td>$time_complete</td>";
	//echo "<td>$time_elapsed_min</td>";
	      
echo "</tr>";

}

while ($row19=mysqli_fetch_array($result19)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row19);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td>";
//echo "<td>Total Elapsed</td><td>$total_elapsed_time</td>"; 
           
			  
			  
echo "</tr>";

}





echo "</table></div></body></html>";

?>