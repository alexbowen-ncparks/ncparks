<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$user_activity_location=$_SESSION['budget']['select'];
$user_activity_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;

/*
if($level=='5' and $tempID !='Dodd3454')

{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
*/

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$range_start=$range_year_start.$range_month_start.$range_day_start;
$range_end=$range_year_end.$range_month_end.$range_day_end;
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
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

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
from user_activity_customformat
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
from user_activity_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

include("../../../budget/menu1314.php");
//include("menu1314_test.php");
//include ("widget1.php");
//echo "filegroup=$filegroup";
echo "<br />";


echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>UserActivity</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

//include ("widget1.php");

//include("widget1.php");


//$query2="select max(acctdate) as 'maxdate' from exp_rev where 1 ";
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysqli_fetch_array($result2);
//extract($row2);
//echo "maxdate=$maxdate";
//$calendar_year=substr($maxdate,0,4);
//echo "calendar_year=$calendar_year";

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//if($period== 'fyear'){$table="report_budget_history_multiyear2";}
//if($period== 'cyear'){$table="report_budget_history_multiyear_calyear3";}
 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";
/*
if($accounts != 'all' and $accounts != 'gmp')
{$where_accounts= " and cash_type='$accounts' ";}

if($accounts != 'all' and $accounts == 'gmp')
{$where_accounts= " and gmp='y' ";}
*/

//echo "tempid1=$tempid1";
$query2="select sum(cy) as 'cy_total',sum(py1) as 'py1_total',sum(py2) as 'py2_total',
sum(py3) as 'py3_total',sum(cy+py1+py2+py3) as 'user_total'
from report_user_activity2 
where tempid1='$tempid1'
group by tempid1 ; ";
//echo "query2=$query2";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//$num2=mysqli_num_rows($result2);
$cy_total=number_format($cy_total,0);
$py1_total=number_format($py1_total,0);
$py2_total=number_format($py2_total,0);
$py3_total=number_format($py3_total,0);
$user_total=number_format($user_total,0);

//echo "tempid1=$tempid1";
$query2a="select 
sum(cy) as 'cy_total_DPR',sum(py1) as 'py1_total_DPR',sum(py2) as 'py2_total_DPR',
sum(py3) as 'py3_total_DPR',sum(cy+py1+py2+py3) as 'dpr_total'
from report_user_activity2 
where 1 and tempid1 !='' ; ";
//echo "query2a=$query2a";
$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);
$cy_total_DPR=number_format($cy_total_DPR,0);
$py1_total_DPR=number_format($py1_total_DPR,0);
$py2_total_DPR=number_format($py2_total_DPR,0);
$py3_total_DPR=number_format($py3_total_DPR,0);
$dpr_total=number_format($dpr_total,0);

echo "<table border='1'>
      <tr><th>Total Usage since 8/8/2010</th></tr>
	  </table>
	  <table border='1'>
      <tr><th></th><th>1314</th><th>1213</th><th>1112</th><th>1011</th><th>Total</th></tr>
	  <tr><td>User</td><td>$cy_total</td><td>$py1_total</td><td>$py2_total</td><td>$py3_total</td><td>$user_total</td></tr>
	  <tr><td>DPR-All</td><td>$cy_total_DPR</td><td>$py1_total_DPR</td><td>$py2_total_DPR</td><td>$py3_total_DPR</td><td>$dpr_total</td></tr>
	  </table>";
echo "<br />";

$query3="select
         tempid1,user_level,time2,filename,count(id) as 'countid'
         FROM `report_user_activity` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'         
		 and tempid1='$tempid1'
		 and time2 >= '$range_start'
		 and time2 <= '$range_end'
         GROUP BY tempid,time2,filename
         ORDER BY `time2` DESC,countid DESC ";

/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
}
*/	

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$query4="select
         count(id) as 'countid_total'
         FROM `report_user_activity` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
         and tempid1='$tempid1'
		 and time2 >= '$range_start'
		 and time2 <= '$range_end'
		 ";        
/*		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query4";//exit;	
}
*/	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);



//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
echo "<table>";
echo "<tr><td><font color=brown class=cartRow>TempID:$tempid1</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>UserLevel:$user_level</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>FY1314 by Day</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>History:$history</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>Period:$period</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>Start_Date:$range_start</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>End_Date:$range_end</font></td></tr>";


echo "</table>";

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
echo "<th align=left><font color=brown>Rank</font></th>"; 
echo "<th align=left><font color=brown>Date</font></th>"; 
echo "<th align=left><font color=brown>FileName</font></th>"; 
echo "<th align=left><font color=brown>Hits</font></th>"; 
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$countid=number_format($countid,0);
$rank=$rank+1;



if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>$rank</td> 
           <td>$time2</td> 
		   <td><A href=$filename>$filename</A></td> 	
           <td>$countid</td> 
           
			  
			  
</tr>";

}
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$amount_total=number_format($amount_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
              
           	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	
           <td>$countid_total</td> 
          
			  
</tr>";

}

 


 echo "</table></html>";
 
 
 

?>





















	














