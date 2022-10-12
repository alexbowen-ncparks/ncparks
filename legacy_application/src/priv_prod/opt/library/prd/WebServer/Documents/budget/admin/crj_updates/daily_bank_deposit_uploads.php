<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

$today=date("Ymd", time() );
$query11="SELECT min(date) as 'date',hid
          from mission_headlines
		  where date <= '$today'
		  and undeposited_message='n'
		  and date >= '20140816' ";







		
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

//echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);
//echo "<table border=1><tr><th>ORMS Cash Receipt Reports</th></tr></table>";
//extract($row11);
//echo "<table><tr><th>ORMS Cash Receipts (Version 2.14)</th></tr></table>";
//if($num11==0){echo "<br /><table><tr><td><font color=red>No ORMS Deposits </font></td></tr></table>";}

echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Date</font></th>
       <th align=left><font color=brown>hid</font></th>       
      
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$date2=date('m-d-y', strtotime($date));
$date_dow=date('l',strtotime($date));

//echo "record_complete=$record_complete<br />";exit;
if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>
		   	<td bgcolor='lightgreen'>$date2<br />$date_dow</td>  
		    <td bgcolor='lightgreen'>$hid</td>";
		
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



















	














