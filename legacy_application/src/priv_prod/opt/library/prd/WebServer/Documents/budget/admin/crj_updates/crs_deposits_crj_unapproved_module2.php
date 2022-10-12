<?php
//echo "<br />beacnum=$beacnum<br />";
//echo "<br />tempid=$tempid<br />";
//echo "<br />level=$level<br />";
// 1)Update Table=crs_tdrr_division_deposits to Override CRJ Days elapsed Exception  AND 2)Re-Score GID 11 in Table=mission_scores
if($crj_override=='y')
{
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;	

$tempid_override=substr($tempid,0,-2);


$query9="update crs_tdrr_division_deposits
      set crj_elapsed_override='y',
	  crj_elapsed_override_comments='$crj_override_comments',
	  crj_elapsed_override_approver='$tempid_override'
	  where id='$override_id' ";
	
//echo "<br />query9=$query9<br />";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");
	
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;	

//Determine Correct Park and Fiscal Year for Re-Scoring 
$query9a="select park,f_year from crs_tdrr_division_deposits
         where id='$override_id'  ";
	
//echo "<br />query9a=$query9a<br />";

$result9a = mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");

$row9a=mysqli_fetch_array($result9a);
extract($row9a);
//echo "<br />park=$park<br />";
//echo "<br />f_year=$f_year<br />";


// New Score for Park for GID=11 in Table=mission_scores	
$query9b="select count(id) as 'gid11_complete'
          from crs_tdrr_division_deposits
		  where f_year='$f_year'
		  and park='$park' 
		  and (crj_compliance='y' or crj_elapsed_override='y') ";
	
//echo "<br />query9b=$query9b<br />";

$result9b = mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");

$row9b=mysqli_fetch_array($result9b);
extract($row9b);//brings back gid11_complete	
		
$query9c="select count(id) as 'gid11_total'
          from crs_tdrr_division_deposits
		  where f_year='$f_year'
		  and park='$park'   ";
	
//echo "<br />query9c=$query9c<br />";

$result9c = mysqli_query($connection, $query9c) or die ("Couldn't execute query 9c.  $query9c");

$row9c=mysqli_fetch_array($result9c);
extract($row9c);//brings back gid11_total
	
	
$gid11_score=round(($gid11_complete/$gid11_total*100),2);

//echo "<br />gid11_complete=$gid11_complete<br />";	
//echo "<br />gid11_total=$gid11_total<br />";	
//echo "<br />gid11_score=$gid11_score<br />";	
	
	
$query9d="update mission_scores
          set complete='$gid11_complete',total='$gid11_total',percomp='$gid11_score'
		  where playstation='$park' and fyear='$f_year' and gid='11'  ";
	
//echo "<br />query9d=$query9d<br />";

$result9d = mysqli_query($connection, $query9d) or die ("Couldn't execute query 9d.  $query9d");
	
	
	
	
}


$query10="SELECT center,new_center
from center where parkcode='$parkcode'
and new_fund='1680' and actcenteryn='y' ";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

//if($fyear==''){$fyear=$f_year;}
//echo "hello crs_deposits_crj_unapproved_module2.php<br />";
if($level < 3)
{
$query11="SELECT center.parkcode,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.dncr,
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
crs_tdrr_division_deposits.crj_elapsed_override,
crs_tdrr_division_deposits.crj_elapsed_override_approver,
crs_tdrr_division_deposits.crj_elapsed_override_comments,
crs_tdrr_division_deposits.crj_compliance,
crs_tdrr_division_deposits.crj_pasu_comment,
crs_tdrr_division_deposits.crj_pasu_player,
crs_tdrr_division_deposits.crj_pasu_comment_date,
crs_tdrr_division_deposits.crj_disu_comment,
crs_tdrr_division_deposits.crj_disu_player,
crs_tdrr_division_deposits.crj_disu_comment_date,
crs_tdrr_division_deposits.crj_buof_comment,
crs_tdrr_division_deposits.crj_buof_player,
crs_tdrr_division_deposits.crj_buof_comment_date,
crs_tdrr_division_deposits.park_complete,
crs_tdrr_division_deposits.document_reload,
crs_tdrr_division_deposits.id,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and 
(crs_tdrr_division_history_parks.old_center='$center')
and deposit_transaction='y'
and version3_active='y'
and crs_tdrr_division_deposits.f_year='$fyear'
group by crs_tdrr_division_history_parks.center,deposit_id
order by record_complete asc,orms_deposit_date desc,orms_deposit_id desc ";
}

if($level >= 3)
{
$query11="SELECT center.parkcode,
crs_tdrr_division_history_parks.center,
batch_deposit_date,
deposit_id,
crs_tdrr_division_deposits.orms_deposit_date,
crs_tdrr_division_deposits.dncr,
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
crs_tdrr_division_deposits.crj_elapsed_override,
crs_tdrr_division_deposits.crj_elapsed_override_approver,
crs_tdrr_division_deposits.crj_elapsed_override_comments,
crs_tdrr_division_deposits.crj_compliance,
crs_tdrr_division_deposits.crj_pasu_comment,
crs_tdrr_division_deposits.crj_pasu_player,
crs_tdrr_division_deposits.crj_pasu_comment_date,
crs_tdrr_division_deposits.crj_disu_comment,
crs_tdrr_division_deposits.crj_disu_player,
crs_tdrr_division_deposits.crj_disu_comment_date,
crs_tdrr_division_deposits.crj_buof_comment,
crs_tdrr_division_deposits.crj_buof_player,
crs_tdrr_division_deposits.crj_buof_comment_date,
crs_tdrr_division_deposits.park_complete,
crs_tdrr_division_deposits.document_reload,
crs_tdrr_division_deposits.id,
sum(amount) as 'amount',
min(transdate_new) as 'trans_min',
max(transdate_new) as 'trans_max',
deposit_date_new as 'deposit_date' 
from crs_tdrr_division_history_parks
left join center on crs_tdrr_division_history_parks.old_center=center.old_center
left join crs_tdrr_division_deposits on crs_tdrr_division_history_parks.deposit_id=crs_tdrr_division_deposits.orms_deposit_id
WHERE 1
and 
(crs_tdrr_division_history_parks.old_center='$center')
and deposit_transaction='y'
and version3_active='y'
and crs_tdrr_division_deposits.f_year='$fyear'
group by crs_tdrr_division_history_parks.deposit_id
order by record_complete asc,orms_deposit_date desc,orms_deposit_id desc ";
}	
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
//echo "query11=$query11<br />"; 
//echo "hello crs_deposits_crj_unapproved_module2.php<br />";
//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
//echo "<table><tr><th>ORMS Cash Receipts (Version 2.14)</th></tr></table>";
if($num11==0){echo "<br /><table><tr><td><font color=red>No Deposits </font></td></tr></table>";}
if($num11!=0)
{
/*
if($num11==1)
{echo "<br /><table><tr><td><font  color=red>Bank Deposits: $num11</font></td></tr></table>";}

if($num11>1)
{echo "<br /><table><tr><td><font  color=red>Bank Deposits: $num11</font></td></tr></table>";}
*/
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
//echo "hello crs_deposits_crj_unapproved_module2.php<br />";
//echo "Line 240 crs_deposits_crj_unapproved_module2.php:  manager_count=$manager_count";	 
echo "<table>";

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
	   <th align=left><font color=brown>Approve<br />Deposit</font></th>";
	//echo "<th align=left><font color=brown>Days Elapsed<br />since Deposit</font></th>";
	 echo "<th align=left><font color=brown>Approve<br />Deposit<br />Budget</font></th>
	   <th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>";
	   
	  //echo "<th align=left><font color=brown>PASU<br />Compliance<br />Comments</font></th>";
	  //echo "<th align=left><font color=brown>DISU<br />Compliance<br />Comments</font></th>";
	//echo "<th align=left><font color=brown>BUOF<br />Compliance<br />Comments</font></th>";
	  //echo "<th align=left><font color=brown>ID</font></th>";
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

$crj_pasu_player2=substr($crj_pasu_player,0,-2);
$crj_disu_player2=substr($crj_disu_player,0,-2);
$crj_buof_player2=substr($crj_buof_player,0,-2);



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
		   if($cashier_count==1)
		   {
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Cashier<br />Update</a>";
		   }
		   if($cashier_count==0)
		   {
		    echo "Cashier<br />Update";	   
		   }
		   
		   echo "</td>";
		   }
		   else
		   {
		   echo "<td align='center' bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$cashier3<br />$bank_deposit_date2<br />$bank_deposit_date_dow</td>";		   
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		   }
		   
		      
  
		   if($manager=='')
			{	
             if($crj_days_elapsed == 3)
		   {

			
		   echo "<td align='center' bgcolor='lightpink'>";
		   if($manager_count==1)
		   {
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Manager<br />Update<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_230.jpg' alt='picture of xmark' title='last day to approve'></img></a><br />$crj_days_elapsed days";
		   }
		   if($manager_count==0)
		   {
		   echo "Manager<br />Update<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_228.ico' alt='picture of xmark' title='last day to approve'></img><br />$crj_days_elapsed days";
		   }
		   echo "</td>";
		   }
		   else
		   {
		   if($crj_days_elapsed > 3 and $crj_elapsed_override != 'y')
		   {

			
		   echo "<td align='center' bgcolor='lightpink'>";
		   if($manager_count==1)
		   {
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Manager<br />Update<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of xmark'></img></a><br />$crj_days_elapsed days";
		   }
		   if($manager_count==0)
		   {
		   echo "Manager<br />Update<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of xmark'></img><br />$crj_days_elapsed days";
		   }
		   echo "</td>";
		   }
		   else
		   {		   
		   echo "<td align='center' bgcolor='lightpink'>";
		   if($manager_count==1)
		   {		   
		   echo "<a href='/budget/admin/crj_updates/crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC' >Manager<br />Update";
		   }
		   if($manager_count==0)
		   {		   
		   echo "Manager<br />Update";
		   }		   
		   echo "</td>";
		   }
		   }
		   }
		   if($manager!='')
		  {
		  /*
		   if($crj_days_elapsed == 3 and $crj_elapsed_override != 'y')		  
		   {		   
		   echo "<td align='center' bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow<br /><img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_230.jpg' alt='picture of xmark'></img></a><br />$crj_days_elapsed days</td>";
		   } 
		   else
		   {
		   */
		   if($crj_days_elapsed > 3 and $crj_elapsed_override != 'y')		  
		   {		   
		   echo "<td align='center' bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow<br />";
		   //acccountant-bass, budget officer-dodd, accounting clerk-rumble
		   if($beacnum != '60032793' and $beacnum != '60032781' and $beacnum != '60036015')
		   {   
		   echo "<img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of xmark'></img>";
		   }
		   
		    //acccountant-bass, budget officer-dodd, accounting clerk-rumble
		   if($beacnum == '60032793' or $beacnum == '60032781' or $beacnum == '60036015')
			 {   
		       echo "<a href='compliance_crj.php?fyear=$fyear&park=$park&override=y'><img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of xmark'></img></a>";
			   if($override=='y')
			   {
				   echo "<form>";
				   echo "<textarea name='crj_override_comments' rows='4' cols='50' placeholder='Override Comments'></textarea>";
				   echo "<input type='hidden' name='fyear' value='$fyear'>";
				   echo "<input type='hidden' name='park' value='$park'>";
				   echo "<input type='hidden' name='override_id' value='$id'>";
				   echo "<input type='hidden' name='crj_override' value='y'>";
				   echo "<br /><input type='submit' name='submit'>";
				   echo "</form>";}
		       }
		      
		   
		   
		   
		   
		   echo "<br />$crj_days_elapsed days";
		   echo "</td>";
		   } 
		   else	   
		   {
		    echo "<td align='center' bgcolor='lightgreen'>$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow";
			if($crj_elapsed_override == 'y'){echo "<br /><font color='purple'>Exception Removed:<br />$crj_elapsed_override_approver<br /><a href='crj_exception_override.php?id=$id' target='_blank'>Override Comments</a></font>";}
			echo "</td>";
		   }
		   
		   
		   }
		  // }
		  
		   if($fs_approver=='')
			{		   
		   echo "<td bgcolor='lightpink'>";
		   if($fs_approver_count==1)
		   {
		   echo "<a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id&GC=$GC'>Budget<br />Update</a>";
		   }
		   if($fs_approver_count==0)
		   {
		   echo "Budget<br />Update</a>";
		   }
		   echo "</td>";	
            }
			else
			{		   
		   echo "<td bgcolor='lightgreen'>";
		   echo "$controllers_deposit_id<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver3<br />$fs_approver_date2<br />$fs_approver_date_dow";
		   echo "</td>";
		   }

           // changed on 09/15/14
		   
           if($fs_approver=='')
			{		   		   
		   echo "<td bgcolor='lightpink'>";
		   echo "$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&dncr=$dncr&GC=$GC' target='_blank'>View</a>";
		       if($document_reload=='y' and $cashier_count==1){echo "<br /><br /><a href='bank_deposit_slip.php?id=$id' target='_blank'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red X mark'></img><br />Re-Load Deposit Slip</a>";}
		   echo "</td>";
		   }
		   else
		   {		   		   
		   echo "<td bgcolor='lightgreen'>";
		   echo "$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&dncr=$dncr&GC=$GC' target='_blank'>View</a>";
		   echo "</td>";
		   }
		   
		   
            
           
echo "</tr>";




}

 echo "</table>";
 }


?>