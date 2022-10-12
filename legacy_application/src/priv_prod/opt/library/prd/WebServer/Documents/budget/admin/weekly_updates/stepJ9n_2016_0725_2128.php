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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

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

$query1="truncate table project_approve_amount;
";
mysql_query($query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into project_approve_amount(source,center,projnum,divapp_amount,status_amount)
select 'div_app_amt',center,projnum,sum(div_app_amt) as 'divapp_amount',''
from partf_projects
where 1
and projyn='y'
and reportdisplay='y'
group by center,projnum;
";
mysql_query($query2) or die ("Couldn't execute query 2. $query2");

$query3="insert into project_approve_amount(source,center,projnum,divapp_amount,status_amount)
select 'status_amount',cid_charg_project_balances.center,project,'',sum(fundsin-fundsout) as 'status_amount'
from cid_charg_project_balances
left join partf_projects on cid_charg_project_balances.project=partf_projects.projnum
where 1
and partf_projects.projyn='y'
and partf_projects.reportdisplay='y'
group by center,project;
";
mysql_query($query3) or die ("Couldn't execute query 3. $query3");

$query4="truncate table report_projects_update_approve_amount;
";
mysql_query($query4) or die ("Couldn't execute query 4. $query4");

$query5="insert into report_projects_update_approve_amount(
center,
projnum,
park,
projname,
projcat,
partf_projects_amt,
partf_fund_trans_amt,
oob)
select project_approve_amount.center,project_approve_amount.projnum,partf_projects.park,partf_projects.projname,projcat,sum(divapp_amount) as 'table_partf_projects' ,sum(status_amount) as 'table_partf_fund_trans',sum(divapp_amount-status_amount) as 'OOB'
from project_approve_amount
left join partf_projects on project_approve_amount.projnum=partf_projects.projnum
where 1
group by project_approve_amount.center,project_approve_amount.projnum;
";
mysql_query($query5) or die ("Couldn't execute query 5. $query5");

$query5a="update report_projects_update_approve_amount,partf_projects
          set report_projects_update_approve_amount.status='complete'
		  where report_projects_update_approve_amount.projnum=partf_projects.projnum
		  and partf_projects.div_app_amt_set='yes';
";
mysql_query($query5a) or die ("Couldn't execute query 5a. $query5a");




$query6="select center,projnum,park,projname,projcat,partf_projects_amt,partf_fund_trans_amt,oob,status
         from report_projects_update_approve_amount
         where 1 and oob != '0' order by center";

		 
		 
$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysql_num_rows($result6);
//echo $num10;exit;
//mysql_close();
echo "<H3 align='center'><A href='step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date'>Return to StepGroup$step_group</b></A></H3>";
echo "Records: $num6";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>center</font></th>";
 echo " <th><font color=blue>proj</font></th>";
 echo " <th><font color=blue>park</font></th>";
 echo " <th><font color=blue>projname</font></th>";
 echo " <th><font color=blue>cat</font></th>";
 echo " <th><font color=blue>(A)partf_projects_amt</font></th>";
 echo " <th><font color=blue>(B)partf_fund_trans_amt</font></th>";
 echo " <th><font color=blue>oob</font></th>";
 echo " <th><font color=blue>(A)</font></th>";
 echo " <th><font color=blue>OR</font></th>";
 echo " <th><font color=blue>(B)</font></th>";
 
 

echo "</tr>";
//echo  "<form method='post' action='stepJ9n_update.php'>";
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
//if($status=='complete'){$t="bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row6=mysql_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);
//echo "status=$status";exit;
//if($status=='complete'){$t="bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepJ9_update.php>";	   
echo  "<td>$center</td>";
echo  "<td>$projnum</td>";
echo  "<td>$park</td>";
echo  "<td>$projname</td>";
echo  "<td>$projcat</td>";
echo  "<td>$partf_projects_amt</td>";
echo  "<td>$partf_fund_trans_amt</td>";
echo  "<td>$oob</td>";
echo  "<td><form method='post' action='stepJ9n_update.php'>
       <input type='hidden' name='projnum' value='$projnum'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num6' value='$num6'>  	   
	   <input type='hidden' name='partf_projects_amt' value='$partf_projects_amt'>  	   
       <input type='submit' name='submita' value='Update'>
       </form> </td>";
	   
echo  "<td>$status</td>";
echo  "<td><form method='post' action='stepJ9n_update.php'>
       <input type='hidden' name='projnum' value='$projnum'> 
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num6' value='$num6'>	   
	   <input type='hidden' name='partf_fund_trans_amt' value='$partf_fund_trans_amt'>	   
       <input type='submit' name='submitb' value='Update'></form></td>";
      
echo "</tr>";

}

//echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";

 
echo "</table>";

echo "<form method=post action=stepJ9n_mark_complete.php>";	  
echo "<table><tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Mark_Step_Complete'></td></tr></table>";
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

echo "</html>";

/*

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


*/

?>

























