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
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="truncate table report_cvip_tempmatch_ok;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_cvip_tempmatch_ok
select 
'all',
'n',
cid_vendor_invoice_payments.ncas_center,
exp_rev_extract.center,
'n',
cid_vendor_invoice_payments.vendor_name,
exp_rev_extract.description,
cid_vendor_invoice_payments.ncas_invoice_number,
exp_rev_extract.invoice,
cid_vendor_invoice_payments.ncas_invoice_amount,
exp_rev_extract.debit_credit,
'n',
cid_vendor_invoice_payments.system_entry_date,
exp_rev_extract.acctdate,
'',
'n',
cid_vendor_invoice_payments.id,
exp_rev_extract.cvip_id,
cid_vendor_invoice_payments.temp_match,
exp_rev_extract.whid
from exp_rev_extract
left join cid_vendor_invoice_payments on exp_rev_extract.cvip_id=cid_vendor_invoice_payments.id
where 1
and exp_rev_extract.cvip_id != 'nm'
and exp_rev_extract.acctdate >= 
'$start_date'
and exp_rev_extract.acctdate <= 
'$end_date'
order by exp_rev_extract.center;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update report_cvip_tempmatch_ok
set days_elapsed=to_days(ere_date)-to_days(cvip_date)
where 1;
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="update report_cvip_tempmatch_ok
set match3='y'
where days_elapsed >= '0'
and days_elapsed <= '60';
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="update report_cvip_tempmatch_ok
set match1='y'
where cvip_center=ere_center;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="update report_cvip_tempmatch_ok
set match2='y'
where cvip_amount=ere_amount;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="update report_cvip_tempmatch_ok
set match_complete='y'
where match1='y'
and match2='y'
and match3='y';
";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="truncate table report_cvip_tempmatch_exceptions;
";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="insert into report_cvip_tempmatch_exceptions
select *
from report_cvip_tempmatch_ok
where 1
and match_complete != 'y';
";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");



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
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 

echo "</H3>";

echo "<br />";

$query10="select 
cvip_center,
ere_center,
cvip_vendor,
ere_vendor,
cvip_invoice,
ere_invoice,
cvip_amount,
ere_amount,
days_elapsed,
cvip_id,
ere_cvip_id,
ere_whid
from report_cvip_tempmatch_exceptions
where 1;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>cvip_center</font></th>";
 echo " <th><font color=blue>ere_center</font></th>";
 echo " <th><font color=blue>cvip_vendor</font></th>";
 echo " <th><font color=blue>ere_vendor</font></th>";
 echo " <th><font color=blue>cvip_invoice</font></th>";
 echo " <th><font color=blue>ere_invoice</font></th>";
 echo " <th><font color=blue>cvip_amount</font></th>";
 echo " <th><font color=blue>ere_amount</font></th>";
 echo " <th><font color=blue>days_elapsed</font></th>";
 echo " <th><font color=blue>cvip_id</font></th>";           
 echo " <th><font color=blue>ere_cvip_id</font></th>";           
 echo " <th><font color=blue>ere_whid</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' action='stepH8e3_update_all.php'>";
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
while ($row10=mysqli_fetch_array($result10)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row10);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td><input type='text' size='10 readonly='readonly' name='cvip_center[]' value='$cvip_center'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='ere_center[]' value='$ere_center'</td>";
echo  "<td><input type='text' size='25' readonly='readonly' name='cvip_vendor[]' value='$cvip_vendor'</td>";
echo  "<td><input type='text' size='25' readonly='readonly' name='ere_vendor[]' value='$ere_vendor'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='cvip_invoice[]' value='$cvip_invoice'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='ere_invoice[]' value='$ere_invoice'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='cvip_amount[]' value='$cvip_amount'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='ere_amount[]' value='$ere_amount'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='days_elapsed[]' value='$days_elapsed'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='cvip_id[]' value='$cvip_id'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='ere_cvip_id[]' value='$ere_cvip_id'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='ere_whid[]' value='$ere_whid'</td>";
   
	      
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
	   <input type='hidden' name='num3' value='$num3'>";
echo   "</form>";	 
echo "</table>";
if($showSQL=='1')
{echo 
"
$query1 <br /><br />
$query2 <br /><br />
$query3 <br /><br />
$query4 <br /><br />
$query5 <br /><br />
$query6 <br /><br />
$query7 <br /><br />
$query8 <br /><br />
$query9 <br /><br />
$query10 <br /><br />
";
}	

echo "</html>";




?>

























