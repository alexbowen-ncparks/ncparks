<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
       from crs_tdrr_division_history_parks
       where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";


{include("bank_deposits_menu_division_final_fyear_header.php");}

//echo "f_year=$f_year<br /><br />";

if($level < '2')
{
$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and crs_tdrr_division_history_parks.center='$concession_center'
and deposit_transaction='y'
and version3='y'
group by crs_tdrr_division_history_parks.center,deposit_id
order by record_complete asc,orms_deposit_date desc ";



//echo "query11=$query11";//exit;
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
*/

}



if($level=='2' and $concession_location=='WEDI')
{
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history_parks.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.center=center.center
WHERE 1
and center.dist='west'
and deposit_transaction='y'
group by crs_tdrr_division_history_parks.center,deposit_id
order by center.parkcode asc,deposit_id asc ";
*/
//echo "query11=$query11";exit;

$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and center.dist='west'
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";

}


if($level=='2' and $concession_location=='SODI')
{
$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and center.dist='south'
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";
}

if($level=='2' and $concession_location=='EADI')
{
$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and center.dist='east'
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";
}

if($level=='2' and $concession_location=='NODI')
{
$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and center.dist='north'
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc
";
}

//10-28-14
// (60036015  Accounting Clerk Rod Bridges)  (60032781 Budget Officer Tammy Dodd)  (60096024 Seasonal OA Maria Cucurullo) 
// (60032997 Accounting Clerk Rachel Gooding)  (60033242 Budget Office Rebecca Owen) (60032793 Budget Office Tony Bass)
// if($level > '2' and $beacnum != '60036015' and $beacnum != '60032781' and $beacnum != '60096024' and $beacnum != '60032997' and $beacnum != '60033242' and  $beacnum != '60032793')

$dpr_bo_staff = array('60032781',      // Budget Officer: Tammy Dodd
                     '65032850',    // 2nd Budget Officer: Mahnaz Rouhani
                     '60032793',    // DPR Accountant: Tony Bass
                     '60036015',    // Accounting Clerk: Heidi Rumble
                     '60032997',    // Accounting Clerk: Rachel Gooding
                     '60033242',    // Processing Assistant: Angela Boggus
                     '65032827'     // Accounting Technician: Carmen Williams
                  );
$budget_officers = array('60032781',      // Budget Officer: Tammy Dodd
                                 '65032850',    // 2nd Budget Officer: Mahnaz Rouhani
                                 '60032793'     // DPR Accountant: Tony Bass
                        );

if ($level > '2'
   AND !in_array($beacnum, $dpr_bo_staff)
   )
{  
   $query11 = "SELECT center.parkcode,
                  crs_tdrr_division_deposits.dncr,
                  crs_tdrr_division_history_parks.center,
                  crs_tdrr_division_history_parks.batch_deposit_date,
                  crs_tdrr_division_history_parks.deposit_id,
                  crs_tdrr_division_deposits.orms_deposit_date,
                  crs_tdrr_division_deposits.bank_deposit_date,
                  crs_tdrr_division_deposits.orms_depositor,
                  crs_tdrr_division_deposits.cashier,
                  crs_tdrr_division_deposits.cashier_date,
                  crs_tdrr_division_deposits.manager,
                  crs_tdrr_division_deposits.manager_date,
                  crs_tdrr_division_deposits.fs_approver,
                  crs_tdrr_division_deposits.fs_approver_date,
                  crs_tdrr_division_deposits.controllers_deposit_id,
                  crs_tdrr_division_deposits.record_complete,
                  SUM(crs_tdrr_division_history_parks.amount) AS 'amount',
                  MIN(crs_tdrr_division_history_parks.transdate_new) AS 'trans_min',
                  MAX(crs_tdrr_division_history_parks.transdate_new) AS 'trans_max',
                  crs_tdrr_division_history_parks.deposit_date_new AS 'deposit_date'
            FROM crs_tdrr_division_history_parks
               LEFT JOIN center
                  ON crs_tdrr_division_history_parks.old_center = center.old_center
               LEFT JOIN crs_tdrr_division_deposits
                  ON crs_tdrr_division_history_parks.deposit_id = crs_tdrr_division_deposits.orms_deposit_id
            WHERE crs_tdrr_division_history_parks.deposit_transaction = 'y'
               AND version3 = 'y'
               AND version3_active = 'y'
            GROUP BY crs_tdrr_division_history_parks.center,
                  crs_tdrr_division_history_parks.deposit_id
            ORDER BY center.parkcode ASC,
                  record_complete ASC,
                  deposit_id ASC
         ";
}  

// (60036015  Accounting Clerk Rod Bridges)  (60032781 Budget Officer Tammy Dodd)  (60096024 Seasonal OA Maria Cucurullo) 
// (60032997 Accounting Clerk Rachel Gooding) (60033242 Budget Office Rebecca Owen) (60032793 Budget Office Tony Bass)
// if($beacnum == '60036015' or $beacnum == '60032781' or $beacnum == '60096024' or $beacnum == '60032997' or $beacnum=='60033242' or $beacnum=='60032793')

if (in_array($beacnum, $dpr_bo_staff))
{
   /* // compliance.php
   // lines: 79 thru 88:
   if($buof_comment != '')
   {$buof_comment=addslashes($buof_comment);
   $buof_comment_query="update cash_summary set buof_comment='$buof_comment',buof_player='$tempID',buof_comment_date='$system_entry_date' where id='$comment_id' ";
   $result_buof_comment_query=mysqli_query($connection, $buof_comment_query) or die ("Couldn't execute query buof comment query. $buof_comment_query");
   //echo "comment_update_query=$comment_update_query<br />";}
   // lines 472 thru 492
   echo "<td>";
   if($compliance=='n' and $buof_comment=='')
   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='buof_comment' placeholder='Enter BUOF Comment. Then click BUOF_Update'>$buof_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";        
   if($level=='5')
   {echo "<input type=submit name=submit value=BUOF_Update></form>";}}
   if($compliance=='n' and $buof_comment!='')
   {echo "$buof_comment_date($buof_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><br />$buof_comment";}
   if($compliance=='y' and $buof_comment!='')
   {echo "$buof_comment_date($buof_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$buof_comment";}
   echo "</td>";    
   */

   //   (60032781 Budget Officer Tammy Dodd)  (60032793  Budget Office Tony Bass)
   // if (($beacnum=='60032781' or $beacnum=='60032793') and ($parkS==''))
   if (in_array($beacnum, $budget_officers)
      AND $parkS == ''
      )
   {
      $parkS = 'admi';
   }

   if ($parkS == '' AND $exception == '')
   {
      $query11 = "SELECT center.parkcode,
                        crs_tdrr_division_deposits.dncr,
                        crs_tdrr_division_history_parks.center,
                        crs_tdrr_division_history_parks.batch_deposit_date,
                        crs_tdrr_division_history_parks.deposit_id,
                        crs_tdrr_division_deposits.orms_deposit_date,
                        crs_tdrr_division_deposits.orms_depositor,
                        crs_tdrr_division_deposits.cashier,
                        crs_tdrr_division_deposits.cashier_date,
                        crs_tdrr_division_deposits.manager,
                        crs_tdrr_division_deposits.manager_date,
                        crs_tdrr_division_deposits.fs_approver,
                        crs_tdrr_division_deposits.fs_approver_date,
                        crs_tdrr_division_deposits.controllers_deposit_id,
                        crs_tdrr_division_deposits.record_complete,
                        crs_tdrr_division_deposits.bank_deposit_date,
                        crs_tdrr_division_deposits.post2ncas,
                        crs_tdrr_division_deposits.post_date,
                        crs_tdrr_division_deposits.document_reload,
                        SUM(crs_tdrr_division_history_parks.amount) AS 'amount',
                        MIN(crs_tdrr_division_history_parks.transdate_new) AS 'trans_min',
                        MAX(crs_tdrr_division_history_parks.transdate_new) AS 'trans_max',
                        crs_tdrr_division_history_parks.deposit_date_new AS 'deposit_date'
                  FROM crs_tdrr_division_history_parks
                     LEFT JOIN center
                        ON crs_tdrr_division_history_parks.old_center = center.old_center
                     LEFT JOIN crs_tdrr_division_deposits
                        ON crs_tdrr_division_history_parks.deposit_id = crs_tdrr_division_deposits.orms_deposit_id
                  WHERE orms_depositor != ''
                        AND cashier != ''
                        AND manager != ''
                        AND crs_tdrr_division_history_parks.deposit_transaction = 'y'
                        AND version3 = 'y'
                        AND version3_active = 'y'
                        AND crs_tdrr_division_deposits.f_year = '$fyear'
                  GROUP BY crs_tdrr_division_history_parks.deposit_id
                  ORDER BY record_complete ASC,
                           center.parkcode ASC,
                           orms_deposit_date DESC
               ";

echo "query11=$query11<br />";


$query11_summary="select count(crs_tdrr_division_history_parks.id) as 'accounting_transactions',sum(crs_tdrr_division_history_parks.amount) as 'dollar_total' from crs_tdrr_division_history_parks
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
where crs_tdrr_division_deposits.orms_depositor != ''
and crs_tdrr_division_deposits.cashier != ''
and crs_tdrr_division_deposits.manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y' 
and crs_tdrr_division_deposits.f_year='$fyear'
and crs_tdrr_division_deposits.version3='y'
and crs_tdrr_division_deposits.version3_active='y' ";


//echo "query11_summary=$query11_summary<br /><br />";

$result11_summary = mysqli_query($connection, $query11_summary) or die ("Couldn't execute query11_summary.  $query11_summary ");

$row11_summary=mysqli_fetch_array($result11_summary);
extract($row11_summary);//brings back max (end_date) as $end_date

//echo "<br />accounting_transactions=$accounting_transactions<br />";
//echo "<br />dollar_total=$dollar_total<br />";

$query11_parkCount="select distinct(crs_tdrr_division_deposits.park)
from crs_tdrr_division_history_parks
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
where crs_tdrr_division_deposits.orms_depositor != ''
and crs_tdrr_division_deposits.cashier != ''
and crs_tdrr_division_deposits.manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y' 
and crs_tdrr_division_deposits.f_year='$fyear'
and crs_tdrr_division_deposits.version3='y'
and crs_tdrr_division_deposits.version3_active='y' 
 ";

$result11_parkCount = mysqli_query($connection, $query11_parkCount) or die ("Couldn't execute query11_parkCount.  $query11_parkCount ");

$row11_parkCount=mysqli_fetch_array($result11_parkCount); 

$num11_parkCount=mysqli_num_rows($result11_parkCount);   

//echo "<br />query11_parkCount=$query11_parkCount<br />";
//echo "<br />parkCount=$num11_parkCount<br />";


}
if($parkS!='' and $exception=='')
{

$query_center_lookup="select center as 'centerS',new_center as 'centerS_new' from center where parkcode='$parkS' and fund='1280' and actcenteryn='y' ";
//echo "<br />query_center_lookup=$query_center_lookup<br />";
$result_center_lookup = mysqli_query($connection, $query_center_lookup) or die ("Couldn't execute query .  $query_center_lookup");
$row_center_lookup=mysqli_fetch_array($result_center_lookup);
extract($row_center_lookup);// brings back variable:  centerS 
//echo "<br />centerS=$centerS<br />";
//echo "<br />centerS_new=$centerS_new<br />";

if($parkS != 'admi' and $parkS != 'ADMI')
{
$where_1=" and (crs_tdrr_division_history_parks.center='$centerS' or crs_tdrr_division_history_parks.new_center='$centerS_new') ";
}

$where_0=" and orms_depositor != '' and cashier != '' and manager != '' ";

if($parkS == 'admi' or $parkS == 'ADMI')
{
$where_0=" and orms_depositor != '' and cashier != '' "; 
$where_1=" and (crs_tdrr_division_history_parks.old_center='12802751') ";
}






$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
crs_tdrr_division_history_parks.batch_deposit_date,
crs_tdrr_division_history_parks.deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.post2ncas,
crs_tdrr_division_deposits.post_date,
crs_tdrr_division_deposits.document_reload,
sum(crs_tdrr_division_history_parks.amount) as 'amount',
min(crs_tdrr_division_history_parks.transdate_new) as 'trans_min',
max(crs_tdrr_division_history_parks.transdate_new) as 'trans_max',
crs_tdrr_division_history_parks.deposit_date_new as 'deposit_date'
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
$where_0
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
and crs_tdrr_division_deposits.f_year='$fyear'
$where_1
group by crs_tdrr_division_history_parks.deposit_id
order by record_complete asc, center.parkcode asc, orms_deposit_date desc, deposit_id desc ";



//echo "<br />query11=$query11<br />";

$query11_summary="select count(crs_tdrr_division_history_parks.id) as 'accounting_transactions',sum(crs_tdrr_division_history_parks.amount) as 'dollar_total' from crs_tdrr_division_history_parks
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
where crs_tdrr_division_deposits.orms_depositor != ''
and crs_tdrr_division_deposits.cashier != ''
and crs_tdrr_division_deposits.manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y' 
and crs_tdrr_division_deposits.f_year='$fyear'
and crs_tdrr_division_deposits.version3='y'
and crs_tdrr_division_deposits.version3_active='y' 
and (crs_tdrr_division_history_parks.center='$centerS' or crs_tdrr_division_history_parks.new_center='$centerS_new') ";


//echo "query11_summary=$query11_summary<br /><br />";

$result11_summary = mysqli_query($connection, $query11_summary) or die ("Couldn't execute query11_summary.  $query11_summary ");

$row11_summary=mysqli_fetch_array($result11_summary);
extract($row11_summary);//brings back max (end_date) as $end_date

//echo "<br />accounting_transactions=$accounting_transactions<br />";
//echo "<br />dollar_total=$dollar_total<br />";


$query11_parkCount="select distinct(crs_tdrr_division_deposits.park)
from crs_tdrr_division_history_parks
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
where crs_tdrr_division_deposits.orms_depositor != ''
and crs_tdrr_division_deposits.cashier != ''
and crs_tdrr_division_deposits.manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y' 
and crs_tdrr_division_deposits.f_year='$fyear'
and crs_tdrr_division_deposits.version3='y'
and crs_tdrr_division_deposits.version3_active='y' 
and (crs_tdrr_division_history_parks.center='$centerS' or crs_tdrr_division_history_parks.new_center='$centerS_new') ";

$result11_parkCount = mysqli_query($connection, $query11_parkCount) or die ("Couldn't execute query11_parkCount.  $query11_parkCount ");

$row11_parkCount=mysqli_fetch_array($result11_parkCount); 

$num11_parkCount=mysqli_num_rows($result11_parkCount);   

//echo "<br />query11_parkCount=$query11_parkCount<br />";
//echo "<br />parkCount=$num11_parkCount<br />";




}



if($exception=='y')
{

$query_center_lookup="select center as centerS from center where parkcode='$parkS' and fund='1280' and actcenteryn='y' ";
$result_center_lookup = mysqli_query($connection, $query_center_lookup) or die ("Couldn't execute query .  $query_center_lookup");
$row_center_lookup=mysqli_fetch_array($result_center_lookup);
extract($row_center_lookup);// brings back variable:  centerS 


$query11="SELECT center.parkcode,
crs_tdrr_division_deposits.dncr,
crs_tdrr_division_history_parks.center,
crs_tdrr_division_history_parks.batch_deposit_date,
crs_tdrr_division_history_parks.deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.orms_depositor,
crs_tdrr_division_deposits.cashier,
crs_tdrr_division_deposits.cashier_date,
crs_tdrr_division_deposits.manager,
crs_tdrr_division_deposits.manager_date,
crs_tdrr_division_deposits.fs_approver,
crs_tdrr_division_deposits.fs_approver_date,
crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits.record_complete,
crs_tdrr_division_deposits.bank_deposit_date,
crs_tdrr_division_deposits.post2ncas,
crs_tdrr_division_deposits.post_date,
crs_tdrr_division_deposits.document_reload,
sum(crs_tdrr_division_history_parks.amount) as 'amount',
min(crs_tdrr_division_history_parks.transdate_new) as 'trans_min',
max(crs_tdrr_division_history_parks.transdate_new) as 'trans_max',
crs_tdrr_division_history_parks.deposit_date_new as 'deposit_date'
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and orms_depositor != '' and cashier != '' and manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
and crs_tdrr_division_deposits.f_year='$fyear'
and crs_tdrr_division_deposits.post2ncas='n'
and crs_tdrr_division_deposits.record_complete='y'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by record_complete asc, center.parkcode asc, orms_deposit_date desc ";




}



}  



      
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);    

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
//echo "<table><tr><th>ORMS Cash Receipts (Version 2.14)</th></tr></table>";
//if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Deposits </font></td></tr></table>";}


/*
if($beacnum=='60032781' or $beacnum=='60032793'){echo "<table><tr><td>hello tammy or tony<a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&parkS=jord'>LINK</a></td></tr></table>";}

*/


// (60032781 Budget Officer Tammy Dodd)  (60032793 Accountant Tony Bass)  (60036015 Accounting Clerk Rod Bridges)
// (60032997 Accounting Clerk Rachel Gooding) (60033242 Budget Office Rebecca Owen) (60032793 Budget Office Tony Bass)
// if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60036015' or $beacnum=='60032997' or $beacnum=='60033242' or $beacnum=='60032793')
if (in_array($beacnum, $dpr_bo_staff))
{
   echo "<table align='center'>
            <tr>
               <td>
                  <form action='bank_deposits_menu_division_final.php'>
                     Park: 
                     <input type='text' name='parkS' value='$parkS' autocomplete='off'>
                     <br>
                     <input type='hidden' name='menu_id' value='a'>
                     <input type='hidden' name='menu_selected' value='y'>
                     <input type='hidden' name='fyear' value='$fyear'>
                     <input type='submit' value='Submit'>
                  </form>
               </td>
            </tr>
         </table>
      ";
}



if($num11!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num11==1)
{echo "<br /><table align='center'><tr><td><font  color=red>Deposits: $num11</font></td></tr></table>";}

if($num11>1)
{

$num11=number_format($num11);
$accounting_transactions=number_format($accounting_transactions);
$dollar_total=number_format($dollar_total,2);


echo "<br /><table border='1' align='center'><tr>";
echo "<td><font  color=red>Parks: $num11_parkCount</font></td>";
echo "<td><font  color=red>Deposits: $num11</font></td>";
echo "<td><font  color=red>Accounting Transactions: $accounting_transactions</font></td>";
echo "<td><font  color=red>Dollar Total: $dollar_total</font></td>";
echo "</tr></table>";}
echo "<br />";
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
/*
echo "<table border='1'>
<tr><th>Start Date</th><td>$start_date2<br />$start_date_dow</td></tr>
<tr><th>End Date</th><td>$end_date2<br />$end_date_dow</td></tr>
</table>";
*/
//echo "<br />";
//echo "hello tony 1418";

//echo "<br />";
echo "<table border=1 align='center'>";

echo 

"<tr> 
      <th align=left><font color=brown>Park</font></th>
      <th align=left><font color=brown>Center</font></th>       
      <th align=left><font color=brown>TransDate<br />Start</font></th>
      <th align=left><font color=brown>TransDate<br />End</font></th>
      <th align=left><font color=brown>Amount</font></th>";
      //echo "<th align=left><font color=brown>ORMS<br />Deposit <br />Date</font></th>";
      //echo "<th align=left><font color=brown>Bank<br />Deposit <br />Date</font></th>";
      echo "<th align=left><font color=brown>CRS<br />Deposit</font></th>
      <th align=left><font color=brown>Bank <br />Deposit</font></th>
      <th align=left><font color=brown>Approve<br />Deposit</font></th>
      <th align=left><font color=brown>Approve<br />Deposit<br />Budget</font></th>
      <th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>";
      //echo "<th align=left><font color=brown>NCAS<br />Post<br />Date<br /><a href='bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y&exception=y'>Exceptions</a></font></th>";
           
           
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$orms_depositor3=substr($orms_depositor,0,-2);
$fs_approver3=substr($fs_approver,0,-2);
$trans_min2=date('m-d-y', strtotime($trans_min));
$trans_max2=date('m-d-y', strtotime($trans_max));
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));



if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}

if($bank_deposit_date=='0000-00-00')
{$bank_deposit_date_dow='';}
else
{$bank_deposit_date_dow=date('l',strtotime($bank_deposit_date));}



if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}


if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}







$trans_min_dow=date('l',strtotime($trans_min));
$trans_max_dow=date('l',strtotime($trans_max));

$orms_deposit_date2=date('m-d-y', strtotime($orms_deposit_date));
$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));
if($parkcode=='ADMI'){$center='1680504';}

if($bank_deposit_date=='0000-00-00')
{
$bank_deposit_date2='';
}
else
{
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
}




//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
$deposit_id2 = substr($deposit_id, 0, 8);
$deposit_idL8 = substr($deposit_id, -8, 8);
if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>
         <td bgcolor='lightgreen'>$parkcode</td>  
         <td bgcolor='lightgreen'>$center</td>
         
         
         
         <td bgcolor='lightgreen'>$trans_min2<br />$trans_min_dow</td>
         <td bgcolor='lightgreen'>$trans_max2<br />$trans_max_dow</td>
         <td bgcolor='lightgreen'>$amount</td>";
         //echo "<td>$deposit_date2<br />$deposit_date_dow</td>";
         //echo "<td>$bank_deposit_date2<br /></td>";
         if($deposit_id=='none')
         {
         echo "<td><font color='red'>$deposit_id</font></td>";
         }
         else
         {
         /*
         echo "<td><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>$deposit_id</a></td>";
         */
         echo "<td bgcolor='lightgreen'>$deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$orms_depositor3<br />$orms_deposit_date2<br />$deposit_date_dow</font></td>";    
               
         
         //echo "<td>$amount</td>";          
         }
         // changed on 09/15/14
         /*
         if($cashier=='')
         {
         echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' >Cashier<br />Update</a></td>";
         }
         */
         if($cashier=='')
         {
         echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Cashier<br />Update</a></td>";
         }  
         
         
         else
         {
         echo "<td bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$cashier3<br />$bank_deposit_date2<br />$bank_deposit_date_dow</td>";       
         /*
         echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
         */
         }
         
           
         
         if($manager=='')
         {        
         echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Manager<br />Update</a></td>";
         }
         else
         {        
         echo "<td bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
         }


         if($fs_approver=='')
         {
            {
               // if($parkcode != 'ADMI')
               // heide rumble, rebecca owen, tammy dodd, tony bass
               // if($beacnum=='60036015' or $beacnum=='60033242' or $beacnum=='60032781' or $beacnum=='60032793')
               if (in_array($beacnum, $dpr_bo_staff))
               {        
               echo "<td bgcolor='lightpink'>
                        <a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC'>
                           Budget
                           <br />
                           Update
                           <br />
                        </a>
                     </td>
                  ";   
               }
         /*
         if($parkcode == 'ADMI' and $beacnum=='60032781')
         {
         echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC'>Budget<br />Update</a></td>";    
         }
         if($parkcode == 'ADMI' and $beacnum!='60032781')
         {
         echo "<td bgcolor='lightpink'>Budget<br />Update</a></td>";  
         }
*/

         
            }
         

         }
         else

         {        
         echo "<td bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver3<br />$fs_approver_date2<br />$fs_approver_date_dow</td>";
         }

         // changed on 09/15/14
         
         if($fs_approver=='')
         {                 
         echo "<td bgcolor='lightpink'>$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&dncr=$dncr&GC=$GC' target='_blank'>View</a>";
         if($document_reload=='y'){echo "<br />Deposit Slip<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red X mark'></img>";}
         "</td>";
         }
         else
         {                 
         echo "<td bgcolor='lightgreen'>$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&dncr=$dncr&GC=$GC' target='_blank'>View</a>";
         if($document_reload=='y'){echo "<br />Deposit Slip<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red X mark'></img>";}
         echo "</td>";
         }
/*          
         if($post2ncas=='y')
         {                 
         echo "<td bgcolor='lightgreen'>$post_date</td>";
         }
         else
        {                  
         echo "<td bgcolor='lightpink'>$post_date</td>";
         }
       
*/         
           
           
           
           
           
           
         
echo "</tr>";




}

 echo "</table>";
 }
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>