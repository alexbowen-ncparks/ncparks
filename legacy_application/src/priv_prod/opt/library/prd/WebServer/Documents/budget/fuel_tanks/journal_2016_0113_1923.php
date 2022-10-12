<?php

session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}


$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo "tempid=$tempid";
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//$crj_prepared_by=$_SESSION['budget']['acsName'];
if($concession_center== '12802953'){$concession_center='12802751' ;}
//if($tempid=='adams_s' and $concession_location='CRMO'){echo "Stacey Adams";}
//echo "concession_location=$concession_location";//exit;
//echo "postitle=$posTitle";exit;

	

extract($_REQUEST);

$deposit_id_first4 = substr($deposit_id, 0, 4);




//echo "approved_by=$approved_by";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


//$table="crs_tdrr_division_history_parks";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;





echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
//include("../../../budget/menu1314.php");
//include("../../../budget/menu1314_no_header.php");
include ("../../budget/menu1415_v1_style.php");
//include ("test_style.php");
echo "</head>";


//if($GC=='n'){$shade_deposit_id="class=cartRow";}
//if($GC=='y'){$shade_deposit_id_GC="class=cartRow";}




 $query12="select 
fuel_tank_usage.center,
fuel_tank_usage.park,
fuel_tank_usage.manager,
center.park_name as 'parkcode',
fuel_tank_usage.reimbursement_gallons,
fuel_tank_usage.reimbursement_rate,
sum(fuel_tank_usage.reimbursement_gallons*fuel_tank_usage.reimbursement_rate) as 'reimbursement_amount'
from fuel_tank_usage
left join center on fuel_tank_usage.center=center.new_center
where fyear='$fyear' and cash_month='$cash_month'
group by fuel_tank_usage.center;";

echo "query12=$query12<br />";

$result12 = mysql_query($query12) or die ("Couldn't execute query 12.  $query12 ");
$num12=mysql_num_rows($result12);

echo "num12=$num12<br />"; //exit;	

echo "<br />";
echo "<table border=1 align='center'>";

echo 

"<tr> 
       <th>Line#</th>
       <th>Park</th>
       <th>Company</th>
       <th>Account</th>
       <th>Center</th>
       <th>Amount</th>
       <th>Debit/Credit</th>
       <th>Line Description</th>
       <th>Acct Rule</th>
              
       
              
</tr>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
$var_total_credit="";
$var_total_debit="";
while ($row12=mysql_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	
if($reimbursement_amount != '0.00')
		{
		@$rank=$rank+1;
		echo 

		"<tr$t> 
					<td>$rank</td>
					<td>$parkcode</td>			
					<td>$company</td>
					<td>$ncas_account</td>
					<td>$center</td>
					<td>$reimbursement_amount</td>
					<td>CR</td>
					<td>$account_name</td>
					<td></td>             
		   
		</tr>";
      }

		}
	
	
$grand_total=$var_total_credit+$var_total_debit;

$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);
$grand_total=number_format($grand_total,2);



echo "</table>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














