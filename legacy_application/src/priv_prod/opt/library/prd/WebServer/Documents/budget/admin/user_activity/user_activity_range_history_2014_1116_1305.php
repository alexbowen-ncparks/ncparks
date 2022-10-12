<?php

if($range_start == ""){exit;}
//$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
//$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysql_fetch_array($result2);
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
if(!isset($where_userlevel)){$where_userlevel="";}

$query3="SELECT tempid1,tempid,user_level,location,postitle,count(id) as 'countid' 
FROM `report_user_activity` 
WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
$where_daterange
$where_userlevel
GROUP BY tempid1
ORDER BY `tempid` asc";

//echo "query3=$query3";

/*
$query3="SELECT tempid1,tempid,user_level,location,postitle,count(id) as 'countid' 
FROM `report_user_activity` 
WHERE 1 
$where_daterange
$where_userlevel
GROUP BY tempid1
ORDER BY `countid` DESC";

echo "query3=$query3";
*/






//echo "query3=$query3";
/*	
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);

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
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);


//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysql_fetch_array($result5);
extract($row5);
*/
echo "<table><tr><td>Users:<font color='red'> $num3 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysql_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Rank</font></th>";
echo "<th align=left><font color=brown>TempID</font></th>";
//echo "<th align=left><font color=brown>TempID2</font></th>";
echo "<th align=left><font color=brown>Location</font></th>";
echo "<th align=left><font color=brown>Position</font></th>"; 
echo "<th align=left><font color=brown>UserLevel</font></th>"; 
echo "<th align=left><font color=brown>Hits</font></th>"; 
echo "</tr>";


while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$countid=number_format($countid,0);
$rank=@$rank+1;
if(@$c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
if(!isset($history)){$history="";}
	echo "<td>$rank</td>
	
	      <td><a href='user_activity_range_history_fileactivity.php?tempid1=$tempid1&report=$report&section=$section&district=$district&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'>$tempid1</a></td>
		  
		  
		  
	      <td>$location</td>
          <td>$postitle</td>	      
		  <td>$user_level</td> 
          <td>$countid</td> 	
          
  			  
</tr>";

}

while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid_total=number_format($countid_total,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           	
           <td></td> 
		   <td></td>
		   <td></td>
		   <td></td>
           <td>Total</td> 	
           <td>$countid_total</td> 
           
			  
</tr>";

}

 


 echo "</table></html>";

?>