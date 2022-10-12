<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
if($cs_update=='')
{

$todays_date=date("Ymd", time() );

$todays_date='20150909';

$query2="SELECT min(date) as 'upload_date',hid
          from mission_headlines
		  where undeposited_message='n'
		  and date >= '20140816'
		  and date <= '$todays_date' ";
echo "query2=$query2<br />";//exit;		  
 $result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2 ");

$row2=mysql_fetch_array($result2);
extract($row2);


$upload_date=str_replace("-","",$upload_date);
$upload_date2=strtotime("$upload_date");
$upload_yesterday=($upload_date2-60*60*24);
$upload_dayb4yesterday=($upload_date2-60*60*24*2);

$upload_date2=date("Ymd", $upload_date2);
$upload_yesterday2=date("Ymd", $upload_yesterday);
$upload_dayb4yesterday2=date("Ymd", $upload_dayb4yesterday);



echo "upload_date2=$upload_date2<br />";
echo "upload_yesterday2=$upload_yesterday2<br />";
echo "upload_dayb4_yesterday2=$upload_dayb4yesterday2<br />";
//$todays_date=date("Ymd", time() );
$today=$upload_date2;
$yesterday=$upload_yesterday2;
$dayb4yesterday=$upload_dayb4yesterday2;



echo "<table align='center' border='1'>";
echo "<tr>";
echo "<td>todays_date=$todays_date</td>";
echo "</tr>";
echo "<tr>";
echo "<td>today=$today</td>";
echo "</tr>";
echo "<tr>";
echo "<td>yesterday=$yesterday</td>";
echo "</tr>";
echo "<tr>";
echo "<td>dayb4yesterday=$dayb4yesterday</td>";
echo "</tr>";
echo "<tr>";
echo "<td><a href='cash_summary_update.php?cs_update=y&upload_date=$upload_date'>Cash Summary Update thru: $yesterday </a></td>";
exit;
}


if($cs_update=='y')
{
//echo "Update Tables<br />";



/*

$query1="insert into cash_trans
(center,trans_date,amount)
SELECT center, transdate_new, sum( amount )
FROM `crs_tdrr_division_history`
WHERE transdate_new = '$yesterday'
AND deposit_transaction = 'y'
and ncas_account != '000437995'
GROUP BY center, transdate_new";
		 

mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query1a="insert into cash_deposits
(center,deposit_date,amount)
SELECT center,deposit_date_new,sum(amount)
from crs_tdrr_division_history_parks
where 1 and deposit_transaction='y'
and deposit_date_new = '$yesterday'
group by center,deposit_date_new";
			 
mysql_query($query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2="update crs_tdrr_division_history
set deposit_date_new='0000-00-00',deposit_id='none'
where deposit_date_new='$today'; ";

		 
mysql_query($query2) or die ("Couldn't execute query 2.  $query2");



$query2a="insert into cash_undeposited
(center,effective_date,amount)
select center,'$yesterday',sum(amount)
from crs_tdrr_division_history
where deposit_transaction='y'
and deposit_id='none'
and ncas_account != '000437995'
group by center;";
			 
mysql_query($query2a) or die ("Couldn't execute query 2a.  $query2a");



$query3="insert into cash_summary(center,effect_date)
select center,'$yesterday'
from center_taxes
where orms='y'";
			 
mysql_query($query3) or die ("Couldn't execute query 3.  $query3");

$query4="update cash_summary,cash_trans
set cash_summary.transaction_amount=cash_trans.amount
where cash_summary.center=cash_trans.center
and cash_summary.effect_date='$yesterday'
and cash_trans.trans_date='$yesterday'";
			 
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

$query5="update cash_summary,cash_deposits
set cash_summary.deposit_amount=cash_deposits.amount
where cash_summary.center=cash_deposits.center
and cash_summary.effect_date='$yesterday'
and cash_deposits.deposit_date='$yesterday'";
			 
mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

$query6="update cash_summary,cash_undeposited
set cash_summary.end_bal=cash_undeposited.amount
where cash_summary.center=cash_undeposited.center
and cash_summary.effect_date='$yesterday'
and cash_undeposited.effective_date='$yesterday'";
			 
mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$query7="update cash_summary
set beg_bal=end_bal-transaction_amount+deposit_amount
where effect_date='$yesterday'";
			 
mysql_query($query7) or die ("Couldn't execute query 7.  $query7");

$query8="update cash_summary
set undeposited_amount=beg_bal-deposit_amount
where effect_date='$yesterday'";
			 
mysql_query($query8) or die ("Couldn't execute query 8.  $query8");

$query9="truncate table cash_deposits_max; ";
			 
mysql_query($query9) or die ("Couldn't execute query 9.  $query9");


$query9a="insert into cash_deposits_max(center,deposit_date_max)
select center,max(orms_deposit_date)
from crs_tdrr_division_deposits
where trans_table='y'
group by center;";
			 
mysql_query($query9a) or die ("Couldn't execute query 9a.  $query9a");


$query9b="truncate table cash_undeposited_min; ";
			 
mysql_query($query9b) or die ("Couldn't execute query 9b.  $query9b");


$query9c="insert into cash_undeposited_min(center,cash_trans_min)
select center,min(transdate_new)
from crs_tdrr_division_history
where deposit_id='none'
group by center; ";
			 
mysql_query($query9c) or die ("Couldn't execute query 9c.  $query9c");


$query9d="truncate table cash_undeposited_max; ";
			 
mysql_query($query9d) or die ("Couldn't execute query 9d.  $query9d");

$query9e="insert into cash_undeposited_max(center,cash_trans_max)
select center,max(transdate_new)
from crs_tdrr_division_history
where deposit_id='none'
group by center; ";
			 
mysql_query($query9e) or die ("Couldn't execute query 9e.  $query9e");



$query10="update cash_summary,cash_deposits_max
set cash_summary.last_deposit=cash_deposits_max.deposit_date_max
where cash_summary.center=cash_deposits_max.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


$query10a="update cash_summary,cash_undeposited_min
set cash_summary.undeposited_transdate_min=cash_undeposited_min.cash_trans_min
where cash_summary.center=cash_undeposited_min.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysql_query($query10a) or die ("Couldn't execute query 10a.  $query10a");


$query10b="update cash_summary,cash_undeposited_max
set cash_summary.undeposited_transdate_max=cash_undeposited_max.cash_trans_max
where cash_summary.center=cash_undeposited_max.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysql_query($query10b) or die ("Couldn't execute query 10b.  $query10b");


$query11="update cash_summary set days_elapsed=datediff(effect_date,last_deposit)
where effect_date='$yesterday';";
			 
mysql_query($query11) or die ("Couldn't execute query 11.  $query11");


$query11a="update cash_summary set days_elapsed2=datediff(effect_date,undeposited_transdate_min)
where effect_date='$yesterday'; ";
			 
mysql_query($query11a) or die ("Couldn't execute query 11a.  $query11a");


$query11b="update cash_summary set
days_elapsed2='0'
where days_elapsed2=''
and effect_date='$yesterday'
;";
			 
mysql_query($query11b) or die ("Couldn't execute query 11b.  $query11b");


$query12="update cash_summary,center
set cash_summary.park=center.parkcode
where cash_summary.center=center.center";
			 
mysql_query($query12) or die ("Couldn't execute query 12.  $query12");


$query13="update cash_summary
set compliance='n'
where deposit_amount < beg_bal
and beg_bal >= '250.00'
and effect_date='$yesterday'";
			 
mysql_query($query13) or die ("Couldn't execute query 13.  $query13");


$query14="update cash_summary
set compliance='n'
where beg_bal < '250.00'
and days_elapsed2 > '6'
and deposit_amount < beg_bal
and effect_date='$yesterday'";
			 
mysql_query($query14) or die ("Couldn't execute query 14.  $query14");


$query15="select weekend as 'weekendDay'
          from mission_headlines where date='$yesterday' ";
		 
//echo "query1=$query1<br />";		 

$result15 = mysql_query($query15) or die ("Couldn't execute query 15.  $query15");

$row15=mysql_fetch_array($result15);
extract($row15);

if($weekendDay=='y')
{
$query16="update cash_summary
set weekend='y'
where effect_date='$yesterday'";

$result16 = mysql_query($query16) or die ("Couldn't execute query 16.  $query16");

$query16a="truncate table cash_last_valid_depdate";

$result16a = mysql_query($query16a) or die ("Couldn't execute query 16a.  $query16a");

$query16b="insert into cash_last_valid_depdate(center,park,effect_date,compliance)
           select center,park,effect_date,compliance
		   from cash_summary 
		   where weekend='n'  ";

$result16b = mysql_query($query16b) or die ("Couldn't execute query 16b.  $query16b");

$query16c="select effect_date as 'last_valid_depdate'
         from cash_last_valid_depdate
		 where effect_date < '$today'
		 order by effect_date desc
		 limit 1 ";
		 
//echo "query1=$query1<br />";		 

$result16c = mysql_query($query16c) or die ("Couldn't execute query 16c.  $query16c");

$row16c=mysql_fetch_array($result16c);
extract($row16c);

$query16d="update cash_summary,cash_last_valid_depdate
set cash_summary.compliance=cash_last_valid_depdate.compliance
where cash_summary.center=cash_last_valid_depdate.center
and cash_summary.effect_date='$yesterday'
and cash_last_valid_depdate.effect_date='$last_valid_depdate'
";
			 
mysql_query($query16d) or die ("Couldn't execute query 16d.  $query16d");



}

$query17="truncate cash_summary_exceptions2;";

$result17 = mysql_query($query17) or die ("Couldn't execute query 17.  $query17");


$query18="insert into cash_summary_exceptions2
(center,park,exceptions)
select center,park,count(compliance)
from cash_summary where valid='y'
and weekend='n'
and compliance='n'
and fyear='1516'
group by center;";

$result18 = mysql_query($query18) or die ("Couldn't execute query 18.  $query18");


$query19="update cash_summary_exceptions2
set effect_date='$yesterday'
where 1;";

$result19 = mysql_query($query19) or die ("Couldn't execute query 19.  $query19");


$query20="update cash_summary,cash_summary_exceptions2
set cash_summary.exceptions=cash_summary_exceptions2.exceptions
where cash_summary.center=cash_summary_exceptions2.center
and cash_summary.effect_date=cash_summary_exceptions2.effect_date;";

$result20 = mysql_query($query20) or die ("Couldn't execute query 20.  $query20");



$query17a="truncate cash_summary_justified2;";

$result17a = mysql_query($query17a) or die ("Couldn't execute query 17a.  $query17a");


$query18a="insert into cash_summary_justified2
(center,park,justified)
select center,park,count(id)
from cash_summary where valid='y'
and weekend='n'
and compliance='n'
and pasu_comment != ''
and fyear='1516'
group by center;";

$result18a = mysql_query($query18a) or die ("Couldn't execute query 18a.  $query18a");


$query19a="update cash_summary_justified2
set effect_date='$yesterday'
where 1;";

$result19a = mysql_query($query19a) or die ("Couldn't execute query 19a.  $query19a");

$query20a="update cash_summary,cash_summary_justified2
set cash_summary.justified=cash_summary_justified2.justified
where cash_summary.center=cash_summary_justified2.center
and cash_summary.effect_date=cash_summary_justified2.effect_date;";


$result20a = mysql_query($query20a) or die ("Couldn't execute query 20a.  $query20a");



$query21="update mission_headlines
          set undeposited_message='y'
    	  where date='$today'  ;";

$result21 = mysql_query($query21) or die ("Couldn't execute query 21.  $query21");


$query22="update cash_summary
set undeposited_transdate_min=effect_date
where undeposited_transdate_min='0000-00-00'
and effect_date='$yesterday'";

$result22 = mysql_query($query22) or die ("Couldn't execute query 22.  $query22");


//}

echo "Update Successful<br />";


*/

//{header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y ");}

$query4="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysql_query($query4) or die ("Couldn't execute query 4.  $query4");



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

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

	  
}  

 ?>




















