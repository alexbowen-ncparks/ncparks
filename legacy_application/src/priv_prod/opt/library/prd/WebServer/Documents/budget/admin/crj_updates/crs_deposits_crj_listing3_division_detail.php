<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
//echo $concession_location;
//echo "hello world";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


extract($_REQUEST);
$query1="SELECT min(transdate_new) as 'start_date',max(transdate_new) as 'end_date'
         from crs_tdrr_division_history
		 where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "start_date=$start_date<br />end_date=$end_date";
//echo "level=$level<br /><br />";

$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount',min(transdate_new) as 'trans_min',max(transdate_new) as 'trans_max',deposit_date_new as 'deposit_date',datediff('$header_message2_date',min(transdate_new)) as 'days_elapsed' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
and deposit_transaction='y' and deposit_id='none'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc,trans_min asc, deposit_id asc ";
//echo "query11=$query11<br /><br />";//exit;
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
$num11=mysqli_num_rows($result11);	
/*
$query11a="select deposit_id 
from crs_tdrr_division_history
where center='$concession_center'
and deposit_transaction='y'
and deposit_id='none'
group by center,deposit_id ";

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
$undeposit_count=mysqli_num_rows($result11a);
*/
//echo "undeposit_count=$undeposit_count<br /><br />";


/*
$query11="SELECT center.parkcode,crs_tdrr_division_history.center,batch_deposit_date,deposit_id,sum(amount) as 'amount' from crs_tdrr_division_history
left join center on crs_tdrr_division_history.center=center.center
WHERE 1
and crs_tdrr_division_history.center='$concession_center'
group by crs_tdrr_division_history.center,deposit_id
order by center.parkcode asc, deposit_id desc ";
*/
echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include("../../../budget/menu1314.php");

echo "<br />";
echo "<table border=1 align='center'>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>"; 
	   echo "<th align=left><font color=brown>Location</font></th>";
	   echo "<th align=left><font color=brown>Session#</font></th>";
	   
       echo "<th align=left><font color=brown>Opened by</font></th>";
       echo "<th align=left><font color=brown>Closed by</font></th>";
       echo "<th align=left><font color=brown>Session Total</font></th>";
       
	   //echo "<th align=left><font color=brown>Days<br />Undeposited</font></th>";
	   /*
 echo "<th align=left><font color=brown>Deposit Date</font></th>
	   <th align=left><font color=brown>ORMS <br />Deposit ID</font></th>";
       
      
 */      
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);

//$trans_min2=date('m-d-y', strtotime($trans_min));
//$trans_max2=date('m-d-y', strtotime($trans_max));

/*
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
*/



//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));


/*
if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}

$trans_min_dow=date('l',strtotime($trans_min));
$trans_max_dow=date('l',strtotime($trans_max));


if($amount >= 250){$amount_color='red';} else {$amount_color='green';}
if($days_elapsed >= 7){$days_color='red';} else {$days_color='green';}
*/

//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));

/*
$deposit_id2 = substr($deposit_id, 0, 8);
$deposit_idL8 = substr($deposit_id, -8, 8);
if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
*/

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   	<td>$parkcode</td>  
		    <td>$center</td>
		    
		    
		    
		    <td>$trans_min2<br />$trans_min_dow</td>";
		   // echo "<td>$trans_max2<br />$trans_max_dow</td>";
			echo "<td align='center'><b>$amount</b></td>
			";
			/*
echo " <td>$deposit_date2<br />$deposit_date_dow</td>";
			if($deposit_id=='none')
			{
			echo "<td><font color='red'>$deposit_id</font></td>";
			}
			else
			{
			echo "<td><a href='crs_deposits_crj_reports_NEW.php?deposit_id=$deposit_id2&GC=$GC' target='_blank'>$deposit_id</a></td>
		    <td>$amount</td>";				
			}
		   
*/		    
		                      
    
       
              
           
echo "</tr>";




}

 echo "</table>";
 
 //}
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














