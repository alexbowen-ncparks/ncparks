<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>";
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


$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../budget/menu1314.php");

include ("../../budget/menu1415_v1.php");

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


$query2a="select count(id) as 'unapproved_count' from service_contracts_invoices where scid='$id' and park_approved='n'  ";	

echo "query2s=$query2a<br />";//exit;		  

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
		  
$row2a=mysqli_fetch_array($result2a);

extract($row2a);



//echo "invoice_count=$invoice_count<br />"; exit;



/*
echo "<table align='center'>";
echo "<tr>";




echo "</tr>";
echo "</table>";

*/


//echo "<html>";




if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";


/*
echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>Service Contract<br />Invoices</font></th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Payment Form</a><br />$report_form</th><th><a href='payment_history.php?fyear=$fyear&report_type=reports&id=$id'>Payment History</a><br />$report_reports </th></tr></table>";
*/
/*
echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>Service Contract<br />Invoices</font></th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Current Invoice</a><br />$report_form</th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>All Invoices</a><br />$report_reports </th></tr></table>";
*/

echo "<br /><table border='1' align='center'><tr><th><a href='/budget/service_contracts/service_contracts.php'><img height='75' width='75' src='dumpster1.jpg' alt='picture of fuel tank'></img></a><font color='brown'><b>Service Contract Invoices</font></th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>ALL</a><br />$report_reports </th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>NEW</a><br />$report_form</th></tr></table>";


echo "<br />";
if($unapproved_count > 0){echo "<table align='center'><tr><td><font color='brown'><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img>Previous Invoice still Pending Approval. Click on ALL Invoices LINK to approve previous Invoice</font></td></tr></table>"; exit;} 


include("head_steps.php"); 
echo "<br />";


/*
if($mess=='y')
{$success_image="<br />Contract Update Successful <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>"

;}
else {$success_image="";}
*/
if($eid == '')
{
//$query3="SELECT * from service_contracts where id='$id' ";
$query3="SELECT park,center,company,purpose,contract_administrator,po_num,line_num,ncas_account,fyear,vendor,id as 'scid' 
         from service_contracts where id='$id' ";
}


if($eid != '')
{
//$query3="SELECT * from service_contracts where id='$id' ";
$query3="SELECT service_contracts.purpose,
                service_contracts.contract_administrator,
				service_contracts.vendor,
				service_contracts.po_num,
				service_contracts.line_num,
				service_contracts.fyear,
				service_contracts_invoices.scid,
				service_contracts_invoices.invoice_num,
				service_contracts_invoices.invoice_date,
				service_contracts_invoices.invoice_amount,
				service_contracts_invoices.previous_amount_paid as 'line_num_previous_paid',
				service_contracts_invoices.ncas_account,
				service_contracts_invoices.park,
				service_contracts_invoices.center,
				service_contracts_invoices.company,
				service_contracts_invoices.service_period
				from service_contracts_invoices
				left join service_contracts on service_contracts_invoices.scid=service_contracts.id
				where service_contracts_invoices.id='$eid' ";
}





echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$row3=mysqli_fetch_array($result3);

extract($row3);





if($mess=='y')
{
$success_image="<br />Invoice Update Successful <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>";
echo "<table align='center'><tr><th>$success_image</th></tr></table>";
}
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='crs_deposits_cashier_deposit_update.php'>";
echo "<form action='current_invoice_update.php' method='post'>";
/*
echo "<table align='center'><tr><th><a href='payment_form.php?fyear=$fyear&report_type=form&edit=y&id=$id'>EDIT Contract Info</a>$success_image</th></tr></table>";
*/

echo "<table align='center' border=1>";
 
//echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";
/*
echo "<tr><th align='center'><font color='brown'>Park</font></th><td><font color='brown'>$park</font></font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td><font color='brown'>$purpose</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td><font color='brown'>$contract_administrator</font></td></tr>";
*/
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><font color='brown'>$vendor</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><font color='brown'>$po_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><font color='brown'>$line_num</font></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Company)</font></th><td><font color='brown'>$company</font></td></tr>";            
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Account)</font></th><td><font color='brown'>$ncas_account</font></td></tr>";            
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Center)</font></th><td><font color='brown'>$center</font></td></tr>";  
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (FYear)</font></th><td><font color='brown'>$fyear</font></td></tr>";
/*
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (<font color='red'>Previous Invoices Total Paid</font>)</font></th><td><input type='text' name='line_num_previous_paid' value='$line_num_previous_paid'></font></td></tr>";
*/
echo "<tr><th align='center'><font color='red'>Previous Invoices (Total Amount Paid)</font></th><td><input type='text' name='line_num_previous_paid' autocomplete='off' value='$line_num_previous_paid'></font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Current Invoice#</font></th><td><input type='text' name='invoice_num' autocomplete='off' value='$invoice_num'></td></tr>";            
echo "<tr><th align='center'><font color='brown'>Current Invoice Date</font></th><td><input name='invoice_date' type='text' value='$invoice_date' id='datepicker' ></td></tr>";   
echo "<tr><th align='center'><font color='brown'>Current Invoice Amount</font></th><td><input type='text' name='invoice_amount' autocomplete='off' value='$invoice_amount'></td></tr>";         
echo "<tr><th align='center'><font color='brown'>Current Invoice Service Period<br />(Example: December 2015)</font></th><td><input type='text' name='service_period' size='45' autocomplete='off' value='$service_period'></td></tr>";            
if($eid == '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Add></th></tr>";     
}
if($eid != '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Update></th></tr>";     
}

echo "<tr>";
echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";
echo "</tr>";




echo "</table>";

/*
echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='report_type' value='$report_type'>";
echo "<input type='hidden' name='edit' value='$edit'>";

echo "</table>";
*/
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='company' value='$company'>";
echo "<input type='hidden' name='ncas_account' value='$ncas_account'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='eid' value='$eid'>";

echo "</form>";


/*
echo "<table align='center'>";
echo "<tr><th>Invoice#</th><th>Invoice Date</th><th>Service Period<br />(example: December 2015)</th><th>Company</th><th>Account</th><th>Center</th></tr>";

echo "<tr>";
echo "<td><input name='invoice_num[]' type='text' size='25' value=''></td>";
echo "<td><input name='invoice_date[]' type='text' size='25' value=''></td>";
echo "<td><input name='service_period[]' type='text' size='25' value=''></td>";
echo "<td><input name='company[]' type='text' size='9' value=''></td>";
echo "<td><input name='account[]' type='text' size='25' value=''></td>";
echo "<td><input name='center[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='invoice_num[]' type='text' size='25' value=''></td>";
echo "<td><input name='invoice_date[]' type='text' size='25' value=''></td>";
echo "<td><input name='service_period[]' type='text' size='25' value=''></td>";
echo "<td><input name='company[]' type='text' size='9' value=''></td>";
echo "<td><input name='account[]' type='text' size='25' value=''></td>";
echo "<td><input name='center[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='invoice_num[]' type='text' size='25' value=''></td>";
echo "<td><input name='invoice_date[]' type='text' size='25' value=''></td>";
echo "<td><input name='service_period[]' type='text' size='25' value=''></td>";
echo "<td><input name='company[]' type='text' size='9' value=''></td>";
echo "<td><input name='account[]' type='text' size='25' value=''></td>";
echo "<td><input name='center[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='invoice_num[]' type='text' size='25' value=''></td>";
echo "<td><input name='invoice_date[]' type='text' size='25' value=''></td>";
echo "<td><input name='service_period[]' type='text' size='25' value=''></td>";
echo "<td><input name='company[]' type='text' size='9' value=''></td>";
echo "<td><input name='account[]' type='text' size='25' value=''></td>";
echo "<td><input name='center[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr><th colspan='6'><input type=submit name=submit value=Update></th></tr>";

echo "</table>";
*/






echo "</body></html>";

?>

























