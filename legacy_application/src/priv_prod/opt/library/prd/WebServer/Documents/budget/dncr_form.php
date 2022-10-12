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
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


//$table="crs_tdrr_division_history_parks";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

//$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");
//$row10=mysqli_fetch_array($result10);

$result10=mysqli_query($connection,$query10) or die ("Couldn't execute query 10. $query10");
$row10=mysqli_fetch_array($result10);
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
include ("../../budget/menu1415_v1_new_style.php");
//include ("test_style.php");
echo "</head>";


//if($GC=='n'){$shade_deposit_id="class=cartRow";}
//if($GC=='y'){$shade_deposit_id_GC="class=cartRow";}



/*
 $query12="select * from service_contracts_invoices where id='$id' ";

//echo "query12=$query12<br />";

$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
$num12=mysqli_num_rows($result12);
*/

//echo "num12=$num12<br />"; //exit;	
include("journal_header_form.php");
echo "<br />";
echo "<table border=1 align='center'>";
/*
echo 

"<tr> 
       <th>Invoice Number</th>
       <th>Invoice<br />Date</th>
       <th>Company</th>
       <th>Account<br />
	   (Account must match<br />account on P.O.)</th>
       <th>1099<br />code</th>
       <th>Center<br />(Center must match Center on P.O.)</th>
       <th>Total</th>
      
              
       
              
</tr>";
*/

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
//$var_total_credit="";
//$var_total_debit="";

//$var_total_refund="";

//while ($row12=mysqli_fetch_array($result12))
//	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
//	extract($row12);
/*
$reimbursement_amount=number_format($reimbursement_amount,2);
$admin_fee=number_format($admin_fee,2);
$total_refund=$reimbursement_amount+$admin_fee;
$total_refund2=number_format($total_refund,2);
*/
//$var_total_refund+=$total_refund;
$ending_balance=$line_num_beg_bal-$previous_amount_paid-$invoice_amount;
$ending_balance2=number_format($ending_balance,2);
$available_before_invoice=$line_num_beg_bal-$previous_amount_paid;
$available_before_invoice2=number_format($available_before_invoice,2);
$invoice_amount2=number_format($invoice_amount,2);
$previous_amount_paid2=number_format($previous_amount_paid,2);
$cummulative_amount_paid2=number_format($cummulative_amount_paid,2);
$line_num_beg_bal2=number_format($line_num_beg_bal,2);

$invoice_date2=date('m/d/y', strtotime($invoice_date));

if($invoice_date=='0000-00-00')
{$invoice_date2='unknown';}
else
$invoice_date2=date('m/d/y', strtotime($invoice_date));





if($manager_date=='0000-00-00')
{$manager_date2='';}
else
$manager_date2=date('m/d/y', strtotime($manager_date));


if($puof_date=='0000-00-00')
{$puof_date2='';}
else
$puof_date2=date('m/d/y', strtotime($puof_date));

//echo "table_bg2=$table_bg2<br />";




//$ncas_account='533310';
//$company='4601';
//$line_description='MFM Gas '.$cash_month_year;   //$cash_month_year comes from include file: journal_header.php
/*	
if($reimbursement_amount != '0.00')
		{
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}		
		
		@$rank=$rank+1;
		
*/		
/*
		echo 

		"<tr bgcolor='cornsilk'> 
					
					<td>$invoice_num</td>			
					<td>$invoice_date2</td>			
					<td>$company</td>
					<td>$ncas_account</td>
					<td></td>
					<td>$center</td>
					<td>$invoice_amount2</td>
					            
		   
		</tr>";
		*/
		
  //    }
//$var_total_refund+=$total_refund;
//		}
//$var_total_refund2=number_format($var_total_refund,2);

/*
echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Grand Total</td><td>$invoice_amount2</td></tr>";	
*/
	
//$grand_total=$var_total_credit+$var_total_debit;

//$var_total_credit=number_format($var_total_credit,2);
//$var_total_debit=number_format($var_total_debit,2);
//$grand_total=number_format($grand_total,2);

echo "</table>";
echo "<br />";
/*
echo "<table border=0 align='center'>";
echo "<tr><td></td><td></td><td></td><td></td><t d></td><td></td><td></td><td>JUSTIFICATION:</td><td><u>$line_description</u></td><td></td><td></td><td></td><td></td><td>Prepared by:   <u>Heide Rumble</u></td><td>Date:____________</td></tr>";

echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td><td>Approved by:   <u>Tammy Dodd</u></td><td>Date:____________</td></tr>";


echo "</table>";
*/
/*
echo "<table border=0 align='center'>";
echo "<tr><td>Contract Recap for Line#</td><td><u>&nbsp;&nbsp&nbsp&nbsp&nbsp;1</u></td><td></td><td></td><td></td><td></td><td>Contract Administrator:   <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ron Anundson</u></td><td>Date:____________</td></tr>";
echo "<tr><td>&nbsp&nbsp&nbsp;Beginning Balance for Line</td><td><u>&nbsp;&nbsp&nbsp&nbsp&nbsp;1</u></td><td></td><td></td><td></td><td></td><td>&nbsp&nbsp&nbsp;&nbsp;&nbsp;Division Purchasing Officer:   <u>JoAnne Hunt</u></td><td>Date:____________</td></tr>";
echo "<tr><td>Total YTD Payments Line</td><td><u>&nbsp;&nbsp&nbsp&nbsp&nbsp;1</u></td><td></td><td></td><td></td><td></td><td>Division Fiscal Officer:   <u>Tammy Dodd</u></td><td>Date:____________</td></tr>";
*/
include("approver_credentials_1a.php");

include ("signature_name_lookup.php");
//echo "Line 215: puof_name=$puof_name<br />";

echo "<table border=1 align='center'>";
/*
echo "<tr>";

echo "<td>";
echo "Beginning Balance for Line# $line_num";
echo "</td>";

echo "<td>";
echo "$line_num_beg_bal2";
echo "</td>";

echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Previous Payments";
echo "</td>";
echo "<td>";
//echo "$722.00";
echo "$previous_amount_paid2";
echo "</td>";
echo "</tr>";
*/
echo "<tr>";
echo "<th>";
echo "Current Invoice# $invoice_num";
echo "<br />date: $invoice_date2 <a href='$document_location' target='_blank'>VIEW</a>";
echo "</th>";
echo "<th>";
//echo "$722.00";
echo "$invoice_amount2";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Ending Balance for Line# $line_num";
echo "</td>";
echo "<td>";
//echo "$3,872.00";
echo "$ending_balance2";
echo "</td>";
echo "</tr>";
echo "</table>";
//echo "</td>";
//Left Side Table Ends
// extra spaces between 2 Tables
//echo "<td></td><td></td><td></td><td></td><td></td>";
//Right Side Table Begins
echo "<br />";
echo "<table align='center' border='1'>";
//echo "<tr>";
if($cashier_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
echo "<tr>";
echo "<form method='post' action='dncr_form_update.php'>";
echo "<td>";
echo "<font color='brown'>";
echo "Cashier";
echo "</font>";
echo "</td>";
echo "<td>";
//echo "Karen Ake Checkbox";
echo "<font color='brown'>";
echo "$signature_name</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y'>";
echo "</font>";
echo "</td>";
echo "<td>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='role' value='cashier'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</tr>";
}

if($manager_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
echo "<tr>";
echo "<form method='post' action='dncr_form_update.php'>";
echo "<td>";
echo "<font color='brown'>";
echo "Manager";
echo "</font>";
echo "</td>";
echo "<td>";
//echo "Karen Ake Checkbox";
echo "<font color='brown'>";
echo "$signature_name</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
echo "</font>";
echo "</td>";
echo "<td>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='role' value='manager'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</tr>";
}


/*
if($puof_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
//echo "<tr>";
echo "<td>";
echo "PUOF";
echo "</td>";
echo "<td>";
echo "JoAnne Hunt Checkbox";
echo "</td>";
}
*/


if($puof_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
echo "<tr>";
echo "<form method='post' action='dncr_form_update.php'>";
echo "<td>";
echo "<font color='brown'>";
echo "Purchasing Officer";
echo "</font>";
echo "</td>";
echo "<td>";
//echo "Karen Ake Checkbox";
echo "<font color='brown'>";
echo "$signature_name</th><td>Approved:<input type='checkbox' name='puof_approved' value='y'>";
echo "</font>";
echo "</td>";
echo "<td>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='role' value='puof'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</tr>";
}

/*
if($buof_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
//echo "<tr>";
echo "<td>";
echo "BUOF";
echo "</td>";
echo "<td>";
echo "Tammy Dodd Checkbox";
echo "</td>";
}

*/


if($buof_count==1) 
{
//echo "<td>";
//echo "<table border='1'>";
echo "<tr>";
echo "<form method='post' action='dncr_form_update.php'>";
echo "<td>";
echo "<font color='brown'>";
echo "Budget Officer";
echo "</font>";
echo "</td>";
echo "<td>";
//echo "Karen Ake Checkbox";
echo "<font color='brown'>";
echo "$signature_name</th><td>Approved:<input type='checkbox' name='buof_approved' value='y'>";
echo "</font>";
echo "</td>";
echo "<td>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='role' value='buof'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";
echo "</tr>";
}























//echo "</tr>";
echo "</table>";
//echo "</td>";

/*
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";




echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
echo "</table>";
echo "</form>";
*/









echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//echo "</html>";


?>