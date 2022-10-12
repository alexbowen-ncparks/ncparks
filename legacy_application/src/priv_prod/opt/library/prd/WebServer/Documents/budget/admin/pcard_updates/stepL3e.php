<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$sed=date("Ymd");
//echo "<br />Line 11: sed=$sed<br />";
//$sed='20181130';
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


if($reset=='yes')
{
include("step_reset_form.php");
} 

$query2b="SELECT fiscal_year,start_date,end_date FROM project_substeps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' and step_num='$step_num'  order by substep_num asc";


//echo "query2b=$query2b<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");

$row2b=mysqli_fetch_array($result2b);
extract($row2b);
//echo "start_date=$start_date<br />end_date=$end_date<br />";
if($start_date=='0000-00-00'){$start_date='';}
if($end_date=='0000-00-00'){$end_date='';}



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
include ("../../../budget/menu1415_v3.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-Day5</font></i></H1>";
//echo "<H1 ALIGN=center > <font color=brown><i>$project_name</font></i></H1>";

$table1="pcard_report_dates_compliance";
$table2="pcard_unreconciled";
$table3="pcard_unreconciled_xtnd_temp2_perm";
$table4="pcard_unreconciled_xtnd_temp2_perm_unique";
$table5="pcard_users";


$report1="budget.$table1";
$report1_backup="budget_pcard_backup.$sed$table1";
$report2="budget.$table2";
$report2_backup="budget_pcard_backup.$sed$table2";
$report3="budget.$table3";
$report3_backup="budget_pcard_backup.$sed$table3";
$report4="budget.$table4";
$report4_backup="budget_pcard_backup.$sed$table4";
$report5="budget.$table5";
$report5_backup="budget_pcard_backup.$sed$table5";
/*
echo "<br />report1=$report1<br />";
echo "<br />report1_backup=$report1_backup<br />";
echo "<br />report2=$report2<br />";
echo "<br />report2_backup=$report2_backup<br />";
echo "<br />report3=$report3<br />";
echo "<br />report3_backup=$report3_backup<br />";
echo "<br />report4=$report4<br />";
echo "<br />report4_backup=$report4_backup<br />";
echo "<br />report5=$report5<br />";
echo "<br />report5_backup=$report5_backup<br />";
*/
if($backup_verify=='y')
{
// $report1_count  VARIABLE
$query2c="select count(*) as 'report1_count' from $report1"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report1_count=$report1_count<br />";


// $report1_count_backup  VARIABLE
$query2c="select count(*) as 'report1_count_backup' from $report1_backup"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report1_count_backup=$report1_count_backup<br />";


// $report2_count  VARIABLE
$query2c="select count(*) as 'report2_count' from $report2"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report2_count=$report2_count<br />";


// $report2_count_backup  VARIABLE
$query2c="select count(*) as 'report2_count_backup' from $report2_backup"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report2_count_backup=$report2_count_backup<br />";


// $report3_count  VARIABLE
$query2c="select count(*) as 'report3_count' from $report3"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report3_count=$report3_count<br />";


// $report3_count_backup  VARIABLE
$query2c="select count(*) as 'report3_count_backup' from $report3_backup"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report3_count_backup=$report3_count_backup<br />";


// $report4_count  VARIABLE
$query2c="select count(*) as 'report4_count' from $report4"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report4_count=$report4_count<br />";


// $report4_count_backup  VARIABLE
$query2c="select count(*) as 'report4_count_backup' from $report4_backup"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report4_count_backup=$report4_count_backup<br />";


// $report5_count  VARIABLE
$query2c="select count(*) as 'report5_count' from $report5"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report5_count=$report5_count<br />";


// $report5_count_backup  VARIABLE
$query2c="select count(*) as 'report5_count_backup' from $report5_backup"; 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c"); $row2c=mysqli_fetch_array($result2c); extract($row2c);
//echo "<br />report5_count_backup=$report5_count_backup<br />";

$tables_total_records=$report1_count+$report2_count+$report3_count+$report4_count+$report5_count;
$tables_total_records_backup=$report1_count_backup+$report2_count_backup+$report3_count_backup+$report4_count_backup+$report5_count_backup;
//echo "<br />tables_total_records=$tables_total_records<br />";
//echo "<br />tables_total_records_backup=$tables_total_records_backup<br />";
//$tables_total_records_backup='80153';
if($tables_total_records==$tables_total_records_backup){$backup_success='yes';}else{$backup_success='no';}
//echo "<br />backup_success=$backup_success<br />";

}






echo "<br /><br />";
echo "<table align=center><tr><th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />PCARD Weekly Updates</th></tr></table>";
echo "<br /><br />";

echo
"<form align=center>";
echo "<font size=5>"; 

echo
"<form action='stepL3e.php'>";
echo "<font size=5>"; 
//echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly' autocomplete='off'>";
echo "<br />";
//echo "start_date:&nbsp<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "start_date:&nbsp<input name='start_date' type='text' value='$start_date' readonly='readonly' autocomplete='off'>";
echo "<br />";
//echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' value='$end_date' readonly='readonly' autocomplete='off'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";	
echo "<input type='hidden' name='project_name' value='$project_name'>";	
echo "<input type='hidden' name='step_group' value='$step_group'>";	
echo "<input type='hidden' name='step_num' value='$step_num'>";	
//echo "<input type='submit' name='submit' value='set_dates'>";
echo "</form>";








echo "<br />";

echo "</form>";

echo "<br /><br />";



$query3="SELECT * FROM project_substeps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' and step_num='$step_num'  order by substep_num asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//echo "query3=$query3<br />";

////mysql_close();
echo "<table align='center'>";
echo "<tr>";
echo "<th><a href='stepL3e.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&reset=yes'>Re-Set Form</a></th>";
//echo "<td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href='pcard_lookup.php' target='_blank'>Missing PCARD Lookup</a></td>";
echo "</tr>";
echo "</table>";
echo "<br /><br />";
echo "<table border=1 align='center'>";
 
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
if($backup_verify=='y' and $backup_success=='yes'){$backup_message="<br />total records backed up=$tables_total_records_backup. <img height='25' width='25' src='green_checkmark1.png' alt='picture of green check mark'></img>";}

if($backup_verify=='y' and $backup_success=='no'){$backup_message="<br />total records backed up=$tables_total_records_backup. <img height='25' width='25' src='xmark1.png' alt='picture of green check mark'></img>";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo "<tr$t>";	

       
       

echo "<th>$substep_num</th>";




if($substep_num!='1bd')
{   
echo "<td>$substep_name</td>";
}

if($substep_num=='1bd')
{   
echo "<td>$substep_name$backup_message</td>";
}









echo "<td>
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