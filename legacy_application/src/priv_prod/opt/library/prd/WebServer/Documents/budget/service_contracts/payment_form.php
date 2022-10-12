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
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters



$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../budget/menu1314.php");

//include ("../../budget/menu1415_v1.php");
include ("../../budget/menu1415_v1_new.php");
//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection,$query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

echo "<br /><br />Line 63<br /><br />";

/*
echo "<table align='center'>";
echo "<tr>";




echo "</tr>";
echo "</table>";




//echo "<html>";

echo "<head>";

echo "</head>";
*/

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
echo "line 104: report_form=$report_form<br /><br />";

echo "<br /><table border='1' align='center'><tr><th><a href='/budget/service_contracts/service_contracts.php'><img height='75' width='75' src='dumpster1.jpg' alt='picture of fuel tank'></img></a><font color='brown'><b>Service Contract Invoices</font></th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>View<br />ALL<br />Invoices</a><br />$report_reports </th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Create <br />NEW<br />Invoice</a><br />$report_form</th></tr></table>";

/*
echo "<br /><table align='center' border='1' align='left'><tr><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Pay Invoice</a><br />$report_form</th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>All Invoices</a><br />$report_reports </th></tr></table>";
*/





echo "<br />";

if($report_type=='form')
{
//include ("approver_credentials_1a.php");
include("head_steps.php"); 
//echo "<br />";
echo "<br /><br />Line 124<br /><br />";
if($edit!='y')
{

if($mess=='y')
{$success_image="<br />Contract Update Successful <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>";}
else {$success_image="";}

$query3="SELECT * from service_contracts where id='$id' ";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection,$query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$row3=mysqli_fetch_array($result3);

extract($row3);


//include ("approver_credentials_1a.php");

if($puof_count==1 or $buof_count==1 or $cashier_count==1 or $cashier_count==1)
{
echo "<table align='center'><tr><th><a href='payment_form.php?fyear=$fyear&report_type=form&edit=y&id=$id'>EDIT Contract Info</a>$success_image</th></tr></table>";
}
echo "<table align='center' border=1>";
 
//echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";
echo "<tr><th align='center'><font color='brown'>Park</font></th><td><font color='brown'>$park</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td><font color='brown'>$purpose</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td><font color='brown'>$contract_administrator</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><font color='brown'>$vendor</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract#</font></th><td><font color='brown'>$contract_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><font color='brown'>$po_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><font color='brown'>$line_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Company)</font></th><td><font color='brown'>$company</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Account)</font></th><td><font color='brown'>$ncas_account</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Center)</font></th><td><font color='brown'>$center</font></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (FYear)</font></th><td><font color='brown'>$fyear</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Begin Balance)</font></th><td><font color='brown'>$line_num_beg_bal</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Total Paid-OLD Method)</font></th><td><font color='brown'>$total_paid_old_method</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Buy Entity</font></th><td><font color='brown'>$buy_entity</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><font color='brown'>$remit_address</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>FID#</font></th><td><font color='brown'>$fid_num</font></td></tr>";
echo "<tr><th align='center'><font color='brown'>Group#</font></th><td><font color='brown'>$group_num</font></td></tr>";



      
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time


echo "</table>";
}
if($edit=='y')
{
//{echo "<table align='center'><tr><th>Pending</th></tr></table>" ;}

$query4="SELECT * from service_contracts where id='$id' ";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result4 = mysqli_query($connection,$query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

$row4=mysqli_fetch_array($result4);

extract($row4);

//echo "<table align='center'><tr><th><a href='payment_form.php?fyear=$fyear&report_type=form&edit=y&id=$id'>EDIT Contract Info</a></th></tr></table>";
echo "<form method='post' action='verify_contract_update.php'>";
if($buof_count==1)
{
echo "<table align='center' border=1>";
 
//echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";

echo "<tr><th align='center'><font color='brown'>Park</font></th><td><input type='text' name='park' value='$park' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td><textarea rows='4' cols='50' name='purpose' autocomplete='off'>$purpose</textarea></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td><input type='text' name='contract_administrator' value='$contract_administrator' autocomplete='off'></td></tr>";  
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><input type='text' size='50' name='vendor' value='$vendor' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract#</font></th><td><input type='text' name='contract_num' value='$contract_num' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><input type='text' name='po_num' value='$po_num' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><input type='text' name='line_num' value='$line_num' autocomplete='off'></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (FYear)</font></th><td><input type='text' name='fisyear' value='$fyear'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Company)</font></th><td><input type='text' name='company' value='$company' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Account)</font></th><td><input type='text' name='ncas_account' value='$ncas_account' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Center)</font></th><td><input type='text' name='center' value='$center' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Begin Balance)</font></th><td><input type='text' name='line_num_beg_bal' value='$line_num_beg_bal' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Total Paid-OLD Method)</font></th><td><input type='text' name='total_paid_old_method' value='$total_paid_old_method' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Buy Entity</font></th><td><input type='text' name='buy_entity' value='$buy_entity' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><input type='text' size='50' name='remit_address' value='$remit_address' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>FID#</font></th><td><input type='text' name='fid_num' value='$fid_num' autocomplete='off'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Group#</font></th><td><input type='text' name='group_num' value='$group_num' autocomplete='off'></td></tr>";

 
                 
 

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
 echo "<tr><th><input type=submit name=submit value=Update></th></tr>";
//echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='report_type' value='$report_type'>";
echo "<input type='hidden' name='buof_count' value='$buof_count'>";
echo "<input type='hidden' name='edit' value='$edit'>";
echo "<input type='hidden' name='id' value='$id'>";



echo "</table>";
}

if($puof_count==1)
{
echo "<table align='center' border=1>";
 
//echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";

echo "<tr><th align='center'><font color='brown'>Park</font></th><td><input type='text' name='park' value='$park' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td><textarea rows='4' cols='50' name='purpose' autocomplete='off' readonly='readonly'>$purpose</textarea></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td><input type='text' name='contract_administrator' value='$contract_administrator' autocomplete='off' readonly='readonly'></td></tr>";  
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><input type='text' size='50' name='vendor' value='$vendor' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract#</font></th><td><input type='text' name='contract_num' value='$contract_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><input type='text' name='po_num' value='$po_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><input type='text' name='line_num' value='$line_num' autocomplete='off' readonly='readonly'></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (FYear)</font></th><td><input type='text' name='fisyear' value='$fyear'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Company)</font></th><td><input type='text' name='company' value='$company' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Account)</font></th><td><input type='text' name='ncas_account' value='$ncas_account' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Center)</font></th><td><input type='text' name='center' value='$center' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Begin Balance)</font></th><td><input type='text' name='line_num_beg_bal' value='$line_num_beg_bal' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Total Paid-OLD Method)</font></th><td><input type='text' name='total_paid_old_method' value='$total_paid_old_method' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Buy Entity</font></th><td><input type='text' name='buy_entity' value='$buy_entity' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><input type='text' size='50' name='remit_address' value='$remit_address' autocomplete='off' ></td></tr>";
echo "<tr><th align='center'><font color='brown'>FID#</font></th><td><input type='text' name='fid_num' value='$fid_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Group#</font></th><td><input type='text' name='group_num' value='$group_num' autocomplete='off' readonly='readonly'></td></tr>";

 
                 
 

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
 echo "<tr><th><input type=submit name=submit value=Update></th></tr>";
//echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='report_type' value='$report_type'>";
echo "<input type='hidden' name='buof_count' value='$buof_count'>";
echo "<input type='hidden' name='edit' value='$edit'>";
echo "<input type='hidden' name='id' value='$id'>";



echo "</table>";
}

if($cashier_count==1)
{
echo "<table align='center' border=1>";
 
//echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";

echo "<tr><th align='center'><font color='brown'>Park</font></th><td><input type='text' name='park' value='$park' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td><textarea rows='4' cols='50' name='purpose' autocomplete='off' readonly='readonly'>$purpose</textarea></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td><input type='text' name='contract_administrator' value='$contract_administrator' autocomplete='off' readonly='readonly'></td></tr>";  
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td><input type='text' size='50' name='vendor' value='$vendor' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract#</font></th><td><input type='text' name='contract_num' value='$contract_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td><input type='text' name='po_num' value='$po_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line#</font></th><td><input type='text' name='line_num' value='$line_num' autocomplete='off' readonly='readonly'></td></tr>";
//echo "<tr><th align='center'><font color='brown'>Purchase Order Line (FYear)</font></th><td><input type='text' name='fisyear' value='$fyear'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Company)</font></th><td><input type='text' name='company' value='$company' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Account)</font></th><td><input type='text' name='ncas_account' value='$ncas_account' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Center)</font></th><td><input type='text' name='center' value='$center' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Begin Balance)</font></th><td><input type='text' name='line_num_beg_bal' value='$line_num_beg_bal' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order Line (Total Paid-OLD Method)</font></th><td><input type='text' name='total_paid_old_method' value='$total_paid_old_method' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Buy Entity</font></th><td><input type='text' name='buy_entity' value='$buy_entity' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td><input type='text' size='50' name='remit_address' value='$remit_address' autocomplete='off' ></td></tr>";
echo "<tr><th align='center'><font color='brown'>FID#</font></th><td><input type='text' name='fid_num' value='$fid_num' autocomplete='off' readonly='readonly'></td></tr>";
echo "<tr><th align='center'><font color='brown'>Group#</font></th><td><input type='text' name='group_num' value='$group_num' autocomplete='off' readonly='readonly'></td></tr>";

 
                 
 

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
 echo "<tr><th><input type=submit name=submit value=Update></th></tr>";
//echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='report_type' value='$report_type'>";
echo "<input type='hidden' name='buof_count' value='$buof_count'>";
echo "<input type='hidden' name='edit' value='$edit'>";
echo "<input type='hidden' name='id' value='$id'>";



echo "</table>";
}

echo "</form>";

}



}


echo "</body></html>";

?>