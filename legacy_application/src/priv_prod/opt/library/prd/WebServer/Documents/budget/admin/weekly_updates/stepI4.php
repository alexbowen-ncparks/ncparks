<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
echo "start_date=$start_date";
echo "<br />"; 
echo "end_date=$end_date";//exit;
echo "<br />"; 
echo "today_date=$today_date";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="truncate table equipment_recon;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into equipment_recon(center,acct,bca_amount,er3_amount)
select center,ncas_acct,sum(allocation_amount),''
from budget_center_allocations
where allocation_justification='approved_equipment_purchase'
and fy_req=
'$fiscal_year'
group by center,ncas_acct;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="insert into equipment_recon(center,acct,bca_amount,er3_amount)
select pay_center,ncas_account,'',sum(unit_cost*unit_quantity)
from equipment_request_3
where f_year=
'$fiscal_year'
and division_approved='y'
and status='active'
and ncas_account like '534%'
and order_complete='n'
group by pay_center,ncas_account;
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="insert into equipment_recon(center,acct,bca_amount,er3_amount)
select pay_center,ncas_account,'',sum(ordered_amount)
from equipment_request_3
where f_year=
'$fiscal_year'
and division_approved='y'
and status='active'
and ncas_account like '534%'
and order_complete='y'
group by pay_center,ncas_account;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="select equipment_recon.center,parkcode,acct,sum(bca_amount) as 'bca_amount',sum(er3_amount)as 'er3_amount',sum(bca_amount-er3_amount) as 'oob'
from equipment_recon
left join center on equipment_recon.center=center.center
where 1
and acct like '534%'
group by equipment_recon.center,acct
order by parkcode;
";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//////mysql_close();


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
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";

echo "<br />";

echo "<table border=1>";
 
echo "<tr>"; 
       
       
 echo "<th>center</th>";
 echo "<th>parkcode</th>";
 echo "<th>acct</th>";
 echo "<th>bca_amount</th>";
 echo "<th>er3_amount</th>";
 echo "<th>oob</th>";
    
echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo "<tr$t>";	
   
echo "<td>$center</td>";
echo "<td>$parkcode</td>";
echo "<td>$acct</td>";
echo "<td>$bca_amount</td>";
echo "<td>$er3_amount</td>";
echo "<td>$oob</td>";
	   
	      
echo "</tr>";



}

echo "</table></body></html>";


/* $query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
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


*/

?>

























