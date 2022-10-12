<?php

// Populate New Date Field  (TABLE=crs_tdrr_cc_all)
			
$query10="update crs_tdrr_cc_all set new_date=concat(mid(transaction_date,7,4),mid(transaction_date,1,2),mid(transaction_date,4,2)) where new_date='' ";			
			


/*
$query11="SELECT depositid_cc,sum(amount) as 'amount',f_year
            from crs_tdrr_cc_all
			WHERE 1 
			group by depositid_cc
			order by id desc ";
	
*/


	
 $result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10 ");
 //$num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);

$query11="SELECT new_date,sum(amount) as 'amount',count(id) as 'rec_count' FROM `crs_tdrr_cc_all` WHERE `depositid_cc`='$depositid_cc' group by new_date";			
		
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");




echo "<br />";
echo "<table align='center'><tr><td><font color='red'>DepositID: $depositid_cc</font></td></tr><tr><td><font color='red'>Total: $amount</font></td></tr></table>";
echo "<br />";
echo "<table align='center' border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>TransDate</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Count</font></th>";

  
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

echo "<td>$new_date</td><td>$amount</td><td>$rec_count</td>";
		  
       
              
           
echo "</tr>";




}

 echo "</table>";
 
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














