<?php
//echo "<pre>";print_r($_SESSION);echo "<pre>";
$parkcodeGMP=$_SESSION['budget']['select'];
//echo "parkcodeGMP=$parkcodeGMP";
//if ($centerS=='12802817')($harp=" or center='12802879'");
//echo "harp=$harp";

//if(!isset($harp)){$harp="";}
/*
$query3="SELECT budget_group, cash_type, gmp, sum( cy_amount ) AS 'cy_amount', sum( py1_amount ) AS 'py1_amount', sum( cy_amount - py1_amount ) AS 'change'
FROM report_budget_history_multiyear2
WHERE 1
AND gmp = 'y'
AND (center = '$centerS'
$harp)
GROUP BY budget_group
ORDER BY budget_group ASC";
*/

$query3="SELECT budget_group, cash_type, gmp, sum( cy_amount ) AS 'cy_amount', sum( py1_amount ) AS 'py1_amount', sum( cy_amount - py1_amount ) AS 'change'
FROM report_budget_history_multiyear2
WHERE 1
AND gmp = 'y'
AND parkcode='$parkcodeGMP'
GROUP BY budget_group
ORDER BY budget_group ASC";










		 
	 
//if($level=='5' and $tempID !='Dodd3454')

	 
	//echo "Query3=$query3";//exit;	


$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<br />";	
/*
$query4="
select sum(cy_amount) as 'cy_amount',
sum(py1_amount) as 'py1_amount',sum(cy_amount-py1_amount) as 'change'	 
FROM report_budget_history_multiyear2
WHERE 1
AND gmp = 'y'
AND (center = '$centerS'
$harp)	 
";
*/

$query4="
select sum(cy_amount) as 'cy_amount',
sum(py1_amount) as 'py1_amount',sum(cy_amount-py1_amount) as 'change'	 
FROM report_budget_history_multiyear2
WHERE 1
AND gmp = 'y'
AND parkcode='$parkcodeGMP'
";









	 
//if($level=='5' and $tempID !='Dodd3454')

//{		 
	//echo "Query4=$query4";//exit;	
//}

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";

$query5="select cy,py1 from fiscal_year where report_year='$f_year' ";
//if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);

if ($centerS=='12802817')
	{$harp_message=" (includes HARI-12802817 and HARP-12802879)";}
	else
	{$harp_message="";}
echo "<table align='center'><tr><td><b>GMP Revenues $harp_message Fiscal Year 2223</b><br /></td></tr></table>";

echo "<table border=1 align='center'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Budget Group</font></th>";
echo "<th align=left><font color=brown>Cash Type</font></th>"; 
echo "<th align=left><font color=brown>GMP</font></th>"; 
echo "<th align=left><font color=brown>$cy</font></th>"; 
echo "<th align=left><font color=brown>$py1</font></th>"; 
echo "<th align=left font size=5><font color=brown>Change</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$cy_amount=number_format($cy_amount,0);
$py1_amount=number_format($py1_amount,0);
$change=number_format($change,0);

if(!isset($table_bg2)){$table_bg2="";}
if(@$c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 		
		
/*		
	echo "<td><a href='budget_group_one_yr_history_accounts.php?report=$report&section=$section&district=$district&accounts=$accounts&history=$history&period=$period&budget_group=$budget_group'>$budget_group</a></td>
		  <td>$cash_type</td> 
           <td>$gmp</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           <td>$change</td>          
  			  
</tr>";

*/
//echo "<td>$budget_group</td>";

if(!isset($section)){$section="";}
echo "<td><a href='/budget/concessions/center_one_yr_history_accounts.php?report=cent&section=$section&district=$district&accounts=gmp&history=1yr&period=fyear&parkcode=$parkcodeGMP&budget_group=$budget_group' target='_blank'>$budget_group</a></td>
		  <td>$cash_type</td> 
           <td>$gmp</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           <td>$change</td>          
  			  
</tr>";

}
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$cy_amount=number_format($cy_amount,0);
$py1_amount=number_format($py1_amount,0);
$change=number_format($change,0);

if(!isset($table_bg2)){$table_bg2="";}
if(@$c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           <td>$change</td> 
           
			  
</tr>";

}

 


 echo "</table></html>";

?>