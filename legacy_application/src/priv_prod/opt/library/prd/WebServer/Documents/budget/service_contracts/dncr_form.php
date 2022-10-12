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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


//$table="crs_tdrr_division_history_parks";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from `budget`.`concessions_customformat`
WHERE 1 
";

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



//echo "num12=$num12<br />"; //exit;	
include("journal_header.php");
//exit;
include("dncr_final_body.php");
//exit;
include ("signature_lookup.php");
//exit;
//echo "Line 215: puof_name=$puof_name<br />";

echo "<table border=0 align='center'>";
echo "<tr>";
include ("contract_recap.php");
//Left Side Table Begins
/*
echo "<td>";
echo "<table border='1'>";
echo "<tr>";
echo "<td>";
echo "Contract Recap for Line#";
echo "</td>";
echo "<th>";
//echo "1";
echo "$line_num";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Beginning Balance for Line";
echo "</td>";
echo "<th>";
//echo "$4,594.00";
echo "$line_num_beg_bal2";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Total YTD Payments";
echo "</td>";
echo "<th>";
//echo "$722.00";
echo "$previous_amount_paid2";
echo "</th>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Ending Balance Available";
echo "</td>";
echo "<th>";
//echo "$3,872.00";
echo "$available_before_invoice2";
echo "</th>";
echo "</tr>";
echo "</table>";
echo "</td>";
//Left Side Table Ends
*/
// extra spaces between 2 Tables
//echo "<td></td><td></td><td></td>";
//Right Side Table Begins
echo "<td>";
echo "<table border='1'>";
//Contract Administrator Starts
echo "<tr>";
echo "<td>";
echo "Contract Administrator";
echo "</td>";
echo "<td>";
//echo "Ron Anundson<br />Signature";
//echo "$crj_approved_by<br /><img height='40' width='200' src='$manager_sig1' ></img>";
//echo "$crj_prepared_by<br /><img height='40' width='200' src='$cashier_sig1' ></img>";
echo "$crj_contract_administrator<br /><img height='40' width='200' src='$contract_administrator_sig1' ></img>";
echo "</td>";
//echo "<td></td>";
//echo "<td></td>";
echo "<td>";
//echo "01/15/16";
echo "$manager_date2";
echo "</td>";
echo "</tr>";
//Purchasing Officer Starts
echo "<tr>";
echo "<td>";
echo "Division Purchasing Officer";
echo "</td>";
echo "<td>";
//echo "$puof_name<br /><img height='40' width='200' src='$puof_sig1' ></img>";
echo "$crj_prepared_by<br /><img height='40' width='200' src='$cashier_sig1' ></img>";
echo "</td>";
//echo "<td></td>";
//echo "<td></td>";
echo "<td>";
echo "$puof_date2";
echo "</td>";
echo "</tr>";
//Fiscal Officer Starts
echo "<tr>";
echo "<td>";
echo "Division Fiscal Officer";
echo "</td>";
echo "<td>";
//echo "Tammy Dodd<br />&nbsp&nbsp;";
//echo "$buof_name<br /><img height='40' width='200' src='$buof_sig1' ></img>";
if($beacnum=='60032781')
{
echo "<form action='dncr_form_approval.php'>";
//echo "Cashier: $tempid<br />  <font color='green'>Approved</font>:<input type='checkbox' name='cashier_approved' value='y' ><input type='submit' name='submit' value='Submit'></th>";
echo "<font color='green'>Approved</font>:<input type='checkbox' name='manager_approved' value='y' >&nbsp;&nbsp&nbsp;<input type='submit' name='submit' value='Submit'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='invoice_num' value='$invoice_num'>";
echo "<input type='hidden' name='park' value='$park'>";

echo "</form>";
}
echo "</td>";
//echo "<td></td>";
//echo "<td></td>";
echo "<td>";
echo "&nbsp;&nbsp;";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
// Previous Line: Master Table Ends  (includes Left Table and Right Table)
 
// Next Line:  Footer Message
echo "<br /><br />";
echo "<table align='center'>";
echo "<tr>";
echo "<td>";
echo "<i><b><u>Signatures attest to service or grants paid out according to contract</u></b></i>";
echo "</td>";
echo "</tr>";
echo "</table>"; 
 
echo "</body></html>";


?>