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

//relevant tables: 
//pcard_utility_xtnd_1646_ws
//pcard_extract_worksheet
//pux1646ws_caa
//pcewu_caa
//pcard_extract

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
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
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 

echo "</H3>";

echo "<br />";
$query1="UPDATE pcard_utility_xtnd_1646_ws SET caa = concat( center, '-', account, '-', trans_amount ) 
WHERE 1 ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//echo $num3;exit;
//////mysql_close();

$query2="UPDATE pcard_extract_worksheet SET caa = concat( center, '-', acct, '-', debit_credit ) 
WHERE 1 ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="truncate table pux1646ws_caa ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query3a="insert into pux1646ws_caa(caa,count) select caa,count(caa)
 from pcard_utility_xtnd_1646_ws where f_year='$fiscal_year' group by caa";
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");



$query4="update pux1646ws_caa set f_year='$fiscal_year' where 1";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update pcard_utility_xtnd_1646_ws,pux1646ws_caa 
set pcard_utility_xtnd_1646_ws.count=pux1646ws_caa.count 
where pcard_utility_xtnd_1646_ws.caa=pux1646ws_caa.caa";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="truncate table pcewu_caa ";
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query6a="insert into pcewu_caa(caa,count) 
select caa,count(caa) from pcard_extract_worksheet 
where 1 group by caa";
$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");


$query7="update pcewu_caa set f_year='$fiscal_year' where 1";
$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update pcard_extract_worksheet,pcewu_caa set pcard_extract_worksheet.count=pcewu_caa.count 
where pcard_extract_worksheet.caa=pcewu_caa.caa";
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update pcard_extract_worksheet,pcard_utility_xtnd_1646_ws 
set pcard_extract_worksheet.id1646=pcard_utility_xtnd_1646_ws.id 
where pcard_extract_worksheet.caa=pcard_utility_xtnd_1646_ws.caa and denr_paid='y' 
and pcard_extract_worksheet.count='1' and pcard_utility_xtnd_1646_ws.count='1' 
and pcard_extract_worksheet.f_year='$fiscal_year' and pcard_utility_xtnd_1646_ws.f_year='$fiscal_year'";
$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="update pcard_utility_xtnd_1646_ws,pcard_extract_worksheet 
set pcard_utility_xtnd_1646_ws.pcew_match='y' 
where pcard_utility_xtnd_1646_ws.id=pcard_extract_worksheet.id1646";
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update pcard_utility_xtnd_1646_ws,pcard_extract set pcard_utility_xtnd_1646_ws.posted='y' 
where pcard_utility_xtnd_1646_ws.transid=pcard_extract.pcard_trans_id 
and pcard_utility_xtnd_1646_ws.f_year='$fiscal_year' and pcard_extract.f_year='$fiscal_year' ";
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="select pcard_extract_worksheet.caa,pcard_utility_xtnd_1646_ws.transdate_new as 'transdate',
pcard_extract_worksheet.acctdate as 'postdate' from pcard_extract_worksheet 
left join pcard_utility_xtnd_1646_ws on pcard_extract_worksheet.id1646=pcard_utility_xtnd_1646_ws.id 
where 1 and pcard_extract_worksheet.caa=pcard_utility_xtnd_1646_ws.caa 
and pcard_extract_worksheet.denr_paid='y' and pcard_utility_xtnd_1646_ws.posted != 'y'";
$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");
$num12=mysqli_num_rows($result12);

echo "<H3><font color=red>Record Count=$num12</font></H3>";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>CAA</font></th>";
 echo " <th><font color=blue>Transdate</font></th>";
 echo " <th><font color=blue>Postdate</font></th>";
       
  
echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG8a0.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row12=mysqli_fetch_array($result12)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row12);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='#B4CDCD'>";  
echo  "<td>$caa</td>";
echo  "<td>$transdate</td>";
echo  "<td>$postdate</td>";
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='mark_complete'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";
echo   "</form>";	 
echo "</table>";
	
if($submit2=='mark_complete')

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

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

}

echo "</html>";



?>

























