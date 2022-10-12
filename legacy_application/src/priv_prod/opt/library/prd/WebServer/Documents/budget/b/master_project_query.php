<?php



$sql = "insert into partf_fund_trans(fund_in,proj_in,amount)
select center,projnum,'0.00'
from partf_projects
where center='$center'
and reportdisplay='y'
group by center,projnum";
$result = @mysqli_query($connection, $sql);


//echo "<br />Hello master_project_query.php  Line 3<br />"; //exit;
$sql = "truncate table cid_master_project_balances";
$result = @mysqli_query($connection, $sql);

//if($level>4){$showSQL=1;}

$sql = "INSERT  INTO cid_master_project_balances(center,project,fundsin,fundsout,payments )
SELECT fund_in,proj_in,sum( amount ) ,  '',  ''
FROM partf_fund_trans where fund_in != '' 
GROUP  BY fund_in,proj_in ";
$result = @mysqli_query($connection, $sql);


//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_master_project_balances( center,project,fundsin, fundsout, payments )
SELECT fund_out,proj_out,'', sum( amount ) ,  ''
FROM partf_fund_trans where fund_out != '' 
GROUP  BY fund_out,proj_out ";
$result = @mysqli_query($connection, $sql);


//echo "<br><br>$sql";//exit;
$sql = "INSERT  INTO cid_master_project_balances( center,project,fundsin, fundsout, payments )
SELECT center,charg_proj_num,'',  '', sum( amount )
FROM partf_payments
GROUP  BY center,charg_proj_num";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);

//echo "<br />master_project_query.php Line 30<br />"; //exit;

//$center='4a27';

$sql = "update cid_master_project_balances as t1,partf_projects as t2
        set t1.project_description=t2.projname,t1.project_type=t2.projcat,t1.park=t2.park,t1.funding_default=t2.funding_default_project
        where t1.project=t2.projnum		";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql);





$query1="SELECT count(ceid) as 'rec_count' from center
         where new_center='$center' ";
		 
//echo "<br />Query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
//echo "<br />rec_count=$rec_count<br />";
//exit;
echo "<table cellspacing='5' cellpadding='5' border='1'>";
echo "<tr><th>Park</th><th>Master<br />Project#</th><th>Master Project Description</th><th>Project<br /> Type</th><th>NEW<br />Funds</th><th>Funds Allocated</th><th>Payments</th><th>Master Project<br />Balance</th></tr>";


// query below brings back financial summary for ALL "Master Partf Projects". The complete list of "Master Partf Projects" can be found in TABLE: partf_projects  field: reportdisplay=y

$sql62 = "SELECT park as 'master_park',project as 'master_project',project_description as 'master_project_description',project_type as 'master_project_type',funding_default as 'master_funding_default', sum( fundsin - fundsout )  AS  'master_funds_allocated', sum( payments )  AS  'master_payments', sum( fundsin - fundsout - payments )  AS  'master_balance'
FROM cid_master_project_balances
WHERE center =  '$center'
GROUP  BY project";

$result62 = @mysqli_query($connection, $sql62);
echo "<br><br>sql62=$sql62<br /><br />";//exit;

while ($row62=mysqli_fetch_array($result62)){
extract($row62);
$master_funds_allocated=number_format($master_funds_allocated,2);
$master_payments=number_format($master_payments,2);
$master_balance=number_format($master_balance,2);
echo "<tr>";
echo "<td>$master_park</td><td>$master_project</td><td>$master_project_description</td><td>$master_project_type</td>";
if($master_funding_default=='y'){$highlight="<font class='cartRow'>";}
echo "<td>$highlight $master_funding_default</td>";
echo "<td>$master_funds_allocated</td><td>$master_payments</td><td>$master_balance</td>";
echo "</tr>";	
	
$highlight='';	
	
	
}
echo "</table>";
//Bass
if($beacnum=$_SESSION['budget']['beacon_num']=='60032793')
{echo "<table align='center'><tr><td><a href='/budget/editFunds.php?submit=Add' target='_blank'>1)Transfer Master Funding</a></td></tr></table><br />";
echo "<table align='center'><tr><td><a href='/budget/infotrack/table_backup_results.php?database_name=budget&table_name=partf_projects' target='_blank'>2)Change NEW Funds Default</a></td></tr></table><br />";}
echo "<br /><br />END of master_project_query.php<br /><br />";
//exit;










?>