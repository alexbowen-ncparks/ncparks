<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$weekly_updates_location=$_SESSION['budget']['select'];
$weekly_updates_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=='5' and $tempID !='Dodd3454')

{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

//echo "f_year=$f_year";


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}



if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "weekly_updates_location:$weekly_updates";
echo "<br />";
echo "weekly_updates_center:$weekly_updates_center";
echo "<br />";
}



$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from weekly_updates_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}

$query11="SELECT filegroup,report_name
from weekly_updates_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Unposted</title>";

//include ("test_style.php");
include ("test_style2.php");

echo "</head>";

include ("widget1.php");
echo "<br />";

//include ("report_header2.php");


//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//if($period== 'fyear'){$table="report_budget_history_multiyear2";}
//if($period== 'cyear'){$table="report_budget_history_multiyear_calyear3";}


 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";




//include("report_header1.php");
if($budget_group_select=="")
{

$query1="truncate table budget1_unposted_weekly;
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, transaction_number, 
transaction_amount, transaction_type, source_table, source_id,system_entry_date ) 
select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, 
ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments', id,system_entry_date 
from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, transaction_number,
 transaction_amount, transaction_type, source_table, source_id,system_entry_date ) 
 select ncas_center, ncas_account, vendor_name, datesql, ncas_invoice_number, -ncas_invoice_amount, 
 'cdcs', 'cid_vendor_invoice_payments', id, system_entry_date 
 from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id; 
";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="
insert into budget1_unposted_weekly( center, account, vendor_name, transaction_date, 
transaction_number, transaction_amount, transaction_type, source_table, source_id,system_entry_date )
 select center, ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),
 transdate_new, transid_new, sum(amount),'pcard','pcard_unreconciled', id,xtnd_rundate_new 
 from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="
update budget1_unposted_weekly,coa set budget1_unposted_weekly.budget_group=coa.budget_group 
where budget1_unposted_weekly.account=coa.ncasnum;
";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="
update budget1_unposted_weekly,center set budget1_unposted_weekly.park=center.parkcode 
where budget1_unposted_weekly.center=center.center;
";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");





//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 

echo "</H3>";

echo "<br />";

$query10="select 
budget_group,count(id) as 'records',sum(transaction_amount) as 'total_unposted'
from budget1_unposted_weekly
where 1 and center like '1280%'
group by budget_group
;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();


$query11="select sum(transaction_amount) as 'total_unposted2',count(id) as 'records_total'
from budget1_unposted_weekly
where 1; ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>budget_group</font></th>";
 echo " <th><font color=blue>records</font></th>";
  echo " <th><font color=blue>total_unposted</font></th>";


echo "</tr>";

while ($row10=mysqli_fetch_array($result10)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row10);
$records=number_format($records,0);
$total_unposted=number_format($total_unposted,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr$t>";	      

               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td><a href='stepH8g0.php?budget_group_select=$budget_group'>$budget_group</a></td> 
               <td>$records</td>		 
               <td>$total_unposted</td> 
           
		  
			  
			  
</tr>";

}
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$total_unposted2=number_format($total_unposted2,2);
$records_total=number_format($records_total,0);




if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
                    	
           	
           <td>Total</td> 
           <td>$records_total</td>		   
           <td>$total_unposted2</td> 
         
		  
			  
			  
</tr>";

}

 


 echo "</table></html>";
}
if($budget_group_select != ""){echo "enter code for budget_group drilldown";}
?>
























