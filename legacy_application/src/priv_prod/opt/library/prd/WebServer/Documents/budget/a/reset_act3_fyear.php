<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//print_r($_REQUEST);
//print_r($_SESSION);
// Construct Query to be passed to Excel Export

 
 /* Get most recent FY from act3. This will determine whether INSERTS are needed  */
 $query = "SELECT `cy`,`py1`,`py2`,`py3` from fiscal_year where active_year='y' ";
 $result = @mysqli_query($connection, $query);
 $row=mysqli_fetch_array($result);extract($row);
echo "<br />$query<br><br>";
echo "<br />cy=$cy<br />"; 
echo "<br />py1=$py1<br />"; 
echo "<br />py2=$py2<br />"; 
echo "<br />py3=$py3<br />"; 

//exit;
 
echo "<br /><br />";
/* Get most recent FY from act3. This will determine whether INSERTS are needed  */
 $query = "SELECT max(f_year) as checkFY from `act3`";
 $result = @mysqli_query($connection, $query);
 $row=mysqli_fetch_array($result);extract($row);
echo "<br />$query<br>";
echo "<br />checkFY=$checkFY<br />";  
 
 
exit;
 
 
if($f_year!=$checkFY){
 $query = "truncate table `act3`";
    $result = @mysqli_query($connection, $query);
//echo "$query<br><br>";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY3  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,f_year )
SELECT acct, center, sum( debit - credit ), '', '', '', '', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py3'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY2  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '',sum( debit - credit ),'','','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py2'
GROUP BY acct, center";
  $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY1  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '','',sum( debit - credit ),'','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

$rangeStart="20".$y2."0701";
$monthDayMax=substr($maxDate1,4,4);
$prevYearMax=substr($maxDate1,0,4)-1;
$rangeEnd=$prevYearMax.$monthDayMax;
//$y=date(Y);$m=date(m);$d=date(d); 
//$dateEnd=mktime(0,0,0,$m,$d,$y-1);
//$rangeEnd=strftime("%Y%m%d",$dateEnd);

/*inserts ACCT-CENTER amount totals from exp_rev table for LYTT  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,authorized_budget_cy,f_year,amount_LYTT )
SELECT acct, center, '','','','','','','',sum(debit-credit)
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
and acctdate >='$rangeStart' and acctdate <= '$rangeEnd'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query);
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for CY  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct , center, '','','',sum( debit - credit ),'', f_year
FROM `exp_rev`
WHERE 1  AND f_year = '$cy'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND exp_rev.fund = '1280' ";

/*inserts ACCT-CENTER amount totals from budget_center_allocations for CY*/
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT ncas_acct,center,'','','','',sum( allocation_amount ), fy_req
FROM `budget_center_allocations`
WHERE 1 AND fy_req='$cy'
GROUP BY ncas_acct,center";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}
}
//echo "$query<br><br>";


?>



