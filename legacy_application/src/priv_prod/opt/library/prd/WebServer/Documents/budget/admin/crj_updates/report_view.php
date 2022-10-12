<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
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
//include("../../../budget/menu1314.php");
include("menu1314_cash_receipts.php");
include ("widget11.php");
include("report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
if($report_date==""){exit;}
include ("report_update3.php");

$query3="SELECT day1 as 'day1',day2 as 'day2',day3 as 'day3',day4 as 'day4',day5 as 'day5',day6 as 'day6',day7 as 'day7' from crj_report_dates where report_date='$report_date' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year
$day1_head=date('m-d', strtotime($day1));
$day2_head=date('m-d', strtotime($day2));
$day3_head=date('m-d', strtotime($day3));
$day4_head=date('m-d', strtotime($day4));
$day5_head=date('m-d', strtotime($day5));
$day6_head=date('m-d', strtotime($day6));
$day7_head=date('m-d', strtotime($day7));

$day1_dow=date('D', strtotime($day1));
$day2_dow=date('D', strtotime($day2));
$day3_dow=date('D', strtotime($day3));
$day4_dow=date('D', strtotime($day4));
$day5_dow=date('D', strtotime($day5));
$day6_dow=date('D', strtotime($day6));
$day7_dow=date('D', strtotime($day7));
//echo $day1_dow;exit;
/*
$query5="SELECT *
FROM crj_weekly3
where report_date='$report_date'
order by park; ";
*/
if($level<3)
{
$query5="select crj_centers.orms,crj_weekly3.park,crj_weekly3.center,crj_weekly3.report_date,crj_weekly3.day1,
crj_weekly3.day2,crj_weekly3.day3,crj_weekly3.day4,crj_weekly3.day5,crj_weekly3.day6,
crj_weekly3.day7,crj_weekly3.total,crj_comments.comments,crj_centers.email,crj_weekly3.ceid
from crj_weekly3
left join crj_centers on crj_weekly3.center=crj_centers.center
left join crj_comments on crj_weekly3.center=crj_comments.center
where crj_weekly3.report_date='$report_date'
and crj_centers.orms='y'
and crj_weekly3.center='$concession_center'
order by park";
//echo "query5=$query5";
}
else
{
$query5="select crj_centers.orms,crj_weekly3.park,crj_weekly3.center,crj_weekly3.report_date,crj_weekly3.day1,
crj_weekly3.day2,crj_weekly3.day3,crj_weekly3.day4,crj_weekly3.day5,crj_weekly3.day6,
crj_weekly3.day7,crj_weekly3.total,crj_comments.comments,crj_centers.email,crj_weekly3.ceid
from crj_weekly3
left join crj_centers on crj_weekly3.center=crj_centers.center
left join crj_comments on crj_weekly3.center=crj_comments.center
where crj_weekly3.report_date='$report_date'
and crj_centers.orms='y'
order by park";
//echo "query5=$query5";
}

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

if($level>3)
{
$query5a="SELECT sum(day1) as 'day1_tot',sum(day2) as 'day2_tot',sum(day3) as 'day3_tot',sum(day4) as 'day4_tot',sum(day5) as 'day5_tot',sum(day6) as 'day6_tot',sum(day7) as 'day7_tot',(sum(day1)+sum(day2)+sum(day3)+sum(day4)+sum(day5)+sum(day6)+sum(day7)) as 'Gtotal'
FROM crj_weekly3
where report_date='$report_date'; ";




$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");
}
//$row5a=mysqli_fetch_array($result5a);

//extract($row5a);


echo "<br />";
//if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}

echo "<table><tr><th>Count: $num5</th></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
      
  echo "<th align=left><font color=brown>Orms</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>$day1_head<br />$day1_dow</font></th>
       <th align=left><font color=brown>$day2_head<br />$day2_dow</font></th>
       <th align=left><font color=brown>$day3_head<br />$day3_dow</font></th>
       <th align=left><font color=brown>$day4_head<br />$day4_dow</font></th>
       <th align=left><font color=brown>$day5_head<br />$day5_dow</font></th>
       <th align=left><font color=brown>$day6_head<br />$day6_dow</font></th>
       <th align=left><font color=brown>$day7_head<br />$day7_dow</font></th>       
       <th align=left><font color=brown>Total</font></th>
       <th align=left><font color=brown>Comments</font></th>
       <th align=left><font color=brown>Email</font></th> 
       <th align=left><font color=brown>ceid</font></th>";  
       
              
echo "</tr>";










//echo  "<form method='post' autocomplete='off' action='report_view_update.php'>";
echo  "<form method='post' autocomplete='off'>";

while ($row=mysqli_fetch_array($result5)){


extract($row);
if($document_location != ""){$document="yes";} else {$document="";}
$cost=number_format($cost,2);

$day1=number_format($day1,2);
$day2=number_format($day2,2);
$day3=number_format($day3,2);
$day4=number_format($day4,2);
$day5=number_format($day5,2);
$day6=number_format($day6,2);
$day7=number_format($day7,2);
$total=number_format($total,2);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       
     echo "<td>$orms</td>
	       <td>$park</td>
           <td>$center</td>		   
           <td>$day1</td>		   
           <td>$day2</td>		   
           <td>$day3</td>		   
           <td>$day4</td>		   
           <td>$day5</td>
           <td>$day6</td>
           <td>$day7</td>
           <td>$total</td>";
	   echo "<td><textarea name='comments' cols='20' rows='6'>$comments</textarea></td>";
	   echo "<td><A HREF=\"mailto:$email?subject=ORMS Bank Deposits.&cc=tammy.dodd@ncparks.gov\">Email</A></td>";
	   
           
/*		   
     echo "<td><input type='text' size='10' name='perm_an[]' value='$perm_an'</td>	   
           <td><textarea name='comments[]' cols='15' rows='3'>$comments</textarea></td>";  
		   
		   */
 /*          
if($document=="yes"){
echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='fixed_assets_document_add.php?source_id=$id&report_date=$report_date'=>Reload</a></td>";}

if($document!="yes"){
echo "<td><a href='fixed_assets_document_add.php?source_id=$id&report_date=$report_date'>Upload</a></td>";} 
*/
		   
         		   
           echo "<td><input type='text' size='5' name='id[]' value='$ceid' readonly='readonly'</td>";
             
echo "</tr>";

}
while ($row5a=mysqli_fetch_array($result5a)){


extract($row5a);
$day1_tot=number_format($day1_tot,2);
$day2_tot=number_format($day2_tot,2);
$day3_tot=number_format($day3_tot,2);
$day4_tot=number_format($day4_tot,2);
$day5_tot=number_format($day5_tot,2);
$day6_tot=number_format($day6_tot,2);
$day7_tot=number_format($day7_tot,2);

echo 

"<tr$t>";

       
     echo "<td></td>
           <td></td>		   
           <td></td>		   
           <td>$day1_tot</td>		   
           <td>$day2_tot</td>		   
           <td>$day3_tot</td>		   
           <td>$day4_tot</td>		   
           <td>$day5_tot</td>
           <td>$day6_tot</td>
           <td>$day7_tot</td>
           <td>$Gtotal</td>
          
</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='num5' value='$num5'>";
echo   "</form>";
 echo "</table>";
 
 
 echo "</body></html>";


 






?>



















	














