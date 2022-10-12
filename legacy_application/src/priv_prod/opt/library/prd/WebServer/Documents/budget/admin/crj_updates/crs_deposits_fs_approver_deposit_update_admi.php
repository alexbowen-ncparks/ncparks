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
//echo "orms_deposit_id=$orms_deposit_id";exit;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";

if($depid_parkcode != ''){echo "depid_parkcode=$depid_parkcode "; exit;}

//echo "concession_location=$concession_location";
//exit;

//echo "tempid=$tempid<br />";
//echo "concession_location=$concession_location<br />";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

$f_year='1314';


$query11a="select count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='admi' and role='fs_approver' and tempid='$tempid' ";	 
		  
//echo "query11a=$query11a";//exit;

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysqli_fetch_array($result11a);

extract($row11a);

//if($manager_nick){$manager_first=$manager_nick;}			  
		  
//echo "query11a=$query11a<br />";//exit;
//echo "cashier_count=$cashier_count<br />";//exit;
//echo "cashier_first=$cashier_first<br />";//exit;
//echo "cashier_last=$cashier_last<br />";//exit;
//echo "fs_approver_count=$fs_approver_count<br />";//exit;

if($fs_approver_count==1)
{

//$checknum0=$checknum[0]; echo "checknum0=$checknum0<br />";
//$payor0=$payor[0]; echo "payor0=$payor0<br />";
//$ck_amount0=$ck_amount[0]; echo "ck_amount0=$ck_amount0<br />";
//$description0=$description[0]; echo "description0=$description0<br />";

//$ck_count=count($checknum); echo "ck_count=$ck_count<br />";//exit;

/*
echo "<table border=\"1\">";
echo "<tr><td>File Uploaded: </td>
   <td>" . $_FILES["document"]["name"] . "</td></tr>";
echo "<tr><td>File Type: </td>
   <td>" . $_FILES["document"]["type"] . "</td></tr>";
echo "<tr><td>File Size: </td>
   <td>" . ($_FILES["document"]["size"] / 1024) . " Kb</td></tr>";
echo "<tr><td>Name of Temp File: </td>
   <td>" . $_FILES["document"]["tmp_name"] . "</td></tr>";
echo "</table>";
*/

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


$source_table="crs_tdrr_division_deposits";
//echo "checks=$checks<br />";
//echo "checknum0=$checknum0<br />";

//if($bank_deposit_date==""){echo "<font color='brown' size='5'><b>Bank Deposit Date Missing<br /><br />Click the BACK button on your Browser to enter Bank Deposit Date</b></font><br />";exit;}

//define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
//$document=$_FILES['document']['name'];
//if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}


//if($checks=='yes' and $checknum0==''){echo "<font color='brown' size='5'><b> Please fill out check listing</b></font>";exit;}



if($fs_approver_approved==""){echo "<font color='brown' size='5'><b>Approval missing<br /><br />Click the BACK button on your Browser to enter Approval</b></font><br />";exit;}

//if($manager_approved==""){echo "<font color='brown' size='5'><b>Manager Approval missing. <br /> Click the BACK button on your Browser to enter Manager Approval</b></font><br />";exit;}



$entered_by=$tempid;

$fs_approver=$entered_by;

/*
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$entered_by' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);			  
		  
echo "query1a=$query1a<br />";//exit;
echo "cashier_count=$cashier_count<br />";exit;
*/

$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];
//$query11b="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$concession_location'";


//echo "query2=$query2<br />";

//$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");
//$row11b=mysqli_fetch_array($result11b);
//extract($row11b);

//$controllers_next=$controllers_max+1;



/*

$query1="insert into crs_tdrr_division_deposits_checklist  SET";
for($j=0;$j<$ck_count;$j++){
$query2=$query1;
$checknum2=addslashes($checknum[$j]);
if($checknum2==''){continue;}
$payor2=addslashes($payor[$j]);
$ck_amount2=$ck_amount[$j];
$ck_amount2=str_replace(",","",$ck_amount2);
$ck_amount2=str_replace("$","",$ck_amount2);
$description2=addslashes($description[$j]);

	$query2.=" orms_deposit_id='$orms_deposit_id',";
	$query2.=" controllers_deposit_id='$controllers_next',";
	$query2.=" bank_deposit_date='$bank_deposit_date',";
	$query2.=" system_entry_date='$system_entry_date',";
	$query2.=" f_year='$f_year',";
	$query2.=" checknum='$checknum2',";
	$query2.=" payor='$payor2',";
	$query2.=" amount='$ck_amount2',";
	$query2.=" cashier='$tempid',";
	$query2.=" description='$description2'";
			

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}

*/

	
//echo "orms_deposit_id=$orms_deposit_id<br />";
//echo "controllers_deposit_id=$controllers_next<br />";
//echo "bank_deposit_date=$bank_deposit_date<br />";


$query3="update crs_tdrr_division_deposits
         set fs_approver='$fs_approver',fs_approver_date='$system_entry_date'
		 where orms_deposit_id='$orms_deposit_id' ; ";
		 
//echo "query3=$query3";exit;

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update crs_tdrr_division_deposits
         set record_complete='y'
		 where orms_deposit_id='$orms_deposit_id'
		 and orms_depositor != ''
		 and cashier != ''
		 and manager != ''
		 and fs_approver != ''
		 ; ";
		 
//echo "query4=$query4";exit;

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



//echo "ok";exit;
/*
$query4="select id 
         from crs_tdrr_division_deposits
         where controllers_deposit_id='$controllers_next'		 ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);

//echo "id=$id<br />"; exit;



$doc_mod=$document;

$document=$source_table."_".$id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query5="update crs_tdrr_division_deposits set document_location='$target'
where id='$id' ";
mysqli_query($connection, $query5) or die ("Error updating Database $query5");

*/
//echo "update successful";
}

{header("location: crs_deposits_crj_reports_final.php?deposit_id=$orms_deposit_id&GC=n");}



?>