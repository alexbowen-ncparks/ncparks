<?php
echo "monthly_compliance_update.php";
$query="select * from cash_imprest_count_scoring where fyear='$compliance_fyear' and cash_month='$compliance_month' ";
echo "<br />query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");
$num=mysqli_num_rows($result);	
if($compliance_fyear != '' and $compliance_month != '' and $num == 0)
{
	
echo "<br />Line 7: query to insert new month deadlines<br />";	
$calyear1='20'.substr($compliance_fyear,0,2);
$calyear2='20'.substr($compliance_fyear,2,2);
//echo "calyear1=$calyear1<br /><br />";
//echo "calyear2=$calyear2<br /><br />";

if($compliance_month=='july' or $compliance_month=='august' or $compliance_month=='september' or $compliance=='october' or $compliance_month=='november' or $compliance_month=='december') {$calyear=$calyear1;}
if($compliance_month=='january' or $compliance_month=='february' or $compliance_month=='march' or $compliance_month=='april' or $compliance_month=='may' or $compliance_month=='june') {$calyear=$calyear2;}	
	
echo "<br >Line 19: calyear=$calyear<br />";	
}	
echo "<table align='center' border='1'>";
echo "<tr><th colspan='9'><font color='purple'>Records: $num</font></th></tr>";
echo 

"<tr> 
       
       <th align=left><font color=brown>fyear</font></th>       
       <th align=left><font color=brown>compliance_month</font></th>
       <th align=left><font color=brown>Start Date</font></th>
	   <th align=left><font color=brown>End Date</font></th>
	   <th align=left><font color=brown>Start Date2</font></th>
	   <th align=left><font color=brown>End Date2</font></th>
	   <th align=left><font color=brown>Score</font></th>
	   <th align=left><font color=brown>Valid</font></th>
	   <th align=left><font color=brown>ID</font></th>
	   ";
	 
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;



while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//$cashier3=substr($cashier,0,-2);
//$manager3=substr($manager,0,-2);


//if($manager != ''){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<tr$t>";


echo "<td>$fyear</td>";  
echo "<td>$cash_month</td>";  
echo "<td>$start_date</td>";  
echo "<td>$end_date</td>";  
echo "<td>$start_date2</td>";  
echo "<td>$end_date2</td>";  
echo "<td>$score</td>";  
echo "<td>$valid</td>";  
echo "<td>$id</td>";  
 
			  
			  
           
echo "</tr>";




}

 echo "</table>";
	
?>