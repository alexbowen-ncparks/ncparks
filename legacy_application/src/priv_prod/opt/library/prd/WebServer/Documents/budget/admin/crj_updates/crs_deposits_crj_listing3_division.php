<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "hello world";
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
if($tempid == 'Fullwood1940'){$concession_location='EADI';}
$today=date("Ymd", time() );
$yesterday=date("Ymd", time() - 60 * 60 * 24);
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;


// Heide Rumble (budget office)

/*
if($beacnum=='60036015')

{
echo "<br />hello Line 33: crs_deposits_crj_listing3_division.php<br />";
}
*/

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


extract($_REQUEST);

// Heide Rumble (budget office)
/*
if($beacnum=='60036015')

{
echo "<br />hello Line 51: crs_deposits_crj_listing3_division.php<br />";
echo "<br />level=$level<br />";
}

*/










$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
         from crs_tdrr_division_history
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";

if($level < '2')
{
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
*/
//echo "query11=$query11<br /><br />";//exit;


$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
and cash_summary.center='$concession_center'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";




//echo "query11=$query11<br />";



$query11a="select deposit_id 
from crs_tdrr_division_history
where center='$concession_center'
and deposit_transaction='y'
and deposit_id='none'
group by center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

//echo "undeposit_count=$undeposit_count<br /><br />";


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
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='west'
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
*/
//echo "query11=$query11";exit;


$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
and center.dist='west'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";




$query11a="select deposit_id 
from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='west'
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

}


if($level=='2' and $concession_location=='SODI')
{
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='south'
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
*/

//echo "query11=$query11";exit;
$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
and center.dist='south'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";

$query11a="select deposit_id 
from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='south'
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

}

if($level=='2' and $concession_location=='EADI')
{
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='east'
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
*/
//echo "query11=$query11";exit;
$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
and center.dist='east'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";

$query11a="select deposit_id 
from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='east'
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

}

if($level=='2' and $concession_location=='NODI')
{
/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='north'
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
*/

//echo "query11=$query11";//exit;
$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
and center.dist='north'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";

$query11a="select deposit_id 
from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='north'
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

}
//heide rumble (budget office)
/*
if($beacnum=='60036015')

{
echo "<br />hello Line 51: crs_deposits_crj_listing3_division.php<br />";
echo "<br />level=$level<br />";
}
*/

if($level > '2')

{  
//if($beacnum=='60032793' or $beacnum=='60032781' or $beacnum=='60032913')
//{//echo "query11 pending";


$query11="SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
FROM cash_summary
LEFT JOIN center ON cash_summary.center = center.center
WHERE 1
AND effect_date = '$yesterday'
GROUP BY cash_summary.center
ORDER BY center.parkcode ASC";


//echo "Line 309: query11=$query11<br />";


$query11a="select deposit_id 
from crs_tdrr_division_history
WHERE 1
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);
}
//exit;}
/*
else
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and deposit_transaction='y' and deposit_id='none'
and ncas_account != '000437995'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, trans_min asc ";


$query11a="select deposit_id 
from crs_tdrr_division_history
WHERE 1
and deposit_transaction='y'
and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);

}
*/			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
/*
if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Deposits </font></td></tr></table>";}
if($num11!=0)
{

if($num11==1)
{echo "<br /><table><tr><td><font  color=red>ORMS Deposits: $num11</font></td></tr></table>";}

if($num11>1)
{echo "<br /><table><tr><td><font  color=red>ORMS Deposits: $num11</font></td></tr></table>";}
echo "<br />";
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
echo "<table border='1'>
<tr><th>Start Date</th><td>$start_date2<br />$start_date_dow</td></tr>
<tr><th>End Date</th><td>$end_date2<br />$end_date_dow</td></tr>
</table>";
echo "<br />";
*/
//echo "hello tony 1418";
/*
echo "<br />";
if($park_code != 'CACR' 
and $park_code != 'CHRO' 
and $park_code != 'DISW' 
and $park_code != 'ELKN' 
and $park_code != 'FOFI' 
and $park_code != 'FOMA' 
and $park_code != 'GRMO' 
and $park_code != 'HARI' 
and $park_code != 'JORI' 
and $park_code != 'MARI' 
and $park_code != 'SILA' 
//and $park_code != 'WEWO' 
and $park_code != 'MOJE' 
)
*/

// 9/18/14
/*
{echo "<br /><table><tr><td align='center'><font  color=red>Deposit data updated daily by 10:00AM</font></td></tr></table>";
}
*/
//echo "<br />";
if($undeposited_message=='y'
//$header_message2 != ''

//and $park_code != 'CACR' 
//and $park_code != 'CHRO' 
//and $park_code != 'DISW' 
//and $park_code != 'ELKN' 
//and $park_code != 'FOFI' 
//and $park_code != 'FOMA' 
//and $park_code != 'GRMO' 
//and $park_code != 'HARI' 
//and $park_code != 'JORI' 
//and $park_code != 'MARI' 
//and $park_code != 'SILA' 
//and $park_code != 'WEWO' 
//and $park_code != 'MOJE' 
//10-03-14
//and $undeposit_count >= 1
/*
and
$beacnum == '60032793'
or
$beacnum == '60032913'
or
$beacnum == '60032840'
*/
)
{

/*
echo "<table><tr><th><marquee loop='1' behavior='slide'>Close of Business $header_message2-F (CRS Parks ONLY) </marquee></th></tr></table>";
*/

/*
echo "<table><tr><th><marquee loop='1' behavior='slide'>Undeposited Financial Session Receipts thru $header_message2</marquee></th></tr></table>";
*/




echo "<br />";
//echo "<table border=1 align='center'>";

//echo 

//echo "<tr>"; 
      
       //echo "<th align=left><font color=brown>Center</font></th>";       
       //echo "<th align=left><font color=brown>Undeposited Session Receipts thru $header_message2</font></th>";
       //echo "<th align=left><font color=brown>Session<br />Receipts<br />Not Deposited<br />Total</font></th>";
	   //echo "<th align=left><font color=brown>Days<br />Undeposited</font></th>";
	   /*
 echo "<th align=left><font color=brown>Deposit Date</font></th>
	   <th align=left><font color=brown>ORMS <br />Deposit ID</font></th>";
       
      
 */      
              
//echo "</tr>";
//echo "</table>";
//$row=mysqli_fetch_array($result);
//echo "hello world 1813";

$query_close_date="SELECT max(effect_date) as 'close_date'
         from cash_summary
		 where 1";
echo "<br />477: query_close_date=$query_close_date<br />";
$result_close_date = mysqli_query($connection, $query_close_date) or die ("Couldn't execute query close date.  $query_close_date");

$row_close_date=mysqli_fetch_array($result_close_date);
extract($row_close_date);//brings back max (end_date) as $end_date
$close_date2=date('m-d-y', strtotime($close_date));
$close_date_dow=date('l',strtotime($close_date));
//echo "<br /><table><tr><td align='center'><font  color=red>Undeposited Funds collected thru $close_date_dow $close_date2</font></td></tr></table>";
echo "<br />";
echo "<br />LINE 486<br />";
echo "<table border='1' align='center'>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<tr><th align='center'>Today's Deposit</th><th>Prior Day<br />Compliance</th><th>Compliance<br />Exceptions<br />Fiscal Year $fyear</tr>";
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$days_elapsed2=$days_elapsed+1;
$trans_min2=date('m-d-y', strtotime($trans_min));
$trans_max2=date('m-d-y', strtotime($trans_max));
$exceptions_remaining=$exceptions-$justified;
//echo "exceptions_remaining=$exceptions_remaining";
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

$trans_min_dow=date('l',strtotime($trans_min));
$trans_max_dow=date('l',strtotime($trans_max));


if($amount >= 250){$amount_color='red';} else {$amount_color='green';}
//if($amount > 0){$amount_color='red';} else {$amount_color='green';}
if($days_elapsed >= 6){$days_color='red';} else {$days_color='green';}
if($days_elapsed >= 6 or $amount >= 250){$deposit_required='y';} else {$deposit_required='n';}
//if($days_elapsed >= 6 or $amount > 0){$deposit_required='y';} else {$deposit_required='n';}
$header_message3="Monday June 23, 2014";
//$header_message is a VARIABLE set in /budget/robot1.html and comes from TABLE=mission_headlines
//$weekend is a VARIABLE set in /budget/robot1.html and comes from TABLE=mission_headlines
//if today's calendar date != weekend or holiday ($header_deposit_required = $header_message) 
if($weekend=='n'){$header_deposit_required=$header_message;}
//if today's calendar date == weekend or holiday ($header_deposit_required will be 
//the next VALID $header_message (the next DATE in TABLE=mission_headlines that is not a weekend
//or holiday) 
if($weekend=='y')
{
$query_hdr="select header_message as 'header_deposit_required'
         from mission_headlines
		 where date > '$today'
		 and weekend='n'
		 order by date
		 limit 1 ";
		 
//echo "query1=$query1<br />";		 

$result_hdr = mysqli_query($connection, $query_hdr) or die ("Couldn't execute query hdr.  $query_hdr");

$row_hdr=mysqli_fetch_array($result_hdr);
extract($row_hdr);
}

if($deposit_required=='y')
{$deposit_message = "<font color='red'>Deposit Required on ".$header_deposit_required.". Thanks</font>";}
else
{$deposit_message = "<font color='green'>NO Deposit required on ".$header_message. ". Thanks</font>";}
//echo "deposit_required=$deposit_required<br /><br />";

//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
$deposit_id2 = substr($deposit_id, 0, 8);
$deposit_idL8 = substr($deposit_id, -8, 8);
if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";
		   //echo "<td>$parkcode</td>";  
		    //echo "<td>$center</td>";
		    
		    
		    
		   echo "<td align='left'>$parkcode  collected  <font color='$amount_color'><b>$amount</b></font>   over <font color='$days_color'><b>$days_elapsed2</b></font> days ($trans_min_dow $trans_min2 thru $header_message2) <br />which is not deposited<br /><marquee behavior='slide' direction='left' loop='1' scrollamount='20'>$deposit_message</marquee></td>";
		  
		
		   if($compliance=='y')
		   {
		   echo "<td align='center'><img height='50' width='50' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";
		   }

            if($compliance=='n')
		   {
		   echo "<td align='center'><img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of Red X Mark'></img></td>";
		   }
           if($exceptions_remaining<=0)
		   {
		   echo "<td align='left'><a href='/budget/admin/crj_updates/compliance.php?parkcode=$parkcode'>Exceptions-$exceptions</a><br />Justified-$justified &nbsp;&nbsp;<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png'></img></td>";		   
		   }
		   else
		   
		    echo "<td align='left'><a href='/budget/admin/crj_updates/compliance.php?parkcode=$parkcode'>Exceptions-$exceptions</a><br />Justified-$justified &nbsp;&nbsp;<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png'></img></td>";
		   
		   		     
		   // echo "<td>$trans_max2<br />$trans_max_dow</td>";
		   
		   /*
			echo "<td align='center'><font color='$amount_color'><b>$amount</b></font><a href='/budget/admin/crj_updates/crs_deposits_crj_listing3_division_detail.php?center=$center&deposit_id=$deposit_id'>&nbsp;&nbsp;<img height='20' width='20' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of magnify glass'></img></a></td>";
			*/
			
			//echo "<td align='center'><font color='$amount_color'><b>$amount</b></font></td>";
			
			
			
			
			
			//echo "<td align='center'><font color='$days_color'><b>$days_elapsed</b></font></td>";
			/*
echo " <td>$deposit_date2<br />$deposit_date_dow</td>";
			if($deposit_id=='none')
			{
			echo "<td><font color='red'>$deposit_id</font></td>";
			}
			else
			{
			echo "<td><a href='crs_deposits_crj_reports_NEW.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>$deposit_id</a></td>
		    <td>$amount</td>";				
			}
		   
*/		    
		                      
    
       
              
           
echo "</tr>";




}

 echo "</table>";
 }
 //}
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 //echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//echo "</html>";


?>



















	














