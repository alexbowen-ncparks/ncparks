<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

//include("../../../budget/menu1314.php");
include ("../../../budget/menu1415_v1.php");
//include("menu1314_cash_receipts.php");
//include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
echo "<br />";

//include ("park_deposits_report_menu_v3.php");

// (60036015 Accounting Clerk  Rod Bridges)   (60032781 Budget Officer Tammy Dodd)   (60096024 Seasonal Maria Cucurullo) 
// (60032997 Accounting Clerk Rachel Gooding)
// (60033242 Budget Office Rebecca Owen)


include ("park_deposits_report_menu_v3_division.php");

$query1="SELECT max(effect_date) as 'effective_date' from cash_summary where 1 ";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

//$effective_date='20201112';

echo "<table border='1' cellspacing='5' align='center'>";
echo "<tr><th>parkcode</th><th>Undeposited<br >Amount</th><th>Collection Period</th></tr>";

$query = "SELECT center.parkcode, cash_summary.center, sum( end_bal ) AS 'amount', undeposited_transdate_min AS 'trans_min', undeposited_transdate_max AS 'trans_max', days_elapsed2 AS 'days_elapsed',compliance,exceptions,justified
         FROM cash_summary LEFT JOIN center ON cash_summary.center = center.center WHERE 1 AND effect_date = '$effective_date' GROUP BY cash_summary.center ORDER BY center.parkcode ASC";

echo "<br />Line 75: query=$query<br />";
//exit;

$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query ");
$num=mysqli_num_rows($result);		




while($row = mysqli_fetch_array($result)){
extract($row);

$amount2=number_format($amount,2);

if($trans_max=='0000-00-00'){$trans_max=$trans_min;}
$collection_period=$trans_min.' thru '.$trans_max;

if($table_bg2==''){$table_bg2='cornsilk';}
    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr$t>";

echo "<td align='center'>$parkcode</td>";
echo "<td align='center'><a href='crs_tdrr_undeposited_detail.php?parkcode=$parkcode&center=$center' target='_blank'>$amount2</a></td>";
echo "<td align='center'>$collection_period</td>";



echo "</tr>";
	}// end while
	
	

echo "</table>";


echo "</html>";

?>