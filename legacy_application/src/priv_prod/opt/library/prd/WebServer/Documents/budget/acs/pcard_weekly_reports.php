<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../../include/authBUDGET.inc");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//$dbTable="partf_payments";
$tempid=$_SESSION['budget']['tempID'];


$file="pcard_weekly_reports.php";
$fileMenu="pcard_weekly_reports_menu.php";
$varQuery=$_SERVER[QUERY_STRING];// ECHO "v=$varQuery";//exit;

extract($_REQUEST);

if($admin_num){$parkcode=$admin_num;}
$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

// ******** Edit/Update Status ***********
if($b_ok!=""){

$query="UPDATE `pcard_unreconciled` 
set budget_ok='$b_ok'
WHERE admin_num='$admin' and report_date='$report_date'";
//echo "$query<br>";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");

if($b_ok=="y"){
$today=date(Ymd);
$query="UPDATE `pcard_unreconciled` 
set budget2controllers='$today'
WHERE admin_num='$admin' and report_date='$report_date'";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


$query="UPDATE `pcard_report_dates_compliance` 
set fs_approver='$tempid',fs_approver_date='$today',deadline_ok2='$de_ok2'
WHERE admin_num='$admin' and report_date='$report_date'";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


}

if($b_ok=="n"){
$query="UPDATE `pcard_unreconciled` 
set budget2controllers='0000-00-00'
WHERE admin_num='$admin' and report_date='$report_date'";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

}

//echo "$query<br>";exit;

}// end for


if($de_ok!=""){

$query="UPDATE `pcard_unreconciled` 
set deadline_ok='$de_ok'
WHERE admin_num='$admin' and report_date='$report_date'";
//echo "$query<br>";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");

}// end for



$varQuery="report_date=$report_date";
// ECHO "v=$varQuery";exit;
//header("Location: pcard_recon.php?$varQuery");exit;


// **************  Show Results ***************

if($rep=="excel"){
$forceText="pc-";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=pcard_weekly_reports.xls');
}


// ******** Show Results ***********

if($rep==""){
include("$fileMenu");
if($varQuery){
echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='/budget/acs/pcard_recon.php?xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&admin_num=all&submit=Find'>ALL</a> Transactions";}
}

if($report_date){
include("../../../include/connectDIVPER.62.inc");
$sql="SELECT parkcode,email from dprunit";
   $result = @mysqli_query($connection, $sql,$connection);
   while($row=mysqli_fetch_array($result)){
   extract($row);
   $emailArray[$parkcode]=$email;}
   $_SESSION[budget][email]="exists";
  // print_r($emailArray);//exit;
include("../../../include/connectBUDGET.inc");

echo "<html><body>
<table border='1' cellpadding='3' align='center'>";

$query="update pcard_unreconciled,coa
set pcard_unreconciled.travel='y'
where pcard_unreconciled.ncasnum=coa.ncasnum
and coa.budget_group='travel'
and (pcard_unreconciled.ncasnum like '5327%' or pcard_unreconciled.ncasnum ='532930')";
$result = @mysqli_query($connection, $query,$connection);

$query="truncate table pcard_summary;";
   $result = @mysqli_query($connection, $query,$connection);

$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers,deadline_ok)
select report_date,admin_num,'','','','',budget_ok,budget2controllers,deadline_ok
from pcard_unreconciled
where 1
and report_date='$report_date'
group by admin_num";
   $result = @mysqli_query($connection, $query,$connection);

$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
select report_date,admin_num,count(xtnd_rundate),'','','','',''
from pcard_unreconciled
where 1 and location='1656'
and travel !='y'
and report_date='$report_date'
group by admin_num";
   $result = @mysqli_query($connection, $query,$connection);

$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
select report_date,admin_num,'',count(xtnd_rundate),'','','',''
from pcard_unreconciled
where 1 and location='1656'
and travel ='y'
and report_date='$report_date'
group by admin_num;";
 $result = @mysqli_query($connection, $query,$connection);

$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
select report_date,admin_num,'','',count(xtnd_rundate),'','',''
from pcard_unreconciled
where 1 and location='1669'
and report_date='$report_date'
group by admin_num";
   $result = @mysqli_query($connection, $query,$connection);

$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
select report_date,admin_num,'','','',count(park_recondate),'',''
from pcard_unreconciled
where 1 and park_recondate != '0000-00-00'
and report_date='$report_date'
group by admin_num";
   $result = @mysqli_query($connection, $query,$connection);
$report_date2=str_replace("-","",$report_date);
if($report_date2 >= '20170518')
{
 $query = "select pcard_summary.report_date,admin,
pcard_report_dates_compliance.cashier,pcard_report_dates_compliance.manager, 
sum(count_1656) as 'count_1656',
sum(count_1656_travel) as 'count_1656_travel',
sum(count_1669) as 'count_1669',
sum(count_1656+count_1656_travel+count_1669) as 'total_count',
sum(count_park_recon) as 'park_reconciled_yes',
sum(count_1656+count_1656_travel+count_1669-count_park_recon) as 'park_reconciled_no',budget_ok,budget2controllers,deadline_ok
from pcard_summary
left join pcard_report_dates_compliance on pcard_summary.report_date=pcard_report_dates_compliance.report_date 
where 1
and pcard_summary.admin=pcard_report_dates_compliance.admin_num
group by admin
order by admin";
}

if($report_date2 < '20170518')
{
$query = "select report_date,admin,
sum(count_1656) as 'count_1656',
sum(count_1656_travel) as 'count_1656_travel',
sum(count_1669) as 'count_1669',
sum(count_1656+count_1656_travel+count_1669) as 'total_count',
sum(count_park_recon) as 'park_reconciled_yes',
sum(count_1656+count_1656_travel+count_1669-count_park_recon) as 'park_reconciled_no',budget_ok,budget2controllers
from pcard_summary
where 1
group by admin
order by admin";
}

   $result = @mysqli_query($connection, $query,$connection);

// $num=mysql_found_rows();
//echo "<br><br />$query<br />";//exit;
if($report_date2 >= '20170518')
{
$header="<tr><th>admin</th><th>cashier</th><th>manager</th><th>count_1656</th><th>count_1656_travel</th><th>count_1669</th><th>total_count</th><th>park_reconciled_yes</th><th>park_reconciled_no</th><th>deadline_ok</th><th>budget_ok</th><th>budget2controllers</th></tr>";
}

if($report_date2 < '20170518')
{
$header="<tr><th>admin</th><th>count_1656</th><th>count_1656_travel</th><th>count_1669</th><th>total_count</th><th>park_reconciled_yes</th><th>park_reconciled_no</th><th>budget_ok</th><th>budget2controllers</th></tr>";
}








echo "$header";

$j=1;
while($row = mysqli_fetch_array($result)){
extract($row);
if(fmod($j,10)==0){echo "$header";}$j++;

if($table_bg2==''){$table_bg2='cornsilk';}
    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr$t>";
$EMAIL=$emailArray[$admin];
$mail="<A HREF=\"mailto:$EMAIL?subject=PCARD Reconciliation is late for $report_date&body=Please reconcile all Pcard purchases using the online Budget database.&cc=tammy.dodd@ncmail.net\">$admin</A>
";
$sum1656+=$count_1656;
$sum1656_travel+=$count_1656_travel;
$sum1669+=$count_1669;
$sumTotal+=$total_count;
$sumYes+=$park_reconciled_yes;
$sumNo+=$park_reconciled_no;
$cashier=substr($cashier,0,-2);
$manager=substr($manager,0,-2);

echo "<td align='center'>$mail</td>";
if($report_date2 >= '20170518')
{
echo "<td align='center'>$cashier</td>";
echo "<td align='center'>$manager</td>";
}
echo "<td align='center'>$count_1656</td>
<td align='center'>$count_1656_travel</td>
<td align='center'>$count_1669</td>
<td align='center'>$total_count</td>
<td align='center'>$park_reconciled_yes</td>
<td align='center'>$park_reconciled_no</td>";

//$g1="<font color='green' class='cartRow'>";$g2="</font>";
//$r1="<font color='red'>";$r2="</font>";
//if($budget_ok=="y"){$ckY="checked";$ckN="";}else{$ckY="";$ckN="checked";}


if($deadline_ok=='y'){$deadline_shadeY="class='cartRow'";$deadline_imgY="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($deadline_ok=='n'){$deadline_shadeN="class='cartRow'";$deadline_imgN="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red x mark'></img>";}

$admin=urlencode($admin);

if($deadline_ok=='y')
{
echo "<td align='center'>";
echo "<a href='$PHP_SELF?$varQuery&admin=$admin&de_ok=n'>$deadline_imgY</a>";
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "</td>";
}

if($deadline_ok=='n')
{
echo "<td align='center'>";
echo "<a href='$PHP_SELF?$varQuery&admin=$admin&de_ok=y'>$deadline_imgN</a>";
echo "</td>";
}



if($budget_ok=='y'){$shade_y="class='cartRow'";}
if($budget_ok=='n'){$shade_n="class='cartRow'";}

//$admin=urlencode($admin);

echo "<td align='center'>";
echo "<a href='$PHP_SELF?$varQuery&admin=$admin&b_ok=y&de_ok2=$de_ok'><font $shade_y>Y</font></a>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href='$PHP_SELF?$varQuery&admin=$admin&b_ok=n'><font $shade_n>N</font></a>";
echo "</td>";


echo "<td align='center'>$budget2controllers</td>
</tr>";
$shade_y="";
$shade_n="";
$deadline_shadeY="";
$deadline_shadeN="";
$deadline_imgY="";
$deadline_imgN="";


	}// end while
} // end if report_date

echo "<tr>";
if($report_date2 >= '20170518')
{
echo "<td align='center'></td>";
echo "<td align='center'></td>";
}
echo "<td align='center'></td>
<td align='center'>$sum1656</td>
<td align='center'>$sum1656_travel</td>
<td align='center'>$sum1669</td>
<td align='center'>$sumTotal</td>
<td align='center'>$sumYes</td>
<td align='center'>$sumNo</td>
</tr>";
echo "</div></body></html>";

?>