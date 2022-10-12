<?php
//echo "VEHICLES.PHP";



session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));




extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category='ITS';
$project_name='wex_bill';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../../budget/menu1314.php");
include("wex_compliance_instructions.php");

echo "<br />";

include("fyear_head_wex_vehicles.php");// database connection parameters
echo "<br />";

include("fyear_months_head_wex_vehicles.php");// database connection parameters

//echo "hello line 12";
/*
$query10="update wex_vehicle_compliance,wex_report
          set wex_vehicle_compliance.rebate_amount=wex_report.rebate_adjust
		  where wex_vehicle_compliance.center=wex_report.center
		  and wex_vehicle_compliance.wex_month='$wex_month'
		  and wex_report.month='$wex_month'
		  and wex_vehicle_compliance.wex_fyear='$wex_fyear'
		  and wex_report.fyear='$wex_fyear'
		  and wex_vehicle_compliance.valid='y'
		  and wex_report.valid='y' ";

*/

/*
$query11=
"SELECT
wex_vehicle_compliance.park as 'parkcode',
wex_vehicle_compliance.center,
wex_vehicle_compliance.center_description,
wex_vehicle_compliance.wex_fyear,
wex_vehicle_compliance.wex_month,
wex_vehicle_compliance.wex_month_number,
wex_vehicle_compliance.wex_month_calyear,
wex_vehicle_compliance.cashier,
wex_vehicle_compliance.cashier_comment,
wex_vehicle_compliance.cashier_amount,
wex_vehicle_compliance.cashier_date,
wex_vehicle_compliance.manager,
wex_vehicle_compliance.manager_comment,
wex_vehicle_compliance.manager_date,
wex_vehicle_compliance.rebate_amount,
wex_vehicle_compliance.score,
wex_vehicle_compliance.valid,
wex_vehicle_compliance.id,
sum(wex_detail.net_cost) as 'net_cost'
from wex_vehicle_compliance
left join wex_detail on wex_vehicle_compliance.park=wex_detail.center_code
WHERE 1
and wex_vehicle_compliance.wex_fyear='$wex_fyear'
and wex_detail.wex_fyear='$wex_fyear'
and wex_vehicle_compliance.wex_month='$wex_month'
and wex_detail.month='$wex_month'
and wex_vehicle_compliance.valid='y'
and wex_detail.valid='y'
group by wex_vehicle_compliance.park
order by wex_vehicle_compliance.park asc
 ";
*/

$query11=
"SELECT
wex_vehicle_compliance.park as 'parkcode',
wex_vehicle_compliance.center,
wex_vehicle_compliance.center_description,
wex_vehicle_compliance.wex_fyear,
wex_vehicle_compliance.wex_month,
wex_vehicle_compliance.wex_month_number,
wex_vehicle_compliance.wex_month_calyear,
wex_vehicle_compliance.cashier,
wex_vehicle_compliance.cashier_comment,
wex_vehicle_compliance.cashier_amount,
wex_vehicle_compliance.cashier_date,
wex_vehicle_compliance.manager,
wex_vehicle_compliance.manager_comment,
wex_vehicle_compliance.manager_date,
sum(wex_report.amount) as 'net_cost',
sum(wex_report.rebate_adjust) as 'rebate_amount',
wex_vehicle_compliance.score,
wex_vehicle_compliance.valid,
wex_vehicle_compliance.id
from wex_vehicle_compliance
left join wex_report on wex_vehicle_compliance.park=wex_report.center_code 
WHERE 1
and wex_vehicle_compliance.wex_fyear='$wex_fyear'
and wex_report.fyear='$wex_fyear'
and wex_vehicle_compliance.wex_month='$wex_month'
and wex_report.month='$wex_month'
and wex_vehicle_compliance.valid='y'
and wex_report.valid='y'
group by wex_vehicle_compliance.park
order by wex_vehicle_compliance.park asc





 ";






echo "query11=$query11<br />";


$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/

echo "<br /><br />";
echo "<table align='center'><tr><th>Valid WEX Centers: <font color='red'>$num11</font></th></tr></table>";
echo "<br />";
echo "<table align='center'>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>       
       <th align=left><font color=brown>Month</font></th>
       <th align=left><font color=brown>NetofTax</font></th>
       <th align=left><font color=brown>Rebate<br />Amount</font></th>
       <th align=left><font color=brown>Billed<br />Amount</font></th>
       <th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>Manager</font></th>";
	  
	   echo "<th align=left><font color=brown>Score</font></th>";
	   echo "<th align=left><font color=brown>Comments</font></th>";
	
       
      
       
              
echo "</tr>";
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$refund_total=number_format($refund_total,2);
$billed_amount=$net_cost-$rebate_amount;
if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

/*
if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}

*/

$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
//$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));

if($manager3 != '' ){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>
		   	<td><a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear' title='$center_description'>$parkcode</a></td>  
		    <td>$center</td>
		    <td>$wex_month</td>
		    <td>$net_cost</td>
		    <td>$rebate_amount</td>
		    <td>$billed_amount</td>
		    <td>$cashier3</td>
		    <td>$manager3</td>";
		   
		    echo "<td>$score</td>";	
if($cashier_comment != '' or $manager_comment != ''){echo "<td><a href='wex_comment_view.php?wex_month_calyear=$wex_month_calyear&wex_month=$wex_month&parkcode=$parkcode&id=$id' target='_blank'>View</a></td>";}			

$total_net_cost+=$net_cost;
$total_rebate_amount+=$rebate_amount;
$total_billed_amount+=$billed_amount;

		   }

           
echo "</tr>";

echo "<tr>";
echo "<td></td><td></td><td>Totals</td>";
echo "<td>$total_net_cost</td>";
echo "<td>$total_rebate_amount</td><td>$total_billed_amount</td><td></td><td></td>";
echo "</tr>";



echo "</table>";




































?>