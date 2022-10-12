<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

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

echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";

$query1="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet_report.count_pcu_transid,
pcard_extract_worksheet.id1646,
pcard_extract_worksheet.denr_paid,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join pcard_extract_worksheet_report on pcard_extract_worksheet.id=pcard_extract_worksheet_report.pce_id
left join center on pcard_extract_worksheet.center=center.new_center
where pcard_extract_worksheet_report.match_complete='n'
and pcard_extract_worksheet_report.count_pcu_transid =''
and pcard_extract_worksheet.denr_paid != 'y'
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);
echo "<H3><font color='red'>Record Count: $num1</font></H3>";
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
 echo " <th><font color=blue>Count<br /> pcu <br />transid</font></th>";
 echo " <th><font color=blue>id1646</font></th>";
 echo " <th><font color=blue>denr_paid</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG8e_update_all.php'>";

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
echo  "<td>$company</td>";
echo  "<td>$acct</td>";
echo  "<td>$center</td>";
echo  "<td>$calendar_acctdate</td>";
echo  "<td>$amount</td>";
echo  "<td>$sign</td>";
echo  "<td><a href=stepG8e_update.php?pcard_trans_id=$pcard_trans_id&id=$id&project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date>$pcard_trans_id</td>";
echo  "<td>$count_pcu_transid</td>";
echo  "<td>$id1646</td>";
echo  "<td>$denr_paid</td>";
echo  "<td>$id</td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Mark_Step_Complete'></td></tr>";
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


?>

























