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



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$range_start=$range_year_start.$range_month_start.$range_day_start;
$range_start2=$range_year_start2.$range_month_start.$range_day_start;

$range_end=$range_year_end.$range_month_end.$range_day_end;
$range_end2=$range_year_end2.$range_month_end.$range_day_end;

$where_daterange="and postdate >= '$range_start' and postdate <= '$range_end'";
$where_daterange2="and postdate >= '$range_start2' and postdate <= '$range_end2'";




$year1_start_date=$range_month_start."-".$range_day_start."-".$range_year_start;
$year1_end_date=$range_month_end."-".$range_day_end."-".$range_year_end;

$year2_start_date=$range_month_start."-".$range_day_start."-".$range_year_start2;
$year2_end_date=$range_month_end."-".$range_day_end."-".$range_year_end2;

$table2="report_budget_history_range_temp1";


/*
if($level=='5' and $tempID !='Dodd3454'){
echo "range_year_start=$range_year_start";echo "<br />";
echo "range_month_start=$range_month_start";echo "<br />";
echo "range_day_start=$range_day_start";echo "<br />";
echo "range_year_end=$range_year_end";echo "<br />";
echo "range_month_end=$range_month_end";echo "<br />";
echo "range_day_end=$range_day_end";echo "<br />";


echo "range_start=$range_start";
echo "<br />";
echo "range_end=$range_end";
echo "<br /><br />";
}
*/

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
$table="report_budget_history_range";

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

/*
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

*/
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
//include ("test_style.php");

echo "</head>";

$table2="report_budget_history_range_temp1";

$query2a="delete from report_budget_history_range_temp1 where beacnum='$beacnum' ";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");

//include ("widget1.php");
//$accounts='all';
//include("widget1.php");






$query2a="select ncasnum as 'account_header',park_acct_desc as 'account_description_header',
          cash_type as 'cash_type_header',gmp as 'gmp_header'
		  from coa where ncasnum='$account' ";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";
/*
if($period== 'fyear'){$table="report_budget_history_multiyear2";}
if($period== 'cyear'){$table="report_budget_history_multiyear_calyear3";}
*/

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


$query2b="insert into report_budget_history_range_temp1(budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,year1,beacnum)
         select budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,sum(amount) as 'year1','$beacnum'
         from $table where 1
		 $where_section
		 $where_accounts
		 $where_district
		 $where_daterange
		 group by parkcode,postdate,account asc ";


$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");			 
		 
//echo "query2b=$query2b"; //exit;		 
		 
$query2c="insert into report_budget_history_range_temp1(budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,year2,beacnum)
         select budget_group,cash_type,gmp,account,account_description,center,center_description,parkcode,district,section,postdate,f_year,sum(amount) as 'year2','$beacnum'
         from $table where 1
		 $where_section
		 $where_accounts
		 $where_district
		 $where_daterange2
		 group by parkcode,postdate,account asc ";	 
		 
$result2c = mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c.  $query2c");	




echo "<br />";



$query3="select parkcode,district,section,
         sum(year1) as 'year1',sum(year2) as 'year2',sum(year2-year1) as 'difference'
         from $table2 where 1 and beacnum='$beacnum'
		 and account='$account'
		 group by account,parkcode ";
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$query4="select
         sum(year1) as 'year1_total'		 
         from $table2 where 1 and beacnum='$beacnum' 
		and account='$account'
         	 
         	 
		 ";


		 
//	echo "<br />query4=$query4<br />"; //exit;	

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);
extract($row4);//brings back max (start_date) as $start_date


$query4a="select
         sum(year2) as 'year2_total'		 
         from $table2 where 1 and beacnum='$beacnum'
		and account='$account'
        	 
         		 
		 ";

		 
//	echo "query4a=$query4a";//exit;	


$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);
$row4a=mysqli_fetch_array($result4a);
extract($row4a);//brings back max (start_date) as $start_date


$query4b="select
         sum(year2-year1) as 'difference_total'		 
         from $table2 where 1 and beacnum='$beacnum'
		 and account='$account'
        
		 ";

		 
//	echo "query4b=$query4b";//exit;	


$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
$row4b=mysqli_fetch_array($result4b);
extract($row4b);//brings back max (start_date) as $start_date

//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
/*
echo "<table>";
echo "<tr><td><font color=brown class=cartRow>Section:$section</font></td></tr>";
if($section=='operations')
{echo "<tr><td><font color=brown class=cartRow>District:$district</font></td></tr>";}
echo "<tr><td><font color=brown class=cartRow>Budget Group:$budget_group</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>Account:$account_header</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>Account Description:$account_description_header</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>Cash Type:$cash_type_header</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>GMP:$gmp_header</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>History:$history</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>Period:$period</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>Start_Date:$range_start</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>End_Date:$range_end</font></td></tr>";
echo "</table>";
*/
echo "<table><tr><th>Report Filters</th></tr></table>";

echo "<table>";
echo "<tr><td>Section<br /><font color=brown class=cartRow>$section</font></td>";
if($section=='operations')
{echo "<td>District<br /><font color=brown class=cartRow>$district</font></td>";}
//echo "<td>Budget Group<br /><font color=brown class=cartRow>$budget_group</font></td>";
echo "<td>Account<br /><font color=brown class=cartRow>$account_header</font></td>";
echo "<td>Account Description<br /><font color=brown class=cartRow>$account_description_header</font></td>";
//echo "<td>Cash Type<br /><font color=brown class=cartRow>$cash_type_header</font></td>";
//echo "<td>GMP<br /><font color=brown class=cartRow>$gmp_header</font></td>";
//echo "<tr><td><font color=brown class=cartRow>History:$history</font></td></tr>";
echo "<td>Period<br /><font color=brown class=cartRow>$period</font></td>";
//echo "<td>Start_Date<br /><font color=brown class=cartRow>$range_start</font></td>";
//echo "<td>End_Date<br /><font color=brown class=cartRow>$range_end</font></td></tr>";
echo "</table>";

echo "<br />";

















/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);

*/


echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

echo "<th align=left><font color=brown>Center</font></th>"; 
echo "<th align=left><font color=brown>Section</font></th>"; 
echo "<th align=left><font color=brown>District</font></th>"; 
echo "<th align=left><font color=brown>$year1_start_date<br />thru<br />$year1_end_date</font></th>"; 
echo "<th align=left><font color=brown>$year2_start_date<br />thru<br />$year2_end_date</font></th>"; 
echo "<th align=left><font color=brown>Change</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$year1=number_format($year1,2);
$year2=number_format($year2,2);
$difference2=number_format($difference,2);
$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>$parkcode</td>
		   <td>$section</td>
           <td>$district</td> 	
           <td>$year1</td> 
           <td>$year2</td> 
           <td>$difference2</td>
                    
			  
</tr>";

}
//while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row4);
$year1_total=number_format($year1_total,2);
$year2_total=number_format($year2_total,2);
$difference_total=number_format($difference_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
            
           <td></td> 
           <td></td> 	
           <td>Total</td> 	
           <td>$year1_total</td> 
           <td>$year2_total</td> 
           <td>$difference_total</td> 
           
			  
</tr>";

//}

 


 echo "</table></html>";
 
 
 

?>














