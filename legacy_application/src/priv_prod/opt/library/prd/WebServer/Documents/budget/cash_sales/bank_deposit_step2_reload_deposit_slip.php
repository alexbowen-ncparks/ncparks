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
if($concession_location=='ADM'){$concession_location='ADMI';}
extract($_REQUEST);
$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
//$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$today_date=date("Ymd");


if($submit!='Submit')
{
{
echo "<html><body>";
echo "<br /><br />";
include ("../../budget/menu1415_v1.php");
//echo  "<form method='post' autocomplete='off' action='bank_deposit_step2_update3.php'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='bank_deposit_step2_reload_deposit_slip.php'>";
//echo "total_check=$total_check<br /><br />";





echo "<br /><br />";
echo "<table align='center'>";
//echo "<tr>";
//echo "<td><font color='brown'>Bank Deposit Amount = $total_count</font></td>";
echo "<tr>";
echo "<th><font color='red' size='5'> Re-Load Deposit Slip </font><font color='blue' size='5'>(Deposit# $deposit_id)</font><br /><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></th>";
echo "<td>";
//echo "<td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='manual_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='deposit_amount' value='$total_count'>";
//echo "<input type='hidden' name='total_check' value='$total_check'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";

}
 

 echo "</body></html>";
 
}
if($submit=='Submit')
{
//echo "Code to update Table and header to final destination"; //exit;
//echo "<br />manual_deposit_id=$manual_deposit_id<br />";


define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];
//echo "document=$document<br />";
$document_format2=substr($document, -3);
//echo "document_format2=$document_format2<br />";
//if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
//echo "format_ok=$format_ok";
//exit;


if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}


$query4="select id 
         from crs_tdrr_division_deposits
         where orms_deposit_id='$manual_deposit_id' ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);

//echo "<br />id=$id<br />"; //exit;


$source_table="crs_tdrr_division_deposits";

$doc_mod=$document;

$document=$source_table."_".$id;  //echo $document; exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);

$target2="/budget/cash_sales/";
$target3=$target2.$target;
$query5="update crs_tdrr_division_deposits set document_location='$target3'
where id='$id' ";
mysqli_query($connection, $query5) or die ("Error updating Database $query5");	
	

//echo "<br />Line 125: Update Successful<br />"; //exit;
$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
	$k=array_rand($array);
	$photo_location=$array[$k];
	$photo_location2="<img src='$photo_location' height='100' width='100'>";
echo "<table align='center'><tr><td>$photo_location2</td><td><font size='10' color='brown'>Document Added on $today_date. Thanks!</font></td></tr></table>";
echo "<table align='center'><tr><td><font size='10'><a href='/budget/admin/crj_updates/crs_deposits_crj_reports_final.php?deposit_id=$manual_deposit_id&dncr=y&GC=n'>Return to Cash Receipts Journal</a></font></td></tr></table>";

exit;





}
 
?>