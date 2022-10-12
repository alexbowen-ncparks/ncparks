<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
*/

$query0="SELECT count(id) as 'idcount'
from pcard_extract
where 1
and pcard_extract.acctdate >= 
'$start_date2'
and pcard_extract.acctdate <= 
'$end_date2'
and record_complete='n';";

//echo "<br />query0=$query0<br />";
		 
//echo "query0=$query0<br />";		 

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

//echo "<br />idcount=$idcount<br />"; exit;

//if($idcount >= 15){echo "<br /><font color='red' size='8'>Table=pcard_extract is NOT Complete</font><br />"; exit;}

/*
if($idcount == 0)
{
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete',time_complete=unix_timestamp(now())
         where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


}
*/

//echo "submit1=$submit1";echo "submit2=$submit2";exit;

/*
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

//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
//echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
$query1="SELECT count(id) as 'idcount'
from pcard_extract
where 1
and pcard_extract.acctdate >= 
'$start_date'
and pcard_extract.acctdate <= 
'$end_date'
and record_complete='n';";

echo "<br />query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);

echo "<br />num1=$num1<br />"; exit;

////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>ID_count</th>";   
echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo "<tr$t>";	
echo "<td>$idcount</td>";    
echo "</tr>";



}

echo "</table>";
echo "<form method=post action=stepG8k_update.php>";
echo "<input type='submit' name='submit' value='Records_Complete-YES'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>";	   
	   
echo "</form>";

echo "</html>";     
*/     

?>