<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update vmc_posted7_v2 SET";
for($j=0;$j<$num5;$j++)
	{	
	//if($tag_num[$j] ==""){continue;}
	$query2=$query1;
		$query2.=" license_tag='$tag_num[$j]',";
		$query2.=" vmc_comments='$vmc_comments[$j]',";	
		$query2.=" player='$tempid'";	
		$query2.=" where id='$id[$j]'";
			
	
	$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
	}	
	

$query1a="update vmc_posted7_v2
set license_tag=license_tag_manual
where license_tag_manual != '' ";

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");	




	
$query2a="update vmc_posted7_v2
set record_complete='n'
where license_tag = ''
or license_tag='multiple' ";

$result2a=mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");	
	
	
	
	
$query3="update vmc_posted7_v2
set record_complete='y'
where license_tag != ''
and license_tag != 'multiple' ";

$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");



//11-22-14  After TABLE=vmc_posted7_v2 is update (see above), remaining code updates TABLE=mission_scores for GID=1  (gid = game id)


/*

$query4="update mission_scores 
         set complete='0',total='0'
         where gid='1' ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");	

	

$query7a="update mission_scores
set percomp='.01'
where gid = '1' and percomp='0.00' ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

*/
	

$query5="select count(id) as 'total' from vmc_posted7_v2
where park='$park'
and f_year='$f_year'
and parent_record != 'y'
 ";

echo "query5=$query5<br />"; //exit;



$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$row5=mysqli_fetch_array($result5);
extract($row5);

echo "total=$total<br />"; //exit;


	 
$query5a="update mission_scores
     set total='$total'
	 where playstation='$park'
	 and gid='1' and fyear='$f_year' ";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");
	 


$query6="select count(id) as 'complete' from vmc_posted7_v2
where park='$park'
and f_year='$f_year'
and parent_record != 'y'
and record_complete = 'y'
 ";

echo "query6=$query6<br />";



$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);
extract($row6);

echo "complete=$complete<br />"; //exit;


$query6a="update mission_scores
     set complete='$complete'
	 where playstation='$park'
	 and gid='1' and fyear='$f_year' ";

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");


$query6b="update mission_scores
set percomp=complete/total*100
where playstation='$park'
and gid = '1' and fyear='$f_year'  "; 

echo "query6b=$query6b<br />";

$result6b=mysqli_query($connection, $query6b) or die ("Couldn't execute query6b. $query6b");


$query6c="update mission_scores
set percomp='100.00'
where playstation='$park' and gid = '1' and fyear='$f_year' and total='0'  ";


echo "query6c=$query6c<br />";



$result6c=mysqli_query($connection, $query6c) or die ("Couldn't execute query6c. $query6c");



$query7="update mission_scores
set percomp='.01'
where playstation='$park' and gid = '1' and fyear='$f_year' and percomp='0.00'  ";


echo "query7=$query7<br />";



$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");








echo "Update Successful<br />";

//exit;

//11-22-14 End of Query to update TABLE=mission_scores

//Return to PHP File vm_costs_center_daily.php



if($submit2=='Update')
{
header("location: vm_costs_center_daily.php?f_year=$f_year&park=$park&center=$center");
}
else
{
echo "go to split page"; 
 }
 

 
 
 ?>




















