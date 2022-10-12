<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

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
$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
//10-25-14
//include ("park_deposits_report_menu_v2.php");
//include ("park_deposits_report_menu_v3_division.php");
//include ("park_posted_deposits_widget1_v2.php");
//include ("park_posted_deposits_monthly_distmenu_v2.php");
//include ("park_posted_deposits_fyear_header.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//echo "<div align='center'>";
$today=date("Ymd");
//echo "today=$today<br />";
$unix_today=strtotime("$today");
//echo "unix_today=$unix_today<br />";

$unix_less7day=($unix_today-60*60*24*7);
$today_less7day=date("Ymd", $unix_less7day);
//echo "today_less7day=$today_less7day<br />";


$unix_less15day=($unix_today-60*60*24*15);
$today_less15day=date("Ymd", $unix_less15day);
//echo "today_less15day=$today_less15day<br />";


$unix_less30day=($unix_today-60*60*24*30);
$today_less30day=date("Ymd", $unix_less30day);
//echo "today_less30day=$today_less30day<br />";

//echo "</div>";




if($report_type == '')
{
if($days==''){$days='7';}

if($days=='7')
{
$query5="SELECT position_report_users.report_id, position_report.report_name, downloaded, COUNT( id ) as 'count' 
FROM  `position_report_users` 
LEFT JOIN position_report ON position_report_users.report_id = position_report.report_id
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less7day'
and download_date <= '$today'
GROUP BY report_id
ORDER BY report_name ASC ";

//echo "query5=$query5<br />";
}


if($days=='15')
{
$query5="SELECT position_report_users.report_id, position_report.report_name, downloaded, COUNT( id ) as 'count' 
FROM  `position_report_users` 
LEFT JOIN position_report ON position_report_users.report_id = position_report.report_id
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less15day'
and download_date <= '$today'
GROUP BY report_id
ORDER BY report_name ASC ";

//echo "query5=$query5<br />";
}


if($days=='30')
{
$query5="SELECT position_report_users.report_id, position_report.report_name, downloaded, COUNT( id ) as 'count' 
FROM  `position_report_users` 
LEFT JOIN position_report ON position_report_users.report_id = position_report.report_id
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less30day'
and download_date <= '$today'
GROUP BY report_id
ORDER BY report_name ASC ";

//echo "query5=$query5<br />";
}


if($days=='all')
{
$query5="SELECT position_report_users.report_id, position_report.report_name, downloaded, COUNT( id ) as 'count' 
FROM  `position_report_users` 
LEFT JOIN position_report ON position_report_users.report_id = position_report.report_id
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
GROUP BY report_id
ORDER BY report_name ASC ";

//echo "query5=$query5<br />";
}



//echo "query5=$query5<br />";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);




if($days=='7')
{
$query5_total="SELECT count(id) as 'total_downloads' 
FROM  `position_report_users` 
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less7day'
and download_date <= '$today'
";
}


if($days=='15')
{
$query5_total="SELECT count(id) as 'total_downloads' 
FROM  `position_report_users` 
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less15day'
and download_date <= '$today'
";
}


if($days=='30')
{
$query5_total="SELECT count(id) as 'total_downloads' 
FROM  `position_report_users` 
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$today_less30day'
and download_date <= '$today'
";
}



if($days=='all')
{
$query5_total="SELECT count(id) as 'total_downloads' 
FROM  `position_report_users` 
WHERE 1 
AND downloaded =  'y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
";
}



$result5_total = mysqli_query($connection, $query5_total) or die ("Couldn't execute query 5 total.  $query5_total");

$row5_total=mysqli_fetch_array($result5_total);
extract($row5_total);
//echo "query5_total=$query5_total<br />";
if($days=='7'){$check7="<br /><img  height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png'></img>";}
if($days=='15'){$check15="<br /><img  height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png'></img>";}
if($days=='30'){$check30="<br /><img  height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png'></img>";}
if($days=='all'){$checkall="<br /><img  height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png'></img>";}

echo "<br />";
echo "<table align='center' border='1' cellspacing='10'><tr><th><a href='myreports.php?days=7'>7 day</a>$check7</th><th><a href='myreports.php?days=15'>15 day</a>$check15</th><th><a href='myreports.php?days=30'>30 day</a>$check30</th><th><a href='myreports.php?days=all'>all</a>$checkall</th></tr></table>";
echo "<br />";
echo "<table align='center'><tr><th>Total Downloads: $total_downloads</th></tr></table>";

echo "<br />";


echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>report_id</font></th>";
  echo "<th align=left><font color=brown>report</font></th>";
  echo "<th align=left><font color=brown>downloads</font></th>";
  //echo "<th align=left><font color=brown>count</font></th> ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);





//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
     //echo "<td>$report_id</td>";
     echo "<td align='left'>$report_name (#$report_id)</td>";		   
     //echo "<td>$downloaded</td>";		   
     echo "<td>$count<a href='myreports.php?days=$days&report_id=$report_id&report_type=2'>&nbsp;&nbsp;&nbsp;<img height='20' width='20' src='/budget/infotrack/icon_photos/magnify.png'></a></td>";
          	   
          
          
                    
      
           
              
           
echo "</tr>";




}


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
}
if($report_type == '2')
{

if($days=='7'){$start_date=$today_less7day;}
if($days=='15'){$start_date=$today_less15day;}
if($days=='30'){$start_date=$today_less30day;}
if($days=='all'){$start_date='';}

//echo "<table align='center'><tr><td>MyReports Report 2 here</td></tr></table><br />";

if($start_date == '')
{
$query_report2="select position_report_users.report_id,position_report.report_name,position_report_users.center_code,position_report_users.tempid,position_report_users.download_date
from position_report_users
left join position_report on position_report_users.report_id=position_report.report_id
where position_report_users.report_id='$report_id'
and position_report_users.downloaded='y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
order by center_code,tempid				";
}
else
{
$query_report2="select position_report_users.report_id,position_report.report_name,position_report_users.center_code,position_report_users.tempid,position_report_users.download_date
from position_report_users
left join position_report on position_report_users.report_id=position_report.report_id
where position_report_users.report_id='$report_id'
and position_report_users.downloaded='y'
AND beacnum !=  '60032793'
AND beacnum !=  '60032781'
and download_date >= '$start_date'
order by center_code,tempid ";


}				
				
//echo "query_report2=$query_report2<br />";	//exit;

$result_report2 = mysqli_query($connection, $query_report2) or die ("Couldn't execute query report2.  $query_report2");
//$num_players=mysqli_num_rows($result_report2);
echo "<br /><br />";
echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>report_id</font></th>";
  echo "<th align=left><font color=brown>report</font></th>";
  echo "<th align=left><font color=brown>center_code</font></th>";
  echo "<th align=left><font color=brown>tempid</font></th>";
  echo "<th align=left><font color=brown>download_date</font></th>";
  //echo "<th align=left><font color=brown>count</font></th> ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row_report2=mysqli_fetch_array($result_report2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row_report2);





//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
     //echo "<td>$report_id</td>";
     echo "<td align='left'>$report_name (#$report_id)</td>";		   
     //echo "<td>$downloaded</td>";		   
     echo "<td>$center_code</td>";
     echo "<td>$tempid</td>";
     echo "<td>$download_date</td>";
          	   
          
          
                    
      
           
              
           
echo "</tr>";




}


 echo "</table>";

			
}
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














