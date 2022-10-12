<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$step_variables="fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&start_date=$start_date&end_date=$end_date&step_group=$step_group&step_num=$step_num";
echo "<br />step_variables=$step_variables<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="select count(id) as 'pcew_exceptions'
from pcard_extract_worksheet
where correction='m'
and denr_paid != 'y'
and transid_verified != 'y' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "<br />pcew_exceptions=$pcew_exceptions<br />";  exit;

//$pcew_exceptions=1;
if($pcew_exceptions==0)
{
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);


if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}


if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
}


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#ffffff;}
.highlight {background-color:#ff0000;} 
</style>

<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>
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


echo "<br />";
if($new_center != ''){$and1=" and pcard_extract_worksheet.center='$new_center'" ;}

$query3="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.debit_credit as 'amount',
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.new_center
where correction='m'
and denr_paid != 'y'
and transid_verified != 'y'
$and1
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.debit_credit,acct
";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
//echo "<br />query3=$query3<br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo "<font size='5'>Records: $num3</font>";//exit;
//////mysql_close();

echo "<table border=1 align='center'>";
echo "<tr>";
echo "<th colspan='7'>Records: $num3</th>";
echo "<tr>"; 
    
 //echo " <th><font color=blue>Company</font></th>";
 
 
 echo " <th><font color=blue>Account</font></th>";
 
 echo " <th><font color=blue>Amount</font></th>";
 //echo " <th><font color=blue>Sign</font></th>";
 
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
 echo " <th><font color=blue>Transid_verified</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG5_update_all.php'>";
//exit;

while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//if($sign=='credit'){$amount=-$amount;}

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";	      
//echo "<form method=post action=stepG5_update.php>";	   
//echo  "<td><input type='text' size='10 name='company[]' value='$company'</td>";


echo  "<td><input type='text' size='10' name='acct[]' value='$acct'></td>";

echo  "<td><input type='text' size='10' name='amount[]' value='$amount'></td>";
//echo  "<td><input type='text' size='10' name='sign[]' value='$sign'</td>";

echo  "<td><a href='stepG5.php?$step_variables&new_center=$center'>$center</a></td>";
echo  "<td><input type='text' size='10' name='calendar_acctdate[]' value='$calendar_acctdate'></td>";
echo  "<td><input type='text' size='15' name='pcard_trans_id[]' value='$pcard_trans_id'></td>";
echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'></td>";
echo  "<td><input type='text' size='10' name='id[]' value='$id'></td>";
   
	      
echo "</tr>";
$amount2.=$amount." or amount=";
//echo "<br />amount2=$amount2<br />";
}
$amount3=substr($amount2,0,-11);
$amount4="amount=".$amount3;
//echo "<br />amount4=$amount4<br />";

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
	   <input type='hidden' name='num3' value='$num3'>";
echo   "</form>";	 
echo "</table>";


$today_date=date("Ymd");
$today_date2=strtotime($today_date);
$today_90_unix=($today_date2-60*60*24*90);
$today_90=date("Ymd", $today_90_unix);

//echo "<br /><font color='red'>today_90=$today_90</font><br />";;


	
$query4="select admin_num,center,vendor_name,amount,transid_new,transdate_new,ncas_yn,ncasnum,id
         from pcard_unreconciled
         where center='$new_center'
         and transdate_new >= '$today_90'
         and transdate_new <= '$end_date'
		 and ncas_yn='n'
		 and ($amount4)
         order by amount,ncasnum  ";		 
	
	
//echo "<br />query4=$query4<br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);	
	
echo "<table border='1' align='center'>";	
echo "<tr>";
echo "<th colspan='7'>Records: $num4</th>";
echo "</tr>";
echo "<tr>";


echo "<th>ncasnum</th>";
echo "<th>amount</th>";

echo "<th>center</th>";

echo "<th>transdate_new</th>";
echo "<th>transid_new</th>";
echo "<th>admin_num</th>";
echo "<th>vendor_name</th>";

echo "<th>ncas_yn</th>";
echo "<th>id</th>";
echo "</tr>";




while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";		


echo "<td>$ncasnum</td>";	
echo "<td>$amount</td>";

echo "<td>$center</td>";
	
echo "<td>$transdate_new</td>";	
echo "<td>$transid_new</td>";
echo "<td>$admin_num</td>";		
echo "<td>$vendor_name</td>";	

	
echo "<td>$ncas_yn</td>";	


echo "<td>$id</td>";	

echo "</tr>";	
	
	
}

echo "</table>";	
	
	
	
	
	
	
	
	
	

echo "</html>";

?>