<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//$start_date=str_replace("-","",$start_date);


//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />"; //exit;

/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
*/


//include("../../../../include/activity.php");// database connection parameters
/*
$end_date=str_replace("-","",$end_date);
$start_date=str_replace("-","",$start_date);


$query0="select start_date as 'first_day_of_fyear' from fiscal_year
         where start_date <= '$start_date' and end_date >= '$start_date'            ";

//echo "query0=$query0<br /><br />"; //exit;
			 
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

$first_day_of_fyear=str_replace("-","",$first_day_of_fyear);
*/

//echo "first_day_of_fyear=$first_day_of_fyear";  exit;

//echo "start_date=$start_date <br />"; //exit;
//echo "end_date=$end_date <br />"; exit;



$query0="select count(whid) as 'exprev_count',sum(debit-credit) as 'exprev_amount'
from exp_rev_ws
where f_year=
'$fiscal_year'
and acctdate < '$start_date2'
and description='bank of america' ";



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
//echo "charge_amount='$charge_amount'"; //exit;
//echo "<br />echo query0=$query0<br />";

$query0a="select count(id)as 'pce_count',sum(debit-credit)as 'pce_amount'
from pcard_extract
where 1
and f_year=
'$fiscal_year' and acctdate < '$start_date2' ";

//echo "<br />query0a=$query0a<br />";

$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);


//$exprev_count=number_format($exprev_count,2);
//$exprev_amount=number_format($exprev_amount,2);
//$pce_count=number_format($pce_count,2);
//$pce_amount=number_format($pce_amount,2);


//echo "<br />exprev_count=$exprev_count<br />";
//echo "<br />pce_count=$pce_count<br />";
//echo "<br />exprev_amount=$exprev_amount<br />";
//echo "<br />pce_amount=$pce_amount<br />";

if($exprev_count==$pce_count){$count_balanced='y';}else{$count_balanced='n';}
if($exprev_amount==$pce_amount){$amount_balanced='y';}else{$amount_balanced='n';}

//echo "<br />count_balanced=$count_balanced<br />";
//echo "<br />amount_balanced=$amount_balanced<br />";


//exit;


if($count_balanced=='n' or $amount_balanced=='n')
{

{echo "<br /><font color='red' size='8'>StepG1.php failed. Unable to insert NEW PCARD Records into Table=pcard_extract.  Existing TABLE is not balanced to TABLE=exp_rev_ws. Possible Backdated Entries in Table=exp_rev_ws</font><br />"; exit;}

}




$query1="insert into pcard_extract(new_center,new_fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate)
select new_center,new_fund,acctdate,invoice,pe,description,debit,credit,sys,acct,f_year,dist,debit_credit,acct6,ciad,caa6,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate
from exp_rev_ws
where 1 and acctdate >=  
'$start_date2'
and acctdate <=
'$end_date2'
and description='bank of america'
group by whid;
";

//echo "query1=$query1<br /><br />"; exit;
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="update pcard_extract
set calendar_acctdate=concat(mid(acctdate,5,2),'/',mid(acctdate,7,2),'/',mid(acctdate,1,4))
where f_year=
'$fiscal_year'
and acctdate >=  
'$start_date2'
and acctdate <=
'$end_date2'
and calendar_acctdate='';
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


$query3="update pcard_extract,center
set pcard_extract.old_center=center.old_center
where pcard_extract.new_center=center.new_center
and f_year=
'$fiscal_year'
and acctdate >=  
'$start_date2'
and acctdate <=
'$end_date2';
";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update pcard_extract
         set center=new_center,fund=new_fund
		 where f_year='$fiscal_year' ";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



// added 5/6/20-tbass


$query5="update pcard_extract
         set pcard_user=pc_cardname,pcard_vendor=pc_merchantname,pcard_trans_date=concat(mid(pc_purchdate,5,2),'/',mid(pc_purchdate,7,2),'/',mid(pc_purchdate,1,4))
		 where 1 and acctdate >= '$start_date2' and acctdate <= '$end_date2' and pc_transid != '' ";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


// added 5/6/20-tbass


$query6="update pcard_extract
         set record_complete='y' 
		 where pcard_user != '' and pcard_vendor != '' and pcard_trans_date != '' and acctdate >= '$start_date2' and acctdate <= '$end_date2'   ";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="update pcard_extract
         set pc_merchantname='na',agency_admin='na',agency_location='na',pc_transdate='na',pc_cardname='na',pc_purchdate='na'
         where record_complete='n' and acctdate >= '$start_date2' and acctdate <= '$end_date2'   ";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$query8="update pcard_extract
         set pcard_vendor=pc_merchantname,pcard_trans_id=pc_transid,pcard_trans_date=pc_purchdate,pcard_user=pc_cardname
         where acctdate >= '$start_date2' and acctdate <= '$end_date2'   ";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");


$query8a="update pcard_extract,pcard_unreconciled
          set pcard_extract.pcard_user=pcard_unreconciled.cardholder_xtnd,
		      pcard_extract.pcard_vendor=pcard_unreconciled.vendor_name,
			  pcard_extract.pcard_trans_date=pcard_unreconciled.trans_date,
			  pcard_extract.record_complete='y'
         where pcard_extract.acctdate >= '$start_date2' and pcard_extract.acctdate <= '$end_date2'
         and pcard_extract.pcard_trans_id=pcard_unreconciled.transid_new
         and pcard_unreconciled.ncas_yn2='n'	
         and pcard_extract.record_complete='n'		 ";
			 
//echo "<br />query8a=$query8a<br />";
//echo "<br />Line 129<br />";
			 
			 
			 
			 
mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");




$query9=" update pcard_unreconciled,pcard_extract 
 set pcard_unreconciled.post2ncas=pcard_extract.acctdate,pcard_unreconciled.ncas_yn2='y'
 where pcard_unreconciled.transid_new=pcard_extract.pcard_trans_id 
 and pcard_unreconciled.ncas_yn2='n'
 and pcard_unreconciled.transid_new != '' 
 and pcard_extract.record_complete='y'
 and pcard_extract.acctdate >= '$start_date2' and pcard_extract.acctdate <= '$end_date2' ";
 
//echo "<br />query9=$query9<br />";
//echo "<br />Line 148<br />";


mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");







$query9a=" update pcard_unreconciled 
          set ncas_yn=ncas_yn2 where 1 ";
 
////echo "<br />query9a=$query9a<br />";
////echo "<br />Line 155<br />";

mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");


//exit;		  



$query9b="update pcard_extract,pcard_unreconciled
          set pcard_extract.pcard_user=pcard_unreconciled.cardholder_xtnd,
		      pcard_extract.pcard_vendor=pcard_unreconciled.vendor_name,
			  pcard_extract.pcard_trans_date=pcard_unreconciled.trans_date,
			  pcard_extract.record_complete='y'
         where pcard_extract.acctdate >= '$start_date2' and pcard_extract.acctdate <= '$end_date2'
         and pcard_extract.pcard_trans_id=pcard_unreconciled.transid_new
         and pcard_unreconciled.ncas_yn2='y'
         and pcard_unreconciled.transdate_new >= '$first_day_of_fyear'		 
         and pcard_extract.record_complete='n'		 ";
			 
////echo "<br />query9b=$query9b<br />";
////echo "<br />Line 185<br />";		 
			 
//exit;			 
			 
mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");


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