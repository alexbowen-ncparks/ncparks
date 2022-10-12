<?php
$today=date("Ymd", time() );
if($today_date == ''){$today_date=$today;}
$today_date_last=date("Ymd", $today_date - 60 * 60 * 24);
if($previous=='y'){$today_date=$today_date_last;}

echo "today=$today<br />today_date=$today_date<br />today_date_last=$today_date_last<br />";

$query1="truncate table report_user_activity_today";

//echo "query1=$query1";exit;
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="
insert into report_user_activity_today
(user_level,tempid,user_browser,position,posnum,beacon_num,location,centersess,filename,time1,time2)
select 
user_level,tempid,user_browser,position,posnum,beacon_num,location,centersess,filename,time1,time2
from activity_1314 where time2='$today_date'
 ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

/*
$query2a="REPAIR TABLE `report_user_activity` ";

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
*/

/*
$query3="
update report_user_activity
set cyear=mid(time2,1,4)
where 1 ";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
*/

/*
$query4="
update report_user_activity
set fyear='$fiscal_year'
where 1 ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
*/

/*

$query5="
update report_user_activity
set month_number=mid(time2,5,2)
where 1 ";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
 */
 
$query6="
update report_user_activity_today
set tempid1=left(tempid,char_length(tempid)-2)
where 1 ";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6"); 


$query7="
update report_user_activity_today,tempid_centers
set report_user_activity_today.postitle=tempid_centers.postitle
where report_user_activity_today.tempid=tempid_centers.tempid
";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7"); 


$query8="
update report_user_activity_today,tempid_centers_manual
set report_user_activity_today.postitle=tempid_centers_manual.postitle
where report_user_activity_today.tempid=tempid_centers_manual.tempid
";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8"); 

/*
$query9="
update report_user_activity set fyear='1314'
where fyear='' ";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9"); 

*/
	
	

$query3="SELECT tempid, user_level,location, count(id) as 'countid' 
FROM `report_user_activity_today` 
WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
and time2='$today_date'
GROUP BY tempid
ORDER BY `countid` DESC ";


/*	
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$query4="select
         count(id) as 'countid_total'	 
         FROM `report_user_activity_today` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
         and time2='$today_date' ";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query4";//exit;	
}
*/	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);
extract($row4);

//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
*/
echo "<table>
<tr><th><br /><a href='/budget/admin/user_activity/user_activity_matrix.php?period=today&report=user' title='previous day'><<</a>$today_date<a href='/budget/admin/user_activity/user_activity_matrix.php?period=today&report=user' title='next day'>>></a></th></tr>
<tr><td>$message</td></tr>
<tr><th>$num3 Players </th></tr>
<tr><th>$countid_total Hits </th></tr>
</table>";

echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Rank</font></th>";
echo "<th align=left><font color=brown>TempID</font></th>";
echo "<th align=left><font color=brown>Location</font></th>";
echo "<th align=left><font color=brown>UserLevel</font></th>"; 
echo "<th align=left><font color=brown>Hits</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$countid=number_format($countid,0);
@$rank=$rank+1;
if(@$c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
        
        if(!isset($district)){$district="";}
	echo "<td>$rank</td>
	      <td><a href='user_activity_today_history_fileactivity.php?tempid=$tempid&report=$report&section=$section&district=$district&user_level=$user_level&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'>$tempid</a></td>
		  <td>$location</td>
		  <td>$user_level</td> 
           <td>$countid</td> 	
          
  			  
</tr>";

}
/*
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
*/
$countid_total=number_format($countid_total,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$countid_total</td> 
           
			  
</tr>";

//}

 


 echo "</table></html>";

 
?>