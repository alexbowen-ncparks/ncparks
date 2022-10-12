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
		 echo "<td><a href='stepH8g02.php?budget_group_select=$budget_group'>$budget_group</a></td> 
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
if($budget_group_select != "" and $source_table_select=="")
//{echo "enter code for budget_group drilldown";}
{$query10="select 
source_table,count(id) as 'records',sum(transaction_amount) as 'total_unposted'
from budget1_unposted_weekly
where 1 and center like '1280%'
and budget_group='$budget_group_select'
group by source_table
;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();


$query11="select sum(transaction_amount) as 'total_unposted2',count(id) as 'records_total'
from budget1_unposted_weekly
where 1
and center like '1280%'
and budget_group='$budget_group_select'
; ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


echo "<table>";
echo "<tr><td><font color=brown class=cartRow>Budget Group:$budget_group_select</font></td></tr>";

echo "</table>";

echo "<table border=1>";
 echo "<tr>"; 
    
 echo " <th><font color=blue>source_table</font></th>";
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
		 echo "<td><a href='stepH8g02.php?source_table_select=$source_table&budget_group_select=$budget_group_select'>$source_table</a></td> 
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
if($source_table_select != "" )
//{echo "enter code for budget_group drilldown";}
{$query10="select 
system_entry_date,count(id) as 'records',sum(transaction_amount) as 'total_unposted'
from budget1_unposted_weekly
where 1 and center like '1280%'
and budget_group='$budget_group_select'
and source_table='$source_table_select'
group by budget_group,source_table,system_entry_date
;
";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();


$query11="select sum(transaction_amount) as 'total_unposted2',count(id) as 'records_total'
from budget1_unposted_weekly
where 1
and center like '1280%'
and budget_group='$budget_group_select'
and source_table='$source_table_select'
; ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


echo "<table>";
echo "<tr><td><font color=brown class=cartRow>Budget Group:$budget_group_select</font></td></tr>";

echo "</table>";

echo "<table border=1>";
 echo "<tr>"; 
    
 echo " <th><font color=blue>system_entry_date</font></th>";
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
		 echo "<td><a href='stepH8g02.php?source_table_select=$source_table&budget_group_select=$budget_group_select&system_entry_date_select=$system_entry_date'>$system_entry_date</a></td> 
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
?>
























