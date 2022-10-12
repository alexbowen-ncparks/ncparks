<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$step_variables="fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&start_date=$start_date&end_date=$end_date&step_group=$step_group&step_num=$step_num";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

// changed on 5/14/20-TBass
/*
$query1="select count(id) as 'pcew_exceptions'
from pcard_extract_worksheet
where pcard_trans_id=''
and denr_paid != 'y'
and (sign='debit' or sign='credit')
";
*/

//5/26/20 (TBASS)
/*
$query1="select count(id) as 'pcew_exceptions'
from pcard_extract_worksheet
where pcard_trans_id=''
and denr_paid != 'y'
";
*/

$query1="select count(id) as 'pcew_exceptions'
from pcard_extract_worksheet
where record_complete='n' ";


$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "<br />pcew_exceptions=$pcew_exceptions<br />";  exit;

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









//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#B4CDCD;}
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

echo "</H3>";

echo "<br />";

if($new_center != ''){$and1=" and pcard_extract_worksheet.center='$new_center' " ;}

//changed 5/14/20-TBass
/*
$query3="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
coa.park_acct_desc as 'account_description',
center.parkcode,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.debit_credit as 'amount',
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.correction,
pcard_extract_worksheet.denr_paid,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.new_center
left join coa on pcard_extract_worksheet.acct=coa.ncasnum
where pcard_trans_id=''
and denr_paid != 'y'
and (sign='debit' or sign='credit')
$and1
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.debit_credit,acct ;
";
*/

//5/26/20 (TBASS)
/*
$query3="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
coa.park_acct_desc as 'account_description',
center.parkcode,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.acctdate,
pcard_extract_worksheet.debit_credit as 'amount',
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.correction,
pcard_extract_worksheet.denr_paid,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.new_center
left join coa on pcard_extract_worksheet.acct=coa.ncasnum
where pcard_trans_id=''
and denr_paid != 'y'
$and1
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.debit_credit,acct ;
";
*/

$query3="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
coa.park_acct_desc as 'account_description',
center.parkcode,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.acctdate,
pcard_extract_worksheet.debit_credit as 'amount',
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.correction,
pcard_extract_worksheet.denr_paid,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.new_center
left join coa on pcard_extract_worksheet.acct=coa.ncasnum
where pcard_extract_worksheet.record_complete='n'
$and1
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.debit_credit,acct ; ";




echo "<br />query3=$query3<br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo $num3;exit;
//////mysql_close();
//echo "<H3></H3>";
echo "<table border=1 align='center' cellpadding='5'>";
// changed on 5/11/20-TBass
//echo "<tr><th colspan='6'><font color=red>Record Count=$num3</font></th></tr>"; 
echo "<tr><th colspan='6'><font color=red>Transactions with NO pcard_trans_id. Record Count=$num3</font></th></tr>"; 
echo "<tr>"; 
    
 //echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 //echo " <th><font color=blue>Account_Description</font></th>";
 echo " <th><font color=blue>PostingDate</font></th>";
  echo " <th><font color=blue>TransactionID</font></th>";
// echo " <th><font color=blue>Center</font></th>";
// echo " <th><font color=blue>PostDate</font></th>";
 
 //echo " <th><font color=blue>Sign</font></th>";

 //echo " <th><font color=blue>Transid verified</font></th>";
 //echo " <th><font color=blue>Correction</font></th>";
 //echo " <th><font color=blue>DENR Paid</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
//echo " <th><font color=blue>Complete</font></th>";           
//echo " <th><font color=blue>Complete2</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
  
echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG8a_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";  
//echo  "<td>$company</td>";
//changed on 5/11/20
//echo  "<td>$acct<br />$account_description</td>";
echo  "<td><a href='stepG8a.php?$step_variables&new_center=$center'>$center<br />$parkcode</td>";
echo  "<td>$acct</td>";
echo  "<td>$amount</td>";
//echo  "<td>$calendar_acctdate</td>";
echo  "<td>$acctdate</td>";
echo  "<td><input type='text' size='15'  name='pcard_trans_id[]' value='$pcard_trans_id'</td>";
//echo  "<td>$account_description</td>";
//echo  "<td><a href='stepG8a.php?$step_variables&new_center=$center'>$center<br />$parkcode</td>";
//echo  "<td>$calendar_acctdate</td>";

//echo  "<td>$sign</td>";

//echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'</td>";
//echo  "<td>$correction</td>";
//echo  "<td>$denr_paid</td>";
echo  "<td><input type='text' size='3' readonly='readonly' name='id[]' value='$id'</td>";
  
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
$today_180_unix=($today_date2-60*60*24*180);
$today_180=date("Ymd", $today_180_unix);








//$new_center='1680516';
$query4="select admin_num,vendor_name,amount,transid_new,transdate_new,ncas_yn,ncasnum,id
         from pcard_unreconciled
         where center='$new_center'
         and transdate_new >= '$today_180'
         and transdate_new <= '$end_date'
		 and ncas_yn2='n'
		 and ($amount4)
		 order by amount,ncasnum  ";		 
	
	
echo "<br />query4=$query4<br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);	
if($new_center != '')
{	
echo "<table border='1' align='center' cellpadding='5'>";	
echo "<tr>";
//echo "<th colspan='7'>Records: $num4<br /><a href='stepG8a_lookup.php?fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&new_center=$new_center' target='_blank'>Lookup all PCARD transactions for Center: $new_center</a></th>";
// changed on 5/11/20-TBass
echo "<th colspan='6'><font color='red'> Possible Matches from TABLE=pcard_unreconciled. Record Count=$num4</font></th>";
echo "</tr>";
echo "<tr>";

echo "<th>Center</th>";
echo "<th>Account</th>";
echo "<th>Amount</th>";
//echo "<th>admin_num</th>";
//echo "<th>vendor_name</th>";
echo "<th>TransDate</th>";
echo "<th>TransactionID</th>";
//echo "<th>Center</th>";
//echo "<th>transdate_new</th>";

//echo "<th>ncas_yn</th>";
echo "<th>id</th>";
echo "</tr>";




while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";		

echo "<td>$new_center</td>";	
echo "<td>$ncasnum</td>";	
echo "<td>$amount</td>";
echo "<td>$transdate_new</td>";
echo "<td>$transid_new</td>";	
//echo "<td>$new_center</td>";	
//echo "<td>$admin_num</td>";	
//echo "<td>$vendor_name</td>";		
//echo "<td>$transdate_new</td>";	

//echo "<td>$ncas_yn</td>";	
echo "<td>$id</td>";	

echo "</tr>";	
	
	
}

echo "</table>";	
}

echo "</html>";



?>