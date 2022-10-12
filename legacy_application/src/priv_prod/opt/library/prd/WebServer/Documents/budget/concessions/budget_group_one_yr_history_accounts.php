<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/


$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;
include("../../budget/menu1314.php");

echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

//include ("widget1.php");

//include("widget1.php");


$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "maxdate=$maxdate";
$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";
if($period== 'fyear'){$table="report_budget_history_multiyear2";}
if($period== 'cyear'){$table="report_budget_history_multiyear_calyear3";}

if($section != 'all'){$where_section= " and section='$section' ";}

if($accounts != 'all' and $accounts != 'gmp')
{$where_accounts= " and cash_type='$accounts' ";}

if($accounts != 'all' and $accounts == 'gmp')
{$where_accounts= " and gmp='y' ";}

if($district != 'all' and $district != ''){$where_district= " and district='$district' ";}

 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";

/*
if($accounts != 'all' and $accounts != 'gmp')
{$where_accounts= " and cash_type='$accounts' ";}

if($accounts != 'all' and $accounts == 'gmp')
{$where_accounts= " and gmp='y' ";}
*/

if(!isset($where_section)){$where_section="";}
if(!isset($where_accounts)){$where_accounts="";}
if(!isset($where_district)){$where_district="";}
$query3="select account,account_description,cash_type,gmp,
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount'
         from $table where 1 
		 and budget_group='$budget_group'
		 $where_section
		 $where_accounts
		 $where_district		 
		 group by account ";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$query4="select
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount'	 
         from $table where 1 
		 and budget_group='$budget_group'
		 $where_section
		 $where_accounts
		 $where_district		 
		 ";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query4";//exit;	
}
*/	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

echo "<table><tr><th>Report Filters</th></tr></table>";

//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
echo "<table>";
//echo "<tr><td><font color=brown class=cartRow>Center:$parkcode</font></td></tr>";
echo "<tr><td>Section<br /><font color=brown class=cartRow>$section</font></td>";
if($section=='operations')
{echo "<td>District<br /><font color=brown class=cartRow>$district</font></td>";}
echo "<td>Budget Group<br /><font color=brown class=cartRow>$budget_group</font></td>";
//echo "<td>Accounts<br /><font color=brown class=cartRow>$accounts</font></td>";
echo "<td>History<br /><font color=brown class=cartRow>$history</font></td>";
echo "<td>Period<br /><font color=brown class=cartRow>$period</font></td></tr>";


echo "</table>";
echo "<br />";

if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);




echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

echo "<th align=left><font color=brown>Account</font></th>"; 
echo "<th align=left><font color=brown>Account Description</font></th>"; 
echo "<th align=left><font color=brown>Cash Type</font></th>"; 
echo "<th align=left><font color=brown>GMP</font></th>"; 
echo "<th align=left><font color=brown>$cy</font></th>"; 
echo "<th align=left><font color=brown>$py1</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);


if(@$c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='budget_group_one_yr_history_account_centers.php?report=$report&section=$section&district=$district&history=$history&period=$period&budget_group=$budget_group&account=$account'>$account</a></td>
		   <td>$account_description</td>
           <td>$cash_type</td> 	
           <td>$gmp</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           
			  
</tr>";

}
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
           <td></td>  
           <td></td> 
           <td></td> 	
           <td>Total</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           
			  
</tr>";

}

 


 echo "</table></html>";
 
 
 

?>





















	














