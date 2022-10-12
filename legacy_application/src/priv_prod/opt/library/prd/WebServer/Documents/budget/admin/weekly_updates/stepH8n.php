<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;

//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;
extract($_REQUEST);

//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
*/
//include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;


//$query = "SELECT `cy`,`py1`,`py2`,`py3` from fiscal_year where active_year='y' ";
$query = "SELECT `cy`,`py1`,`py2`,`py3` from fiscal_year where report_year='$fiscal_year' ";
$result = @mysqli_query($connection, $query);
$row=mysqli_fetch_array($result);
extract($row);

/*
echo "<br />$query<br><br>";
echo "<br />cy=$cy<br />"; 
echo "<br />py1=$py1<br />"; 
echo "<br />py2=$py2<br />"; 
echo "<br />py3=$py3<br />"; 
*/

//exit;
 
//echo "<br /><br />";
/* Get most recent FY from act3. This will determine whether INSERTS are needed  */
/*
 $query = "SELECT max(f_year) as checkFY from `act3`";
 $result = @mysqli_query($connection, $query);
 $row=mysqli_fetch_array($result);extract($row);
*/

/*
echo "<br />$query<br>";
echo "<br />checkFY=$checkFY<br />";  
exit;
*/

// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(acctdate),'Report Date: %c/%e/%Y') as maxDate, DATE_FORMAT(max(acctdate),'%Y%m%d') as maxDate1 FROM `exp_rev` WHERE 1 and f_year='$cy' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 0. $sql");
$row=mysqli_fetch_array($result);
extract($row);

//echo "<br />$sql<br>";
//echo "<br />maxDate=$maxDate<br />";  
//echo "<br />maxDate1=$maxDate1<br />";  
//exit;


$range_start_LY=("20".substr($py1,0,2).'0701');
$range_end_LY=(substr($maxDate1,0,4)-1).substr($maxDate1,4,4);

/*
echo "<br />cy=$cy<br />";  
echo "<br />py1=$py1<br />";  
echo "<br />py2=$py2<br />";  
echo "<br />py3=$py3<br />";  
echo "<br />range_start_LY=$range_start_LY<br />";  
echo "<br />range_end_LY=$range_end_LY<br />";  
exit;
*/


//$rangeStart="20".$y2."0701";
//$monthDayMax=substr($maxDate1,4,4);
//$prevYearMax=substr($maxDate1,0,4)-1;
//$rangeEnd=$prevYearMax.$monthDayMax;
//$y=date(Y);$m=date(m);$d=date(d); 
//$dateEnd=mktime(0,0,0,$m,$d,$y-1);
//$rangeEnd=strftime("%Y%m%d",$dateEnd);






 
 
//if($cy!=$checkFY){	
	
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



/*inserts ACCT-CENTER amount totals from exp_rev table for LYTT  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,authorized_budget_cy,f_year,amount_LYTT )
SELECT acct, center, '','','','','','','',sum(debit-credit)
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
and acctdate >='$range_start_LY' and acctdate <= '$range_end_LY'
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
//}
//echo "$query<br><br>";

/*
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


 ?>