<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//Enable North District OA Cara Hadfield to approved cash receipt journals for N. District
//$beacnum 60033148=cara hadfield position

//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);

//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;
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
$table="bank_deposits_menu";

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
//include ("test_style_deposit_form.php");
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "</head>";

include("../../../budget/menu1314.php");
include("1418.html");
//include("menu1314_cash_receipts.php");
//include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");
//cara hadfield or sherry quinn or adrian oneal or julie bunn
if($beacnum=='60033148' or $beacnum=='60032892' or $beacnum=='60032912' or $beacnum=='60032931' or $beacnum=='60033093')
{
$query1="SELECT park,center from crs_tdrr_division_deposits
         where orms_deposit_id='$deposit_id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$concession_location=$park;
$concession_center=$center;

//echo "query1=$query1";

}
//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


$query1="SELECT park FROM crs_tdrr_division_deposits where orms_deposit_id='$deposit_id'";
//echo "query1=$query1<br />";//exit;
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);


//echo "park=$park<br />";//exit;

/*
$query2="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$park'";
*/

$query2="select controllers_deposit_id  FROM crs_tdrr_division_deposits
         where orms_deposit_id='$deposit_id'";

//echo "query2=$query2<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);


//$controllers_next=$controllers_max+1;



//echo "controllers_next=$controllers_next<br />";

$query3="SELECT sum(amount) as 'cash_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
         and payment_type='cash'
         and ncas_account != '000437995'		 ";
//echo "query3=$query3<br />";//exit;
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);
if($cash_total==''){$cash_total='0';}
//echo "cash_total=$cash_total<br />";


$query4="SELECT sum(amount) as 'check_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and payment_type='per chq' ";
//echo "query4=$query4<br />";//exit;
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
if($check_total==''){$check_total='0';}
//echo "check_total=$check_total<br />";

$query5="SELECT sum(amount) as 'money_order_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and (payment_type='mon ord' or payment_type='cert chq' or payment_type='trav chk') ";
//echo "query5=$query5<br />";//exit;
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
if($money_order_total==''){$money_order_total='0';}
//echo "money_order_total=$money_order_total<br />";


$query6="SELECT sum(amount) as 'over_short_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and ncas_account='000437995' ";
//echo "query6=$query6<br />";//exit;
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysqli_fetch_array($result6);
extract($row6);
if($over_short_total==''){$over_short_total='0';}
//echo "over_short_total=$over_short_total<br />";

$bank_deposit_total=$cash_total+$check_total+$money_order_total+$over_short_total;

$bank_deposit_total=number_format($bank_deposit_total,2);

$query12="SELECT crs_tdrr_division_history_parks.center,center.parkcode,taxcenter,ncas_account,account_name,sum(amount) as 'amount'  from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.center=center.center
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 group by center,ncas_account
 order by center,ncas_account";
 
//echo "query12=$query12";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);
 
 



echo "<table border=1>";

//echo "<tr>"; 
//echo "<th>Line#</th>";
//echo "<th>Park</th>";
//echo "<th>Company</th>";
//echo "<th>Account</th>";
//echo "<th>Center</th>";

//echo "<th>Debit/Credit</th>";
//echo "<th>Line Description</th>";
//echo "<th>Amount</th>";
//echo "<th>Acct Rule</th>";             
//echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
//$var_total_credit="";
//$var_total_debit="";
echo "<tr><th colspan='2'>ORMS Deposit $deposit_id</th></tr>";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	if($ncas_account=='435900001'){$account_name='CRS Transaction Fees';}
	if($ncas_account=='000211940'){$center=$taxcenter;}
	if($ncas_account=='000211940'){$account_name='sales tax';}
	/*
	if($amount < '0')
		{
		$var_total_debit+=$amount;
		$sign="debit";
		}
		else
		{
		$var_total_credit+=$amount;
		$sign="credit";
		}
		*/
	$amount=number_format($amount,2);
	if($ncas_account=='000218110'){$center="2235";}
	if($ncas_account=='435900001'){$center="12802751";}
	if($ncas_account=='000200000'){$ncas_account="";}
	if($ncas_account=='000300000'){$ncas_account="";}
	if($center=='2235'){$company='1602';} else {$company='1601';}

	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
	$t=" bgcolor='lightcyan'";
	if($sign=="debit"){$sto="<strong>(";$stc=")</strong>";}else{$sto="";$stc="";}
	if($amount != '0.00')
		{
		@$rank=$rank+1;

		echo "<tr$t>"; 
		//echo "<td>$rank</td>";
		//echo "<td>$parkcode</td>";			
		//echo "<td>$company</td>";
		//echo "<td>$ncas_account</td>";
		//echo "<td>$center</td>";
		
		//echo "<td>$sto $sign $stc</td>";
		echo "<td>$account_name<br />$ncas_account</td>";
		echo "<td>$sto $amount $stc</td>";
		//echo "<td></td>";	   
		echo "</tr>";


		}
		
	}
//echo "<tr><td><font color='blue'>ORMS ID $deposit_id</font><br /><font color='red'>";
echo "<tr bgcolor='cornsilk'><td><font color='blue'>Deposit Amount</font><br /><font color='red'>";

//if($controllers_deposit_id)
//{echo "Deposit# $controllers_deposit_id";}
echo"</td><td><font color='blue'>$bank_deposit_total</td></font></tr>";	
echo "</table>";

echo "</body>";
echo "</html>";



?>