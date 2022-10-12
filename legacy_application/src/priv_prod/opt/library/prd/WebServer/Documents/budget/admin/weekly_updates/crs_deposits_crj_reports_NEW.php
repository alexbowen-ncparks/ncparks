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
if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "postitle=$posTitle";exit;


extract($_REQUEST);

//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


$table="crs_tdrr_history";

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

$deposit_id_GC=$deposit_id.'GiftCard';
//echo "deposit_id_GC=$deposit_id_GC<br />";
$query11="SELECT deposit_id, count( deposit_id ) as 'deposits'
FROM crs_tdrr_history
WHERE deposit_id LIKE '$deposit_id%'
GROUP BY deposit_id";
//echo "query11=$query11";
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
$deposits=mysqli_num_rows($result11);

echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
//include("../../../budget/menu1314.php");
//include("../../../budget/menu1314_no_header.php");
include ("test_style.php");

echo "</head>";

//include ("widget2.php");
//include("../../budget/menus2.php");
//include("widget1.php");
if($GC=='n'){$shade_deposit_id="class=cartRow";}
if($GC=='y'){$shade_deposit_id_GC="class=cartRow";}

if($GC=='n'){$GCN="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($GC=='y'){$GCY="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($GC=='n'){$budcode='14300';}else{$budcode='24309';}


if($deposits > '1')
{echo "<table><tr><th>Your Deposit included Gift Card Sales. 2 Cash Receipts Journals must be printed & submitted to Controllers Office. Please Contact DPR Budget Office with questions. Thanks</th></tr></table> ";}

include ("crj_header.php");
//echo "deposits=$deposits";
 {echo "<br />";  echo "<table><tr><th>
 <a href='/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y'>
 <img height='50' width='50' src='/budget/wake_tech/images/bank.jpg' alt='picture of bank'></img></a></th><th>Cash Receipts Journal- ORMS Deposit ID</th><td>$GCN <a href=crs_deposits_crj_reports_NEW.php?deposit_id=$deposit_id&GC=n><font $shade_deposit_id>$deposit_id</font></a></td>";
 if($deposits > 1){echo "<td>$GCY<a href=crs_deposits_crj_reports_NEW.php?deposit_id=$deposit_id&GC=y><font $shade_deposit_id_GC>$deposit_id_GC</font></a></td>";}
 "</tr></table>";}
 
 $deposit_id_GC='';
 
 if($GC=='y'){$deposit_id2=$deposit_id.'GiftCard';}
 if($GC=='n'){$deposit_id2=$deposit_id;}

 {$query12="SELECT crs_tdrr_division_history.center,center.parkcode,taxcenter,ncas_account,account_name,sum(amount) as 'amount'  from crs_tdrr_division_history
 left join center on crs_tdrr_division_history.center=center.center
 WHERE 1 and deposit_id='$deposit_id2'
 and deposit_transaction='y'
 group by center,ncas_account
 order by center,ncas_account";
 
//echo "query12=$query12";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);	
 
 
 $query_ck="SELECT count(payment_type) as 'ck_count'
            from crs_tdrr_division_history
            where deposit_id='$deposit_id2'
            and	payment_type='per chq' ";

$result_ck = mysqli_query($connection, $query_ck) or die ("Couldn't execute query ck.  $query_ck");

$row_ck=mysqli_fetch_array($result_ck);
extract($row_ck);//brings back number of records paid by check
echo "check count=$ck_count";
 
 
 
 $query13="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_division_history
			WHERE 1
			and deposit_id='$deposit_id2'
			and deposit_transaction='y'
			 ";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);
 
 
$query14="SELECT sum(amount) as 'total_debits' 
            from crs_tdrr_division_history
			WHERE 1
			and deposit_id='$deposit_id2'
			and amount < '0'
            and deposit_transaction='y' ";
			
 $result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);
 $row14=mysqli_fetch_array($result14);
 extract($row14);
 $total_debits=number_format($total_debits,2);
 
 $query15="SELECT sum(amount) as 'total_credits' 
            from crs_tdrr_division_history
			WHERE 1
			and deposit_id='$deposit_id2'
			and amount >= '0' 
			and deposit_transaction='y' ";
			
 $result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
 $num15=mysqli_num_rows($result15);
 $row15=mysqli_fetch_array($result15);
 extract($row15);
 $total_credits=number_format($total_credits,2); 
 
 
 
 
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
echo "<table border=1>";

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

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
$var_total_credit="";
$var_total_debit="";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	if($ncas_account=='000211940'){$center=$taxcenter;}
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
	$amount=number_format($amount,2);
	if($ncas_account=='000218110'){$center="2235";}
	if($ncas_account=='435900001'){$center="12802751";}
	if($ncas_account=='000200000'){$ncas_account="";}
	if($ncas_account=='000300000'){$ncas_account="";}
	if($center=='2235'){$company='1602';} else {$company='1601';}

	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
	if($sign=="debit"){$sto="<strong>(";$stc=")</strong>";}else{$sto="";$stc="";}
	if($amount != '0.00')
		{
		@$rank=$rank+1;

		echo 

		"<tr$t> 
					<td>$rank</td>
					<td>$parkcode</td>			
					<td>$company</td>
					<td>$ncas_account</td>
					<td>$center</td>
					<td>$sto $amount $stc</td>
					<td>$sto $sign $stc</td>
					<td>$account_name</td>
					<td></td>             
		   
		</tr>";


		}
	}

while ($row13=mysqli_fetch_array($result13)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row13);
$total_amount=number_format($total_amount,2);
if($total_amount < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
}
echo 

"<tr$t><form> 
            <td colspan='2'>Checks:<select name='checks_included'>
  <option value=''></option>
  <option value='yes'>YES</option>
  <option value='no'>NO</option>
  </select></td><td colspan='3'>Revenue Collection Period:<br /><input type='text' name='collection_period' value='' size='45'><br /><br /></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    
		   
           
</tr>";
$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);



echo "<tr><td colspan='2'>Prepared by:<br /><br />Approved by:<br /><br />Entered by</td><td colspan='3'><input type='text' name='entered_by' value='' size='20'>Phone#<input type='text' name='entered_by' value='' size='20'><br /><br />________________________Date:_______________<br /><br />________________________Date:______________</td></form><td>Total Debits</td><td>$var_total_debit</td></tr>";







echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";
//echo "<tr></tr><tr></tr><tr></tr>";
//echo "<tr></tr><tr></tr><tr></tr>";
echo 

"<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total Credits</td>
		   <td>$var_total_credit</td>
           
</tr>";
/*
echo "<tr></tr><tr></tr><tr></tr>";
echo 

"<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>$var_total_credit</td>
		    <td>Total Credits</td>
		   
           
</tr>";

*/




 echo "</table>";
 
//echo "Query12=$query12"; 
 
 }
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














