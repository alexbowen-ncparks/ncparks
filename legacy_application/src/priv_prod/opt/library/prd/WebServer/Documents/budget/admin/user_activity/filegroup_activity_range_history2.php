<?php

if($range_start == ""){exit;}
//$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysqli_fetch_array($result2);
//extract($row2);
//echo "maxdate=$maxdate";
//$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";

/*

$query3="select budget_group,cash_type,gmp,
         sum(amount) as 'amount'	 
         from report_budget_history_range where 1 
		 $where_section
		 $where_accounts
		 $where_district
		 $where_daterange
		 group by budget_group order by cash_type desc, budget_group asc";
	*/

$query3="SELECT filegroup,tempid,count(id) as 'countid' 
FROM `report_user_activity` 
WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
$where_daterange
$where_userlevel
GROUP BY filegroup
ORDER BY `filegroup` ASC";




		 
	echo "$query3";//exit;	

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$query4="select
         count(id) as 'countid_total'	 
         FROM `report_user_activity` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
         $where_daterange
		 $where_userlevel";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query4";//exit;	
}
*/	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
*/




echo "<table><tr><td>Program_Files:<font color='red'> $num3 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
//echo "<th align=left><font color=brown>Rank</font></th>";
echo "<th align=left><font color=brown>Game</font></th>";
//echo "<th align=left><font color=brown>Hits</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$countid=number_format($countid,0);
$rank=$rank+1;
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
	//echo "<td>$rank</td>";
/*
	echo "<td><a href='application_activity_range_history_fileactivity.php?filename3=$filename&report=$report&section=$section&district=$district&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'>$filename</a></td>";
*/	
	
	echo "<td>$filegroup ($countid)</td>";
	
	
	
	
	 //echo "<td>$tempid</td>";
	 //echo "<td>$filename</td>
		//echo "<td>$countid</td> 	
          
  			  
echo "</tr>";

}

while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid_total=number_format($countid_total,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           	
         
           <td>Total ($countid_total)</td> 
           
			  
</tr>";

}

 


 echo "</table></html>";

?>