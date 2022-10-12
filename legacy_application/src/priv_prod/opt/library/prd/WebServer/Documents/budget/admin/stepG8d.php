<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="select 
center.company,
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet_report.count_pcu_transid,
pcard_extract_worksheet.pcu_id,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join pcard_extract_worksheet_report on pcard_extract_worksheet.id=pcard_extract_worksheet_report.pce_id
left join center on pcard_extract_worksheet.center=center.center
where pcard_extract_worksheet_report.match_complete='n'
and pcard_extract_worksheet_report.count_pcu_transid !='1'
and pcard_extract_worksheet.denr_paid != 'y'
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);

//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Sign</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
 echo " <th><font color=blue>Count_pcu_transid</font></th>";
 echo " <th><font color=blue>pcu_id</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' action='stepG8d_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td><input type='text' size='10 name='company[]' value='$company'</td>";
echo  "<td><input type='text' size='10' name='acct[]' value='$acct'</td>";
echo  "<td><input type='text' size='10' name='center[]' value='$center'</td>";
echo  "<td><input type='text' size='10' name='calendar_acctdate[]' value='$calendar_acctdate'</td>";
echo  "<td><input type='text' size='10' name='amount[]' value='$amount'</td>";
echo  "<td><input type='text' size='10' name='sign[]' value='$sign'</td>";
echo  "<td><input type='text' size='10' name='pcard_trans_id[]' value='$pcard_trans_id'</td>";
echo  "<td><input type='text' size='10' name='count_pcu_transid[]' value='$count_pcu_transid'</td>";
echo  "<td><input type='text' size='10' name='pcu_id[]' value='$pcu_id'</td>";
echo  "<td><input type='text' size='10' name='id[]' value='$id'</td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num1' value='$num1'>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";


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

























