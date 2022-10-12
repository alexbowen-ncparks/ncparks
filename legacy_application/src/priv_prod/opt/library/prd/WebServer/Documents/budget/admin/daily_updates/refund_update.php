<?php

session_start();



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

/*
$upload_date=str_replace("-","",$upload_date);
$upload_date2=strtotime("$upload_date");
$upload_yesterday=($upload_date2-60*60*24);
$upload_dayb4yesterday=($upload_date2-60*60*24*2);

$upload_date2=date("Ymd", $upload_date2);
$upload_yesterday2=date("Ymd", $upload_yesterday);
$upload_dayb4yesterday2=date("Ymd", $upload_dayb4yesterday);



echo "upload_date2=$upload_date2<br />";
echo "upload_yesterday2=$upload_yesterday2<br />";
echo "upload_dayb4_yesterday2=$upload_dayb4yesterday2<br />";
*/
$todays_date=date("Ymd", time() );
//$today=$upload_date2;
//$yesterday=$upload_yesterday2;
//$dayb4yesterday=$upload_dayb4yesterday2;

//$yesterday='20150308';

//$dayb4yesterday='20150307';
//$dayb4yesterday='20150308';

/*
echo "upload_today=$upload_today<br />";
echo "upload_yesterday=$upload_yesterday<br />";
*/
/*
$end_date=str_replace("-","",$end_date);
$today=date("Ymd", time() );
$yesterday=date("Ymd", time() - 60 * 60 * 24);
$dayb4yesterday=date("Ymd", time() - 60 * 60 * 24*2);
*/
//$today='20140705';
//$yesterday='20140704';
//$dayb4yesterday='20140703';
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
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
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include("../../../budget/menu1314.php");
$query0="SELECT crs_tdrr_division_deposits.park, crs_tdrr_division_deposits.orms_deposit_id, crs_tdrr_division_deposits.center,crs_tdrr_division_history_parks.deposit_id, crs_tdrr_division_history_parks.ncas_account,crs_tdrr_division_history_parks.transdate_new, count( crs_tdrr_division_history_parks.ncas_account ) as 'count',
sum(crs_tdrr_division_history_parks.amount ) as 'amount'
FROM `crs_tdrr_division_deposits`
LEFT JOIN crs_tdrr_division_history_parks ON crs_tdrr_division_deposits.orms_deposit_id = crs_tdrr_division_history_parks.deposit_id
WHERE 1
AND crs_tdrr_division_deposits.trans_table = 'y'
AND crs_tdrr_division_deposits.download_date = '$todays_date'
and ncas_account='000300000'
GROUP BY crs_tdrr_division_deposits.park, crs_tdrr_division_deposits.orms_deposit_id, crs_tdrr_division_history_parks.ncas_account";
echo "query0=$query0<br />";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0 ");
$num_lines=mysqli_num_rows($result0);	


echo "<table border='1' align='center'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='brown'>park</font></th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
echo "<th align='left'><font color='brown'>orms_deposit_id</font></th>"; 
echo "<th align='left'><font color='brown'>deposit_id</font></th>"; 
echo "<th align='left'><font color='brown'>center</font></th>"; 
echo "<th align='left'><font color='brown'>ncas<br />account</font></th>"; 
echo "<th align='left'><font color='brown'>transdate</font></th>"; 
echo "<th align='left'><font color='brown'>count</font></th>"; 
echo "<th align='left'><font color='brown'>amount</font></th>"; 
echo "<th align='left'><font color='brown'>Move to Account#</font></th>"; 
echo "</tr>";

echo  "<form method='post' autocomplete='off' action='refund_update2.php'>";

while ($row0=mysqli_fetch_array($result0)){
extract($row0);
$amount_adj=-$amount;
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td>$park</td> 	
           <td>
		   <a href='cash_summary_detail.php?deposit_id=$orms_deposit_id&GC=n' target='_blank'>
		   $orms_deposit_id
		   </a>
		   </td> 		   
           <td>$deposit_id</td> 	
           <td><input type='text' name='center[]' value='$center' size='10' readonly='readonly' ></td> 	
           <td><input type='text' name='account_number[]' value='$ncas_account' size='10' readonly='readonly'></td>
		   <td><input type='text' name='transdate_new[]' value='$transdate_new' size='10' readonly='readonly'></td>
           <td>$count</td> 
           <td><input type='text' name='amount[]' value='$amount' readonly='readonly' size='10'></td>";
           

echo   "<td>
	   	   
	   <input type='hidden' name='orms_deposit_id[]' value='$orms_deposit_id'>	   
	   <input type='hidden' name='amount_adj[]' value='$amount_adj'>	   
	   <input type='text' name='account_number_adj[]' value='$account_number' size='10'>	   
	   </td>";	   
	  
			  
			  
echo "</tr>";

}

 echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='upload_date' value='$upload_date'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='num_lines' value='$num_lines'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='step_group' value='$step_group'>";
echo "<input type='hidden' name='step' value='$step'>";
echo "<input type='hidden' name='step_num' value='$step_num'>";
echo   "</form>";

 echo "</table>";

echo "</html>";


  

 ?>




















