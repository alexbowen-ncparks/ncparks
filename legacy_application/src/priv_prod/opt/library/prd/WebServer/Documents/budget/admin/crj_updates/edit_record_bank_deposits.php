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

$deposit_amount=str_replace(",","",$deposit_amount);

$deposit_amount=str_replace("$","",$deposit_amount);





//echo "<pre>";print_r($_SERVER);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$Lname=substr($tempid,0,-4);
//echo "tempid=$tempid";
//echo "Lname=$Lname";

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$source_table="bank_deposits";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


//include("../budget/~f_year.php");

//include("../../budget/~f_year.php");

//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}


if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($deposit_id==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($deposit_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bank_deposit_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_start_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_end_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bo_receipt_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}


define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];

if($document==""){

$query11="update bank_deposits
          set center='' where id='$id' ";	
	
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

	
$query12="update bank_deposits
          set park='$park',deposit_id='$deposit_id',deposit_amount='$deposit_amount',bank_deposit_date='$bank_deposit_date',collection_start_date='$collection_start_date',collection_end_date='$collection_end_date',bo_receipt_date='$bo_receipt_date',entered_by='$Lname'  where id='$id' ";	
	
$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");


$query13="update bank_deposits,center
         set bank_deposits.center=center.center
		 where bank_deposits.park=center.parkcode; ";

mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


$query13a="update bank_deposits
set bank_deposits.post2ncas='n',
bank_deposits.post_date='0000-00-00'
where bank_deposits.id='$id'; ";

$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");


$query14a="update bank_deposits,crj_posted8_v2
set bank_deposits.post2ncas='y',
bank_deposits.post_date=crj_posted8_v2.acctdate
where bank_deposits.deposit_id=crj_posted8_v2.deposit_id
and bank_deposits.center=crj_posted8_v2.center
and bank_deposits.deposit_amount=crj_posted8_v2.amount_total
and bank_deposits.id='$id'
and crj_posted8_v2.acctdate >= '20130701'; ";
//echo "query13=$query13";echo "<br />";//exit;
$result14a=mysqli_query($connection, $query14a) or die ("Couldn't execute query 14a. $query14a");


}
//echo "$document";exit;
if($document!=""){
$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$id;//echo $document;//exit;
//echo "<br />";
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;exit;
//echo "<br />";
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target;//exit;

$query14="update bank_deposits
          set center='' where id='$id' ";	
	
$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

	
$query15="update bank_deposits
          set park='$park',deposit_id='$deposit_id',deposit_amount='$deposit_amount',bank_deposit_date='$bank_deposit_date',collection_start_date='$collection_start_date',collection_end_date='$collection_end_date',bo_receipt_date='$bo_receipt_date',entered_by='$Lname',document_location='$target'  where id='$id' ";	
	
$result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");


$query16="update bank_deposits,center
         set bank_deposits.center=center.center
		 where bank_deposits.park=center.parkcode; ";

mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

$query13a="update bank_deposits
set bank_deposits.post2ncas='n',
bank_deposits.post_date='0000-00-00'
where bank_deposits.id='$id'; ";

$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");


$query14a="update bank_deposits,crj_posted8_v2
set bank_deposits.post2ncas='y',
bank_deposits.post_date=crj_posted8_v2.acctdate
where bank_deposits.deposit_id=crj_posted8_v2.deposit_id
and bank_deposits.center=crj_posted8_v2.center
and bank_deposits.deposit_amount=crj_posted8_v2.amount_total
and bank_deposits.id='$id'
and crj_posted8_v2.acctdate >= '20130701' ; ";
//echo "query13=$query13";echo "<br />";//exit;
$result14a=mysqli_query($connection, $query14a) or die ("Couldn't execute query 14a. $query14a");


}

/*

$query12="update concessions_vendor_fees

          set f_year='$f_year',fee_period='$fee_period',park='$park',vendor_name='$vendor_name',

		   fee_amount='$fee_amount',vendor_ck_num='$check_num',

		   internal_deposit_num='$internal_deposit_num',ncas_post_date='$ncas_post_date',

		   ncas_center='$ncas_center',ncas_account='$ncas_account',ncas_invoice_num='$ncas_invoice_num',entered_by='$Lname' where id='$id' ";
		
*/		   
	


//echo "query13=$query13";exit;


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



header("location: bank_deposits.php?add_your_own=y");





?>