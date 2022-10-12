<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//$status='complete';


$query="truncate table bd725_dpr_temp_pre2";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="insert into bd725_dpr_temp_pre2(bc_fu_fud_acc,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance)
        select account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance
		from bd725_dpr_temp_pre
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");

$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=trim(bc_fu_fud_acc)
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");




$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='rmdsid46' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='----------' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='460   DEPT' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='461   DEPT' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='ACCOUNT' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-01' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-02' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BUDGET COD' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS OF' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXPENDITUR' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='FRU TOTALS' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='REVENUES -' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='43' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");

$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='53' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set account_len=char_length(account)
		where account != '' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set account_valid='y'
		where (account_len='6' or account_len='9') ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=mid(bc_fu_fud_acc,1,5)
        where account_valid!='y'		";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=trim(bc_fu_fud_acc2)
        where 1		";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2_len=char_length(bc_fu_fud_acc2)
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="delete from bd725_dpr_temp_pre2
        where bc_fu_fud_acc2_len='0'
		and account_valid != 'y' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set bc=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='5' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set fund=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='4' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set fund_descript_pre=SUBSTR(bc_fu_fud_acc,5) 
        WHERE 1  
        AND fund !=  '' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set fund_descript=concat(fund_descript_pre,account_descript)
        WHERE 1  
        AND fund !=  '' ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");








$query="update bd725_dpr_temp_pre2
        set bc=mid(bc_fu_fud_acc,1,5)
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set fund=mid(bc_fu_fud_acc,1,4)
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set fund_descript=bc_fu_fud_acc
		where 1 ";
		  
		  
mysql_query($query) or die ("Couldn't execute query.  $query");









 
 ?>




















