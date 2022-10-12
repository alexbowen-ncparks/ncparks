<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 14pt;}
TD{font-family: Arial; font-size: 14pt;}
input{style=font-family: Arial; font-size:12.0pt}
</style>
</head>";


//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
//echo  "<form method='post' action='stepG5_update_all.php'>";
//echo "<input type='submit' name='submit2' value='UpdateAllRecords'>";
//echo   "</form>";
echo "</H3>";

/*<font color=blue>StepName-$step_name</font></H1>";
echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/
echo "<br />";

if($submit != 'complete')
{

$query1="update pcard_unreconciled_xtnd 
set xtnd_rundate=trim(xtnd_rundate),
location=trim(location),
admin_num=trim(admin_num),
post_date=trim(post_date),
amount=trim(amount),
vendor_name=trim(vendor_name),
address=trim(address),
pcard_num=trim(pcard_num),
xtnd_cardholder=trim(xtnd_cardholder);";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="update pcard_unreconciled_xtnd
set valid_record='y'
where mid(trans_date,4,1)='/'; ";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update pcard_unreconciled_xtnd
set complete_record='y'
where mid(trans_date,4,1)='/'
and pcard_num != ''; ";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="
truncate table xtnd_cardholder_count; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query4a= "insert into xtnd_cardholder_count(location,xtnd_cardholder,pcard_num)
select distinct location,xtnd_cardholder,pcard_num
from pcard_unreconciled_xtnd
where 1
and complete_record='y'
order by location,xtnd_cardholder,pcard_num; ";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$query5="
truncate table xtnd_cardholder_count2; ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");



$query5a= "insert into xtnd_cardholder_count2(location,xtnd_cardholder,cards)
select location,xtnd_cardholder,count(id)
from xtnd_cardholder_count
where 1
group by location,xtnd_cardholder
order by location,xtnd_cardholder; ";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");



$query6= "select location,xtnd_cardholder,cards
          from xtnd_cardholder_count2 where 1 and cards != '1' ;  ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysqli_num_rows($result6);
echo "<font color='red' size='5'>Record Count: $num6</font>";//exit;
//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>location</font></th>";
 echo " <th><font color=blue>xtnd_cardholder</font></th>";
 echo " <th><font color=blue>cards</font></th>";
 
 echo "</tr>";
 

//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row6=mysqli_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td>$location</td>";
echo  "<td>$xtnd_cardholder</td>";
echo  "<td>$cards</td>";


//echo  "<td><a href='stepH8e_update?center=$center&ncasnum=$ncasnum&amount=$amount' target='_blank'>$amount</a></td>";
//echo  "<td><a href='stepH8e_update?center=$center&ncasnum=$ncasnum&amount=$amount&project_category=$project_category&project_name=$project_name&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&step_group=$step_group&step=$step&step_num=$step_num&center=$center&park=$park' >$amount</a></td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='cvip_id[]' value='$cvip_id'</td>";
//echo  "<td>$postdate</td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='recon[]' value='$recon'</td>";
//echo  "<td>$id</td>";
   
	      
echo "</tr>";

}
echo "</table>";

echo "<form method='post' action='stepL3d6a.php'>"; 
echo "<input type='submit' name='submit' value='complete'>";

/*echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
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
*/	
echo "<input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='substep_num' value='$substep_num'>";	   
	   
   
echo   "</form>";

}

if($submit=='complete')

{

$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num'";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group' and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num'";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}

}
echo "</html>";

?>

























