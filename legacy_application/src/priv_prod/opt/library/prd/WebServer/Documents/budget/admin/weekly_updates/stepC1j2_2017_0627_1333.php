<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



$query5="update budget.bd725_dpr_temp_pre3
set bc=trim(bc),
fund=trim(fund),
fund_descript=trim(fund_descript),
account=trim(account),
account_descript=trim(account_descript),
total_budget=trim(total_budget),
unallotted=trim(unallotted),
total_allotments=trim(total_allotments),
current=trim(current),
ytd=trim(ytd),
ptd=trim(ptd),
allotment_balance=trim(allotment_balance),
dpr=trim(dpr) ";
			 
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

$query5a="truncate table bd725_dpr_temp_pre4; ";
			 
mysql_query($query5a) or die ("Couldn't execute query 5a.  $query5a");

$query5b="insert into bd725_dpr_temp_pre4(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr
from bd725_dpr_temp_pre3
where 1 ";
			 
mysql_query($query5b) or die ("Couldn't execute query 5b.  $query5b");




$query6="select min(id) as 'start_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result6=mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysql_fetch_array($result6);

extract($row6); //brings back id value for first record in table=exp_rev_down_temp2

$query7="select max(id) as 'end_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result7=mysql_query($query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysql_fetch_array($result7);

extract($row7); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
$record2=$start_id+1;
//echo "<br />";
//echo "record2=$record2"; exit;

$query8="select * from bd725_dpr_temp_pre4 where 1 and id >= '$record2' order by id asc ";
$result8=mysql_query($query8) or die ("Couldn't execute query 8.  $query8");

while ($row8=mysql_fetch_array($result8))
{

extract($row8);

$previous_record=$id-1;


$query9="update bd725_dpr_temp_pre4,bd725_dpr_temp_pre3
         set bd725_dpr_temp_pre4.fund=bd725_dpr_temp_pre3.fund,bd725_dpr_temp_pre4.fund_descript=bd725_dpr_temp_pre3.fund_descript
		 where bd725_dpr_temp_pre4.id='$id' and bd725_dpr_temp_pre3.id='$previous_record'
		 and bd725_dpr_temp_pre4.fund='' ";
		 
$result9=mysql_query($query9) or die ("Couldn't execute query 9.  $query9");	

$query10="update bd725_dpr_temp_pre3,bd725_dpr_temp_pre4
         set bd725_dpr_temp_pre3.fund=bd725_dpr_temp_pre4.fund,bd725_dpr_temp_pre3.fund_descript=bd725_dpr_temp_pre4.fund_descript
		 where bd725_dpr_temp_pre3.id='$id' and bd725_dpr_temp_pre4.id='$id'
		 and bd725_dpr_temp_pre3.fund='' ";
		 
$result10=mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


}

echo "<br />Line 103: Update Successful<br />";

 ?>