<?php

{
$query11="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_cc
			WHERE 1 ";

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
$row11=mysqli_fetch_array($result11);
extract($row11);//brings back max (start_date) as $start_date
$total_amount=number_format($total_amount,2);
}

{
$query12="SELECT sum(amount) as 'adjustment_total' 
            from crs_tdrr_cc
			WHERE 1 and ncas_account='000300000'
			 ";
			 
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 "); 
 $row12=mysqli_fetch_array($result12);
 $num12=mysqli_num_rows($result12);
extract($row12);
if($adjustment_total < '0'){$sign2="debit";} else {$sign2="credit";}
$adjustment_total=number_format($adjustment_total,2);
}

{echo "<br />";  echo "<table border=1><tr><th>DepositID</th><th> $deposit_id</th></tr><tr><th> Deposit Total</th><th>$total_amount</th></tr><tr><th>Deposit Adjustments</th><th>$adjustment_total</th></tr></table>";
 
 
  echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc_test.php'>";
  echo "<br />"; 
  echo "<table><tr><th>Step3: Pass Deposit Adjustments below to 434410003-campsite rentals</th>
       <th><input type=submit name=pass_adjustments submit value=YES></th></table>";
  
  echo "<input type='hidden' name='step' value='4'>";
  echo "<input type='hidden' name='deposit_id' value='$deposit_id'>";
  echo "<input type='hidden' name='deposit_dates' value='$deposit_dates'>";
  echo "</form>";
}		   
  
  
 {$query13="SELECT center,parkcode,taxcenter,ncas_account,account_name,tax_note,sum(amount) as 'amount',py_total,validated 
            from crs_tdrr_cc
			WHERE 1 and ncas_account='000300000'
			group by center,ncas_account
            order by center,rank";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);	
 
echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Line#</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Adjustment</font></th>
       <th align=left><font color=brown>Debit/Credit</font></th>
              
</tr>";


while ($row13=mysqli_fetch_array($result13))
{


extract($row13);
$amount=number_format($amount,2);
//if($ncas_account=='000211940'){$center=$taxcenter;}
//if($ncas_account=='000211940'){$account_name=$tax_note;}
if($amount < '0'){$sign="debit";} else {$sign="credit";}
//if($ncas_account=='000200000'){$ncas_account="";}
//if($ncas_account=='000300000'){$ncas_account="";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($amount != '0.00')
{
@$rank=$rank+1;

echo 

"<tr$t> 
		    <td>$rank</td>
		    <td>$parkcode</td>			
		    <td>$center</td>
		    <td>$amount</td>
		    <td>$sign</td>
		    		    
		    
              
           
</tr>";
}
}


//$adjustment_total=number_format($adjustment_total,2);
if($adjustment_total < '0'){$sign2="debit";} else {$sign2="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t> 
		    
		    <td></td>
		    <td></td>
		    <td>Total</td>
		    <td>$adjustment_total</td>
		    <td>$sign2</td>
		   
           
</tr>";

}


 echo "</table>";
 
//echo "Query12=$query12"; 


?>