<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//First occurrence of Page

if($submit1=="Execute")

{
include("../../../budget/menu1314.php");
echo "<html>";
/*
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";
*/




echo "<br />";
//echo "<H2 ALIGN=LEFT > <font color=brown><i>$project_name-Set Dates</i> </font></H2>";
echo "<table align='center'><tr><th><i>$project_name-Set Dates</i></th></tr></table>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";
echo "<br />";
echo "<table align='center'><tr>";
echo "<td>
<form method=post autocomplete='off' action=stepA1.php>";
//echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' size='12' id=fiscal_year value='$fiscal_year'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' size='12' id=start_date value='$start_date'>";
echo "<br />";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' size='12' id=end_date value='$end_date'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='step_group' value='$step_group'>";	   
echo "<input type='hidden' name='step_num' value='$step_num'>";	

//echo "<br />";
//echo "complete:&nbsp&nbsp&nbsp<input name='complete' type='text' size='12' id=complete_date value='$complete'>";


echo "<br /><br />";

//echo "&emsp";
echo "<input type=submit name=submit2 value=Execute>";

echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";


echo "</html>";}
 
 //Second occurrence of Page
 if($submit2=="Execute")
 
 {//update weekly_updates_steps for date fields and status field
 //echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
 /*
$query0="insert ignore into project_steps_history(
fiscal_year,start_date,end_date,project_category,project_name,step_group,
step,link,weblink,status,time_complete,time_elapsed_sec,time_elapsed_min)
select fiscal_year,start_date,end_date,project_category,project_name,step_group,
step,link,weblink,status,time_complete,time_elapsed_sec,time_elapsed_min
from project_steps
where project_category='fms' and project_name='weekly_updates'; "; 

mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0"); 
*/
 
 
 
$query1="update project_steps set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending', time_complete='', time_elapsed_sec='', time_elapsed_min='' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 

if($showsql=='y')
{
echo "query1=$query1<br /><br />";
}
	 
		 
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update project_steps_detail set fiscal_year='$fiscal_year',start_date='$start_date',
         end_date='$end_date',status='pending' where 1 and project_category='$project_category'
		 and project_name='$project_name' "; 
		 
if($showsql=='y')
{		 
echo "query2=$query2<br /><br />";
}		 
		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query3="update project_steps_detail set status='complete' 
        where project_category='$project_category' and project_name='$project_name'
		and step_group= '$step_group' and step_num= '$step_num' "; 
		
if($showsql=='y')
{		 		
echo "query3=$query3<br /><br />";		
}


mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

if($showsql=='y')
{				 
echo "query4=$query4<br /><br />";			 
}		 

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$num4=mysqli_num_rows($result4);



if($num4==0)

{


$query5="update project_steps set status='complete',time_complete=unix_timestamp(now()) where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";

if($showsql=='y')
{				 
echo "query5=$query5<br /><br />";	
}

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

}

//echo "Update Successful<br /><br />";


				 
if($num4==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}



if($num4!=0)



{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 
 
 
 }
 
?>




