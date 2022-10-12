<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;





/*
$query1=" update pcard_unreconciled,pcard_extract 
 set pcard_unreconciled.post2ncas=pcard_extract.acctdate 
 where pcard_unreconciled.transid_new=pcard_extract.pcard_trans_id 
 and pcard_unreconciled.transid_date_count='1' 
 and pcard_unreconciled.post2ncas='0000-00-00'
 and pcard_extract.pcard_user != 'controllers_office'";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2=" update pcard_unreconciled 
 set ncas_yn='y' 
 where post2ncas != '0000-00-00'; 
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
*/
/*
$query3=" update pcard_unreconciled,pcard_extract
          set pcard_unreconciled.ncas_yn2='y',pcard_unreconciled.post2ncas=pcard_extract.acctdate 
          where pcard_unreconciled.transid_new=pcard_extract.pcard_trans_id
		  and pcard_unreconciled.ncas_yn2='n'
		  and pcard_extract.acctdate >= '$start_date' and pcard_extract.acctdate <= '$end_date' ";
*/
		  
//echo "<br />query3=$query3<br />";
//echo "<br />Line 48<br />";
//exit;		  
		  
		  
//mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");




$query1=" update pcard_unreconciled,pcard_extract 
 set pcard_unreconciled.post2ncas=pcard_extract.acctdate,pcard_unreconciled.ncas_yn2='y'
 where pcard_unreconciled.transid_new=pcard_extract.pcard_trans_id 
 and pcard_unreconciled.ncas_yn2='n'
 and pcard_unreconciled.transid_new != '' 
 and pcard_extract.acctdate >= '$start_date' and pcard_extract.acctdate <= '$end_date' ";
 
echo "<br />query1=$query1<br />";
echo "<br />Line 68<br />";


$query2=" update pcard_unreconciled 
          set ncas_yn=ncas_yn2 where 1 ";
 
echo "<br />query2=$query2<br />";
echo "<br />Line 75<br />";




exit;		  
 
 
 
 
 
//mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
//mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");




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

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>

























