<?php


$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "maxdate=$maxdate";
$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";



$query3="select parkcode,district,section,
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount'
		 from $table where 1
		 $where_section
		 $where_accounts
		 $where_district
		 group by parkcode asc ";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$query4="select
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount' 
         from $table where 1 
         $where_section	
         $where_accounts
         $where_district		 
		 ";

/*
{		 
	echo "$query4";//exit;	
}
*/

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";

if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);

echo "<table><tr><td>Centers:<font color='red'> $num3 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Center</font></th>"; 
echo "<th align=left><font color=brown>Section</font></th>"; 
echo "<th align=left><font color=brown>District</font></th>"; 
echo "<th align=left><font color=brown>$cy</font></th>"; 
echo "<th align=left><font color=brown>$py1</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td><a href='center_one_yr_history_budget_groups.php?report=$report&section=$section&district=$district&accounts=$accounts&history=$history&period=$period&parkcode=$parkcode'>$parkcode</a></td> 
           <td>$section</td> 	
           <td>$district</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
             
  
           
           	  
			  
</tr>";

}
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           
			  
</tr>";

}

 


 echo "</table></div><div id='footer'>footer</div></div></body></html>";

?>