<?php

//$start_date='20100701';
//$end_date='20101231';
//echo "range_start=$range_start";
if($range_start == ""){exit;}
//$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysqli_fetch_array($result2);
//extract($row2);
//echo "maxdate=$maxdate";
//$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$year1_start_date=$range_month_start."-".$range_day_start."-".$range_year_start;
$year1_end_date=$range_month_end."-".$range_day_end."-".$range_year_end;

$year2_start_date=$range_month_start."-".$range_day_start."-".$range_year_start2;
$year2_end_date=$range_month_end."-".$range_day_end."-".$range_year_end2;

//echo "<br />year1_start_date=$year1_start_date<br />";
//echo "<br />year1_end_date=$year1_end_date<br />";

//echo "<br />beacnum=$beacnum<br />";
//echo "<br />where_daterange=$where_daterange<br />";
//echo "<br />where_daterange2=$where_daterange2<br />";

$table2="report_budget_history_range_temp1";

$query2a="delete from report_budget_history_range_temp1 where beacnum='$beacnum' ";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
//echo "<br />query2a=$query2a<br />"; //exit;

$query2b="insert into report_budget_history_range_temp1(budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,year1,beacnum)
         select budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,sum(amount) as 'year1','$beacnum'
         from $table where 1
		 $where_section
		 $where_accounts
		 $where_district
		 $where_daterange
		 group by parkcode,postdate,account asc ";


$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");			 
		 
//echo "query2b=$query2b"; //exit;		 
		 
$query2c="insert into report_budget_history_range_temp1(budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,year2,beacnum)
         select budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,sum(amount) as 'year2','$beacnum'
         from $table where 1
		 $where_section
		 $where_accounts
		 $where_district
		 $where_daterange2
		 group by parkcode,postdate,account asc ";	 
		 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c");		 
//echo "query2c=$query2c"; //exit;		 
		 
//echo "Line50"; //exit;	 



//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //EXIT;

$query3="select parkcode,district,section,sum(year1) as 'year1',sum(year2) as 'year2',sum(year2-year1) as 'difference'
         from $table2 where 1 and beacnum='$beacnum'
		 $where_section
		 $where_accounts
		 $where_district
		 group by parkcode asc ";
	 
//	echo "<br />query3=$query3<br />"; //exit;	

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$query4="select
         sum(year1) as 'year1_total'		 
         from $table2 where 1 and beacnum='$beacnum' 
         $where_section	
         $where_accounts
         $where_district		 
         	 
		 ";


		 
//	echo "<br />query4=$query4<br />"; //exit;	

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);
extract($row4);//brings back max (start_date) as $start_date


$query4a="select
         sum(year2) as 'year2_total'		 
         from $table2 where 1 and beacnum='$beacnum'
         $where_section	
         $where_accounts
         $where_district		 
         		 
		 ";

		 
//	echo "query4a=$query4a";//exit;	


$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);
$row4a=mysqli_fetch_array($result4a);
extract($row4a);//brings back max (start_date) as $start_date


$query4b="select
         sum(year2-year1) as 'difference_total'		 
         from $table2 where 1 and beacnum='$beacnum'
         $where_section	
         $where_accounts
         $where_district		 
         		 
		 ";

		 
//	echo "query4a=$query4a";//exit;	


$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
$row4b=mysqli_fetch_array($result4b);
extract($row4b);//brings back max (start_date) as $start_date









//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}


$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
*/
echo "<table><tr><td>Centers:<font color='red'> $num3 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Center</font></th>"; 
echo "<th align=left><font color=brown>Section</font></th>"; 
echo "<th align=left><font color=brown>District</font></th>"; 
echo "<th align=left><font color=brown>$year1_start_date<br />thru<br />$year1_end_date</font></th>"; 
echo "<th align=left><font color=brown>$year2_start_date<br />thru<br />$year2_end_date</font></th>"; 
echo "<th align=left><font color=brown>Change</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$year1=number_format($year1,2);
$year2=number_format($year2,2);
$difference2=number_format($difference,2);

$table_bg2="cornsilk";
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td><a href='center_range_history_budget_groups.php?report=$report&section=$section&district=$district&accounts=$accounts&period=$period&range_year_start=$range_year_start&range_year_start2=$range_year_start2&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_year_end2=$range_year_end2&range_month_end=$range_month_end&range_day_end=$range_day_end&parkcode=$parkcode'>$parkcode</a></td> 
           <td>$section</td> 	
           <td>$district</td> 	
           <td>$year1</td> 
           <td>$year2</td> 
           <td>$difference2</td> 
           
			  
			  
</tr>";

}
//while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row4);
$year1_total=number_format($year1_total,2);
$year2_total=number_format($year2_total,2);
$difference_total=number_format($difference_total,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$year1_total</td> 
           <td>$year2_total</td> 
           <td>$difference_total</td> 
                        
		  
		  
			  
			  
</tr>";

//}

 


 echo "</table></html>";


?>