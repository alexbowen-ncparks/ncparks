<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";

//echo "<body bgcolor=>";
include ("../../../budget/menu1415_v3.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-Day5</font></i></H1>";
//echo "<H1 ALIGN=center > <font color=brown><i>$project_name</font></i></H1>";
echo "<br /><br />";
echo "<table align=center><tr><th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />PCARD Lookup</th></tr></table>";
echo "<br /><br />";
/*
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e&reset=yes> RESET REPORT WEEK </A></font></H2>";
*/
//echo "<br />";
echo "<table align='center'>";
echo "<tr>";
echo "<td>";
echo "<table align='center' border='1'> ";
echo "<tr><th><font color='blue'>Reconcilements</font></th></tr>";
echo
"<form align=center>";
echo "<font size=5>"; 
//echo "XTND_day:<input name='fiscal_year' type='text' value='$xtnd_day' readonly='readonly'>";

//echo "<br />";
echo
"<form action='pcard_lookup.php'>";
echo "<font size=5>"; 
//echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";


/*
echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' value='$cardholder' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text' value='$pcard_num' autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text' value='$vendor_name' autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text' value='$amount' autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' value='Find'></td></tr>";
*/

echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='Find'></td></tr>";
echo "<br />";
//echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
//echo "<br />";
//echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
echo "</table>";
echo "</td>";

echo "<td>";
echo "<table align='center' border='1'> ";
echo "<tr><th><font color='red'>XTND Downloads</font></th></tr>";
echo
"<form align=center>";
echo "<font size=5>"; 
//echo "XTND_day:<input name='fiscal_year' type='text' value='$xtnd_day' readonly='readonly'>";

//echo "<br />";
echo
"<form action='pcard_lookup.php'>";
echo "<font size=5>"; 
//echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";


/*
echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' value='$cardholder' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text' value='$pcard_num' autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text' value='$vendor_name' autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text' value='$amount' autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' value='Find'></td></tr>";
*/

echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='Find2'></td></tr>";
echo "<br />";
//echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
//echo "<br />";
//echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";




echo "<br /><br />";


if($submit=='Add')
{

$query1="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.id='$insert_id'
             and pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')	 ";


echo "<br />query1=$query1<br />";	

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


$query11="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where id='$insert_id' ";


echo "<br />query11=$query11<br />";	

$result11 = mysql_query($query11) or die ("Couldn't execute query 11.  $query11");




	
$query1a="SELECT admin_num as 'insert_admin_num' from pcard_unreconciled_xtnd_temp2_perm
          where id='$insert_id' ";

echo "<br />query1a=$query1a<br />";			  
	
$result1a = mysql_query($query1a) or die ("Couldn't execute query 1a.  $query1a");

$row1a=mysql_fetch_array($result1a);
extract($row1a);//brings back max (end_date) as $end_date
	
$query1b="SELECT max(report_date) as 'insert_report_date'
          from pcard_report_dates_compliance
          WHERE 1
          and (admin_num='$insert_admin_num' )
         ";		
	
echo "<br />query1b=$query1b<br />";		
	
$result1b = mysql_query($query1b) or die ("Couldn't execute query 1b.  $query1b");	

$row1b=mysql_fetch_array($result1b);
extract($row1b);//brings back max (end_date) as $end_date



	
$query1c="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$insert_report_date',center,company,last_name,first_name,'$insert_report_date'
from pcard_unreconciled_xtnd_temp2_perm
where id='$insert_id' ; ";

echo "<br />query1c=$query1c<br />";  exit;

//$result1c = mysql_query($query1c) or die ("Couldn't execute query 1c.  $query1c");
}	


if($submit==''){exit;}
if($submit=='Find')
{
	
if($cardholder!=''){$where2=" and cardholder like '%$cardholder%' ";}
if($vendor_name!=''){$where2=" and vendor_name like '%$vendor_name%' ";}
if($amount!=''){$where2=" and amount='$amount' ";}
if($pcard_num!=''){$where2=" and pcard_num='$pcard_num' ";}
	
	
	
$query3="SELECT * FROM pcard_unreconciled
         where 1 $where2 and transdate_new >= '20160701'
		 order by transdate_new desc ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
echo "Line 217: query3=$query3<br />";

mysql_close();
//echo "<br /><br />";

echo "<table align='center'><tr><th><font color='blue'>Reconcilements ($num3 Records)</font></th></tr></table>";

echo "<table border=1 align='center'>";
 
echo 

"<tr>      
       
       <th>Cardholder</th>
       <th>Card#</th>
       <th>Admin#</th>
       <th>Trans Date</th>
       <th>Report Date</th>
       <th>Vendor</th>
       <th>Amount</th>               
       <th>Proj#</th>               
       <th>ID</th>               
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;



echo 
	
"<tr$t>	      
       
	   
	   <td>$cardholder</td>
	   <td>$pcard_num</td>
	   <td>$admin_num</td>
	   <td>$transdate_new</td>
	   <td>$report_date</td>
	   <td>$vendor_name</td>
	   <td>$amount</td>";
	   if($location==1669)
	   {
	   echo "<td><font color='blue'>$projnum</font></td>";
	   }
	   if($location!=1669)
	   {
	   echo "<td>$projnum</td>";
	   }
	   
	   echo "<td>$id</td>";
	   
	      
echo "</tr>";



}

echo "</table>";
}

if($submit=='Find2')
{
	
if($cardholder!=''){$where2=" and cardholder like '%$cardholder%' ";}
if($vendor_name!=''){$where2=" and vendor like '%$vendor_name%' ";}
if($amount!=''){$where2=" and amount='$amount' ";}
if($pcard_num!=''){$where2=" and card_number2='$pcard_num' ";}
	
	
	
$query3="SELECT * FROM pcard_unreconciled_xtnd_temp2_perm
         where 1 $where2 and date_purchased_new >= '20160701'
		 order by date_purchased_new desc ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
echo "query3=$query3<br />";

mysql_close();
//echo "<br /><br />";

echo "<table align='center'><tr><th><font color='red'>XTND Downloads ($num3 Records)</font></th></tr></table>";

echo "<table border=1 align='center'>";
 
echo 

"<tr>      
       
       <th>Cardholder</th>
       <th>Card#</th>
       <th>Admin#</th>
       <th>Report Date</th>
       <th>Vendor</th>
       <th>Amount</th>               
       <th>Trans Date</th>               
       <th>DPR</th>               
       <th>ID</th>               
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;



echo 
	
"<tr$t>	      
       
	   
	   <td>$cardholder</td>
	   <td>$card_number2</td>
	   <td>$admin_num</td>
	   <td>$report_date</td>
	   <td>$vendor</td>
	   <td>$amount</td>
	   <td>$date_purchased_new</td>
	   <td>$dpr</td>
	   <td>$id</td>";
	   if($dpr=='n')
	   {
	   echo "<td><form action='pcard_lookup.php'><input type='submit' name='submit' value='Add'><input type='hidden' name='insert_id' value='$id'></form></td>";
	   }
	      
echo "</tr>";



}

echo "</table>";
}


echo "</body>";
echo "</html>";

?>