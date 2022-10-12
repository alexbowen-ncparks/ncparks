<?php



session_start();



$active_file=$_SERVER['SCRIPT_NAME'];



$level=$_SESSION['budget']['level'];

$posTitle=$_SESSION['budget']['position'];

$tempid=$_SESSION['budget']['tempID'];

$beacnum=$_SESSION['budget']['beacon_num'];

$concession_location=$_SESSION['budget']['select'];

$concession_center=$_SESSION['budget']['centerSess'];







extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$fee_amount=str_replace(",","",$fee_amount);

$fee_amount=str_replace("$","",$fee_amount);



if($level=='5' and $tempID !='Dodd3454')

{

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

}
$Lname=substr($tempid,0,-4);
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}



if($f_year==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($ncas_center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($vendor_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($ncas_post_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($ncas_post_date=="0000-00-00"){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}



if($ncas_invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

//if($ncas_post_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


//if($ncas_invoice_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

if($id==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}






/*

$query12="update concessions_vendor_fees

          set f_year='$f_year',fee_period='$fee_period',park='$park',vendor_name='$vendor_name',

		   fee_amount='$fee_amount',vendor_ck_num='$check_num',

		   internal_deposit_num='$internal_deposit_num',ncas_post_date='$ncas_post_date',

		   ncas_center='$ncas_center',ncas_account='$ncas_account',ncas_invoice_num='$ncas_invoice_num',entered_by='$Lname' where id='$id' ";
		   
*/		   
		   
$query12="update concessions_vendor_fees

  set ncas_post_date='$ncas_post_date',ncas_invoice_num='$ncas_invoice_num',verified_by='$Lname',post2ncas='y',record_complete='y' where id='$id' ";	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

/*



$query13="select max(project_note_id) as 'project_note_id' from concessions_documents where user='$beacnum' ";



$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");



$row13=mysqli_fetch_array($result13);



extract($row13);

if($level=='5' and $tempID !='Dodd3454')

{

echo "record_insert=$record_insert";

echo "<br />";

echo "project_note_id=$project_note_id";

echo "<br />";

echo "project_category=$project_category";

echo "<br />";

echo "project_name=$project_name";

echo "<br />";

echo "project_note=$project_note";

echo "<body>";

}



echo "<h1>ADD Document</h1>";

echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";

echo "<input type='hidden' name='MAX_FILE_SIZE' value='50000000'>";

echo "<input type='file' id='document' name='document'>";

echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";

echo "<input type='hidden' name='project_category' value='$project_category'>";

echo "<input type='hidden' name='project_name' value='$project_name'>";



echo "<br /> <br />";

echo "<input type='submit' value='add_document' name='submit'>";

echo "</form>";

echo "</body>";



exit;





/*

if($project_note_id != ""){

echo "<body>";





echo "<h1>ADD Document</h1>";

echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";

echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";

echo "<input type='file' id='document' name='document'>";

echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";

echo "<input type='hidden' name='project_category' value='$project_category'>";

echo "<input type='hidden' name='project_name' value='$project_name'>";



echo "<br /> <br />";

echo "<input type='submit' value='add_document' name='submit'>";

echo "</form>";

echo "</body>";

exit;}

*/



header("location: vendor_fees_drilldown1.php?park=$park&vendor_name=$vendor_name&f_year=$f_year");





?>