<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "hello world";

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempID' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695')
//echo "cashier_count=$cashier_count<br />";


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	

//echo "query1b=$query1b<br /><br />";		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";



$query1c="select count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='$concession_location' and role='fs_approver' and tempid='$tempID' ";	

//echo "query1c=$query1c<br /><br />";		  

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);
//echo "fs_approver_count=$fs_approver_count<br />";


$query0="update crs_tdrr_division_deposits
         set park_complete='y'
		 where version3='y'
		 and cashier != ''
		 and manager != '' ";
		 
		 
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");	


$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
         from crs_tdrr_division_history_parks
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";

if($level < '2')
{
$query11="SELECT center.parkcode,
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
crs_tdrr_division_deposits.crj_days_elapsed,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and (crs_tdrr_division_history_parks.old_center='$concession_center')
and deposit_transaction='y'
and version3='y'
and version3_active='y'
and park_complete='n'
group by crs_tdrr_division_history_parks.center,deposit_id
order by record_complete asc,deposit_id desc ";



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
crs_tdrr_division_deposits.crj_days_elapsed,
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
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";

}


if($level=='2' and $concession_location=='SODI')
{
$query11="SELECT center.parkcode,
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
crs_tdrr_division_deposits.crj_days_elapsed,
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
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";
}

if($level=='2' and $concession_location=='EADI')
{
$query11="SELECT center.parkcode,
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
crs_tdrr_division_deposits.crj_days_elapsed,
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
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";
}

if($level=='2' and $concession_location=='NODI')
{
$query11="SELECT center.parkcode,
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
crs_tdrr_division_deposits.crj_days_elapsed,
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
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc



";
}



if($level == 3)

{  




$query11="SELECT center.parkcode,
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
sum(crs_tdrr_division_history_parks.amount) as 'amount',
crs_tdrr_division_deposits.crj_days_elapsed,
min(crs_tdrr_division_history_parks.transdate_new) as 'trans_min',
max(crs_tdrr_division_history_parks.transdate_new) as 'trans_max',
crs_tdrr_division_history_parks.deposit_date_new as 'deposit_date'
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc ";
}




if($level > '3')

{  




$query11="SELECT center.parkcode,
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
sum(crs_tdrr_division_history_parks.amount) as 'amount',
crs_tdrr_division_deposits.crj_days_elapsed,
min(crs_tdrr_division_history_parks.transdate_new) as 'trans_min',
max(crs_tdrr_division_history_parks.transdate_new) as 'trans_max',
crs_tdrr_division_history_parks.deposit_date_new as 'deposit_date'
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by center.parkcode asc, record_complete asc, deposit_id desc ";
}	

/*
if($beacnum == '60036015')

{  




$query11="SELECT center.parkcode,
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
sum(crs_tdrr_division_history_parks.amount) as 'amount',
min(crs_tdrr_division_history_parks.transdate_new) as 'trans_min',
max(crs_tdrr_division_history_parks.transdate_new) as 'trans_max',
crs_tdrr_division_history_parks.deposit_date_new as 'deposit_date'
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.center=center.center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and orms_depositor != '' and cashier != '' and manager != ''
and crs_tdrr_division_history_parks.deposit_transaction='y'
and version3='y'
and version3_active='y'
and park_complete='n'
group by crs_tdrr_division_history_parks.center,crs_tdrr_division_history_parks.deposit_id
order by record_complete asc,center.parkcode asc ";
}	
*/
//echo "query11=$query11";

		
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
//echo "<table><tr><th>ORMS Cash Receipts (Version 2.14)</th></tr></table>";
//if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Deposits </font></td></tr></table>";}
if($num11!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
/*
if($num11==1)
{echo "<br /><table><tr><td><font  color=red>Unapproved Deposits: $num11</font></td></tr></table>";}

if($num11>1)
{echo "<br /><table><tr><td><font  color=red>Unapproved Deposits: $num11</font></td></tr></table>";}
*/

echo "<br />";

echo "<table align='center'><tr><th>Park Manager is required to Approve Deposit within 3 business days of Deposit. Thanks!</th></tr></table><br />";
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
       <th align=left><font color=brown>TransDate Start</font></th>
       <th align=left><font color=brown>TransDate End</font></th>
	   <th align=left><font color=brown>Amount</font></th>";
       //echo "<th align=left><font color=brown>ORMS<br />Deposit <br />Date</font></th>";
       //echo "<th align=left><font color=brown>Bank<br />Deposit <br />Date</font></th>";
       echo "<th align=left><font color=brown>CRS<br />Deposit</font></th>
	   <th align=left><font color=brown>Bank <br />Deposit</font></th>
	   <th align=left><font color=brown>Approve<br />Deposit</font></th>
	   <th align=left><font color=brown>Days Elapsed<br />since Deposit</font></th>";
	  /* 
	  echo "<th align=left><font color=brown>Approve<br />Deposit</font><br /><font color='red'>Budget</font></th>
	   <th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>
	   */
       
      
       
              
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
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));



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
		    
		    
		    
		    <td align='center' bgcolor='lightgreen'>$trans_min2<br />$trans_min_dow</td>
		    <td align='center' bgcolor='lightgreen'>$trans_max2<br />$trans_max_dow</td>
			<td align='center' bgcolor='lightgreen'>$amount</td>";
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
			echo "<td align='center' bgcolor='lightgreen'>$deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$orms_depositor3<br />$orms_deposit_date2<br />$deposit_date_dow</font></td>";		
					
			
		    //echo "<td>$amount</td>";				
			}
			
			
			if($cashier=='')
			{
		   echo "<td align='center' bgcolor='lightpink'>";
		   
		   //$cashier_count=1 (park cashiers), $beacnums=district oa's + cara hadfield(acting oa for north). Allows Dist OA's to backup Park Cashiers
		   if($cashier_count==1 or $beacnum=='60033199' or $beacnum=='60033148' or $beacnum=='60032892' or $beacnum=='60033093' or $beacnum=='60032931')
		   {
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Cashier<br />Update</a>";
		   }
		   if($cashier_count==0 and $beacnum!='60033199' and $beacnum!='60033148' and $beacnum!='60032892' and $beacnum!= '60033093' and $beacnum!= '60032931')
		   {
		   echo "Cashier<br />Update";
		   }
		   	   
		   echo "</td>";
		   }
		   else
		   {
		   echo "<td align='center' bgcolor='lightgreen'>";
		   echo "$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$cashier3<br />$bank_deposit_date2<br />$bank_deposit_date_dow";
		   echo "</td>";		   
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		   }
		   
		      
		   
		   if($manager=='')
			{		   
		   echo "<td align='center' bgcolor='lightpink'>";
		   //$manager_count=1 (park managers), $beacnums=DISUs.  Allows DISU's to backup Park Managers
		   if($manager_count==1 or $beacnum=='60032912' or $beacnum=='60033104' or $beacnum=='60033019' or $beacnum=='60032913')
		   {
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Manager<br />Update</a>";
		   }
		    if($manager_count==0 and $beacnum!='60032912' and $beacnum!='60033104' and $beacnum!='60033019' and $beacnum!='60032913' )
		   {
		   echo "Manager<br />Update";
		   }  
		   
		   echo "</td>";
		   }
		   else
		   {		   
		   echo "<td align='center' bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
		   } 
           echo "<td align='center'>$crj_days_elapsed";
		   if($crj_days_elapsed == 3){echo "<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_230.jpg' alt='picture of green check mark' title='last day to Approve'></img>";}
		   if($crj_days_elapsed > 3){echo "<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img>";}
		   
		   
		   
		   echo "</td>";
           /*
		   if($fs_approver=='')
			{		   
		   echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC'>Update</a></td>";	
            }
			else
			{		   
		   echo "<td>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver3<br />$fs_approver_date2<br />$fs_approver_date_dow</td>";
		   }







		   
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>View</a></td>";
		    */
		                      
    
       
              
           
echo "</tr>";




}

 echo "</table>";
 }
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 //echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//echo "</html>";
echo "</body>";
/*
if(
($active_file=='/budget/menu1314.php')
and
(
$beacnum=='60032779' or
$beacnum=='60033202' or
$beacnum=='60033162' or
$beacnum=='60032920' or
$beacnum=='60032781' or
$beacnum=='60033012' or
$beacnum=='60032793' or
$beacnum=='60033009' or
$beacnum=='60033018' or
$beacnum=='60032997' or
$beacnum=='60032791' or
$beacnum=='60036015' or
$beacnum=='60032787' or
$tempid=='Howard6319' or
$tempid=='Cucurullo1234'
)
)
*/
//{
echo "</html>";
//}

?>