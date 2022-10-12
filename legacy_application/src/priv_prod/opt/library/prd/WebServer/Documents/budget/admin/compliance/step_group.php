<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category='FMS';
$project_name='monthly_compliance';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters



$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");








if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='yearly_reset'){$report_yearly_reset="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='scoring_presentation'){$scoring_presentation="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='energy_reporting'){$energy_reporting="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
//if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";


/*
echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>$project_name<br />Tasks</font></th><th><a href='step_group.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th><th><a href='step_group.php?fyear=$fyear&report_type=form'>Form</a><br />$report_form</th></tr></table>";
*/


echo "<br /><table align='center' border='1'>";
echo "<tr>";
//echo "<th><font color='brown'>$project_name<br />Tasks</font></th>";



echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/finger_red_ribbon1.jpg' alt='reminder image' title='compliance deadlines'></img><br /><font color='brown'>DB-Admin<br />Deadlines</font>
</a></th>";


//echo "<th><a href='step_group.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th>";
echo "<th><a href='step_group.php?fyear=$fyear&report_type=form'>Monthly_Form</a><br />$report_form</th>";
echo "<th><a href='step_group.php?fyear=$fyear&report_type=yearly_reset'>Yearly_Reset_Form</a><br />$report_yearly_reset</th>";
echo "<th><a href='step_group.php?fyear=$fyear&report_type=scoring_presentation'>Wheelhouse<br />Scoring</a><br />$scoring_presentation</th>";
echo "<th><a href='step_group.php?fyear=$fyear&report_type=energy_reporting'>Energy<br />Reporting</a><br />$energy_reporting</th>";
echo "</tr>";
echo "</table>";






echo "<br />";

//include("monthly_compliance_tasks_fyear.php");
//include("monthly_compliance_tasks_fyear_months.php");



if($report_type=='form')
{
include("monthly_compliance_tasks_fyear.php");
include("monthly_compliance_tasks_fyear_months.php");

echo "<br />";

$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>
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
		   <input type='hidden' name='link' value='$link'>	   
		   <input type='hidden' name='compliance_fyear' value='$compliance_fyear'>	   
		   <input type='hidden' name='compliance_month' value='$compliance_month'>	   
		   <input type='submit' name='submit1' value='Execute'>
		   </form>
		   </td>";
		
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";

}
if($report_type=='yearly_reset')
{
	
$project_category='fms';
$project_name='monthly_compliance_fyear_reset';
$step_group='C';

echo "<br />project_category=$project_category<br />";
echo "<br />project_name=$project_name<br />";
echo "<br />step_group=$step_group<br />";
	

// IF statement below Updates 2 TABLES associated with "Monthly Compliance Module"

//TABLE1 Updates (Table=fiscal_year)	
//...... Re-Set the active Report Year
//...... The Existing Report Year must be "inactivated" (Field=active_year_compliance, Value=n)
//...... The New Report Year must be "activated"....... (Field=active_year_compliance, Value=y)	

//TABLE2 Updates (Table=project_steps_detail)
//...... Re-Set Field Values  .......where project_category=fms and project_name=monthly_compliance_fyear_reset and step_group=C 
//.......Changes field=fiscal_year to $new_compliance_fyear
//.......Changes field=status to "pending"

if($reset=='y')
{
//TABLE1 Updates (Table=fiscal_year)
	
$query0="select report_year as 'old_compliance_fyear' from fiscal_year where active_year_compliance='y' ";	
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
//0628: Brings back Existing "compliance_fyear" as "old_compliance_fyear"
echo "<br />old_compliance_fyear=$old_compliance_fyear<br />";  

$query0a="select report_year as 'new_compliance_fyear' from fiscal_year where report_year > '$old_compliance_fyear' order by report_year asc limit 1 ";		 
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);
//0628: Brings back New "compliance_fyear" as "new_compliance_fyear"
echo "<br />new_compliance_fyear=$new_compliance_fyear<br />";  

//TABLE2 Updates (Table=project_steps_detail)
$query0d="update project_steps_detail set fiscal_year='$new_compliance_fyear',status='pending' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
$result0d = mysqli_query($connection, $query0d) or die ("Couldn't execute query 0d.  $query0d");
echo "<br />query0d=$query0d<br />";

}


	
include("monthly_compliance_tasks_fyear.php");
//include("monthly_compliance_tasks_fyear_months.php");

echo "<br />";

echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to Start Over?')
 return (bConfirm);
}
";
echo "</script>";




echo "<table align='center'><tr><th><a href=\"step_group.php?&report_type=yearly_reset&reset=y\" onClick='return confirmLink()'><img height='75' width='75' src='/budget/infotrack/icon_photos/mission_icon_photos_204.jpg' alt='picture of Start Over Icon'></img></a></th></tr></table>";




$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>";
		echo "<td>$step_name</td>";
		if($step_live_update=='y')
		{
		echo "<td bgcolor='red'>
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
		      <input type='hidden' name='link' value='$link'>	   
		      <input type='hidden' name='compliance_fyear' value='$compliance_fyear'>	   
		      <input type='hidden' name='compliance_month' value='$compliance_month'>	   
		      <input type='submit' name='submit1' value='Execute'>
		      </form>
		    </td>";
		}
		 if($step_status_change=='y')
		{  
	  echo "<td>
			<form method='post' action='status_change.php'>
			<input type='hidden' name='status' value='$status'>
			<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
			<input type='hidden' name='project_category' value='$project_category'>	   
			<input type='hidden' name='project_name' value='$project_name'>	   
			<input type='hidden' name='start_date' value='$start_date'>	   
			<input type='hidden' name='end_date' value='$end_date'>	   
			<input type='hidden' name='step_group' value='$step_group'>	   
			<input type='hidden' name='step_num' value='$step_num'>	   
			<input type='hidden' name='step' value='$step'>	   
			<input type='hidden' name='step_name' value='$step_name'> 
			<input type='hidden' name='report_type' value='$report_type'> 
			<input type='submit' name='submit2' value='change_status'>
			</form></td>";	
		}
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";

}

if($report_type=='scoring_presentation')
{
	
$project_category='fms';
$project_name='scoring_presentation';
$step_group='D';

echo "<br />project_category=$project_category<br />";
echo "<br />project_name=$project_name<br />";
echo "<br />step_group=$step_group<br />";
	

// IF statement below Updates 2 TABLES associated with "Monthly Compliance Module"

//TABLE1 Updates (Table=fiscal_year)	
//...... Re-Set the active Report Year
//...... The Existing Report Year must be "inactivated" (Field=active_year_compliance, Value=n)
//...... The New Report Year must be "activated"....... (Field=active_year_compliance, Value=y)	

//TABLE2 Updates (Table=project_steps_detail)
//...... Re-Set Field Values  .......where project_category=fms and project_name=monthly_compliance_fyear_reset and step_group=C 
//.......Changes field=fiscal_year to $new_compliance_fyear
//.......Changes field=status to "pending"



//include("monthly_compliance_tasks_fyear_months.php");






$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>";
		echo "<td>$step_name</td>";
		if($step_live_update=='y')
		{
		echo "<td bgcolor='red'>
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
		      <input type='hidden' name='link' value='$link'>	   
		      <input type='hidden' name='compliance_fyear' value='$compliance_fyear'>	   
		      <input type='hidden' name='compliance_month' value='$compliance_month'>	   
		      <input type='submit' name='submit1' value='Execute'>
		      </form>
		    </td>";
		}
		 if($step_status_change=='y')
		{  
	  echo "<td>
			<form method='post' action='status_change.php'>
			<input type='hidden' name='status' value='$status'>
			<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
			<input type='hidden' name='project_category' value='$project_category'>	   
			<input type='hidden' name='project_name' value='$project_name'>	   
			<input type='hidden' name='start_date' value='$start_date'>	   
			<input type='hidden' name='end_date' value='$end_date'>	   
			<input type='hidden' name='step_group' value='$step_group'>	   
			<input type='hidden' name='step_num' value='$step_num'>	   
			<input type='hidden' name='step' value='$step'>	   
			<input type='hidden' name='step_name' value='$step_name'> 
			<input type='hidden' name='report_type' value='$report_type'> 
			<input type='submit' name='submit2' value='change_status'>
			</form></td>";	
		}
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";

}

if($report_type=='energy_reporting')
{
	
$project_category='fms';
//$project_name='energy_reporting';
$project_name='weekly_updates_energy';
//$step_group='E';
$step_group='K';

echo "<br />project_category=$project_category<br />";
echo "<br />project_name=$project_name<br />";
echo "<br />step_group=$step_group<br />";
	

// IF statement below Updates 2 TABLES associated with "Monthly Compliance Module"

//TABLE1 Updates (Table=fiscal_year)	
//...... Re-Set the active Report Year
//...... The Existing Report Year must be "inactivated" (Field=active_year_compliance, Value=n)
//...... The New Report Year must be "activated"....... (Field=active_year_compliance, Value=y)	

//TABLE2 Updates (Table=project_steps_detail)
//...... Re-Set Field Values  .......where project_category=fms and project_name=monthly_compliance_fyear_reset and step_group=C 
//.......Changes field=fiscal_year to $new_compliance_fyear
//.......Changes field=status to "pending"



//include("monthly_compliance_tasks_fyear_months.php");
$query_energy_fyear="select cy from fiscal_year where energy_update_year='y' ";
echo "<br />query_energy_fyear=$query_energy_fyear<br />";

$result_energy_fyear = mysqli_query($connection, $query_energy_fyear) or die ("Couldn't execute query_energy_fyear .  $query_energy_fyear");

$row_energy_fyear=mysqli_fetch_array($result_energy_fyear);
extract($row_energy_fyear);


echo "<br /><table align='center' border='1'><tr><td><font class='cartRow'>Fiscal Year: $cy</font></td></tr></table>";


$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>";
		echo "<td>$step_name</td>";
		if($step_live_update=='y')
		{
		echo "<td bgcolor='red'>
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
		      <input type='hidden' name='link' value='$link'>	   
		      <input type='hidden' name='compliance_fyear' value='$compliance_fyear'>	   
		      <input type='hidden' name='compliance_month' value='$compliance_month'>	   
		      <input type='submit' name='submit1' value='Execute'>
		      </form>
		    </td>";
		}
		 if($step_status_change=='y')
		{  
	  echo "<td>
			<form method='post' action='status_change.php'>
			<input type='hidden' name='status' value='$status'>
			<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
			<input type='hidden' name='project_category' value='$project_category'>	   
			<input type='hidden' name='project_name' value='$project_name'>	   
			<input type='hidden' name='start_date' value='$start_date'>	   
			<input type='hidden' name='end_date' value='$end_date'>	   
			<input type='hidden' name='step_group' value='$step_group'>	   
			<input type='hidden' name='step_num' value='$step_num'>	   
			<input type='hidden' name='step' value='$step'>	   
			<input type='hidden' name='step_name' value='$step_name'> 
			<input type='hidden' name='report_type' value='$report_type'> 
			<input type='submit' name='submit2' value='change_status'>
			</form></td>";	
		}
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";

}
echo "</body></html>";

?>