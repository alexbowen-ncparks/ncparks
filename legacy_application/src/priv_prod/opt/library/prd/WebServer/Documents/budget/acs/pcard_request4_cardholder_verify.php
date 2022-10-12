<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid_player=$_SESSION['budget']['tempID_player'];
//echo "<br />tempid_player=$tempid_player<br />";
if($tempid_player != ''){$tempid=$tempid_player;}

if($concession_location=='ADM'){$concession_location='ADMI';}
//echo "<br />tempid=$tempid<br />";
//$system_entry_date=date("Ymd");

extract($_REQUEST);

$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
$today_date2=date('m-d-y', strtotime($today_date));

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");




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

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<html>";
echo "<head>
<title>MoneyTracker</title>";
/*
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
*/

//echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this score?')
 return (bConfirm);
}

function confirmLink2()
{
 bConfirm=confirm('Are you sure you want to approve this score?')
 return (bConfirm);
}


";
echo "</script>";
echo "</head>";

//include("../../budget/menu1314.php");
include("../../budget/menu1314_tony.html");
include ("../../budget/menu1415_v1.php");
include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";
echo "</head>";
$report_type='reports';
if($report_type=='reports'){$report_reports="<img height='35' width='35' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
echo "<br />";
echo "<table align='center' border='1'>";


	
echo "<tr>";
echo "<th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";

//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";

echo "<th>Request Status<br/>$report_reports</th>";


//echo "<iframe width='420' height='315' src='https://www.youtube.com/embed/SSR6ZzjDZ94' frameborder='0' allowfullscreen></iframe>";
//include("music_slideshow2.php");
//echo "</th>";
echo "</tr>";	
	
	
	
echo "</table>";
echo "<br />";
echo "<table align='center' cellspacing='5'><tr><th><font color='red'>Purchasing Guideline Documents</th></tr></table>";
echo "<table border='2' align='center' cellspacing='5'>";
echo "<tr><th><a href='purchasing_guidelines.docx' target='_blank'>1) Purchasing Guidelines</a></th><th><a href='best_price_form.xls' target='_blank'>2) Best Price Form</a></th><th><a href='ci_mm_trails_purchasing_guidelines.pdf' target='_blank'>3) Capital Improvement Purchasing Guidelines</a></th></tr>";
echo "</table>";
echo "<br />";
//added 8/17/21
if($tempid_player != ''){$tempid=$tempid_player;}

$query11="SELECT * from pcard_users
WHERE 1 and act_id = 'p'
and employee_tempid='$tempid'
 ";

echo "query11=$query11<br /><br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";
echo "<table border='1' align='center'>";
echo "<tr>";
echo "<th align=left><font color=brown>Admin <br />Request#</font></th>
	   <th align=left><font color=brown>Cashier<br />Requestor</font></th>
       <th align=left><font color=brown>Employee Info</font></th>       
       
	   <th align=left><font color=brown>Employee<br />verifies knowledge of<br />Purchasing Guidelines</font></th>";
	   
	   
	  

echo "</tr>"; 

while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);

$cashier3=substr($cashier,0,-2);
$student_id=substr($student_id,0,-2);
$manager3=substr($manager,0,-2);
$manager_comment_name3=substr($manager_comment_name,0,-2);
$fs_comment_name3=substr($fs_comment_name,0,-2);
$fs_approver3=substr($fs_approver,0,-2);
$manager_comment_date_dow=date('l',strtotime($manager_comment_date));
/*
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));



if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}
*/
if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}


if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}



$cashier_date2=date('m-d-y', strtotime($cashier_date));
$student_test_date=date('m-d-y', strtotime($student_test_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));

echo "<tr>";
echo "<td bgcolor='lightgreen'>$admin$id</td>"; 
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$cashier3<br />$cashier_date2<br />$cashier_date_dow<br /></td>";
echo "<td bgcolor='lightgreen'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number</td>";
if($pcard_holder=='')
{
echo "<td>";
echo "<form method='post' autocomplete='off' action='cardholder_verification.php'>";

echo "<table>";
echo "<tr><th>Cardholder: $first_name $last_name $suffix</th><td>I \"Received & Understood\" Procurement Card Purchasing Guidelines:<input type='checkbox' name='cardholder_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='record_count' value='$num12'>";

echo "<input type='submit' name='submit' value='Submit'>";

echo "</td>";
echo"</tr>";
echo "</table>";

echo "</form>";
echo "</td>";
}
if($pcard_holder!='')
{
echo "<td>";
echo "<table>";
echo "<tr><th>Cardholder: $first_name $last_name $suffix</th></tr>";
echo "<tr><td>I \"Received & Understood\" Procurement Card Purchasing Guidelines:<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";	
}


echo "</tr>";


}
echo "</table>";
?>



















	














