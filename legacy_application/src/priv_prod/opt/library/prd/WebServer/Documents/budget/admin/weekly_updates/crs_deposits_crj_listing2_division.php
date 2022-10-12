<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}



if($level < '2')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
//echo "query11=$query11";exit;
}



if($level=='2' and $concession_location=='WEDI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='west'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
//echo "query11=$query11";exit;
}


if($level=='2' and $concession_location=='SODI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='south'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
//echo "query11=$query11";exit;
}

if($level=='2' and $concession_location=='EADI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='east'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
//echo "query11=$query11";exit;
}

if($level=='2' and $concession_location=='NODI')
{
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and center.dist='north'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
//echo "query11=$query11";exit;
}


if($level > '2')

{  

$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
         from crs_tdrr_division_history
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

echo "start_date=$start_date<br />end_date=$end_date";





$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
}			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Cash Receipts Journals </font></td></tr></table>";}
if($num11!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
if($num11==1)
{echo "<br /><table><tr><td><font  color=red>ORMS Cash Receipt Journals: $num11</font></td></tr></table>";}

if($num11>1)
{echo "<br /><table><tr><td><font  color=red>ORMS Cash Receipt Journals: $num11</font></td></tr></table>";}


echo "hello tony 1418";

//echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>ORMS Deposit Date</font></th>
       <th align=left><font color=brown>ORMS Deposit ID</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>TransDate Start</font></th>
       <th align=left><font color=brown>TransDate End</font></th>
       <th align=left><font color=brown>Deposit Date</font></th>
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$deposit_id2 = substr($deposit_id, 0, 8);
$deposit_idL8 = substr($deposit_id, -8, 8);
if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   	<td>$parkcode</td>  
		    <td>$center</td>
		    <td>$batch_deposit_date</td>
		    <td><a href='crs_deposits_crj_reports_division.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>$deposit_id</a></td>
		    <td>$amount</td>
		    <td>$trans_min</td>
		    <td>$trans_max</td>
		    <td>$deposit_date</td>
		                      
    
       
              
           
</tr>";




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



















	














