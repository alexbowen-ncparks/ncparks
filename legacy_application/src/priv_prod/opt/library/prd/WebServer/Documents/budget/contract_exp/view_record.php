<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//$level=$_SESSION['budget']['level'];
//$posTitle=$_SESSION['budget']['position'];
//$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

 
echo "<html>";
echo "<head>";
echo "<title>Contract Expenditure Form</title>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 14;}
TH{font-family: Arial; font-size: 14pt;}
TD{font-family: Arial; font-size: 14pt;}
input{style=font-family: Arial; font-size:13.0pt}
</style>";
echo "</head>";
//echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=CENTER > <font color=brown><i>Contract Expenditure Report</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=left > <A href=/budget/menu.php?forum=blank> Budget-HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";
echo "<body>";
//echo "<H2><font color='red'>WARNING-When changing step_group OR step_num, User must re-name associated PHP File</font></H2>";

       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  
echo "sheet-$sheet";echo "<br />";

$query1="select max(id) as 'header_id'
from contract_payments
where sheet='$sheet' ;";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
echo "header_id=$header_id";//exit;

$query1="select max(id) as 'header_id'
from contract_payments
where sheet='$sheet' ;";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);


//echo "<form name='form1' method='post' action='update_record.php'>";

//echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

$query2="select con_reportperiod,ncas_po_number,con_fy,po_line1,con_location,con_original,
         con_num,con_payments,vendor_name,con_purpose
         from contract_payments
         where id='$header_id';";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);





echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  
	   echo "<tr><td><font color='blue'>Reporting Period (example: August 2010)</font></td><td><input type='text' name='con_reportperiod' autocomplete='off' value='$con_reportperiod' ></td><td><font color='blue'>Purchase Order Number</font></td><td><input type='text' name='ncas_po_number' size='10' autocomplete='off' value='$ncas_po_number' ></td></tr>";
	   echo "<tr><td><font color='blue'>Fiscal Year</font></td><td><input type='text' name='con_fy' size='10' autocomplete='off' value='$con_fy' ></td><td><font color='blue'>PO Line-Number</font></td><td><input type='text' name='po_line1' size='5' autocomplete='off' value='$po_line1' ></td></tr>";
	   echo "<tr><td><font color='blue'>Division/Section/Prog</font></td><td><input type='text' name='con_location' size='40' autocomplete='off' value='$con_location'></td><td><font color='blue'>PO Line-Original Amount</font></td><td><input type='text' name='con_original' size='10' autocomplete='off' value='$con_original' ></td></tr>";
	   echo "<tr><td><font color='blue'>Contract Number (if applicable)</font></td><td><input type='text' name='con_num' size='20' autocomplete='off' value='$con_num' ></td><td><font color='blue'>PO Line-Total Payments (excludes current payment)</font><td><input type='text' name='con_payments' size='10' autocomplete='off' value='$con_payments' ></td></tr>";
	   echo "<tr><td><font color='blue'>Contractor</font></td><td><input type='text' name='vendor_name' size='40' autocomplete='off' value='$vendor_name' ></td></tr>";
	   echo "<tr><td><font color='blue'>Purpose</font></td><td><input type='text' name='con_purpose' size='40' autocomplete='off' value='$con_purpose' ></td></tr>";
	   //echo "<tr><td><font color='blue'>Payment Lines Needed :</font></td><td><input type='text' name='lines' size='10' value='$lines' ></td></tr>";


	   	   echo "</table>"; echo "<br />";

//echo "<br /> <br />";
//echo "<input type='hidden' name='cid' value='$cid'>";
//echo "<h1 ALIGN=center><input type='submit' name='submit'
//value='show_form'></h1>";

//echo "</form>";
//if($submit=="show_form"){


/*
echo "<table>";
echo "<tr><th><font color='blue'>Invoice Number</font></th><th><font color='blue'>Invoice Date <br /> (mm/dd/yy)</font></th><th><font color='blue'>Company</font></th><th><font color='blue'>Account</font></th><th><font color='blue'>1099 code</font></th><th><font color='blue'>Center</font></th><th><font color='blue'>Amount</font></th></tr>";
for($i=1;$i<=5;$i++)

echo "<tr>
<td><input type='text' name='ncas_invoice_number[$i]' autocomplete='off' size='20' ></td>
<td><input type='text' name='ncas_invoice_date[$i]' autocomplete='off' size='13' ></td>
<td><input type='text' name='ncas_company[$i]'  autocomplete='off' size='10'></td>
<td><input type='text' name='ncas_account[$i]' autocomplete='off' size='10'></td>
<td><input type='text' name='code_1099[$i]' autocomplete='off' size='10'></td>
<td><input type='text' name='ncas_center[$i]' size='10'></td>
<td><input type='text' name='ncas_invoice_amount[$i]' size='10'></td>

</tr>";


   echo "<tr>
         <td colspan='10' align='right'><input type='submit' name='submit' value='Print_Report'></td>
         </tr></table></form></body></html>";


//echo "</font>";

//echo "</form>";
*/

?>






















