<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
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
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="delete from fixed_assets1 where field4=''; ";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from fixed_assets1
where field4 like '%ACCOUNTS%';
";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from fixed_assets1
where field4 like '%ASSET%';
 ";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="delete from fixed_assets1
where field4 like '%PERIOD%';
";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="delete from fixed_assets1
where field4 like '%NUMBER%';
";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query5a="delete from fixed_assets1
where field4 like '%INVOICE%';
";
			 
mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

$query5b="delete from fixed_assets1
where field4 like '%----%';
";
			 
mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");

$query5c="
update fixed_assets1
set field1=trim(field1),field2=trim(field2),field3=trim(field3),
field4=trim(field4),field5=trim(field5),field6=trim(field6),
field7=trim(field7),field8=trim(field8);

";
			 
mysqli_query($connection, $query5c) or die ("Couldn't execute query 5c.  $query5c");

$query5d="
update fixed_assets1
set field1=replace(field1,'\"','')";
			 
mysqli_query($connection, $query5d) or die ("Couldn't execute query 5d.  $query5d");

$query5e="
update fixed_assets1
set field8=replace(field8,'\"','')";
			 
mysqli_query($connection, $query5e) or die ("Couldn't execute query 5e.  $query5e");

$query5f="
update fixed_assets1
set field1=trim(field1),field2=trim(field2),field3=trim(field3),
field4=trim(field4),field5=trim(field5),field6=trim(field6),
field7=trim(field7),field8=trim(field8);

";
			 
mysqli_query($connection, $query5f) or die ("Couldn't execute query 5f.  $query5f");

$query5g="
truncate table fixed_assets2;
";
			 
mysqli_query($connection, $query5g) or die ("Couldn't execute query 5g.  $query5g");

$query5h="
insert into fixed_assets2(field1,field2,field3,field4,field5,field6,field7,field8)
select field1,field2,field3,field4,field5,field6,field7,field8
from fixed_assets1 where 1;

";
			 
mysqli_query($connection, $query5h) or die ("Couldn't execute query 5h.  $query5h");


$query5j="
truncate table fixed_assets3;
";
			 
mysqli_query($connection, $query5j) or die ("Couldn't execute query 5j.  $query5j");

$query5k="
insert into fixed_assets3(field1,field2,field3,field4,field5,field6,field7,field8)
select field1,field2,field3,field4,field5,field6,field7,field8
from fixed_assets1 where 1;

";
			 
mysqli_query($connection, $query5k) or die ("Couldn't execute query 5k.  $query5k");



$query6="select min(id) as 'start_id' from fixed_assets3 where 1; ";
			 
$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);

extract($row6); //brings back id value for first record in table=exp_rev_down_temp2

$query7="select max(id) as 'end_id' from fixed_assets3 where 1; ";
			 
$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysqli_fetch_array($result7);

extract($row7); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
//$record2=$start_id+1;
//echo "<br />";
//echo "record2=$record2"; exit;



$query8="select * from  fixed_assets3 where 1 and id < '$end_id' order by id asc ";
$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

while ($row8=mysqli_fetch_array($result8))
{

extract($row8);

$next_record=$id+1;


$query9="update fixed_assets3,fixed_assets2
         set fixed_assets3.field9=fixed_assets2.field1,
		     fixed_assets3.field10=fixed_assets2.field2, 
		     fixed_assets3.field11=fixed_assets2.field3, 
		     fixed_assets3.field12=fixed_assets2.field4, 
		     fixed_assets3.field13=fixed_assets2.field5, 
		     fixed_assets3.field14=fixed_assets2.field6, 
		     fixed_assets3.field15=fixed_assets2.field7, 
		     fixed_assets3.field16=fixed_assets2.field8 
		 where fixed_assets3.id='$id' and fixed_assets2.id='$next_record'
		 ";
		 
$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");



	

//$query10="update exp_rev_down_temp2,exp_rev_down_temp3
//         set exp_rev_down_temp2.acct=exp_rev_down_temp3.acct
//		 where exp_rev_down_temp2.id='$id' and exp_rev_down_temp3.id='$id'
//		 and exp_rev_down_temp2.acct='' ";
		 
//$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

}

$query10="delete from  fixed_assets3 where field1 not like '016%' ";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


$query11="update fixed_assets3 
          set lvl1=mid(field1,1,3),lvl2=mid(field1,6,3),temp_an=mid(field1,12,8),
		      asset_descript=field9,budget_code=field2,buy_entity=field10,center=field3,
			  pay_entity=field11,invoice=field12,
              account=field5,std_descript=field13,control_date=mid(field6,1,6),
              vendor_num=field14,control_group=mid(field6,10,4),acq_date=field7,
              cost=field8,vendor_name=field16
           where 1;			  
           ";
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

//po_number=mid(field4,1,10),
//check_num=mid(field4,13,9),

$query11a="update fixed_assets3
           set po_number=mid(field4,1,10) where field4 like 'NC%'";
$result11a=mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");

$query11b="update fixed_assets3
           set check_num=mid(field4,13,9) where field4 like 'NC%'";
$result11b=mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");

$query11c="update fixed_assets3
           set check_num=mid(field4,1,9) where field4 like '00%'";
$result11c=mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c");

$query12="update fixed_assets3 set cost=replace(cost,',','') where 1; ";
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="insert into fixed_assets4(lvl1,lvl2,temp_an,perm_an,asset_descript,budget_code,buy_entity,center,
          pay_entity,po_number,invoice,check_num,account,std_descript,control_date,vendor_num,
		  control_group,acq_date,cost,vendor_name)
		  select lvl1,lvl2,temp_an,perm_an,asset_descript,budget_code,buy_entity,center,
		  pay_entity,po_number,invoice,check_num,account,std_descript,control_date,vendor_num,
		  control_group,acq_date,cost,vendor_name
		  from fixed_assets3 where 1; ";
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


/*
$query11="update exp_rev_down_temp3
set valid_record='y'
where mid(acctdate,3,1)='/'
and mid(acctdate,6,1)='/' ; ";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="update budget.exp_rev_down_temp3
set acctdate_new=concat(mid(acctdate,7,4),
mid(acctdate,1,2),
mid(acctdate,4,2))
where 1 ; ";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


*/

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);
//echo "num24=$num24";exit;
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
//{echo "num24 not equal to zero";}

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 ?>




















