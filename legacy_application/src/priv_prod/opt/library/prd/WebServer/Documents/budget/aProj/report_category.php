<?php
// Create variables
	if($report_period=="all"){
		$start="19930701";
		$yr_end=substr($f_year,2,2); 
		$end="20".$yr_end."0630";
					}
	if($report_period=="current"){
		$yr_start=substr($f_year,0,2); 
		$start="20".$yr_start."0701";
		$yr_end=substr($f_year,2,2); 
		$end="20".$yr_end."0630";
					}
	if($other_period){
		$rep_p="Fiscal Year $other_period";
		$yr_start=substr($other_period,0,2); 
		$start="20".$yr_start."0701";
		$yr_end=substr($other_period,2,2); 
		$end="20".$yr_end."0630";
					}

//echo "s=$start e=$end";exit;


$query="truncate table project_cash_flow_posted;";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="insert into project_cash_flow_posted (project_number,partf_payments_amount)
select
charg_proj_num,
sum(amount)
from partf_payments
where 1
and partf_payments.datenew >= 
'$start'
and partf_payments.datenew <=
'$end'
and invoice != 'report_date'
group by charg_proj_num;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="insert into project_cash_flow_posted (project_number,partf_fund_trans_in_amount)
select
proj_in,
sum(amount)
from partf_fund_trans
where 1
and proj_in != ''
and datenew >= 
'$start'
and datenew <=
'$end'
group by proj_in;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="insert into project_cash_flow_posted (project_number,partf_fund_trans_out_amount)
select
proj_out,
sum(amount)
from partf_fund_trans
where 1
and proj_out != ''
and datenew >= 
'$start'
and datenew <=
'$end'
group by proj_out;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="update project_cash_flow_posted,partf_projects
set project_cash_flow_posted.projcat=partf_projects.projcat
where project_cash_flow_posted.project_number=partf_projects.projnum;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="update project_cash_flow_posted,project_categories
set project_cash_flow_posted.project_category=project_categories.category
where project_cash_flow_posted.projcat=project_categories.code;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};

$query="select 
concat(project_cash_flow_posted.projcat,'-',project_cash_flow_posted.project_category) as 'project_category',
sum(project_cash_flow_posted.partf_fund_trans_in_amount-project_cash_flow_posted.partf_fund_trans_out_amount) as 'funding',
sum(project_cash_flow_posted.partf_payments_amount) as 'expenditures',
sum(project_cash_flow_posted.partf_fund_trans_in_amount-project_cash_flow_posted.partf_fund_trans_out_amount)-sum(project_cash_flow_posted.partf_payments_amount) as 'net_funds'
from project_cash_flow_posted
where 1
group by project_cash_flow_posted.project_category
order by project_cash_flow_posted.projcat;
";
   $result = @mysqli_query($connection, $query);
if($showSQL){echo "$query<br><br>";};


// ********** Summary Header
$query="select max(acctdate) as acctdate from exp_rev where 1;
";
   $resultMax = @mysqli_query($connection, $query);
   
if($showSQL){echo "$query<br><br>";};
$row=mysqli_fetch_array($resultMax);
$report_date=$row['acctdate'];

$color='blue';
$f1="<font color='$color'>"; $f2="</font>";
echo "<div align='center'><table border='1'>
<tr><td>Report Date:</td><td>$f1$report_date$f2</td></tr>
<tr><td>Report Name:</td><td>$f1 PARTF_Budget_History$f2</td></tr>
<tr><td>Report Level:</td><td>$f1$report_level$f2</td></tr>
<tr><td>Report Period:</td><td>$f1$rep_p$f2</td></tr>
</table>";


// ****** Body Query
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

$num=count($ARRAY);

$fieldNames=array_values(array_keys($ARRAY[0]));
$decimalFields=array("funding","expenditures","net_funds");
$count=count($fieldNames);

echo "<table border='1' cellpadding='2'><tr><td colspan='$count'>&nbsp;</td></tr>";

echo "<tr><td colspan='2' align='center'><font color='red'>$num</font> records</td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
echo "<th>$v</th>";}
echo "</tr>";

foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2="";$j++;
if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}


echo "<tr>";
	foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
		if(in_array($k1,$decimalFields)){
		$total[$k1]+=$v1;
		$v1=number_format($v1,$decPoint[$k1]);
							}
		
		echo "<td align='right'>$v1</td>";}
	
echo "</tr>";
}

echo "<tr>";
foreach($fieldNames as $k=>$v){
$v2=number_format($total[$v],2);
if($k>0){echo "<th>$v2</th>";}else{echo "<th></th>";}
}
echo "</tr>";
echo "</table>";
echo "<table>";

$color='red';
$f1="<font color='$color'>"; $f2="</font>";
echo "<h2>Important Notes</h2>";

echo "<tr><td><font color='red'>1) Data are incomplete for Project Category: Land</font></td></tr>
      <tr><td><font color='red'>2) Funding & expenditure totals for individual Fiscal Years prior to Fiscal Year 0506 are incomplete</font></td></tr>";
	  
echo "<tr><td><font color='red'>3) MI Project Category includes unallocated Project Funds (Fund 2235, Project 1562)</font></td></tr>";

echo "</table></body></html>";

?>