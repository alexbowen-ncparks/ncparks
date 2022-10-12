<?php

/*
$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysql_fetch_array($result2);
extract($row2);
//echo "maxdate=$maxdate";
$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";

*/

$query1="truncate table cid_fund_balances";
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
echo "<br />Line 16: query1=$query1<br />";	
$query2="INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
         SELECT fund_in, sum( amount ) ,  '',  ''
         FROM partf_fund_trans
         GROUP  BY fund_in";
echo "<br />Line 21: query2=$query2<br />";		 
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");


$query3="INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
         SELECT fund_out,  '', sum( amount ) ,  ''
         FROM partf_fund_trans
         GROUP  BY fund_out";
echo "<br />Line 29: query3=$query3<br />";			 
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");



$query4="INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )
         SELECT partf_payments.center,  '',  '', sum( amount )
         FROM partf_payments
         left join center on partf_payments.center=center.center
         where 1 
         group by partf_payments.center";
echo "<br />Line 40: query4=$query4<br />";			 
 $result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
 
 
 $where="where 1 and (";
 
if($administration=="X"){$where.="section='administration' or " ;}	  	 
if($design_development=="X"){$where.="section='design_development' or " ;}	  	 
if($natural_resources=="X"){$where.="section='natural_resources' or " ;}	  	 
if($operations=="X"){$where.="section='operations' or " ;}	  	 
 	 
 
  $where.=")";
  
$where2 = str_replace("or )", ")",$where); 

$where2.=" and (";

if($fyear_cy=="X"){$where2.="f_year_funded='$cy' or " ;}
if($fyear_py1=="X"){$where2.="f_year_funded='$py1' or " ;}
if($fyear_py2=="X"){$where2.="f_year_funded='$py2' or " ;}
if($fyear_py3=="X"){$where2.="f_year_funded='$py3' or " ;}
if($fyear_py4=="X"){$where2.="f_year_funded='$py4' or " ;}
if($fyear_py5=="X"){$where2.="f_year_funded='$py5' or " ;}
if($fyear_py6=="X"){$where2.="f_year_funded='$py6' or " ;}
if($fyear_py7=="X"){$where2.="f_year_funded='$py7' or " ;}
if($fyear_py8=="X"){$where2.="f_year_funded='$py8' or " ;}
if($fyear_py9=="X"){$where2.="f_year_funded='$py9' or " ;}
if($fyear_py10=="X"){$where2.="f_year_funded='$py10' or " ;}


$where2.=")";
//echo $where2;exit;
$where3 = str_replace("or )", ")",$where2);



//echo "where statement=$where2"; exit; 
 

 $query5="SELECT cid_fund_balances.center, upper(concat_ws('_',center.center,center.center_desc,center.f_year_funded)) as center_num_name_year, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'expenses', sum( fundsin - fundsout - payments )  AS  'balance'
         FROM cid_fund_balances
         LEFT  JOIN center ON cid_fund_balances.center = center.center
         $where3
         GROUP  BY center";
 $result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
 $num5=mysql_num_rows($result5);
 
 $query6="SELECT sum(fundsin - fundsout )  AS  'funds_allocated_total', sum( payments )  AS  'expenses_total', sum( fundsin - fundsout - payments )  AS  'balance_total'
         FROM cid_fund_balances
         LEFT  JOIN center ON cid_fund_balances.center = center.center
         $where3 ";
		 
 $result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");
 $num6=mysql_num_rows($result6);




echo "query5=$query5";
//if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
//if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}


//$row5=mysql_fetch_array($result5);
//extract($row5);
echo "<br />";
echo "<table><tr><td>Center:<font color='red'> $num5 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysql_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo "<th align=center><font color=brown>Center</font></th>"; 
echo "<th align=center><font color=brown>Center_num_name_year</font></th>"; 
echo "<th align=center><font color=brown>Funds_allocated</font></th>"; 
echo "<th align=center><font color=brown>Expenses</font></th>"; 
//echo "<th align=center><font color=brown>Center_balances</font></th>"; 
//echo "<th align=center><font color=brown>Balance</font></th>"; 
echo "<th align=center><font color=brown>Balance</font></th>"; 
echo "</tr>";


while ($row5=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
$funds_allocated=number_format($funds_allocated,2);
$expenses=number_format($expenses,2);
$balance=number_format($balance,2);





if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		echo  "<td><a href='/budget/b/prtf_center_budget_a.php?center=$center&submit=Submit' target='blank'>$center</a></td>
		       <td>$center_num_name_year</td> 	
               <td>$funds_allocated</td> 	
               <td>$expenses</td>  	
               <td>$balance</td> 	
                
		  
		  
			  
			  
</tr>";

}
while ($row6=mysql_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);

$funds_allocated_total=number_format($funds_allocated_total,2);
$expenses_total=number_format($expenses_total,2);
$balance_total=number_format($balance_total,2);



if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           	
           <td></td> 	
           <td>Total</td> 	
           <td>$funds_allocated_total</td> 
           <td>$expenses_total</td> 
           <td>$balance_total</td> 
           
           
           
                
		  
		  
			  
			  
</tr>";

}

 


 echo "</table></html>";

?>