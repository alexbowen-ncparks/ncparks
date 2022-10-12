<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($level <3){$admin_num=$concession_location;}
$admin_num=$concession_location;
//echo "admin_num=$admin_num<br />";
if($admin_num=='ADM'){$admin_num="ADMN";}

extract($_REQUEST);

if($level==1){$admin_num=$concession_location;}
//echo "admin_num=$admin_num<br />";

$today_date=date("Ymd");
//echo "today_date=$today_date<br />";
$today_date2=strtotime("$today_date");
//echo "today_date2=$today_date2<br />";
$today_date3=($today_date2-60*60*24*15);
//echo "today_date3=$today_date3<br />";
$today_date4=date("Ymd", $today_date3);
//echo "today_date4=$today_date4<br />";
if($range_year_start==''){$range_year_start=substr($today_date4,0,4);}
//echo "range_year_start=$range_year_start<br />";
if($range_month_start==''){$range_month_start=substr($today_date4,4,2);}
//echo "range_month_start=$range_month_start<br />";
if($range_day_start==''){$range_day_start=substr($today_date4,6,2);}
//echo "range_day_start=$range_day_start<br />";

if($range_year_end==''){$range_year_end=substr($today_date,0,4);}
//echo "range_year_end=$range_year_end<br />";
if($range_month_end==''){$range_month_end=substr($today_date,4,2);}
//echo "range_month_end=$range_month_end<br />";
if($range_day_end==''){$range_day_end=substr($today_date,6,2);}
//echo "range_day_end=$range_day_end<br />";

//if($submit2==''){$submit2="Go";}


//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

if(!isset($range_year_start)){$range_year_start="";}
if(!isset($range_month_start)){$range_month_start="";}
if(!isset($range_day_start)){$range_day_start="";}
$range_start=$range_year_start.$range_month_start.$range_day_start;
//echo "range_start=$range_start<br />";

if(!isset($range_year_end)){$range_year_end="";}
if(!isset($range_month_end)){$range_month_end="";}
if(!isset($range_day_end)){$range_day_end="";}
$range_end=$range_year_end.$range_month_end.$range_day_end;
//echo "range_end=$range_end<br />";



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

/*
if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=current_year_budget.xls');
}
*/




if($submit2=='Go')
{$query="select
location,	
admin_num,	
trans_date,	
amount,	
vendor_name,	
address,	
pcard_num,	
xtnd_rundate,	
parkcode,	
cardholder,	
transid_new,	
item_purchased,	
ncasnum,	
center,	
company,	
projnum,	
equipnum,	
ncas_description,	
id
from pcard_unreconciled
where admin_num='$admin_num'
and transdate_new >= '$range_start'
and transdate_new <= '$range_end'
order by transdate_new";
//echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query");
$num=mysqli_num_rows($result);

$query_total="select sum(amount) as 'total_dollars'
              from pcard_unreconciled
			  where admin_num='$admin_num'
			  and transdate_new >= '$range_start'
              and transdate_new <= '$range_end' ";


$result_total = mysqli_query($connection, $query_total) or die ("Couldn't execute query total.  $query_total");

$row_total=mysqli_fetch_array($result_total);
extract($row_total);



}





echo "<html><body>";
echo "<style>";
echo "td{text-align:center; font-size: 20px;}";
echo "th{text-align:center; font-size: 20px; color: brown;}";
echo "input{text-align:center; font-size: 20px;}";
echo "</style>";
echo "<table><tr><td><font color='brown' size='5'>PCARD Transactions by Date Range</font></td></tr></table><br />";
//if($level==1){$readonly="readonly='readonly";}
//if($level!=1){$readonly='placeholder="parkcode (cabe,etc.)" ';}
echo "<form method='post' autocomplete='off' action=''>";
echo "<table><tr><td><font color='brown'>Admin#</font><input type='text' size='10' name='admin_num' value='$admin_num' $readonly></td></tr></table>";
echo "<br />";
echo "<table border='1'>";


   
	  
//row1	  

echo "<tr>";

echo "<td></td><td><font color='brown'>Month</font></td><td><font color='brown'>Day</font></td><td><font color='brown'>Year</font></td>";

echo "</tr>";

	  
//row2	  

echo "<tr>";

echo "<td><font color='brown'>Start</font></td>";

echo "<td><select name='range_month_start'><option></option>";

echo "<option value='01'"; if($range_month_start=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_start=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_start=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_start=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_start=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_start=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_start=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_start=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_start=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_start=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_start=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_start=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";
echo "<td><select name='range_day_start'><option></option>";

echo "<option value='01'"; if($range_day_start=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_start=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_start=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_start=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_start=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_start=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_start=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_start=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_start=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_start=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_start=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_start=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_start=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_start=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_start=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_start=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_start=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_start=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_start=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_start=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_start=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_start=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_start=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_start=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_start=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_start=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_start=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_start=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_start=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_start=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_start=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_start'>";
echo "<option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
echo "<option value='2012'"; if($range_year_start=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_start=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_start=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_start=='2015'){echo "selected";}echo ">2015</option>";

echo "</select></td>";

//echo "</form>";
echo "</tr>";

//row3	  

echo "<tr>";

echo "<td><font color='brown'>End</font></td>";

echo "<td><select name='range_month_end'><option></option>";

echo "<option value='01'"; if($range_month_end=='01'){echo "selected";}echo ">Jan</option>";
echo "<option value='02'"; if($range_month_end=='02'){echo "selected";}echo ">Feb</option>";
echo "<option value='03'"; if($range_month_end=='03'){echo "selected";}echo ">Mar</option>";
echo "<option value='04'"; if($range_month_end=='04'){echo "selected";}echo ">Apr</option>";
echo "<option value='05'"; if($range_month_end=='05'){echo "selected";}echo ">May</option>";
echo "<option value='06'"; if($range_month_end=='06'){echo "selected";}echo ">Jun</option>";
echo "<option value='07'"; if($range_month_end=='07'){echo "selected";}echo ">Jul</option>";
echo "<option value='08'"; if($range_month_end=='08'){echo "selected";}echo ">Aug</option>";
echo "<option value='09'"; if($range_month_end=='09'){echo "selected";}echo ">Sep</option>";
echo "<option value='10'"; if($range_month_end=='10'){echo "selected";}echo ">Oct</option>";
echo "<option value='11'"; if($range_month_end=='11'){echo "selected";}echo ">Nov</option>";
echo "<option value='12'"; if($range_month_end=='12'){echo "selected";}echo ">Dec</option>";

echo "</select></td>";

echo "<td><select name='range_day_end'><option></option>";

echo "<option value='01'"; if($range_day_end=='01'){echo "selected";}echo ">01</option>";
echo "<option value='02'"; if($range_day_end=='02'){echo "selected";}echo ">02</option>";
echo "<option value='03'"; if($range_day_end=='03'){echo "selected";}echo ">03</option>";
echo "<option value='04'"; if($range_day_end=='04'){echo "selected";}echo ">04</option>";
echo "<option value='05'"; if($range_day_end=='05'){echo "selected";}echo ">05</option>";
echo "<option value='06'"; if($range_day_end=='06'){echo "selected";}echo ">06</option>";
echo "<option value='07'"; if($range_day_end=='07'){echo "selected";}echo ">07</option>";
echo "<option value='08'"; if($range_day_end=='08'){echo "selected";}echo ">08</option>";
echo "<option value='09'"; if($range_day_end=='09'){echo "selected";}echo ">09</option>";
echo "<option value='10'"; if($range_day_end=='10'){echo "selected";}echo ">10</option>";
echo "<option value='11'"; if($range_day_end=='11'){echo "selected";}echo ">11</option>";
echo "<option value='12'"; if($range_day_end=='12'){echo "selected";}echo ">12</option>";
echo "<option value='13'"; if($range_day_end=='13'){echo "selected";}echo ">13</option>";
echo "<option value='14'"; if($range_day_end=='14'){echo "selected";}echo ">14</option>";
echo "<option value='15'"; if($range_day_end=='15'){echo "selected";}echo ">15</option>";
echo "<option value='16'"; if($range_day_end=='16'){echo "selected";}echo ">16</option>";
echo "<option value='17'"; if($range_day_end=='17'){echo "selected";}echo ">17</option>";
echo "<option value='18'"; if($range_day_end=='18'){echo "selected";}echo ">18</option>";
echo "<option value='19'"; if($range_day_end=='19'){echo "selected";}echo ">19</option>";
echo "<option value='20'"; if($range_day_end=='20'){echo "selected";}echo ">20</option>";
echo "<option value='21'"; if($range_day_end=='21'){echo "selected";}echo ">21</option>";
echo "<option value='22'"; if($range_day_end=='22'){echo "selected";}echo ">22</option>";
echo "<option value='23'"; if($range_day_end=='23'){echo "selected";}echo ">23</option>";
echo "<option value='24'"; if($range_day_end=='24'){echo "selected";}echo ">24</option>";
echo "<option value='25'"; if($range_day_end=='25'){echo "selected";}echo ">25</option>";
echo "<option value='26'"; if($range_day_end=='26'){echo "selected";}echo ">26</option>";
echo "<option value='27'"; if($range_day_end=='27'){echo "selected";}echo ">27</option>";
echo "<option value='28'"; if($range_day_end=='28'){echo "selected";}echo ">28</option>";
echo "<option value='29'"; if($range_day_end=='29'){echo "selected";}echo ">29</option>";
echo "<option value='30'"; if($range_day_end=='30'){echo "selected";}echo ">30</option>";
echo "<option value='31'"; if($range_day_end=='31'){echo "selected";}echo ">31</option>";

echo "</select></td>";

echo "<td><select name='range_year_end'>";
echo "<option></option>";

//echo "<option value='2008'"; if($range_year_start=='2008'){echo "selected";}echo ">2008</option>";
echo "<option value='2012'"; if($range_year_end=='2012'){echo "selected";}echo ">2012</option>";
echo "<option value='2013'"; if($range_year_end=='2013'){echo "selected";}echo ">2013</option>";
echo "<option value='2014'"; if($range_year_end=='2014'){echo "selected";}echo ">2014</option>";
echo "<option value='2015'"; if($range_year_end=='2015'){echo "selected";}echo ">2015</option>";

echo "</select></td>";

echo "<input type='hidden' name='period' value='range'>";	
echo "<input type='hidden' name='report' value='$report'>";	
echo "<input type='hidden' name='accounts' value='$accounts'>";	
echo "<input type='hidden' name='section' value='$section'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<input type='hidden' name='district' value='$district'>";	
echo "<td><input type=submit name=submit2 value=Go></td>";


echo "</tr>";



echo "</table>";
echo "</form>";
echo "<table>";
echo "<tr>";
echo "<td>";
include("slide_toggle_procedures_module2_pid65.php");
echo "</td>";
echo "<td>";
//include("slide_toggle_procedures_module2_pid66.php");
echo "</td>";
echo "</tr>";
echo "</table>";
if($submit2!='Go'){exit;}



//echo "</style>";



echo "<table><tr><td><font color='brown' size='5'>Records: $num</font></td></tr><tr><td>$total_dollars</td></tr></table><br />";
/*
echo "<table><tr><td><a href='/budget/infotrack/date_range_module.php?admin_num=$admin_num&range_start=$range_start&range_end=$range_end&rep=excel' target='_blank'>Excel</a></td></tr></table>";
*/

echo "<table>";

echo "<tr>";
echo "<th>location</th>";
//echo "<th>admin_num</th>";
echo "<th>trans_date</th>";
echo "<th>amount</th>";
echo "<th>vendor_name</th>";
//echo "<th>address</th>";
echo "<th>pcard_num</th>";
//echo "<th>xtnd_rundate</th>";
//echo "<th>parkcode</th>";
echo "<th>cardholder</th>";
echo "<th>transid</th>";
echo "<th>item_purchased</th>";
echo "<th>ncasnum</th>";
echo "<th>center</th>";
echo "<th>projnum</th>";
echo "<th>equipnum</th>";
echo "<th>ncas_description</th>";
echo "<th>id</th>";


echo "</tr>";

while ($row=mysqli_fetch_array($result)){


extract($row);

if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


echo 

"<tr$t>";
echo "<td>$location</td>";
//echo "<td>$admin_num</td>";
echo "<td>$trans_date</td>";
echo "<td>$amount</td>";
echo "<td>$vendor_name</td>";
//echo "<td>$address</td>";
echo "<td>'$pcard_num'</td>";
//echo "<td>$xtnd_rundate</td>";
//echo "<td>$parkcode</td>";
echo "<td>$cardholder</td>";
echo "<td>$transid_new</td>";
echo "<td>$item_purchased</td>";
echo "<td>$ncasnum</td>";
echo "<td>$center</td>";
echo "<td>$projnum</td>";
echo "<td>$equipnum</td>";
echo "<td>$ncas_description</td>";
echo "<td>$id</td>";



echo "</tr>";
}
echo "</table>";



echo "</body></html>";






?>

