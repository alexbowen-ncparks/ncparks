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
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$start_date='20100601';
//$end_date='20100608';
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);




$query1="truncate table report_partf_payments;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_partf_payments
SELECT 'all',partf_payments.center, center_desc,center.section,cyinitfund,account, invoice, amount, vendorname, datenew, proj_num, charg_proj_num, ci_match, ca_match, contract_num, contract_amt,xtid,record_complete
FROM partf_payments
left join center on partf_payments.center=center.center
WHERE datenew >=  
'$start_date'
AND datenew <=  
'$end_date'
and partf_payments.center != '4f87'
ORDER  BY center, vendorname ASC;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

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
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H3>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";


echo "<br />";

$query10="SELECT report_partf_payments.center,report_partf_payments.center_desc,
center.section,report_partf_payments.cyinitfund,account,invoice, amount, vendorname, datenew, proj_num, charg_proj_num, 
ci_match,ca_match, contract_num, contract_amount,xtid,record_complete
FROM report_partf_payments
left join center on report_partf_payments.center=center.center
WHERE datenew >=  
'$start_date'
AND datenew <=  
'$end_date'
and record_complete='n'
ORDER  BY report_partf_payments.center, vendorname ASC;";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();
echo "Records: $num10";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>center</font></th>";
 //echo " <th><font color=blue>center_desc</font></th>";
 echo " <th><font color=blue>section</font></th>";
 //echo " <th><font color=blue>cyinitfund</font></th>";
 //echo " <th><font color=blue>account</font></th>";
// echo " <th><font color=blue>invoice</font></th>";
 //echo " <th><font color=blue>amount</font></th>";
 //echo " <th><font color=blue>vendorname</font></th>";
 //echo " <th><font color=blue>datenew</font></th>";
 echo " <th><font color=blue>proj_num</font></th>";           
 echo " <th><font color=blue>charg_proj_num</font></th>";           
 //echo " <th><font color=blue>ci_match</font></th>";           
 //echo " <th><font color=blue>ca_match</font></th>";           
 echo " <th><font color=blue>contract_num</font></th>";           
 echo " <th><font color=blue>contract_amount</font></th>";           
 echo " <th><font color=blue>xtid</font></th>";           
 echo " <th><font color=blue>record_complete</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' action='stepJ92_update_all.php'>";
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
//echo "<form method=post action=stepJ9_update.php>";	   
echo  "<td>$center</td>";
//echo  "<td>$center_desc</td>";
echo  "<td>$section</td>";
//echo  "<td>$cyinitfund</td>";
//echo  "<td>$account</td>";
//echo  "<td>$invoice</td>";
//echo  "<td>$amount</td>";
//echo  "<td>$vendorname</td>";
//echo  "<td>$datenew</td>";
echo  "<td>$proj_num</td>";
echo  "<td>$charg_proj_num</td>";
//echo  "<td>$ci_match</td>";
//echo  "<td>$ca_match</td>";
echo  "<td>$contract_num</td>";
echo  "<td>$contract_amount</td>";
echo  "<td>$xtid</td>";
echo  "<td>$record_complete</td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='record_complete_yes2all'></td></tr>";
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

























