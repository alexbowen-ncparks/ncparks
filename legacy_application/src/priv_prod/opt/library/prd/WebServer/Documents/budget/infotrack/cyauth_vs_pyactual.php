<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "f_year=$f_year";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 ";

//echo "query10=$query10";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);


echo"
<html>
<head>
<title>MC Procedures</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
include("../../budget/menu1314.php");


$query3="select py1 from fiscal_year where report_year='$f_year' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (start_date) as $start_date
echo "py1=$py1<br />";
echo "f_year=$f_year<br />";


$query3a="truncate table cab_report_year2year_ws;";	 
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
$num3a=mysqli_num_rows($result3a);

$query3b="insert into cab_report_year2year_ws
(fund,acct,acct_descript,cy_authorized,f_year,cash_type)
select cab_dpr.fund,cab_dpr.acct,cab_dpr.acct_descript,sum(cab_dpr.authorized) as 'authorized',cab_dpr.f_year,coa.cash_type
from cab_dpr
left join coa on cab_dpr.acct=coa.ncasnum
where cab_dpr.fund='1280'
and cab_dpr.f_year='$f_year'
group by fund,acct;";	 
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$num3b=mysqli_num_rows($result3b);

$query3c="insert into cab_report_year2year_ws
(fund,acct,acct_descript,py_actual,f_year,cash_type)
select exp_rev.fund,exp_rev.acct,coa.park_acct_desc,sum(debit-credit),f_year,coa.cash_type
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.f_year='$py1'
and exp_rev.fund='1280'
and coa.cash_type='disburse'
group by exp_rev.fund,exp_rev.acct;";	 
$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");
$num3c=mysqli_num_rows($result3c);

$query3d="insert into cab_report_year2year_ws
(fund,acct,acct_descript,py_actual,f_year,cash_type)
select exp_rev.fund,exp_rev.acct,coa.park_acct_desc,sum(credit-debit),f_year,coa.cash_type
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
where exp_rev.f_year='$py1'
and exp_rev.fund='1280'
and coa.cash_type='receipt'
group by exp_rev.fund,exp_rev.acct;";	 
$result3d = mysqli_query($connection, $query3d) or die ("Couldn't execute query 3d.  $query3d");
$num3d=mysqli_num_rows($result3d);

//exit;
/*
$query3e="delete from cab_report_year2year
where f_year='$f_year';";	 
$result3e = mysqli_query($connection, $query3e) or die ("Couldn't execute query 3e.  $query3e");
$num3e=mysqli_num_rows($result3e);
*/

$query3e="truncate table cab_report_year2year";
$result3e = mysqli_query($connection, $query3e) or die ("Couldn't execute query 3e.  $query3e");
//$num3e=mysqli_num_rows($result3e);



$query3f="insert into cab_report_year2year
(fund,acct,acct_descript,cy_authorized,py_actual,difference,f_year,cash_type)
select fund,acct,acct_descript,sum(cy_authorized),sum(py_actual),sum(cy_authorized-py_actual),'$f_year',cash_type
from cab_report_year2year_ws
where 1
group by fund,acct;";	 
$result3f = mysqli_query($connection, $query3f) or die ("Couldn't execute query 3f.  $query3f");
$num3f=mysqli_num_rows($result3f);


//echo "ok";exit;

$query4="select * from cab_report_year2year where 1 group by fund,acct
order by acct; ";	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);





echo "<br />";

echo "<table><tr><th>
Current Year Authorized versus Prior Year Actual</th></tr></table>";

echo "<br />";
//echo "<table><th>CY Authorized versus PY Actual</th></table>";
echo "<br />";
echo "<table><th>$num4 Records</th></table>";

echo "<table border=1>";

echo "<tr>";
echo "<th>fund</th><th>cash_type</th><th>Acct</th><th>Acct Descript</th><th>$f_year Authorized</th>
<th>$py1 Actual</th><th>difference</th><th>id</th>";


echo "</tr>";


while ($row4=mysqli_fetch_array($result4)){


extract($row4);

$cy_authorized=number_format($cy_authorized,2);
$py_actual=number_format($py_actual,2);
$difference=number_format($difference,2);
$acct_descript=strtolower($acct_descript);
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>"; 


echo "<td>$fund</td>";
echo "<td>$cash_type</td>";  
echo "<td>$acct</td>"; 
echo "<td>$acct_descript</td>"; 
echo "<td>$cy_authorized</td>"; 
echo "<td>$py_actual</td>"; 
echo "<td>$difference</td>"; 
echo "<td>$id</td>"; 

          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";
 
 
 ?>
 