<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");
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
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/project_manager/main.php> Return HOME </A></font></H2>";

echo "<br />";

echo "<table border=1>";
echo "<tr><td><H3><font color=blue>Current Table:</font> <font color=red>project_substeps_detail</font></H3></td></tr>";
echo "<tr><td></td></tr>";
echo "<tr><td>Other Tables</td></tr>";
	 
echo "<tr><td><A href=/budget/admin/project_manager/main.php> project_steps </A></td></tr>
      <tr><td><A href=/budget/admin/project_manager/project_steps_detail.php> project_steps_detail </A></td></tr>
</table>";

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
	 echo "<table border=1>";
	 echo "<tr>";
echo"<td><form method=post action=project_substeps_detail.php>";
echo "<font size=5>"; 

$query4="select distinct (project_name) as project_name_menu from project_steps where 1 
order by project_name";
$result4= mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");
$countRecords=mysqli_num_rows($result4);
while ($row4=mysqli_fetch_array($result4)){
extract($row4);$menuArray[]=$project_name_menu;}

echo "<td align='center'>project_name<br><select name=\"project_name\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($project_name==$menuArray[$n] and $project_name!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";

unset($menuArray);
echo "<td></td>";
echo "<td>
<input type='submit' name='submit1' value='Submit'>";
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




if($project_name !="")
{
$query3="SELECT * FROM project_substeps_detail where 1 and project_name='$project_name' 
order by project_name,step_group,step_num,substep_num asc";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<font color='red'>Records: $num3</font>";
echo "<tr>"; 
     
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
	 </form></td></tr>";
echo "<table border=1>";
 
echo 

"<tr> 
       <th><font color=blue>fiscal year</font></th>
       <th><font color=blue>start date</font></th>
       <th><font color=blue>end date</font></th>
       <th><font color=blue>project category</font></th>
       <th><font color=blue>project name</font></th>
       <th><font color=blue>step group</font></th>
       <th><font color=blue>step </font></th>
       <th><font color=blue>step_num</font></th>
       <th><font color=red>step_name</font></th>
       <th><font color=red>substep_num</font></th>
       <th><font color=red>substep_name</font></th>
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
	   <td>$step_num</td>	   
	   <td>$step_name</td>
	   <td>$substep_num</td>
	   <td>$substep_name</td>
	   <td>$link</td>
	   <td>$weblink</td>
	   <td>$status</td>
	   	   
	   
	   
	   <td>	   
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
	   </td>
  	   
       </tr>";



}
echo "</table></body></html>";
}
else {exit;}


?>

























