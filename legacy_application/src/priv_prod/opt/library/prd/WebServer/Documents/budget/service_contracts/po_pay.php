<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");
//mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
echo "<html>";
include("head1.php");
include ("../../budget/menu1415_v1_new.php");

echo "<br />";
//$menu_sc='SC4';
//include("service_contracts_menu.php");
echo "<br />";

$menu_sc='SC5';
include("service_contracts_menu5.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

echo "query2=$query2<br />";//exit;		  

$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


$query2a="select count(id) as 'unapproved_count' from service_contracts_invoices where scid='$id' and park_approved='n'  ";	

echo "query2a=$query2a<br />";//exit;		  

$result2a=mysqli_query($connection,$query2a) or die ("Couldn't execute query 2a. $query2a");

$row2a=mysqli_fetch_array($result2a);

extract($row2a);


$query2b="select sum(invoice_amount) as 'line_num_previous_paid' from service_contracts_invoices where scid='$id' and park_approved='y'  ";	

echo "LINE 90: query2b=$query2b<br />";//exit;		  

$result2b=mysqli_query($connection,$query2b) or die ("Couldn't execute query 2b. $query2b");

$row2b=mysqli_fetch_array($result2b);

extract($row2b);


$query2b1="select park as 'contract_park',vendor as 'contract_vendor',po_num as 'contract_ponum' from service_contracts where id='$id'";	

echo "LINE 115: query2b1=$query2b1<br />";//exit;		  

$result2b1=mysqli_query($connection,$query2b1) or die ("Couldn't execute query 2b1. $query2b1");

$row2b1=mysqli_fetch_array($result2b1);

extract($row2b1);





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



if($scid != ''){$id=$scid;}

echo "</tr></table>";
echo "<br />";
//echo "<table align='center'><tr><td><font color='brown' class='cartRow'>$contract_vendor($contract_park)</font></td><td><font color='brown'>PO#</font> <font color='red'>$contract_ponum</font></td></tr></table>";
//echo "<table align='center'><tr><td><font color='red'> $contract_vendor</font> ($contract_park)</td></tr><tr><td><font color='red'>$contract_ponum</font></td></tr></table>";






echo "<br />";

if($unapproved_count > 0){echo "<table align='center'><tr><td><font color='brown'><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img>Previous Invoice still Pending Approval from Park Cashier OR Park Manager.<br /> Click <a href='all_invoices.php'>here</a> to approve previous Invoice</font></td></tr></table>"; exit;} 


//include("head_steps.php"); 
echo "<br />";
echo "<table align='center'><tr><th><font color='red'>Step1-Invoice</font></th></tr></table>";


if($eid == '')
{

$query3="SELECT park,center,company,purpose,contract_administrator,po_num,line_num,ncas_account,fyear,vendor,id as 'scid',remit_address
         from service_contracts where id='$id' ";
}


if($eid != '')
{



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
				service_contracts_invoices.service_period,
				service_contracts_invoices.remit_address
				from service_contracts_invoices
				left join service_contracts on service_contracts_invoices.scid=service_contracts.id
				where service_contracts_invoices.id='$eid' ";




				
				
}





echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);





extract($row3);





if($mess=='y')
{
$success_image="<br />Invoice Update Successful <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>";
echo "<table align='center'><tr><th>$success_image</th></tr></table>";
}
echo "<form enctype='multipart/form-data' method='post' action='current_invoice_update.php'>";


echo "<table align='center' border=1>";
 

echo "<tr><th align='center'><font color='brown'>Park</font></th><td><font color='brown'>$park</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><font color='brown'>$vendor</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><font color='brown'>$remit_address</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><font color='brown'>$po_num</font></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><font color='brown'>$line</font></td></tr>";

echo "<tr><th align='center'><font color='brown'>Invoice#</font></th><td><input type='text' name='invoice_num' autocomplete='off' value='$invoice_num'></td></tr>";            
echo "<tr><th align='center'><font color='brown'>Invoice Date</font></th><td><input name='invoice_date' type='text' value='$invoice_date' id='datepicker' ></td></tr>";   
echo "<tr><th align='center'><font color='brown'>Invoice Amount</font></th><td><input type='text' name='invoice_amount' autocomplete='off' value='$invoice_amount'></td></tr>";         
echo "<tr><th align='center'><font color='brown'>Invoice Service Period<br />(Example: December 2015)</font></th><td><input type='text' name='service_period' size='45' autocomplete='off' value='$service_period'></td></tr>";  

echo "<tr>";
echo "<th></th><th>Invoice (<font color='red'>PDF Format</font>)<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /></th>";
echo "</tr>";

          
if($eid == '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Add></th></tr>";     
}
if($eid != '')
{         
echo "<tr><th colspan='2'><input type=submit name=submit value=Update></th></tr>";     
}






echo "</table>";


echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='company' value='$company'>";
echo "<input type='hidden' name='ncas_account' value='$ncas_account'>";
echo "<input type='hidden' name='remit_address' value='$remit_address'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='eid' value='$eid'>";

echo "</form>";









echo "</body></html>";

?>