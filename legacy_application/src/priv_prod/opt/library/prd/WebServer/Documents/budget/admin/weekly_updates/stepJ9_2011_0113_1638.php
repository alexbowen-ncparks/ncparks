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
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
$query1="truncate table report_partf_payments_exception;
";
mysql_query($query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_partf_payments_exception
SELECT 'all',partf_payments.center, center_desc,center.section,cyinitfund,account, invoice, amount, vendorname, datenew, proj_num, charg_proj_num, ci_match, ca_match, contract_num, contract_amt,record_complete,xtid
FROM partf_payments
left join center on partf_payments.center=center.center
WHERE datenew >=  
'$start_date'
AND datenew <=  
'$end_date'
and record_complete='n'
ORDER  BY center, vendorname ASC;
";
mysql_query($query2) or die ("Couldn't execute query 2. $query2");

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

$query10="SELECT report_partf_payments_exception.center,report_partf_payments_exception.center_desc,
center.section,report_partf_payments_exception.cyinitfund,account,invoice, amount, vendorname, datenew, proj_num, charg_proj_num, 
ci_match,ca_match, contract_num, contract_amount,record_complete,xtid
FROM report_partf_payments_exception
left join center on report_partf_payments_exception.center=center.center
WHERE datenew >=  
'$start_date'
AND datenew <=  
'$end_date'
ORDER  BY report_partf_payments_exception.section,center, vendorname ASC;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysql_query($query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysql_num_rows($result10);
//echo $num10;exit;
//mysql_close();
echo "Record Count: $num10";
echo "<table border=1>";
 
echo "<tr>"; 
 echo " <th><font color=blue>sec</font></th>";  
 echo " <th><font color=blue>center</font></th>";
 //echo " <th><font color=blue>center_desc</font></th>"; 
 //echo " <th><font color=blue>cyinitfund</font></th>";
 //echo " <th><font color=blue>account</font></th>";
 echo " <th><font color=blue>invoice</font></th>";
 echo " <th><font color=blue>amount</font></th>";
 echo " <th><font color=blue>vendorname</font></th>";
 echo " <th><font color=blue>datenew</font></th>";
 echo " <th><font color=blue>proj</font></th>";           
 echo " <th><font color=blue>charg</font></th>";           
 //echo " <th><font color=blue>ci</font></th>";           
 //echo " <th><font color=blue>ca</font></th>";           
 echo " <th><font color=blue>contractN</font></th>";           
 echo " <th><font color=blue>contractA</font></th>";           
 echo " <th><font color=blue>RC</font></th>";           
 echo " <th><font color=blue>xtid</font></th>";           
 echo " <th><font color=blue>C</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepJ9_update_all.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$row3=mysql_fetch_array($result3);
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
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row10=mysql_fetch_array($result10)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row10);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepJ9_update.php>";	
echo  "<td><input type='text' size='3' readonly='readonly' name='section[]' value='$section'</td>";  
echo  "<td><input type='text' size='5 readonly='readonly' name='center[]' value='$center'</td>";
//echo  "<td><input type='text' size='20' readonly='readonly' name='center_desc[]' value='$center_desc'</td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='cyinitfund[]' value='$cyinitfund'</td>";
//echo  "<td><input type='text' size='10' readonly='readonly' name='account[]' value='$account'</td>";
echo  "<td><input type='text' size='15' readonly='readonly' name='invoice[]' value='$invoice'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='amount[]' value='$amount'</td>";
echo  "<td><input type='text' size='15' readonly='readonly' name='vendorname[]' value='$vendorname'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='datenew[]' value='$datenew'</td>";
echo  "<td><input type='text' size='5'  name='proj_num[]' value='$proj_num'</td>";
echo  "<td><input type='text' size='5'  name='charg_proj_num[]' value='$charg_proj_num'</td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='ci_match[]' value='$ci_match'</td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='ca_match[]' value='$ca_match'</td>";
echo  "<td><input type='text' size='5'  name='contract_num[]' value='$contract_num'</td>";
echo  "<td><input type='text' size='7'  name='contract_amt[]' value='$contract_amount'</td>";
echo  "<td><input type='text' size='2'  name='record_complete[]' value='$record_complete'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='xtid[]' value='$xtid'</td>";
?>

<td><input onclick="this.parentNode.parentNode.style.backgroundColor='yellow'" type="checkbox" /></td>
 <?php  
	      
echo "</tr>";

}

echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num10' value='$num10'>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";




?>

























