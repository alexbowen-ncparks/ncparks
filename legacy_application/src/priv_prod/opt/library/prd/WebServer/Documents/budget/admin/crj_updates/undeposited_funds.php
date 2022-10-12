<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}


$query1="SELECT max(effect_date) as 'close_date'
         from cash_summary
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";

if($level < '2')
{
$query11a="SELECT 
center,park,effect_date,beg_bal,deposit_amount,undeposited_amount,transaction_amount,
end_bal,last_deposit,days_elapsed
from cash_summary
WHERE 1
and center='$concession_center'
and effect_date='$close_date' ";



//echo "query11a=$query11a";//exit;


//}


 $result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a ");
 $num11a=mysqli_num_rows($result11a);		



echo "<table border='1'>
<tr><td><font color='brown'>$concession_location Bank Deposits thru: $close_date</font></td></tr>
</table>";
echo "<br />";

echo "<table border=1>";
/*
echo 

"<tr> 
       <th align=left><font color=brown>Last Deposit</font></th>
       <th align=left><font color=brown>Undeposited </font></th>
       <th align=left><font color=brown>Transaction Amount</font></th>
	   <th align=left><font color=brown>End Bal</font></th>
	   <th align=left><font color=brown>Last Deposit</font></th>
	   <th align=left><font color=brown>Days Elapsed</font></th>";
       
	   
       
      
       
              
echo "</tr>";
*/

while ($row11a=mysqli_fetch_array($result11a)){


extract($row11a);
$days_elapsed2=$days_elapsed+1;

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
/*
echo 

"<tr$t>
		   	
		    <td>$last_deposit<br />$deposit_amount<br />$days_elapsed2 days ago</td>
		    <td>$undeposited_amount</td>
		    <td>$transaction_amount</td>
		    <td>$end_bal</td>
		    <td>$last_deposit</td>
		    <td>$days_elapsed</td>
		  		                      
    
       
              
           
</tr>";
*/
echo "<tr><th>Undeposited Funds equals $end_bal</th></tr>";



}

 echo "</table>";
 
 //{include("undeposit_message.php");}
 
}


?>



















	














