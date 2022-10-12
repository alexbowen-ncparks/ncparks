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
$deposit_amount=str_replace(",","",$deposit_amount);
$deposit_amount=str_replace("$","",$deposit_amount);

//echo "Currently Under Construction-TBASS<br />";//exit;
//$center=str_replace("-","",$center);

//echo "bo_receipt_date";exit;

//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";exit;


/*
echo "<table border=\"1\">";
echo "<tr><td>File Uploaded: </td>
   <td>" . $_FILES["upload_file"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["upload_file"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["upload_file"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temp File: </td>
   <td>" . $_FILES["upload_file"]["tmp_name"] . "</td></tr>";
echo "</table>";

exit;
*/






$source_table="preapproval_tracking";



$park=substr($park,0,4);//echo "park=$park<br />";//exit;
/*
$bank_deposit_date_YYYY=substr($bank_deposit_date,6,4);
$bank_deposit_date_MM=substr($bank_deposit_date,0,2);
$bank_deposit_date_DD=substr($bank_deposit_date,3,2);
$bank_deposit_date=$bank_deposit_date_YYYY.$bank_deposit_date_MM.$bank_deposit_date_DD;

$bo_receipt_date_YYYY=substr($bo_receipt_date,6,4);
$bo_receipt_date_MM=substr($bo_receipt_date,0,2);
$bo_receipt_date_DD=substr($bo_receipt_date,3,2);
$bo_receipt_date=$bo_receipt_date_YYYY.$bo_receipt_date_MM.$bo_receipt_date_DD;
*/

//echo "hello";
//echo "bank_deposit_date=$bank_deposit_date<br />";//exit;
//echo "bo_receipt_date=$bo_receipt_date<br />";//exit;
//$park=substr($park,0,4);echo "park=$park<br />";exit;


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/



if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($deposit_id==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($deposit_amount==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bank_deposit_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_start_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($collection_end_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($bo_receipt_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}

define('PROJECTS_UPLOADPATH','documents_preapproval_tracking/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}


$entered_by=substr($tempid,0,-4);

//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$database="budget";
$db="budget";
$table="preapproval_tracking";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");




$query1="insert into preapproval_tracking
set park='$park',deposit_id='$deposit_id',deposit_amount='$deposit_amount',bank_deposit_date='$bank_deposit_date',collection_start_date='$collection_start_date',collection_end_date='$collection_end_date',bo_receipt_date='$bo_receipt_date',entered_by='$entered_by',sed='$system_entry_date',f_year='$f_year'
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update preapproval_tracking,center
         set preapproval_tracking.center=center.center
		 where preapproval_tracking.park=center.parkcode; ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

/*
$query3="select max(id) as 'maxid'
         from preapproval_tracking where 1 ; ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		  
$row3=mysqli_fetch_array($result3);

extract($row3);



$doc_mod=$document;
$document=$source_table."_".$maxid;//echo $document;//exit;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
$query="update preapproval_tracking set document_location='$target'
where id='$maxid' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

*/


header("location: preapproval_tracking.php?add_your_own=y&message=update_successful");


?>