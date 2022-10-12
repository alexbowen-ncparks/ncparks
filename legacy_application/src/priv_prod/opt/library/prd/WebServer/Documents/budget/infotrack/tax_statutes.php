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

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo $system_entry_date;//exit;
//print_r($_SESSION);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



if($submit=='Add_Message')

{
$system_entry_date=date("Ymd");
$concession_location=strtolower($concession_location);
$comment_note=addslashes($comment_note);

$query2=" insert into infotrack_projects_community_com set
project_note='note_tracker',park='$concession_location',
user='$tempID',system_entry_date='$system_entry_date',
comment_note='$comment_note',status='ip',alert='y',
original_entry_date='$system_entry_date',pid='$pid' ";

//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

}


echo "<html><body>";
echo "<style>";
echo "td{text-align:center; font-size: 20px;}";
echo "th{text-align:center; font-size: 20px; color: brown;}";
echo "input{text-align:center; font-size: 20px;}";
echo "</style>";
include ("../../budget/menu1415_v1.php");
echo "<br />";


if($rep != 'spreadsheet' and $ncas_num=='')
{



$query1="SELECT ncas_num, ncas_num_description, COUNT( id ) as 'record_count'
FROM tax_statutes
WHERE 1 
GROUP BY ncas_num
order by ncas_num_description asc";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query1 .  $query1");
$num1=mysqli_num_rows($result1);



$query2="SELECT count(id) as 'total_records'
FROM tax_statutes
WHERE 1 
";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2 .  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);





echo "<table><tr><td><font color='brown' size='5'>Tax Statutes: $total_records</font></td></tr></table><br />";
/*
echo "<table><tr><td><a href='/budget/infotrack/date_range_module.php?admin_num=$admin_num&range_start=$range_start&range_end=$range_end&rep=excel' target='_blank'>Excel</a></td></tr></table>";
*/
//echo "$spreadsheet_icon<br />";
echo "<table>";

echo "<tr>";

echo "<th>Account Description</th>";
echo "<th>Account#</th>";

//echo "<th>admin_num</th>";


echo "<th>Record Count</th>";



echo "</tr>";

while ($row1=mysqli_fetch_array($result1)){


extract($row1);

//if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


echo 

"<tr$t>";

echo "<td>$ncas_num_description</td>";

echo "<td>$ncas_num</td>";


echo "<td><a href='tax_statutes.php?ncas_num=$ncas_num'>$record_count</a></td>";




echo "</tr>";
}
echo "<tr><td>ALL</td><td>All Accounts</td><td><a href='tax_statutes.php?ncas_num=all'>$total_records</a></td></tr>";
echo "</table>";



















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

//echo "total_dollars=$total_dollars<br />";
$total_dollars2=number_format($total_dollars,2);

$spreadsheet_icon="<a href='date_range_module.php?rep=spreadsheet&admin_num=$admin_num&range_start=$range_start&range_end=$range_end' target='_blank'><img height='50' width='50' src='/budget/infotrack/icon_photos/csv1.png' alt='reports icon' title='spreadsheet download'></img>";
}






echo "<table><tr><td><font color='brown' size='5'>PCARD Transactions by Date Range</font></td></tr></table><br />";
//if($level==1){$readonly="readonly='readonly";}
//if($level!=1){$readonly='placeholder="parkcode (cabe,etc.)" ';}
echo "<form method='post' autocomplete='off' action=''>";
echo "<table><tr><td><font color='brown'>Admin#</font><input type='text' size='10' name='admin_num' value='$admin_num' $readonly></td></tr></table>";
echo "<br />";

if($submit2!='Go'){exit;}



//echo "</style>";


echo "<br />";
echo "<table><tr><td><font color='brown' size='5'>Records: $num</font></td></tr><tr><td><font color='brown' size='5'>Total Spent: $total_dollars2</font></td></tr></table><br />";
/*
echo "<table><tr><td><a href='/budget/infotrack/date_range_module.php?admin_num=$admin_num&range_start=$range_start&range_end=$range_end&rep=excel' target='_blank'>Excel</a></td></tr></table>";
*/
echo "$spreadsheet_icon<br />";
echo "<table>";

echo "<tr>";
echo "<th>trans_date</th>";

//echo "<th>admin_num</th>";

echo "<th>cardholder</th>";
echo "<th>pcard_num</th>";
echo "<th>location</th>";
echo "<th>transid</th>";
echo "<th>vendor_name</th>";
//echo "<th>address</th>";

//echo "<th>xtnd_rundate</th>";
//echo "<th>parkcode</th>";

echo "<th>item_purchased</th>";
echo "<th>amount</th>";
echo "<th>center</th>";
echo "<th>ncasnum</th>";
echo "<th>ncas_description</th>";
echo "<th>projnum</th>";
echo "<th>equipnum</th>";
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
echo "<td>$trans_date</td>";

echo "<td>$cardholder</td>";
echo "<td>'$pcard_num'</td>";
echo "<td>$location</td>";
//echo "<td>$admin_num</td>";
echo "<td>$transid_new</td>";
echo "<td>$vendor_name</td>";
//echo "<td>$address</td>";

//echo "<td>$xtnd_rundate</td>";
//echo "<td>$parkcode</td>";


echo "<td>$item_purchased</td>";
echo "<td>$amount</td>";
echo "<td>$center</td>";
echo "<td>$ncasnum</td>";
echo "<td>$ncas_description</td>";
echo "<td>$projnum</td>";
echo "<td>$equipnum</td>";
echo "<td>$id</td>";



echo "</tr>";
}
echo "</table>";
}
if ($rep=='spreadsheet')
{

$output = "";

/*
$query14="
select admin_num,concat("'",pcard_num,"'") as 'pcard_num',concat("'",transid_new,"'") as 'transid_new', id from pcard_unreconciled where admin_num='ADMN' and transdate_new >= '20141207' and transdate_new <= '20141222' order by transdate_new";
*/


$query14="
select
trans_date,	
cardholder,	
pcard_num,	
location,	
transid_new,
vendor_name,	
item_purchased,	
amount,	
center,
ncasnum,
ncas_description,
projnum,	
equipnum,	
id
from pcard_unreconciled
where admin_num='$admin_num'
and transdate_new >= '$range_start'
and transdate_new <= '$range_end'
order by transdate_new
";




//echo "query14=$query14<br />";exit;

$result14 =mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$columns_total = mysql_num_fields($result14);

// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
$heading = mysql_field_name($result14, $i);
$output .= '"'.$heading.'",';
}
$output .="\n";



// Get Records from the table

while ($row = mysqli_fetch_array($result14)) {
for ($i = 0; $i < $columns_total; $i++) {
if($i==2 or $i==4)
{
$output .='"'."'".$row["$i"]."'".'",';
}
else
{
$output .='"'.$row["$i"].'",';
}


}
$output .="\n";
}



// Download the file

$filename = "myFile.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

}


echo "</body></html>";






?>

