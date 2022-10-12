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
//echo "concession_center=$concession_center";exit;
//echo "postitle=$posTitle";exit;
$crj_prepared_by=@$_SESSION['budget']['acsName'];
if(!$crj_prepared_by)
	{
	$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
	//$_SESSION['budget']['acsName']=$userName;
	}

extract($_REQUEST);

//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

if($tempid=='Kalish1629')
{
$approved_by_user=$tempid;
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	//$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname as Nname_approver,Fname as Fname_approver,Lname as Lname_approver From empinfo where tempID='$approved_by_user'";
	//echo "sql=$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname_approver){$Fname_approver=$Nname_approver;}
	$approved_by=$Fname_approver." ".$Lname_approver;
}
//echo "approved_by=$approved_by";
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


$deposit_id_GC='';
 
 if($GC=='y'){$deposit_id2=$deposit_id.'GiftCard';}
 if($GC=='n'){$deposit_id2=$deposit_id;}


$query12a="SELECT max(deposit_date_new) as 'deposit_date_new_header'
 from crs_tdrr_division_history
 WHERE 1 and deposit_id='$deposit_id2'
 and deposit_transaction='y'
 ";
 
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");

$row12a=mysqli_fetch_array($result12a);
extract($row12a);//brings back number of records paid by check
//echo "check count=$ck_count";
$deposit_date_new_header2=date('m-d-y', strtotime($deposit_date_new_header));






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
//echo "check count=$ck_count";
if($ck_count > 0){$check='yes';} else {$check='no';}


$query12b="SELECT min(transdate_new) as 'mindate_footer',max(transdate_new) as 'maxdate_footer'
 from crs_tdrr_division_history
 WHERE 1 and deposit_id='$deposit_id2'
 and deposit_transaction='y'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check
//echo "check count=$ck_count";
$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;

 
 
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
	
$grand_total=$var_total_credit+$var_total_debit;

$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);
$grand_total=number_format($grand_total,2);



while ($row13=mysqli_fetch_array($result13)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row13);
//2 lines below commented out on 2/8/14 TBASS
//$total_amount=number_format($total_amount,2);
//if($total_amount < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
}
/*
echo "<tr$t><form> 
            <td colspan='2'>Checks:<select name='checks_included'>
  <option value=''></option>
  <option value='yes'>YES</option>
  <option value='no'>NO</option>
  </select></td><td colspan='3'>Revenue Collection Period:<br /><input type='text' name='collection_period' value='' size='45'><br /><br /></td>
		    <td></td>
		    <td></td>
		    <td></td>          
</tr>";
*/
if($check=='yes'){$yes_selected=' selected';}else{$no_selected=' selected';}
echo "<tr$t><form>";
echo "<td colspan='2'><font color='red'>Checks:</font><select name='checks_included'>
  <option value=''></option>
  <option value='yes' $yes_selected>YES</option>
  <option value='no' $no_selected>NO</option>
  </select></td>";
  
 echo "<td colspan='3'><font color='red'>Revenue Collection Period:</font><br /><input type='text' name='collection_period' value='$revenue_collection_period' size='45'><br /><br /></td>
		    <td>Total Debits<br />Total Credits<br /><br />Grand Total</td>
		    <td>$var_total_debit<br />$var_total_credit<br /><br />$grand_total</td>
		    <td></td>          
</tr>";



$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);


/*
echo "<tr><td colspan='2'><font color='red'>Prepared by:</font><br /><br />Approved by:<br /><br />Entered by</td><td colspan='3'><input type='text' name='entered_by' value='$crj_prepared_by' size='20'><font color='red'>Phone#</font><input type='text' name='entered_by' value='$phone' size='15'><br /><br /><input type='text' name='approved_by' value='$approved_by' size='20'>Date:<input type='text' name='approved_date' value='$deposit_date_new_header2' size='15'><br /><br /><input type='text' name='entered_by' value='' size='20' readonly='readonly'>Date:______________</td></form>";
*/

echo "<tr><td colspan='2'><font color='red'>Prepared by:</font><br /><br />Approved by:<br /><br />Entered by</td><td colspan='3'><input type='text' name='entered_by' value='$crj_prepared_by' size='20'><font color='red'>Phone#</font><input type='text' name='entered_by' value='$phone' size='15'><br /><br /><input type='text' name='approved_by' value='' size='20'>Date:<input type='text' name='approved_date' value='' size='15'><br /><br /><input type='text' name='entered_by' value='' size='20' readonly='readonly'>Date:______________</td></form>";



//echo "<td>Total Debits</td><td>$var_total_debit</td></tr>";






/*
echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";

*/
//echo "<tr></tr><tr></tr><tr></tr>";
//echo "<tr></tr><tr></tr><tr></tr>";
/*
echo "<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total Credits</td>
		   <td>$var_total_credit</td>
           
</tr>";
*/
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
 /*
 echo "<table>
 <tr><td>";
 echo "<img height='1000' width='1000' src='/budget/admin/crj_updates/documents_bank_deposits/bank_deposit_slip.png'></img>";
 echo "</td>";
 echo "</tr>";
 echo "</table>";
*/
//echo "Query12=$query12"; 
 
 }
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














