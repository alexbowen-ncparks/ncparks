<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
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

/*
$query1="SELECT start_date as 'fiscal_year_start_date',end_date as 'fiscal_year_end_date'
         from fiscal_year_period
         WHERE fyear='$f_year' ";
*/
	
$query1="SELECT report_year,py1,start_date as fiscal_year_start_date,end_date as fiscal_year_end_date
         from fiscal_year where active_year='y'
          ";
		 
		 

//echo "query1=$query1";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);


$query1a="SELECT start_date as start_date_prior_fiscal,end_date as end_date_prior_fiscal
         from fiscal_year where report_year='$py1'
          ";	 
		 

//echo "query1a=$query1a";
$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$row1a=mysqli_fetch_array($result1a);

extract($row1a);











/*
$query2="SELECT ncas_end_date
         from project_steps_final
         WHERE 1 ";
		 
*/

$query2="SELECT max(postdate) as 'max_actual_date' 
         from report_budget_history_range
         WHERE 1 ";





//echo "query2=$query2";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);
$max_actual_date2=str_replace("-","",$max_actual_date);
$max_actual_date2_unix=strtotime($max_actual_date2);
$max_actual_date2_py_unix=($max_actual_date2_unix-60*60*24*365);
$max_actual_date2_py=(date("Ymd", $max_actual_date2_py_unix))+1;
//$max_actual_date2_year=substr($max_actual_date2,0,4);
$fiscal_year_end_date2=str_replace("-","",$fiscal_year_end_date);
$fiscal_year_end_date2_unix=strtotime($fiscal_year_end_date2);
$fiscal_year_end_date2_py_unix=($fiscal_year_end_date2_unix-60*60*24*365);
$fiscal_year_end_date2_py=date("Ymd", $fiscal_year_end_date2_py_unix);

$end_date_prior_fiscal2=str_replace("-","",$end_date_prior_fiscal);

////echo "<br />report_year=$report_year<br />";
////echo "<br />py1=$py1<br />";
//echo "<br />start_date_prior_fiscal=$start_date_prior_fiscal<br />";
//echo "<br />end_date_prior_fiscal=$end_date_prior_fiscal<br />";
////echo "<br />end_date_prior_fiscal2=$end_date_prior_fiscal2<br />";
//echo "<br />py1=$py1<br />";
//echo "<br />fiscal_year_start_date=$fiscal_year_start_date<br />";
//echo "<br />fiscal_year_end_date=$fiscal_year_end_date<br />";
////echo "<br />max_actual_date=$max_actual_date<br />";
////echo "<br />max_actual_date2=$max_actual_date2<br />";
//echo "<br />max_actual_date2_unix=$max_actual_date2_unix<br />";
//echo "<br />max_actual_date2_py_unix=$max_actual_date2_py_unix<br />";
////echo "<br />max_actual_date2_py=$max_actual_date2_py<br />";
//echo "<br />max_actual_date2_year=$max_actual_date2_year<br />";
////echo "<br />fiscal_year_end_date2=$fiscal_year_end_date2<br />";
//echo "<br />fiscal_year_end_date2_unix=$fiscal_year_end_date2_unix<br />";
//echo "<br />fiscal_year_end_date2_py_unix=$fiscal_year_end_date2_py_unix<br />";
//echo "<br />fiscal_year_end_date2_py=$fiscal_year_end_date2_py<br />";
//echo "<br />max_actual_date=$max_actual_date<br />";
//echo "<br />Line 97<br />";
//exit;

/*
$upload_date=str_replace("-","",$upload_date);
$upload_date2=strtotime("$upload_date");
$upload_yesterday=($upload_date2-60*60*24);
$upload_yesterday2=date("Ymd", $upload_yesterday);
$effective_date=$upload_yesterday2;
*/



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

/*
$query3="select py1 from fiscal_year where report_year='$f_year' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (start_date) as $start_date
*/
///echo "py1=$py1<br />";
//echo "f_year=$f_year<br />";

$query1c="truncate table cab_report_year2year_ws_projection";
 
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
//$num3e=mysqli_num_rows($result3e);


$query1a="insert into cab_report_year2year_ws_projection
(fund,acct,acct_descript,cy_projected,f_year,cash_type)
select '1680',account,account_description,-sum(amount),'$report_year',cash_type
from report_budget_history_range
where postdate >= '$max_actual_date2_py'
and postdate <= '$end_date_prior_fiscal2'
and cash_type='disburse'
group by account ";
 
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
//$num3e=mysqli_num_rows($result3e);


$query1b="insert into cab_report_year2year_ws_projection
(fund,acct,acct_descript,cy_projected,f_year,cash_type)
select '1680',account,account_description,sum(amount),'$report_year',cash_type
from report_budget_history_range
where postdate >= '$max_actual_date2_py'
and postdate <= '$end_date_prior_fiscal2'
and cash_type='receipt'
group by account ";
 
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
//$num3e=mysqli_num_rows($result3e);


/*
$query1c="truncate table cab_report_year2year_cc_adj  ";
 
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
*/


$query3a="truncate table cab_report_year2year_ws;";	 
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
$num3a=mysqli_num_rows($result3a);


////echo "<br />f_year=$f_year<br />";
////echo "<br />report_year=$report_year<br />";

$query3b="insert into cab_report_year2year_ws
(fund,acct,acct_descript,cy_authorized,f_year,cash_type)
select cab_dpr.fund,cab_dpr.acct,cab_dpr.acct_descript,sum(cab_dpr.authorized) as 'authorized',cab_dpr.f_year,coa.cash_type
from cab_dpr
left join coa on cab_dpr.acct=coa.ncasnum
where (cab_dpr.fund='1280' or cab_dpr.fund='1680')
and cab_dpr.f_year='$report_year'
group by acct;";	


 
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");
$num3b=mysqli_num_rows($result3b);


$query3c="insert into cab_report_year2year_ws
(fund,acct,acct_descript,py_actual,f_year,cash_type)
select cab_dpr.fund,cab_dpr.acct,coa.park_acct_desc,sum(ytd),f_year,coa.cash_type
from cab_dpr
left join coa on cab_dpr.acct=coa.ncasnum
where cab_dpr.f_year='$report_year'
and (cab_dpr.fund='1280' or cab_dpr.fund='1680')
and coa.cash_type='disburse'
group by cab_dpr.acct;";

	 
$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");
$num3c=mysqli_num_rows($result3c);

$query3d="insert into cab_report_year2year_ws
(fund,acct,acct_descript,py_actual,f_year,cash_type)
select cab_dpr.fund,cab_dpr.acct,coa.park_acct_desc,sum(ytd),f_year,coa.cash_type
from cab_dpr
left join coa on cab_dpr.acct=coa.ncasnum
where cab_dpr.f_year='$report_year'
and (cab_dpr.fund='1280' or cab_dpr.fund='1680')
and coa.cash_type='receipt'
group by cab_dpr.acct;";


$result3d = mysqli_query($connection, $query3d) or die ("Couldn't execute query 3d.  $query3d");
$num3d=mysqli_num_rows($result3d);



$query3d1="insert into cab_report_year2year_ws
(fund,acct,acct_descript,cy_projected,f_year,cash_type)
select fund,acct,acct_descript,cy_projected,f_year,cash_type
from cab_report_year2year_ws_projection
where 1
group by acct ";


 
$result3d1 = mysqli_query($connection, $query3d1) or die ("Couldn't execute query 3d1.  $query3d1");




$query3e="truncate table cab_report_year2year";
$result3e = mysqli_query($connection, $query3e) or die ("Couldn't execute query 3e.  $query3e");
//$num3e=mysqli_num_rows($result3e);




$query3f="insert into cab_report_year2year
(fund,acct,acct_descript,cy_authorized,py_actual,difference,f_year,cash_type)
select fund,acct,acct_descript,sum(cy_authorized),sum(py_actual),sum(cy_authorized-py_actual),'$f_year',cash_type
from cab_report_year2year_ws
where 1 and cash_type='disburse'
group by acct;";	



$result3f = mysqli_query($connection, $query3f) or die ("Couldn't execute query 3f.  $query3f");
$num3f=mysqli_num_rows($result3f);




$query3g="insert into cab_report_year2year
(fund,acct,acct_descript,cy_authorized,py_actual,difference,f_year,cash_type)
select fund,acct,acct_descript,sum(cy_authorized),sum(py_actual),sum(cy_authorized-py_actual),'$f_year',cash_type
from cab_report_year2year_ws
where 1 and cash_type='receipt'
group by acct;";	



$result3g = mysqli_query($connection, $query3g) or die ("Couldn't execute query 3g.  $query3g");


$query3h="update cab_report_year2year,cab_report_year2year_ws_projection
          set cab_report_year2year.cy_projected=cab_report_year2year_ws_projection.cy_projected
		  where cab_report_year2year.acct=cab_report_year2year_ws_projection.acct
";	



$result3h = mysqli_query($connection, $query3h) or die ("Couldn't execute query 3h.  $query3h");



$query3h1="update cab_report_year2year,cab_report_year2year_cc_adj
           set cab_report_year2year.cy_projected_cc=cab_report_year2year_cc_adj.amount
		   where cab_report_year2year.acct=cab_report_year2year_cc_adj.acct2 ";	



$result3h1 = mysqli_query($connection, $query3h1) or die ("Couldn't execute query 3h1.  $query3h1");




/*
$query3h2a="update cab_report_year2year
           set cy_projected_cc='63000.00'
		   where acct='434410003' ";	


$result3h2a = mysqli_query($connection, $query3h2a) or die ("Couldn't execute query 3h2a.  $query3h2a");
*/


/*
$query3h2a="update cab_report_year2year,cab_report_year2year_cc_adj
            set cab_report_year2year.cy_projected_cc=cab_report_year2year_cc_adj.amount
            where cab_report_year2year.acct=cab_report_year2year_cc_adj.acct2			";	


$result3h2a = mysqli_query($connection, $query3h2a) or die ("Couldn't execute query 3h2a.  $query3h2a");
*/


$query3r="update cab_report_year2year
          set grants='y' where mid(acct,1,3)='536' ";	


$result3r = mysqli_query($connection, $query3r) or die ("Couldn't execute query 3r.  $query3r");


$query3s="update cab_report_year2year
          set valid_record='n' where cy_authorized='0.00' and py_actual='0.00' ";	


$result3s = mysqli_query($connection, $query3s) or die ("Couldn't execute query 3s.  $query3s");


$query3t="update cab_report_year2year
          set cy_projected='0.00' where grants='y' ";	


$result3t = mysqli_query($connection, $query3t) or die ("Couldn't execute query 3t.  $query3t");


//echo "<br />Line 443: query3t=$query3t<br />";




$query3j="update cab_report_year2year
          set cy_projected_total_year=py_actual+cy_projected+cy_projected_cc+facility_closures+price_increases
		  where 1 ";	


$result3j = mysqli_query($connection, $query3j) or die ("Couldn't execute query 3j.  $query3j");



$query3j1="update cab_report_year2year
          set cy_projected2=cy_projected+cy_projected_cc
		  where 1 ";	


$result3j1 = mysqli_query($connection, $query3j1) or die ("Couldn't execute query 3j1.  $query3j1");






$query3k="update cab_report_year2year
          set difference2=cy_authorized-cy_projected_total_year
		  where 1 ";	


$result3k = mysqli_query($connection, $query3k) or die ("Couldn't execute query 3k.  $query3k");


$query3m="update cab_report_year2year,coa
          set cab_report_year2year.acct_descript=coa.park_acct_desc
		  where cab_report_year2year.acct=coa.ncasnum ";	


$result3m = mysqli_query($connection, $query3m) or die ("Couldn't execute query 3m.  $query3m");









if($cash_type==''){$cash_type='receipt';}


//echo "ok";exit;

$query4="select * from cab_report_year2year where 1 and cash_type='$cash_type' and acct != '211940' and valid_record='y' group by fund,acct
order by acct; ";
//echo "<br />query4=$query4<br />";	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


$query4a="select sum(cy_authorized) as 'cy_authorized_total',sum(py_actual) as 'py_actual_total',sum(cy_projected_cc) as 'cy_projected_cc_total',sum(cy_projected2) as 'cy_projected_total',sum(facility_closures) as 'facility_closures_total',sum(price_increases) as 'price_increases_total',sum(cy_projected_total_year) as 'cy_projected_total_year_total',sum(difference2) as 'difference2_total' from cab_report_year2year where 1 and cash_type='$cash_type' and acct != '211940' and valid_record='y'  ";
//echo "<br />query4a=$query4a<br />";	 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);//brings back max (start_date) as $start_date


$cy_authorized_total=number_format($cy_authorized_total,2);
$py_actual_total=number_format($py_actual_total,2);
$cy_projected_cc_total=number_format($cy_projected_cc_total,2);
$cy_projected_total=number_format($cy_projected_total,2);
$facility_closures_total=number_format($facility_closures_total,2);
$price_increases_total=number_format($price_increases_total,2);
$cy_projected_total_year_total=number_format($cy_projected_total_year_total,2);
$difference2_total=number_format($difference2_total,2);



//$difference_total=number_format($difference_total,2);



if($cash_type=='receipt'){$receipt_check="<br /><img height='20' width='20' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}


if($cash_type=='disburse'){$disburse_check="<br /><img height='20' width='20' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}




echo "<br />";

echo "<table><tr><th>
Current Year Authorized versus Current Year Actual (NCAS posted thru: <font color='red'>$max_actual_date</font>)</th></tr></table>";

echo "<br />";
echo "<table><tr><th><a href='cyauth_vs_cyactual2.php?cash_type=receipt'>Receipt $receipt_check</a></th><th>&nbsp;&nbsp;</th><th><a href='cyauth_vs_cyactual2.php?cash_type=disburse'>Disburse $disburse_check</a></th></table>";
//echo "<table><th>CY Authorized versus PY Actual</th></table>";
echo "<br />";
echo "<table><th>$num4 Records</th></table>";

echo "<table border=1>";

echo "<tr>";
//echo "<th>fund</th>";
echo "<th>cash_type</th><th>Acct</th><th>Acct Descript</th><th>$report_year Authorized</th>
<th>$report_year Actual<br /></th><th>$report_year<br />Projected</th><th>$report_year Projected<br />Total Year</th><th>$report_year <br />Authorized-Projected</th><th>id</th>";


echo "</tr>";


while ($row4=mysqli_fetch_array($result4)){


extract($row4);

$cy_authorized=number_format($cy_authorized,2);
$py_actual=number_format($py_actual,2);
$cy_projected_cc=number_format($cy_projected_cc,2);
$cy_projected=number_format($cy_projected,2);
$cy_projected2=number_format($cy_projected2,2);
$facility_closures=number_format($facility_closures,2);
$price_increases=number_format($price_increases,2);
$cy_projected_total_year=number_format($cy_projected_total_year,2);
$difference2=number_format($difference2,2);




$difference=number_format($difference,2);
$acct_descript=strtolower($acct_descript);
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>"; 


//echo "<td>$fund</td>";
echo "<td>$cash_type</td>";  
echo "<td>$acct</td>"; 
echo "<td>$acct_descript</td>"; 
echo "<td>$cy_authorized</td>"; 
echo "<td>$py_actual</td>"; 
//echo "<td>$cy_projected_cc</td>"; 
echo "<td>$cy_projected2</td>";
//echo "<td>$facility_closures</td>"; 
//echo "<td>$price_increases</td>"; 
echo "<td>$cy_projected_total_year</td>"; 
echo "<td>$difference2</td>"; 
//echo "<td>$difference</td>"; 
echo "<td>$id</td>"; 

          
echo "</tr>";

}
/*
echo "<tr>";
echo "<td></td><td></td><td>Total</td><td>$cy_authorized_total</td><td>$py_actual_total</td><td>$cy_projected_total</td><td>$facility_closures_total</td><td>$price_increases_total</td><td>$cy_projected_total_year_total</td><td>$difference2_total</td>";
echo "</tr>";
*/
echo "<tr>";
echo "<td></td><td></td><td>Total</td><td>$cy_authorized_total</td><td>$py_actual_total</td><td>$cy_projected_total</td><td>$cy_projected_total_year_total</td><td>$difference2_total</td>";
echo "</tr>";



 echo "</table>";
 echo "</body>";
 echo "</html>";
 
 
 ?>
 