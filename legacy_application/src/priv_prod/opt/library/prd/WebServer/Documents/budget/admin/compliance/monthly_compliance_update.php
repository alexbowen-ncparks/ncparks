<?php
echo "monthly_compliance_update.php";
$query1="select count(id) as 'rec_count' from cash_imprest_count_scoring where fyear='$compliance_fyear' and cash_month='$compliance_month' ";
//echo "<br />query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "<br />Line9: query1=$query1<br />"; 
//echo "<br />rec_count=$rec_count<br />"; 

//exit;
	
if($compliance_fyear != '' and $compliance_month != '' and $rec_count == 0)
{
	/*
if($compliance_month=='january'){$compliance_month2='february';}	
if($compliance_month=='february'){$compliance_month2='march';}	
if($compliance_month=='march'){$compliance_month2='april';}	
if($compliance_month=='april'){$compliance_month2='may';}	
if($compliance_month=='may'){$compliance_month2='june';}	
if($compliance_month=='june'){$compliance_month2='july';}	
if($compliance_month=='july'){$compliance_month2='august';}	
if($compliance_month=='august'){$compliance_month2='september';}	
if($compliance_month=='september'){$compliance_month2='october';}	
if($compliance_month=='october'){$compliance_month2='november';}	
if($compliance_month=='november'){$compliance_month2='december';}	
if($compliance_month=='december'){$compliance_month2='january';}	
*/



//echo "<br />Line 7: query to insert new month deadlines<br />";	
//echo "compliance_month=$compliance_month";




for ($i = 60; $i <= 100; $i += 10)
{
	
//echo "<br /> score=$i <br />";

$query="insert into cash_imprest_count_scoring
        set fyear='$compliance_fyear',cash_month='$compliance_month',score='$i' ";
		
//echo "<br />query=$query<br />";		

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");		


	
}	

{include ("score_dates.php");}



}	




$query2="select * from cash_imprest_count_scoring where fyear='$compliance_fyear' and cash_month='$compliance_month' order by score desc ";
echo "<br />query2=$query2<br />";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2 .  $query2 ");
$num2=mysqli_num_rows($result2);




echo "<table align='center' border='1'>";
echo "<tr><th colspan='9'><font color='purple'>Records: $num2</font></th></tr>";
echo 

"<tr> 
       
       <th align=left><font color=brown>fyear</font></th>       
       <th align=left><font color=brown>compliance_month</font></th>
       <th align=left><font color=brown>Start Date</font></th>
	   <th align=left><font color=brown>End Date</font></th>
	   <th align=left><font color=brown>Start Date2</font></th>
	   <th align=left><font color=brown>End Date2</font></th>
	   <th align=left><font color=brown>Start Date3</font></th>
	   <th align=left><font color=brown>End Date3</font></th>
	   <th align=left><font color=brown>Score</font></th>
	   <th align=left><font color=brown>Valid</font></th>
	   <th align=left><font color=brown>ID</font></th>
	   ";
	 
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;



while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

//$cashier3=substr($cashier,0,-2);
//$manager3=substr($manager,0,-2);
//if($start_date=='0000-00-00'){$start_date='';}
//if($end_date=='0000-00-00'){$end_date='';}
//if($start_date2=='0000-00-00'){$start_date2='';}
//if($end_date2=='0000-00-00'){$end_date2='';}


//if($manager != ''){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<form method='post' action='monthly_compliance_update2.php' autocomplete='off'>";
echo "<tr$t>";


echo "<td>$fyear</td>";  
echo "<td>$cash_month</td>";  
echo "<td><input type='text' name='start_date' value='$start_date' size='10'></td>";  
echo "<td><input type='text' name='end_date' value='$end_date' size='10'></td>";  
echo "<td><input type='text' name='start_date2' value='$start_date2' size='10'></td>";  
echo "<td><input type='text' name='end_date2' value='$end_date2' size='10'></td>";  
echo "<td><input type='text' name='start_date3' value='$start_date3' size='10'></td>";  
echo "<td><input type='text' name='end_date3' value='$end_date3' size='10'></td>";  


 
echo "<td>$score</td>";  
echo "<td>$valid</td>";  
echo "<td>$id</td>";             
echo "<td>";
echo "<input type='hidden' name='compliance_fyear' value='$compliance_fyear'>";
echo "<input type='hidden' name='compliance_month' value='$compliance_month'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='submit' value='update'>";
echo "</td>";             
echo "</tr>";
echo "</form>";




}

echo "<tr>";
echo "<td colspan='2'></td>";
echo "<td colspan='2'>Cash Imprest Count (GID=10)<br /><br />PCI Compliance (GID=16)</td>";
echo "<td colspan='2'>Park Fuel-MF Vehicles (GID=13)</td>";
echo "<td colspan='2'>WEX Fuel Card (GID=18)</td>";
echo "<td colspan='3'>";

echo "<form action='monthly_compliance_deadline_update.php'>";
echo "<th>Approver: $tempid<br />  <font color='green'>Approved</font>:<input type='checkbox' name='cashier_approved' value='y' ><input type='submit' name='submit' value='Submit'></th>";
echo "<input type='hidden' name='compliance_fyear' value='$compliance_fyear'>";
echo "<input type='hidden' name='compliance_month' value='$compliance_month'>";

echo "</form>";


echo "</td>";
echo "</tr>";



 echo "</table>";
	
?>