<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
         from crs_tdrr_division_history
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";

if($level < '2')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
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
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='west'
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
//echo "query11=$query11";exit;
}


if($level=='2' and $concession_location=='SODI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='south'
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
//echo "query11=$query11";exit;
}

if($level=='2' and $concession_location=='EADI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='east'
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
//echo "query11=$query11";exit;
}

if($level=='2' and $concession_location=='NODI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='north'
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
//echo "query11=$query11";//exit;
}



if($level > '2')

{  




$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and deposit_transaction='y'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, trans_min asc ";
}			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Deposits </font></td></tr></table>";}
if($num11!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
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
//echo "hello tony 1418";

//echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       
       
       
       <th align=left><font color=brown>TransDate Start</font></th>
       <th align=left><font color=brown>TransDate End</font></th>
	   <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Deposit Date</font></th>
	   <th align=left><font color=brown>ORMS <br />Deposit ID</font></th>
       
      
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
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

$trans_min_dow=date('l',strtotime($trans_min));
$trans_max_dow=date('l',strtotime($trans_max));





//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
$deposit_id2 = substr($deposit_id, 0, 8);
$deposit_idL8 = substr($deposit_id, -8, 8);
if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   	<td>$parkcode</td>  
		    <td>$center</td>
		    
		    
		    
		    <td>$trans_min2<br />$trans_min_dow</td>
		    <td>$trans_max2<br />$trans_max_dow</td>
			<td>$amount</td>
		    <td>$deposit_date2<br />$deposit_date_dow</td>";
			if($deposit_id=='none')
			{
			echo "<td><font color='red'>$deposit_id</font></td>";
			}
			else
			{
			echo "<td><a href='crs_deposits_crj_reports_NEW.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>$deposit_id</a></td>
		    <td>$amount</td>";				
			}
		   
		    
		                      
    
       
              
           
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



















	














