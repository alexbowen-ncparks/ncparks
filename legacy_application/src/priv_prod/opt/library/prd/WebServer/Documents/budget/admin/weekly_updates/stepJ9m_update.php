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
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="truncate table reconcilement_non1280_center";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query1a="insert into reconcilement_non1280_center(center,acct,cfyear_exprev)
SELECT center, acct,sum(credit-debit) AS 'cfyear_exprev'
FROM exp_rev
WHERE 1 AND center = '$center' AND f_year = '$fiscal_year'
GROUP BY center,acct";

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query1b="insert into reconcilement_non1280_center(center,acct,cfyear_cid_payments)
SELECT center, account,sum(amount) AS 'cfyear_cid_payments'
FROM partf_payments
WHERE 1 AND center = '$center' AND f_year = '$fiscal_year'
GROUP BY center,account";

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$query1c="insert into reconcilement_non1280_center(center,acct,cfyear_cid_fundsin)
SELECT fund_in as 'center', ncas_in, sum( amount )  AS  'cfyear_cid_fundsin'
frOM  `partf_fund_trans`
WHERE 1 and fund_in != ''
AND fund_in = '$center' AND f_year = '$fiscal_year'
GROUP  BY fund_in,ncas_in;
";

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");



$query1c="insert into reconcilement_non1280_center(center,acct,cfyear_cid_fundsout)
SELECT fund_out as 'center', ncas_out, sum( amount )  AS  'cfyear_cid_fundsout'
frOM  `partf_fund_trans`
WHERE 1 and fund_out != ''
AND fund_out = '$center' AND f_year = '$fiscal_year'
GROUP  BY fund_out,ncas_out;
";

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$query1d="truncate table reconcilement_non1280_center2";

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");



$query1e="insert into reconcilement_non1280_center2(center,account,cid_balance,xtnd_balance)
          select center,acct,sum(cfyear_cid_fundsin-cfyear_cid_fundsout-cfyear_cid_payments),sum(cfyear_exprev)
          from reconcilement_non1280_center
		  group by center,acct";
$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");

$query1f="update reconcilement_non1280_center2 
          set out_balance=cid_balance-xtnd_balance where 1";

$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");

$query2="select center,account,sum(cid_balance)as 'cid_balance',sum(xtnd_balance)as 'xtnd_balance',sum(out_balance)as 'out_balance'
          from reconcilement_non1280_center2
		  where 1 and out_balance != '0'
		  group by center,account; ";


$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


//exit;


//$num1=mysqli_num_rows($result1);
//echo $num10;exit;
//////mysql_close();


echo "Records: $num2";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>center</font></th>";
 echo " <th><font color=blue>account</font></th>";
echo " <th><font color=blue>cid_balance</font></th>";
echo " <th><font color=blue>xtnd_balance</font></th>";
 echo " <th><font color=blue>out_balance</font></th>";
 
 

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
if($status=='complete'){$t=" bgcolor='#B4CDCD'";}else{$t=" bgcolor='yellow'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);
echo  "<form method='post' action='stepJ9m_update2.php'>";

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	 


     
//echo "<form method=post action=stepJ9_update.php>";	   
echo  "<td><input type='text' size='20 readonly='readonly' name='center' value='$center'</td>";
echo  "<td><input type='text' size='20 readonly='readonly' name='account' value='$account'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='cid_balance' value='$cid_balance'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='xtnd_balance' value='$xtnd_balance'</td>";
echo  "<td><input type='text' size='20' readonly='readonly' name='out_balance' value='$out_balance'</td>";

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
echo  "<td><input type='submit' name='submit2' value='Update'>";
 echo "</form>";
echo "</td>";  	   
echo "</tr>";	   
 
}

echo "</table>";

	


//echo "</tr>";
//echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
 


echo "</html>";

/*

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

*/


?>

























