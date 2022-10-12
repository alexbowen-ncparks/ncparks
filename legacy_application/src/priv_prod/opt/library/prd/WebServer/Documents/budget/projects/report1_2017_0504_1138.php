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

$query1="update partf_projects set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat,'-',spo_number) where 1 ";
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query2="truncate table cid_project_balances";
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");


$query3="insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
select projnum,sum(div_app_amt),'','' from partf_projects
where 1 and projyn='y' group by projnum";
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");



$query4="insert into cid_project_balances(projnum,approved,pm_allocation,expenses)
 select proj_num,'','',sum(amount) from partf_payments 
 where 1  group by proj_num";
 $result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

 $where="where 1 and (";
 
if($cat_ci=="X"){$where.="projcat='ci' or " ;}	  	 
if($cat_de=="X") {$where.="projcat='de' or " ;}	  	 
if($cat_en=="X") {$where.="projcat='en' or " ;}	  	 
if($cat_er=="X") {$where.="projcat='er' or " ;}	 
if($cat_la=="X") {$where.="projcat='la' or " ;}	  	 
if($cat_mi=="X") {$where.="projcat='mi' or " ;}	  	 
if($cat_mm=="X") {$where.="projcat='mm' or " ;}	  	 
if($cat_na=="X") {$where.="projcat='na' or " ;}	  	 
if($cat_tm=="X") {$where.="projcat='tm' or " ;}	
 
  $where.=")";
  
$where2 = str_replace("or )", ")",$where); 
$where2.=" and (";

if($status_ca=="X"){$where2.="statusPer='ca' or " ;}
if($status_fi=="X"){$where2.="statusPer='fi' or " ;}
if($status_ip=="X"){$where2.="statusPer='ip' or " ;}
if($status_na=="X"){$where2.="statusPer='na' or " ;}
if($status_ns=="X"){$where2.="statusPer='ns' or " ;}
if($status_oh=="X"){$where2.="statusPer='oh' or " ;}
if($status_tr=="X"){$where2.="statusPer='tr' or " ;}

$where2.=")";

//echo "where statement=$where2"; exit; 
$where3 = str_replace("or )", ")",$where2);


$where3.=" and (";
 
if($fyear_cy=="X"){$where3.="yearfundf='$cy' or " ;}
if($fyear_py1=="X"){$where3.="yearfundf='$py1' or " ;}
if($fyear_py2=="X"){$where3.="yearfundf='$py2' or " ;}
if($fyear_py3=="X"){$where3.="yearfundf='$py3' or " ;}
if($fyear_py4=="X"){$where3.="yearfundf='$py4' or " ;}
if($fyear_py5=="X"){$where3.="yearfundf='$py5' or " ;}
if($fyear_py6=="X"){$where3.="yearfundf='$py6' or " ;}
if($fyear_py7=="X"){$where3.="yearfundf='$py7' or " ;}
if($fyear_py8=="X"){$where3.="yearfundf='$py8' or " ;}
if($fyear_py9=="X"){$where3.="yearfundf='$py9' or " ;}
if($fyear_py10=="X"){$where3.="yearfundf='$py10' or " ;}


$where3.=")";

$where4 = str_replace("or )", ")",$where3);
 
// echo "where statement=$where4"; exit; 
 
 

$query5="select park,projname,partf_projects.project_center_year_type,sum(approved) as 'approved',
sum(expenses) as 'expenses',sum(approved-expenses) as 'balance', statusper as 'status',manager, 
cid_project_balances.projnum from cid_project_balances 
left join partf_projects on cid_project_balances.projnum=partf_projects.projnum 
$where4
group by cid_project_balances.projnum order by park,status desc, partf_projects.projnum asc";
//echo "sql=$query5";exit;
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);

$query6="select sum(approved) as 'approved_total',sum(expenses) as 'expenses_total',
         sum(approved-expenses) as 'balance_total'
		 from cid_project_balances 
         left join partf_projects on cid_project_balances.projnum=partf_projects.projnum 
         $where4 "; 

$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysql_num_rows($result6);

echo "query5=$query5";
//if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
//if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}


//$row5=mysql_fetch_array($result5);
//extract($row5);
echo "<br />";
echo "<table><tr><td>Projects:<font color='red'> $num5 </font></td></tr></table>";

echo "<table border=1>";

//$row=mysql_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo "<th align=center><font color=brown>Park</font></th>"; 
echo "<th align=center><font color=brown>Project Name</font></th>"; 
echo "<th align=center><font color=brown>project_center_year_type</font></th>"; 
echo "<th align=center><font color=brown>Approved</font></th>"; 
echo "<th align=center><font color=brown>Expenses</font></th>"; 
echo "<th align=center><font color=brown>Balance</font></th>"; 
echo "<th align=center><font color=brown>Status</font></th>"; 
echo "<th align=center><font color=brown>Manager</font></th>"; 
echo "</tr>";


while ($row5=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
$approved=number_format($approved,2);
$expenses=number_format($expenses,2);
$balance=number_format($balance,2);





if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td>$park</td> 
           <td>$projname</td> 	
           <td>$project_center_year_type</td> 	
           <td>$approved</td> 	
           <td>$expenses</td> 	
           <td>$balance</td> 	
           <td>$status</td> 	
           <td>$manager</td> 	            
		  
		  
			  
			  
</tr>";

}
while ($row6=mysql_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row6);

$approved_total=number_format($approved_total,2);
$expenses_total=number_format($expenses_total,2);
$balance_total=number_format($balance_total,2);



if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$approved_total</td> 
           <td>$expenses_total</td> 
           <td>$balance_total</td> 
           
           
           
                
		  
		  
			  
			  
</tr>";

}

 


 echo "</table></html>";

?>