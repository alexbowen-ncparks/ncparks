<?php

session_start();

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
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


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

echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");

include ("test_style.php");

echo "</head>";

include ("widget2.php");

//include("widget1.php");



 
 {echo "<br />";  echo "<table><tr><th>Cash Receipts Journal- Deposit ID CC# $depositid_cc</th></tr></table>";}
 
 

 {
 /*
 $query12="SELECT center,parkcode,company_type,taxcenter,ncas_account,account_name,sum(amount) as 'amount' 
            from crs_tdrr_cc_all
			WHERE 1
			and depositid_cc='$depositid_cc'
			group by center,ncas_account
            order by center,rank";

*/

/*
$query12="SELECT crs_tdrr_cc_all.center, crs_tdrr_cc_all.parkcode, company_type, crs_tdrr_cc_all.taxcenter, ncas_account, account_name, center_taxes.tax_rate_total,center_taxes.county,SUM( amount ) AS  'amount'
FROM crs_tdrr_cc_all
LEFT JOIN center_taxes ON crs_tdrr_cc_all.parkcode = center_taxes.parkcode
WHERE 1 
AND depositid_cc =  '$depositid_cc'
GROUP BY crs_tdrr_cc_all.center, ncas_account
ORDER BY crs_tdrr_cc_all.center, rank";
*/

$query12="SELECT crs_tdrr_cc_all.center, crs_tdrr_cc_all.parkcode, company_type, crs_tdrr_cc_all.taxcenter, ncas_account, account_name, center_taxes.tax_rate_total, center_taxes.county, coa.taxable, SUM( amount ) AS  'amount'
FROM crs_tdrr_cc_all
LEFT JOIN center_taxes ON crs_tdrr_cc_all.parkcode = center_taxes.parkcode
LEFT JOIN coa ON crs_tdrr_cc_all.ncas_account = coa.ncasnum
WHERE 1 
AND depositid_cc =  '$depositid_cc'
GROUP BY crs_tdrr_cc_all.center, ncas_account
ORDER BY crs_tdrr_cc_all.center, rank";
			
echo "<br />query12=$query12<br />";
	
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);	
 
 
 $query13="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_cc_all
			WHERE 1
			and depositid_cc='$depositid_cc'
			 ";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);
 
 
$query14="SELECT sum(amount) as 'total_debits' 
            from crs_tdrr_cc_all
			WHERE 1
			and depositid_cc='$depositid_cc'
			and amount < '0' ";
			
 $result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);
 $row14=mysqli_fetch_array($result14);
 extract($row14);
 $total_debits=number_format($total_debits,2);
 
 $query15="SELECT sum(amount) as 'total_credits' 
            from crs_tdrr_cc_all
			WHERE 1
			and depositid_cc='$depositid_cc'
			and amount >= '0' ";
			
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
	//if($ncas_account=='000211940'){$center=$taxcenter;}
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
	if($ncas_account=='000200000'){$ncas_account="";}
	if($ncas_account=='000300000'){$ncas_account="";}
	if($ncas_account=='000211940'){$account_name='sales tax ('.$county.' county '.$tax_rate_total.' %)';}
	if($ncas_account!='000211940' and $ncas_account != '434140003' and $ncas_account != '434410004' and $taxable=='y'){$account_name='***'.$account_name;}
	if($ncas_account!='000211940' and $ncas_account == '434140003' and $taxable=='y'){$account_name='*****'.$account_name;}
	if($ncas_account!='000211940' and $ncas_account == '434410004' and $taxable=='y'){$account_name='*****'.$account_name;}
	//if($center=='2235'){$company='4602';} else {$company='4601';}

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
					<td>$company_type</td>
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

echo 

"<tr$t> 
            <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total</td>
		    <td>$total_amount</td>
		    <td>$sign</td>
		    <td>***All Sales are Taxable
			    <br />*****Only Diesel Fuel Sales are Taxable
				<br />*****Primitive Cabin Rentals are NOT Taxable</td>
		   
           
</tr>";







}
$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);
echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";
echo 

"<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>$var_total_debit</td>
		    <td>Total Debits</td>
		   
           
</tr>";

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






 echo "</table>";
 
//echo "Query12=$query12"; 
 
 }
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














