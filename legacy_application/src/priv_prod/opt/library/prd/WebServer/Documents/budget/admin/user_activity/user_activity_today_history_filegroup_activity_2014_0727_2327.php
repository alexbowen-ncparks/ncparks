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
$today=date("Ymd", time() );
if($today_date == ''){$today_date=$today;}
$previous_date=date("Ymd",strtotime($today_date)- 60 * 60 * 24);
$next_date=date("Ymd",strtotime($today_date)+ 60 * 60 * 24);
//if($previous=='y'){$today_date=$today_date_previous;}
//if($next=='y'){$today_date=$today_date_next;}
/*
echo "today=$today<br />previous_date=$previous_date<br />next_date=$next_date<br />today_date=$today_date<br />";
*/
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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
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

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

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

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
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
//$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
//$row2=mysql_fetch_array($result2);
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


$query3="select
         tempid1,user_level,filegroup,count(filegroup) as 'filegroup_count'
         FROM `report_user_activity_today` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'         
		 and tempid='$tempid1'
		 and time2 = '$today_date'
		 GROUP BY tempid,filegroup
         ORDER BY `filegroup` ASC ";

 
	echo "$query3";//exit;	
	
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
$query4="select
         count(id) as 'countid_total'
         FROM `report_user_activity_today` 
         WHERE 1 AND user_browser != 'Trend Micro Web Protection Add-On 1.2.1029'
         and tempid='$tempid1'
		 and time2 = '$today_date'
		 ";        

	//echo "$query4";//exit;	

$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);

include("../../../budget/menu1314.php");

//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
echo "<table>";
echo "<tr><td><font color=brown class=cartRow>TempID:$tempid1</font></td></tr>";
echo "<tr><td><font color=brown class=cartRow>UserLevel:$user_level</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>History:$history</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>Period:$period</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>Start_Date:$range_start</font></td></tr>";
//echo "<tr><td><font color=brown class=cartRow>End_Date:$range_end</font></td></tr>";


echo "</table>";

/*
if($period=="fyear"){$query5="select * from fiscal_year where report_year='$f_year' ";}
if($period=="cyear"){$query5="select * from calendar_year where report_year='$calendar_year' ";}

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysql_fetch_array($result5);
extract($row5);

*/


echo "<table border=1>";

//$row=mysql_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Rank</font></th>"; 
echo "<th align=left><font color=brown>FileGroup</font></th>"; 
echo "<th align=left><font color=brown>Hits</font></th>"; 
echo "</tr>";


while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$countid=number_format($countid,0);
$rank=$rank+1;



if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>$rank</td> 
		   <td><A href=$filegroup>$filegroup</A></td> 	
           <td>$filegroup_count</td> 
           
			  
			  
</tr>";

}
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$amount_total=number_format($amount_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
              
           	
           <td></td> 	
           <td>Total</td> 	
           <td>$countid_total</td> 
          
			  
</tr>";

}

 


 echo "</table></html>";
 
 
 

?>





















	














