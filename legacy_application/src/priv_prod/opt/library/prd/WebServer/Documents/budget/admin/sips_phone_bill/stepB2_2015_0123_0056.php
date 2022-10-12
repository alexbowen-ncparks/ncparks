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
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
echo "tempid=$tempid<br />";

$database="divper";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$tempid'";
echo "sql=$sql<br />"; //exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$row=mysql_fetch_array($result);
extract($row);

$prepared_by=$Fname." ".$Lname;

$received_by=$prepared_by;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters


$query5a="truncate table sips_phone_bill3; ";
			 
mysql_query($query5a) or die ("Couldn't execute query 5a.  $query5a");

$query5b="insert into sips_phone_bill3(a,b,c,d,e,f,g,h,i,j,row,id)
select a,b,c,d,e,f,g,h,i,j,row,id
from sips_phone_bill2
where 1; ";
			 
mysql_query($query5b) or die ("Couldn't execute query 5b.  $query5b");




$query6="select min(id) as 'start_id' from sips_phone_bill3 where 1; ";
			 
$result6=mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysql_fetch_array($result6);

extract($row6); //brings back id value for first record in table=exp_rev_down_temp2

$query7="select max(id) as 'end_id' from sips_phone_bill3 where 1; ";
			 
$result7=mysql_query($query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysql_fetch_array($result7);

extract($row7); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
$record2=$start_id+1;
//echo "<br />";
//echo "record2=$record2"; exit;

$query8="select * from sips_phone_bill3 where 1 and id >= '$record2' order by id asc ";
$result8=mysql_query($query8) or die ("Couldn't execute query 8.  $query8");

while ($row8=mysql_fetch_array($result8))
{

extract($row8);

$previous_record=$id-1;


$query9="update sips_phone_bill3,sips_phone_bill2
         set sips_phone_bill3.a=sips_phone_bill2.a
		 where sips_phone_bill3.id='$id' and sips_phone_bill2.id='$previous_record'
		 and sips_phone_bill3.row='2' ";
		 
$result9=mysql_query($query9) or die ("Couldn't execute query 9.  $query9");

/*
$query10="update exp_rev_down_temp2,exp_rev_down_temp3
         set exp_rev_down_temp2.acct=exp_rev_down_temp3.acct
		 where exp_rev_down_temp2.id='$id' and exp_rev_down_temp3.id='$id'
		 and exp_rev_down_temp2.acct='' ";
		 
$result10=mysql_query($query10) or die ("Couldn't execute query 10.  $query10");
*/

}

$query11=" update sips_phone_bill3
set center=mid(a,5,8)
where 1 ; ";

$result11=mysql_query($query11) or die ("Couldn't execute query 11.  $query11");

$query12=" update sips_phone_bill3
set invoice_num=mid(a,23,10)
where 1 ; ";

$result12=mysql_query($query12) or die ("Couldn't execute query 12.  $query12");


$query13="truncate table sips_phone_bill4 ; ";

$result13=mysql_query($query13) or die ("Couldn't execute query 13.  $query13");


$query13b="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532811','local service',invoice_num,b
           from sips_phone_bill3
           where row='1' ";

$result13b=mysql_query($query13b) or die ("Couldn't execute query 13b.  $query13b");

$query13c="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532819','inst/svc/maint',invoice_num,c
           from sips_phone_bill3
           where row='1' ";

$result13c=mysql_query($query13c) or die ("Couldn't execute query 13c.  $query13c");


$query13d="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','voice misc',invoice_num,d
           from sips_phone_bill3
           where row='1' ";

$result13d=mysql_query($query13d) or die ("Couldn't execute query 13d.  $query13d");


$query13e="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532812','wan',invoice_num,e
           from sips_phone_bill3
           where row='1' ";

$result13e=mysql_query($query13e) or die ("Couldn't execute query 13e.  $query13e");


$query13f="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','sna',invoice_num,f
           from sips_phone_bill3
           where row='1' ";

$result13f=mysql_query($query13f) or die ("Couldn't execute query 13f.  $query13f");

$query13g="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','point to point',invoice_num,g
           from sips_phone_bill3
           where row='1' ";

$result13g=mysql_query($query13g) or die ("Couldn't execute query 13g.  $query13g");

$query13h="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','dial-up data',invoice_num,h
           from sips_phone_bill3
           where row='1' ";

$result13h=mysql_query($query13h) or die ("Couldn't execute query 13h.  $query13h");

$query13i="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532811','long distance',invoice_num,i
           from sips_phone_bill3
           where row='1' ";

$result13i=mysql_query($query13i) or die ("Couldn't execute query 13i.  $query13i");


$query14b="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','virtual service',invoice_num,b
           from sips_phone_bill3
           where row='2' ";

$result14b=mysql_query($query14b) or die ("Couldn't execute query 14b.  $query14b");


$query14c="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532811','800 service',invoice_num,c
           from sips_phone_bill3
           where row='2' ";

$result14c=mysql_query($query14c) or die ("Couldn't execute query 14c.  $query14c");

$query14d="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532811','calling cards',invoice_num,d
           from sips_phone_bill3
           where row='2' ";

$result14d=mysql_query($query14d) or die ("Couldn't execute query 14d.  $query14d");

$query14e="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532814','cellular charges',invoice_num,e
           from sips_phone_bill3
           where row='2' ";

$result14e=mysql_query($query14e) or die ("Couldn't execute query 14e.  $query14e");


$query14f="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','video service',invoice_num,f
           from sips_phone_bill3
           where row='2' ";

$result14f=mysql_query($query14f) or die ("Couldn't execute query 14f.  $query14f");


$query14g="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','misc/pass through',invoice_num,g
           from sips_phone_bill3
           where row='2' ";

$result14g=mysql_query($query14g) or die ("Couldn't execute query 14g.  $query14g");

$query14h="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'none','erate',invoice_num,h
           from sips_phone_bill3
           where row='2' ";

$result14h=mysql_query($query14h) or die ("Couldn't execute query 14h.  $query14h");

$query14i="insert into sips_phone_bill4(center,account,service,invoice_num,amount)
           select center,'532822','lan',invoice_num,i
           from sips_phone_bill3
           where row='2' ";

$result14i=mysql_query($query14i) or die ("Couldn't execute query 14i.  $query14i");



$query14j="delete from sips_phone_bill4
           where amount='0' ";

$result14j=mysql_query($query14j) or die ("Couldn't execute query 14j.  $query14j");


$query14k="update sips_phone_bill4
         set prepared_by='$prepared_by',received_by='$received_by'
		 where 1 ";
		 
$result14k=mysql_query($query14k) or die ("Couldn't execute query 14k.  $query14k");

$tempid2=substr($tempid,0,-2);
$query14m="update sips_phone_bill4
         set user_id='$tempid2'
		 where 1 ";

//echo "query14m=$query14m<br />"; exit;
		 
$result14m=mysql_query($query14m) or die ("Couldn't execute query 14m.  $query14m");


$query15="update sips_phone_bill4,center
          set sips_phone_bill4.playstation=center.parkcode
		  where sips_phone_bill4.center=center.center ";

$result15=mysql_query($query15) or die ("Couldn't execute query 15.  $query15");



$query16a="update sips_phone_bill4
           set prefix=mid(account,1,2),ncas_number=mid(account,3,7),ncas_account=account,
		   ncas_fund=mid(center,1,4),ncas_rcc=mid(center,5,4),ncas_center=center
		   where 1 ";

$result16a=mysql_query($query16a) or die ("Couldn't execute query 16a.  $query16a");


$query16b="update sips_phone_bill4,center
           set sips_phone_bill4.ncas_company=center.company,
		   sips_phone_bill4.ncas_budget_code=center.budcode
		   where sips_phone_bill4.center=center.center  ";
		 

$result16b=mysql_query($query16b) or die ("Couldn't execute query 16b.  $query16b");




/*
$query16b="";

$result16b=mysql_query($query16b) or die ("Couldn't execute query 16b.  $query16b");



$query16c="";

$result16c=mysql_query($query16c) or die ("Couldn't execute query 16c.  $query16c");


$query16d="";

$result16d=mysql_query($query16d) or die ("Couldn't execute query 16d.  $query16d");


$query16e="";

$result16e=mysql_query($query16e) or die ("Couldn't execute query 16e.  $query16e");


*/



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

/*

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);
//echo "num24=$num24";exit;
//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}

*/
mysql_close();
/*
if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0) 
//{echo "num24 not equal to zero";}
*/
{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y");}

 ?>




















