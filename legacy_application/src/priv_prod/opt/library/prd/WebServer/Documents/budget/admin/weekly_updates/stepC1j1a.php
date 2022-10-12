<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
//include("../../../include/activity_new.php");// database connection parameters
//$status='complete';

$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1j1a';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


$query="truncate table bd725_dpr_temp_pre2";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");		  
		  



$query="insert into bd725_dpr_temp_pre2(bc_fu_fud_acc,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance)
        select account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance
		from bd725_dpr_temp_pre
		where 1 ";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");			  
		  


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=trim(bc_fu_fud_acc)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	




$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='rmdsid46' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='----------' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='460   DEPT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='461   DEPT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='ACCOUNT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-01' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-02' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BUDGET COD' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS OF' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXPENDITUR' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='FRU TOTALS' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='REVENUES -' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='43' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	

$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='53' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set account_len=char_length(account)
		where account != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set account_valid='y'
		where (account_len='6' or account_len='9') ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=mid(bc_fu_fud_acc,1,5)
        where account_valid!='y'		";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=trim(bc_fu_fud_acc2)
        where 1		";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2_len=char_length(bc_fu_fud_acc2)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="delete from bd725_dpr_temp_pre2
        where bc_fu_fud_acc2_len='0'
		and account_valid != 'y' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='5' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set fund=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='4' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set fund_descript_pre=SUBSTR(bc_fu_fud_acc,5) 
        WHERE 1  
        AND fund !=  '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=concat(fund_descript_pre,account_descript)
        WHERE 1  
        AND fund !=  '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc=mid(bc_fu_fud_acc,1,5)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund=mid(bc_fu_fud_acc,1,4)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=bc_fu_fud_acc
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc=''
		where bc_fu_fud_acc2_len != '5' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund=''
		where bc_fu_fud_acc2_len != '4' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=concat(fund_descript_pre,account_descript)
		where fund != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set fund_descript=trim(fund_descript)
		where fund != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set fund_descript=''
		where fund = '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");




$query="truncate table bd725_dpr_temp_pre3";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");


$query="insert into bd725_dpr_temp_pre3(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr 
from bd725_dpr_temp_pre2 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");





$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	




{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}




 
 ?>