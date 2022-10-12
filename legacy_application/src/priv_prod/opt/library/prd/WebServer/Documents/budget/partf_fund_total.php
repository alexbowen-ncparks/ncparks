<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

// 1
$sql = "DROP TABLE if exists tempPARTF";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

// 2
// Get Total Funds Out for all post dates ($totalFundOut)
$where="where proj_out != ''  AND  datenew<='$end'";
$sql="SELECT sum( amount )  AS totalFundOut
FROM partf_fund_trans
$where";
//echo "$sql";exit;  // This returns same value as 6 below but as one Total
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);

// 3
// Get Total Funds In for all post dates ($totalFundIn)
$where="where proj_in !='' and datenew<='$end'";
$sql="Select sum(amount) as totalFundIn from partf_fund_trans 
$where";
//echo "$sql";exit; 
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);

// 4
// Get Total Funds for all post dates ($totalFund)
$totalFund=$totalFundIn-$totalFundOut;
//echo "tf=$totalFund";exit; 

// 5  Creat Temp Table to hold dollor amount by projNum
// Since base table has both In and Out first get the In amounts

$whereIn="where proj_in !='' and datenew<='$end'";
//$whereIn="where proj_in !='' and datenew>='$start' and datenew<='$end'";

$sql="CREATE TABLE tempPARTF Select proj_in as projNum, sum(amount) as credit
from partf_fund_trans 
$whereIn
group by proj_in";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");


// 6 This returns same value as 3 below but grouped by proj_out
// Used to get FundOut for Total Posted Fund
//$whereOut="where proj_out !='' and  post_date !=''";
$whereOut="where proj_out !='' and datenew<='$end'";
$sql="Select proj_in as projNum,proj_out as projNumOut, sum(amount) as creditOT,datenew as dateFund
from partf_fund_trans 
$whereOut
group by proj_out";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
extract($row);$projFundOut[$projNumOut]=$creditOT;}


// Used to get FundOut for Month Posted Fund
$whereOut="where proj_out !='' and datenew>='$start' and datenew<='$end'";
$sql="Select proj_in as projNum,proj_out as projNumOut, sum(amount) as creditOM,datenew as dateFund
from partf_fund_trans 
$whereOut
group by proj_out";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	$projFundOutMonth[$projNumOut]=$creditOM;
	}

//echo "$sql <pre>";print_r($projFundOut);print_r($projFundOutMonth);echo "</pre>";exit;

if($start)
	{
	$whereIn="where proj_in !='' and datenew>='$start'";
	if($end){$whereIn=$whereIn." and datenew<='$end' ";}
	}

$sql="Select proj_in as projNum,proj_out as projNumOut, sum(amount) as credit,datenew as dateFund
from partf_fund_trans 
$whereIn
group by proj_in";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result))
	{
	extract($row);$projFundIn[$projNum]=$credit;
	}

//echo "$sql <pre>";print_r($projFundIn);print_r($projFundOut);echo "</pre>";exit;


for($i=0;$i<count($projFundOut);$i++)
	{
	$val=each($projFundOut); 
	//echo "<pre>";print_r($val);echo "</pre>";
	//echo "$val[key] $val[value]<br>";
	$pr=$val['key']; $va=$val['value'];
	
	$sql = "UPDATE tempPARTF set credit=(credit-'$va')
	WHERE projNum='$pr'";
	//echo "$sql";exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	}


$sql = "ALTER TABLE `tempPARTF` ADD PRIMARY KEY (`projNum`)";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//echo "<pre>";print_r($proj);echo "</pre>";

//exit;
//echo "<pre>";print_r($in);echo "</pre>";

//echo "<pre>";print_r($out);echo "</pre>";
?>