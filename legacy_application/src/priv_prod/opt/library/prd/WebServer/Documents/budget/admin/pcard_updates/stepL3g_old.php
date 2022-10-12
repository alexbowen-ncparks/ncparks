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
echo "start_date=$start_date";
echo "<br />"; 
echo "end_date=$end_date";//exit;
echo "<br />"; 
echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query0="select xtnd_start as 'day1' from pcard_report_dates where xtnd_start='$start_date' ";



$query1="update pcard_unreconciled
set reconciled=''
where reconciled='n'; ";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="update pcard_unreconciled_xtnd
set trans_date=trim(trans_date);
delete from pcard_unreconciled_xtnd
where amount=''; ";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="INSERT  IGNORE  INTO pcard_unreconciled(
location,
admin_num,
post_date,
trans_date,
amount,
vendor_name,
address,
trans_id,
pcard_num,
xtnd_rundate,
transdate_new,
parkcode,
cardholder,
transid_new,
postdate_new,
xtnd_rundate_new,
item_purchased,
ncasnum,
center,
park_recondate,
budget2controllers,
post2ncas,
company,
projnum,
equipnum,
budget_ok,
reconciled,
reconcilement_date,
recon_complete,
ncas_description,
report_date,
ca,
count_amount,
ca_count_posted,
ca_count_unposted,
f_year)
select
location,
admin_num,
post_date,
trans_date,
amount,
vendor_name,
address,
trans_id,
pcard_num,
xtnd_rundate,
transdate_new,
parkcode,
xtnd_cardholder,
transid_new,
postdate_new,
xtnd_rundate_new,
item_purchased,
ncasnum,
center,
park_recondate,
budget2controllers,
post2ncas,
company,
projnum,
equipnum,
budget_ok,
reconciled,
reconcilement_date,
recon_complete,
ncas_description,
report_date,
ca,
count_amount,
ca_count_posted,
ca_count_unposted,
f_year
from pcard_unreconciled_xtnd
where valid_record='y'; ";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="update pcard_unreconciled set location=trim(location);
update pcard_unreconciled set cardholder=trim(cardholder);
update pcard_unreconciled set admin_num=trim(admin_num);
update pcard_unreconciled set post_date=trim(post_date);
update pcard_unreconciled set trans_date=trim(trans_date);
update pcard_unreconciled set amount=trim(amount);
update pcard_unreconciled set vendor_name=trim(vendor_name);
update pcard_unreconciled set address=trim(address);
update pcard_unreconciled set pcard_num=trim(pcard_num);
update pcard_unreconciled set xtnd_rundate=trim(xtnd_rundate); ";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="update pcard_unreconciled
set transdate_new=concat(mid(trans_date,7,4),mid(trans_date,1,2),mid(trans_date,4,2))
where 1; ";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="update pcard_unreconciled
set postdate_new=concat(mid(post_date,7,4),mid(post_date,1,2),mid(post_date,4,2))
where 1; ";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="update pcard_unreconciled,pcard_users
set pcard_unreconciled.parkcode=pcard_users.parkcode
where pcard_unreconciled.pcard_num=pcard_users.card_number; ";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="update pcard_unreconciled,pcard_users
set pcard_unreconciled.cardholder=pcard_users.last_name
where pcard_unreconciled.pcard_num=pcard_users.card_number; ";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="update pcard_unreconciled
set transid_new=
LPAD( trim(replace(trans_id,',','')),9,'0') 
WHERE 1 and transid_new=''; ";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="update pcard_unreconciled_xtnd
set transid_new=
LPAD( trim(replace(trans_id,',','')),9,'0') 
WHERE 1 and transid_new=''; ";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$query11="update pcard_unreconciled
set xtnd_rundate_new=concat('20',mid(xtnd_rundate,7,2),mid(xtnd_rundate,1,2),mid(xtnd_rundate,4,2))
where 1; ";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="update pcard_unreconciled
set report_date=
'$end_date'
where xtnd_rundate_new >= 
'$start_date'
and xtnd_rundate_new <= 
'$end_date'
and report_date=''; ";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="update pcard_unreconciled
set company='1601'
where (location='1616' or location='1656')
and company='';
update pcard_unreconciled
set company='1604'
where (location='1629' or location='1669')
and company=''; ";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="update pcard_unreconciled_xtnd set location=trim(location);
update pcard_unreconciled_xtnd set cardholder=trim(cardholder);
update pcard_unreconciled_xtnd set admin_num=trim(admin_num);
update pcard_unreconciled_xtnd set post_date=trim(post_date);
update pcard_unreconciled_xtnd set trans_date=trim(trans_date);
update pcard_unreconciled_xtnd set amount=trim(amount);
update pcard_unreconciled_xtnd set vendor_name=trim(vendor_name);
update pcard_unreconciled_xtnd set address=trim(address);
update pcard_unreconciled_xtnd set pcard_num=trim(pcard_num);
update pcard_unreconciled_xtnd set xtnd_rundate=trim(xtnd_rundate); ";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="update pcard_unreconciled,pcard_unreconciled_xtnd
set pcard_unreconciled.reconciled='n'
where pcard_unreconciled.transid_new=pcard_unreconciled_xtnd.transid_new
and pcard_unreconciled.reconciled=''; ";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="update pcard_unreconciled
set reconcilement_date=
'20091204'
where reconciled=''; ";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="update pcard_unreconciled
set reconciled='y'
where reconciled=''; ";
mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="update pcard_unreconciled,pcard_users
set pcard_unreconciled.center=pcard_users.center
where pcard_unreconciled.pcard_num=pcard_users.card_number
and pcard_unreconciled.center=''
and pcard_unreconciled.report_date=
'20091204'; ";
mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="update pcard_unreconciled,coa
set pcard_unreconciled.ncas_description=coa.park_acct_desc
where pcard_unreconciled.ncasnum=coa.ncasnum; ";
mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query20="select count (distinct transid_new)
from pcard_unreconciled
where reconciled='n'; ";
mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");

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




?>

























