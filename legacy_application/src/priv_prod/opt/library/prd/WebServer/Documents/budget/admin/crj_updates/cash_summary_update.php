<?php

session_start();

echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

$upload_date=str_replace("-","",$upload_date);
$upload_date2=strtotime("$upload_date");
$upload_yesterday=($upload_date2-60*60*24);
$upload_dayb4yesterday=($upload_date2-60*60*24*2);

$upload_date2=date("Ymd", $upload_date2);
$upload_yesterday2=date("Ymd", $upload_yesterday);
$upload_dayb4yesterday2=date("Ymd", $upload_dayb4yesterday);



//echo "upload_date2=$upload_date2<br />";
//echo "upload_yesterday2=$upload_yesterday2<br />";
//echo "upload_dayb4_yesterday2=$upload_dayb4yesterday2<br />";  exit;
$todays_date=date("Ymd", time() );
$today=$upload_date2;
$yesterday=$upload_yesterday2;
$dayb4yesterday=$upload_dayb4yesterday2;

//$yesterday='20170312';

//$dayb4yesterday='20170312';


/*
echo "upload_today=$upload_today<br />";
echo "upload_yesterday=$upload_yesterday<br />";
*/
/*
$end_date=str_replace("-","",$end_date);
$today=date("Ymd", time() );
$yesterday=date("Ymd", time() - 60 * 60 * 24);
$dayb4yesterday=date("Ymd", time() - 60 * 60 * 24*2);
*/
//$today='20140705';
//$yesterday='20140704';
//$dayb4yesterday='20140703';
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
if($cs_update=='')
{
$query0="SELECT crs_tdrr_division_deposits.park, crs_tdrr_division_deposits.orms_deposit_id, crs_tdrr_division_deposits.center,crs_tdrr_division_history_parks.deposit_id, crs_tdrr_division_history_parks.ncas_account,crs_tdrr_division_history_parks.transdate_new, count( crs_tdrr_division_history_parks.ncas_account ) as 'count',
sum(crs_tdrr_division_history_parks.amount ) as 'amount'
FROM `crs_tdrr_division_deposits`
LEFT JOIN crs_tdrr_division_history_parks ON crs_tdrr_division_deposits.orms_deposit_id = crs_tdrr_division_history_parks.deposit_id
WHERE 1
AND crs_tdrr_division_deposits.trans_table = 'y'
AND crs_tdrr_division_deposits.download_date = '$todays_date'
and ncas_account='000300000'
GROUP BY crs_tdrr_division_deposits.park, crs_tdrr_division_deposits.orms_deposit_id, crs_tdrr_division_history_parks.ncas_account";
echo "query0=$query0<br />";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0 ");
$num_lines=mysqli_num_rows($result0);	


echo "<table border='1'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='brown'>park</font></th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
echo "<th align='left'><font color='brown'>orms_deposit_id</font></th>"; 
echo "<th align='left'><font color='brown'>deposit_id</font></th>"; 
echo "<th align='left'><font color='brown'>center</font></th>"; 
echo "<th align='left'><font color='brown'>ncas<br />account</font></th>"; 
echo "<th align='left'><font color='brown'>transdate</font></th>"; 
echo "<th align='left'><font color='brown'>count</font></th>"; 
echo "<th align='left'><font color='brown'>amount</font></th>"; 
echo "<th align='left'><font color='brown'>Move to Account#</font></th>"; 
echo "</tr>";

echo  "<form method='post' autocomplete='off' action='cash_summary_update2.php'>";

while ($row0=mysqli_fetch_array($result0)){
extract($row0);
$amount_adj=-$amount;
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td>$park</td> 	
           <td>
		   <a href='cash_summary_detail.php?deposit_id=$orms_deposit_id&GC=n' target='_blank'>
		   $orms_deposit_id
		   </a>
		   </td> 		   
           <td>$deposit_id</td> 	
           <td><input type='text' name='center[]' value='$center' size='10' readonly='readonly' ></td> 	
           <td><input type='text' name='account_number[]' value='$ncas_account' size='10' readonly='readonly'></td>
		   <td><input type='text' name='transdate_new[]' value='$transdate_new' size='10' readonly='readonly'></td>
           <td>$count</td> 
           <td><input type='text' name='amount[]' value='$amount' readonly='readonly' size='10'></td>";
           

echo   "<td>
	   	   
	   <input type='hidden' name='orms_deposit_id[]' value='$orms_deposit_id'>	   
	   <input type='hidden' name='amount_adj[]' value='$amount_adj'>	   
	   <input type='text' name='account_number_adj[]' value='$account_number' size='10'>	   
	   </td>";	   
	  
			  
			  
echo "</tr>";

}

 echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='upload_date' value='$upload_date'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='num_lines' value='$num_lines'>";
echo   "</form>";

 echo "</table>";

//echo "<input type='hidden' name='fiscal_year' value='$f_year'>";	   
//echo "<input type='hidden' name='num6' value='$num5'>";

 
echo "todays_date=$todays_date<br />";
echo "today=$today<br />";
echo "yesterday=$yesterday<br />";
echo "dayb4yesterday=$dayb4yesterday<br />";
echo "<a href='cash_summary_update.php?cs_update=y&upload_date=$upload_date'>Cash Summary Update thru: $yesterday </a>";
exit;
}
if($cs_update=='y')
{
//echo "Run Queries to Update Table=cash_summary"; exit;

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "end_date=$end_date"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps






$query1="insert into cash_trans
(center,trans_date,amount)
SELECT center, transdate_new, sum( amount )
FROM `crs_tdrr_division_history`
WHERE transdate_new = '$yesterday'
AND deposit_transaction = 'y'
and ncas_account != '000437995'
and payment_type != 'hist'
GROUP BY center, transdate_new";
		 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

/*
$query1a="insert into cash_deposits
(center,deposit_date,amount)
SELECT center,deposit_date_new,sum(amount)
from crs_tdrr_division_history_parks
where 1 and deposit_transaction='y'
and deposit_date_new = '$yesterday'
group by center,deposit_date_new";
*/

// replaced query above on 12/9/15

$query1a="insert into cash_deposits
(center,deposit_date,amount)
SELECT center,deposit_date_new,sum(amount)
from crs_tdrr_division_history
where 1 and deposit_transaction='y'
and deposit_date_new = '$yesterday'
group by center,deposit_date_new";

			 
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$query2="update crs_tdrr_division_history
set deposit_date_new='0000-00-00',deposit_id='none'
where deposit_date_new='$today'; ";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$query2a="insert into cash_undeposited
(center,effective_date,amount)
select center,'$yesterday',sum(amount)
from crs_tdrr_division_history
where deposit_transaction='y'
and deposit_id='none'
and ncas_account != '000437995'
and payment_type != 'hist'
group by center;";
			 
mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");



$query3="insert into cash_summary(center,effect_date)
select center,'$yesterday'
from center_taxes
where orms='y'";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update cash_summary,cash_trans
set cash_summary.transaction_amount=cash_trans.amount
where cash_summary.center=cash_trans.center
and cash_summary.effect_date='$yesterday'
and cash_trans.trans_date='$yesterday'";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update cash_summary,cash_deposits
set cash_summary.deposit_amount=cash_deposits.amount
where cash_summary.center=cash_deposits.center
and cash_summary.effect_date='$yesterday'
and cash_deposits.deposit_date='$yesterday'";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update cash_summary,cash_undeposited
set cash_summary.end_bal=cash_undeposited.amount
where cash_summary.center=cash_undeposited.center
and cash_summary.effect_date='$yesterday'
and cash_undeposited.effective_date='$yesterday'";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update cash_summary
set beg_bal=end_bal-transaction_amount+deposit_amount
where effect_date='$yesterday'";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update cash_summary
set undeposited_amount=beg_bal-deposit_amount
where effect_date='$yesterday'";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="truncate table cash_deposits_max; ";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query9a="insert into cash_deposits_max(center,deposit_date_max)
select center,max(orms_deposit_date)
from crs_tdrr_division_deposits
where trans_table='y'
group by center;";
			 
mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");


$query9b="truncate table cash_undeposited_min; ";
			 
mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");


$query9c="insert into cash_undeposited_min(center,cash_trans_min)
select center,min(transdate_new)
from crs_tdrr_division_history
where deposit_id='none'
and amount != '0.00'
and payment_type != 'hist'
group by center; ";
			 
mysqli_query($connection, $query9c) or die ("Couldn't execute query 9c.  $query9c");


$query9d="truncate table cash_undeposited_max; ";
			 
mysqli_query($connection, $query9d) or die ("Couldn't execute query 9d.  $query9d");

$query9e="insert into cash_undeposited_max(center,cash_trans_max)
select center,max(transdate_new)
from crs_tdrr_division_history
where deposit_id='none'
and amount != '0.00'
group by center; ";
			 
mysqli_query($connection, $query9e) or die ("Couldn't execute query 9e.  $query9e");



$query10="update cash_summary,cash_deposits_max
set cash_summary.last_deposit=cash_deposits_max.deposit_date_max
where cash_summary.center=cash_deposits_max.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


$query10a="update cash_summary,cash_undeposited_min
set cash_summary.undeposited_transdate_min=cash_undeposited_min.cash_trans_min
where cash_summary.center=cash_undeposited_min.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");


$query10b="update cash_summary,cash_undeposited_max
set cash_summary.undeposited_transdate_max=cash_undeposited_max.cash_trans_max
where cash_summary.center=cash_undeposited_max.center
and cash_summary.effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query10b) or die ("Couldn't execute query 10b.  $query10b");


$query11="update cash_summary set days_elapsed=datediff(effect_date,last_deposit)
where effect_date='$yesterday';";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


$query11a="update cash_summary set days_elapsed2=datediff(effect_date,undeposited_transdate_min)
where effect_date='$yesterday'; ";
			 
mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");


$query11b="update cash_summary set
days_elapsed2='0'
where days_elapsed2=''
and effect_date='$yesterday'
;";
			 
mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");


$query12="update cash_summary,center
set cash_summary.park=center.parkcode
where cash_summary.center=center.center";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


$query13="update cash_summary
set compliance='n'
where deposit_amount < beg_bal
and beg_bal >= '250.00'
and effect_date='$yesterday'";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


$query14="update cash_summary
set compliance='n'
where beg_bal < '250.00'
and days_elapsed2 > '6'
and deposit_amount < beg_bal
and effect_date='$yesterday'";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$query15="select weekend as 'weekendDay'
          from mission_headlines where date='$yesterday' ";
		 
//echo "query1=$query1<br />";		 

$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$row15=mysqli_fetch_array($result15);
extract($row15);

if($weekendDay=='y')
{
$query16="update cash_summary
set weekend='y'
where effect_date='$yesterday'";

$result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

$query16a="truncate table cash_last_valid_depdate";

$result16a = mysqli_query($connection, $query16a) or die ("Couldn't execute query 16a.  $query16a");

$query16b="insert into cash_last_valid_depdate(center,park,effect_date,compliance)
           select center,park,effect_date,compliance
		   from cash_summary 
		   where weekend='n'  ";

$result16b = mysqli_query($connection, $query16b) or die ("Couldn't execute query 16b.  $query16b");

$query16c="select effect_date as 'last_valid_depdate'
         from cash_last_valid_depdate
		 where effect_date < '$today'
		 order by effect_date desc
		 limit 1 ";
		 
//echo "query1=$query1<br />";		 

$result16c = mysqli_query($connection, $query16c) or die ("Couldn't execute query 16c.  $query16c");

$row16c=mysqli_fetch_array($result16c);
extract($row16c);

$query16d="update cash_summary,cash_last_valid_depdate
set cash_summary.compliance=cash_last_valid_depdate.compliance
where cash_summary.center=cash_last_valid_depdate.center
and cash_summary.effect_date='$yesterday'
and cash_last_valid_depdate.effect_date='$last_valid_depdate'
";
			 
mysqli_query($connection, $query16d) or die ("Couldn't execute query 16d.  $query16d");



}

$query17="truncate cash_summary_exceptions2;";

$result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");


$query18="insert into cash_summary_exceptions2
(center,park,exceptions)
select center,park,count(compliance)
from cash_summary where valid='y'
and weekend='n'
and compliance='n'
and fyear='1617'
group by center;";

$result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");


$query19="update cash_summary_exceptions2
set effect_date='$yesterday'
where 1;";

$result19 = mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");


$query20="update cash_summary,cash_summary_exceptions2
set cash_summary.exceptions=cash_summary_exceptions2.exceptions
where cash_summary.center=cash_summary_exceptions2.center
and cash_summary.effect_date=cash_summary_exceptions2.effect_date;";

$result20 = mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");



$query17a="truncate cash_summary_justified2;";

$result17a = mysqli_query($connection, $query17a) or die ("Couldn't execute query 17a.  $query17a");


$query18a="insert into cash_summary_justified2
(center,park,justified)
select center,park,count(id)
from cash_summary where valid='y'
and weekend='n'
and compliance='n'
and pasu_comment != ''
and fyear='1617'
group by center;";

$result18a = mysqli_query($connection, $query18a) or die ("Couldn't execute query 18a.  $query18a");


$query19a="update cash_summary_justified2
set effect_date='$yesterday'
where 1;";

$result19a = mysqli_query($connection, $query19a) or die ("Couldn't execute query 19a.  $query19a");

$query20a="update cash_summary,cash_summary_justified2
set cash_summary.justified=cash_summary_justified2.justified
where cash_summary.center=cash_summary_justified2.center
and cash_summary.effect_date=cash_summary_justified2.effect_date;";


$result20a = mysqli_query($connection, $query20a) or die ("Couldn't execute query 20a.  $query20a");



$query21="update mission_headlines
          set undeposited_message='y'
    	  where date='$today'  ;";

$result21 = mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");


$query22="update cash_summary
set undeposited_transdate_min=effect_date
where undeposited_transdate_min='0000-00-00'
and effect_date='$yesterday'";

$result22 = mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");

// 12/9/2015 queries below

$query23="update crs_tdrr_division_deposits
set old_center=center
where old_center=''
and park != 'admi' ";

$result23 = mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");


$query24="update crs_tdrr_division_deposits,center
set crs_tdrr_division_deposits.new_center=center.new_center
where crs_tdrr_division_deposits.old_center=center.old_center
and crs_tdrr_division_deposits.dncr='y'
and crs_tdrr_division_deposits.park != 'admi'  ";

$result24 = mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");


$query25="update crs_tdrr_division_deposits
set center=new_center
where dncr='y'
and park != 'admi' ";

$result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");


$query26="update crs_tdrr_division_history_parks
set old_center=center
where old_center=''
and admi != 'y' ";

$result26 = mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26");


$query27="update crs_tdrr_division_history_parks,center
set crs_tdrr_division_history_parks.new_center=center.new_center where crs_tdrr_division_history_parks.old_center=center.old_center and crs_tdrr_division_history_parks.dncr='y' 
and crs_tdrr_division_history_parks.admi != 'y' ";

$result27 = mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27");


$query28="update crs_tdrr_division_history_parks
set center=new_center
where dncr='y' 
and admi != 'y' ";

$result28 = mysqli_query($connection, $query28) or die ("Couldn't execute query 28.  $query28");


}

{header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y ");}
	  
  

 ?>




















