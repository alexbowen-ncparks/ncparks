<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_L3=substr($concession_center,-3);
$first_fyear_deposit=$concession_center_L3.'001';
//echo "concession_center_L3=$concession_center_L3<br />";//exit;
//echo "first_fyear_deposit=$first_fyear_deposit";//exit;


extract($_REQUEST);
$rc_total=array_sum($rc_amount);

// echo "rc_total=$rc_total<br />";//exit;
 
//echo "orms_deposit_id=$orms_deposit_id";exit;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "tempid=$tempid<br />"; exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

/*
if($tempid=='Buck4707')
{
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<br /><br />";
echo "<pre>";print_r($_REQUEST);"</pre>"; 
echo "bank_deposit_date=$bank_deposit_date<br /><br />";
exit;
}
*/

//{echo "Cain4311"; exit;}
/*
else
{
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
}
*/

//echo "cashier_overshort_comment=$cashier_overshort_comment<br />"; exit;

/*
if($beacnum=='60032931')
{
echo "<pre>";print_r($_SESSION);"</pre>";
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
}
*/

//echo "concession_location=$concession_location";
//exit;
//echo "tempid=$tempid<br />";
//echo "concession_location=$concession_location<br />";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "tempid=$tempid<br /><br />"; exit;
/*
if($tempid=='Cain4311')
{
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<br /><br />";
echo "<pre>";print_r($_REQUEST);"</pre>"; 
echo "bank_deposit_date=$bank_deposit_date<br /><br />";
//exit;
}
*/

//include("../budget/~f_year.php");
//include("../../../budget/~f_year.php");

//$f_year='1314';

// Lines 92 thru 110 below. This Step is not necessary for Park OA's, but it is necessary when the District OA is backing up the Park OA
// Query below determines the correct Park and Center based on the orms_deposit_id  
// This allows the correct $concession_location and $concession_center to be used for this PHP File
// 60032931=wedi oa julie bunn   60032892=eadi oa sherry quinn  6003-3093 =sodi OA Val Mitchener  6003-3148=nodi OA VACANT 
// 6003-3199=nodi ACTING OA Cara Hadfield

if($beacnum=='60032931' or $beacnum=='60032892' or $beacnum=='60033093' or $beacnum=='60033148' or $beacnum=='60033199')
{
$query1="SELECT park,center from crs_tdrr_division_deposits
         where orms_deposit_id='$orms_deposit_id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$concession_location=$park;
$concession_center=$center;


//echo "query1=$query1<br />concession_location=$concession_location<br />concession_center=$concession_center<br />tempid=$tempid"; exit;

}




$query11a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysqli_fetch_array($result11a);

extract($row11a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  
//echo "query11a=$query11a<br />";//exit;
//echo "cashier_count=$cashier_count<br />";//exit;
//echo "cashier_first=$cashier_first<br />";//exit;
//echo "cashier_last=$cashier_last<br />"; exit;


if($cashier_count==1)
{

$checknum0=$checknum[0]; //echo "checknum0=$checknum0<br />";
$payor0=$payor[0]; //echo "payor0=$payor0<br />";
$payor_bank0=$payor_bank[0]; //echo "payor0=$payor0<br />";
//echo "payor_bank0=$payor_bank0<br />";exit;
$ck_amount0=$ck_amount[0]; //echo "ck_amount0=$ck_amount0<br />";
$description0=$description[0]; //echo "description0=$description0<br />";

$ck_count=count($checknum); //echo "ck_count=$ck_count<br />"; exit;

//echo "rcf_amount=$rcf_amount<br />";//exit;
//echo "rc_total=$rc_total<br />";//exit;
//if($rcf_amount==$rc_total){echo "rcf_amount=rc_total";} else {echo "out of balance";}
//exit;

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


if($rcf=='y')//{echo "rcf=y";}else {echo "rcf not equal y";} exit;
{echo "Contact Tony P Bass";exit;}

/*
{
if($rc_total != $rcf_amount)
{echo "<font color='brown' size='5'><b>Reimbursement Allocation does not equal $rcf_amount<br /><br />Click the BACK button on your Browser to re-enter info on form</b></font><br />";exit;}
}
*/
$query11a1="select cashier,controllers_deposit_id,checks as 'check_verify' from crs_tdrr_division_deposits
            where orms_deposit_id='$orms_deposit_id' ";	 

$result11a1 = mysqli_query($connection, $query11a1) or die ("Couldn't execute query 11a1.  $query11a1");
		  
$row11a1=mysqli_fetch_array($result11a1);

extract($row11a1);



$query11a2="select sum(amount) as 'over_short_amount' from crs_tdrr_division_history_parks
            where deposit_id='$orms_deposit_id'
            and ncas_account='000437995'";	 
			
			
//echo "query11a2=$query11a2<br />";			

$result11a2 = mysqli_query($connection, $query11a2) or die ("Couldn't execute query 11a2.  $query11a2");
		  
$row11a2=mysqli_fetch_array($result11a2);

extract($row11a2);

if($over_short_amount==''){$over_short_amount='0';}

//echo "over_short_amount=$over_short_amount"; exit;


if($controllers_deposit_id != '')
{

$cashier2=substr($cashier,0,-4);


echo "<font color='brown' size='5'><b>Oops! Cashier Form for Bank Deposit# $controllers_deposit_id already completed by $cashier2 </b></font><br />";exit;
}
/*
if($tempid=='Cain4311' or $tempid=='Howell4351')
{

if($bank_deposit_date!="")
{
echo "Line number 212: bank_deposit_date=$bank_deposit_date<br /><br />";
exit;
}
if($bank_deposit_date=="")
{
echo "Line number 217 No Bank Deposit Date"; exit;

}
}
*/

/*
else
{
echo "Line number 207: bank_deposit_date=$bank_deposit_date<br /><br />";
exit;

}
*/

if($bank_deposit_date==""){echo "<font color='brown' size='5'><b>Bank Deposit Date Missing<br /><br />Click the BACK button on your Browser to enter Bank Deposit Date</b></font><br />";exit;}

define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];
//echo "document=$document<br />";
$document_format2=substr($document, -3);
//echo "document_format2=$document_format2<br />";
if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
//echo "format_ok=$format_ok";
//exit;


if($cashier_overshort_comment=='' and ($over_short_amount <= -10.00 or $over_short_amount >= 10.00))
{
echo "<font color='brown' size='5'><b>Cashier Comment missing<br /><br />Click the BACK button on your Browser to enter Cashier Comment</b></font><br />";exit;
}


if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

if($format_ok=='n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>";exit;}



if($checks=='yes' and $checknum0=='' and $crs_park != 'no'){echo "<font color='brown' size='5'><b> Please fill out check listing</b></font>";exit;}



if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval missing<br /><br />Click the BACK button on your Browser to enter Cashier Approval</b></font><br />";exit;}

//if($manager_approved==""){echo "<font color='brown' size='5'><b>Manager Approval missing. <br /> Click the BACK button on your Browser to enter Manager Approval</b></font><br />";exit;}



$entered_by=$tempid;

$cashier=$entered_by;

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



$query11a2="SELECT f_year as 'current_fyear' from crs_tdrr_division_deposits
            where orms_deposit_id='$orms_deposit_id' ";
		 
 

$result11a2 = mysqli_query($connection, $query11a2) or die ("Couldn't execute query 11a2.  $query11a2");

$row11a2=mysqli_fetch_array($result11a2);
extract($row11a2);


$query11a3="SELECT count(f_year) as 'current_fyear_count' from crs_tdrr_division_deposits
            where park='$concession_location' and f_year='$current_fyear' and cashier != '' ";
		 
	 

$result11a3 = mysqli_query($connection, $query11a3) or die ("Couldn't execute query 11a3.  $query11a3");

$row11a3=mysqli_fetch_array($result11a3);
extract($row11a3);

//echo "<br />current_fyear_count=$current_fyear_count";

if($current_fyear_count == 0){$controllers_next=$first_fyear_deposit;}

//echo "<br />controllers_next=$controllers_next";//exit;

if($current_fyear_count != 0)

{
$query11b="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$concession_location'
and f_year='$current_fyear' ";


//echo "query2=$query2<br />";

$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");
$row11b=mysqli_fetch_array($result11b);
extract($row11b);

$controllers_next=$controllers_max+1;



}

//if($tempid=='Buck4707'){$controllers_next='809021' ;}
//if($tempid=='Sponaugle7857' or $tempid=='Bernhardt3627'){$controllers_next='836029' ;}  //sila
//if($tempid=='Sanford5534'){$controllers_next='868033' ;} //disw
//if($tempid=='Johnson3846' or $tempid=='Phillips6792'){$controllers_next='820028' ;} //chro
//if($tempid=='Fox7680' or $tempid=='Summerlin2658'){$controllers_next='818020' ;} //mari
//if($tempid=='George0267' or $tempid=='Coffman4471' or $tempid=='Barnes5511'){$controllers_next='812012' ;} //jori
//if($tempid=='Moraleda8906' or $tempid=='Taylor2194'){$controllers_next='808094' ;} //fofi
//if($tempid=='May4884' or $tempid=='Weaver8871'){$controllers_next='547007' ;} //moje
//if($tempid=='Myers0564' or $tempid=='Vass6841'){$controllers_next='817067' ;} //hari
//if($tempid=='Harrison8693'){$controllers_next='867031' ;} //elkn

//echo "<br />controllers_next=$controllers_next";exit;
//echo "<br />Line 364: crs_park=$crs_park<br />"; //exit;
//echo "<br />ck_count=$ck_count<br />"; exit;
if($crs_park != 'no')
{
$query1="insert into crs_tdrr_division_deposits_checklist  SET";
for($j=0;$j<$ck_count;$j++){
$query2=$query1;
//$checknum2=addslashes($checknum[$j]);
$checknum2=($checknum[$j]);
//if($checknum2==''){continue;}
//$payor2=addslashes($payor[$j]);
$payor2=($payor[$j]);
//$payor_bank2=addslashes($payor_bank[$j]);
$payor_bank2=($payor_bank[$j]);
$ck_amount2=$ck_amount[$j];
$ck_amount2=str_replace(",","",$ck_amount2);
$ck_amount2=str_replace("$","",$ck_amount2);
//$description2=addslashes($description[$j]);
$description2=($description[$j]);

if($checknum2=='' and $payor2=='' and $payor_bank2=='' and $ck_amount2=='' and $description2==''){continue;}


	$query2.=" orms_deposit_id='$orms_deposit_id',";
	$query2.=" controllers_deposit_id='$controllers_next',";
	$query2.=" bank_deposit_date='$bank_deposit_date',";
	$query2.=" system_entry_date='$system_entry_date',";
	$query2.=" f_year='$current_fyear',";
	$query2.=" checknum='$checknum2',";
	$query2.=" payor='$payor2',";
	$query2.=" payor_bank='$payor_bank2',";
	$query2.=" amount='$ck_amount2',";
	$query2.=" cashier='$tempid',";
	$query2.=" description='$description2'";
			
//echo "<br />query2=$query2<br />"; exit;
$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}
}

	
//echo "orms_deposit_id=$orms_deposit_id<br />";
//echo "controllers_deposit_id=$controllers_next<br />";
//echo "bank_deposit_date=$bank_deposit_date<br />";

/*
changed below on 6/22/14
$query3="update crs_tdrr_division_deposits
         set controllers_deposit_id='$controllers_next',
		 bank_deposit_date='$bank_deposit_date',
		 f_year='$f_year',
		 cashier='$tempid',
		 cashier_date='$system_entry_date'
		 where orms_deposit_id='$orms_deposit_id' ; ";
*/		 

$cashier_overshort_comment2=addslashes($cashier_overshort_comment);

//echo "cashier_overshort_comment=$cashier_overshort_comment<br />";	
//echo "cashier_overshort_comment2=$cashier_overshort_comment2<br />"; exit;


	 
$query3="update crs_tdrr_division_deposits
         set controllers_deposit_id='$controllers_next',
		 bank_deposit_date='$bank_deposit_date',
		 cashier='$tempid',
		 cashier_date='$system_entry_date',
		 cashier_overshort_comment='$cashier_overshort_comment2'
		 where orms_deposit_id='$orms_deposit_id' ; ";		 
		 
		 
//echo "query3=$query3";exit;

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


//echo "ok";exit;

$query4="select id 
         from crs_tdrr_division_deposits
         where controllers_deposit_id='$controllers_next'
         and f_year='$current_fyear'  ; ";

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



if($check_verify=='y')
{
$query6="select count(orms_deposit_id) as 'total_check_records'
from crs_tdrr_division_deposits_checklist
where orms_deposit_id='$orms_deposit_id' " ;	
	

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
		  
$row6=mysqli_fetch_array($result6);

extract($row6);

$query7="select count(orms_deposit_id) as 'completed_check_records'
from crs_tdrr_division_deposits_checklist
where orms_deposit_id='$orms_deposit_id'
and checknum != ''
and payor != ''
and payor_bank != ''
and amount != ''
and description != '' " ;

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");
		  
$row7=mysqli_fetch_array($result7);

extract($row7);


if($completed_check_records != $total_check_records){echo "<table align='center'><tr><td><font color='brown' size='5'>CHECK INFO is Missing <a href='check_listing.php?id=$id&edit=y' target='_blank'>Edit Check Listing</a></font></td></tr></table>"; exit;}
if($completed_check_records == $total_check_records)
{
header("location: crs_deposits_crj_reports_final.php?deposit_id=$orms_deposit_id&GC=n");	
}

	
}

if($check_verify!='y')
{
{header("location: crs_deposits_crj_reports_final.php?deposit_id=$orms_deposit_id&GC=n");}
}
//echo "update successful";
}





//{header("location: crs_deposits_crj_reports_final.php?deposit_id=$orms_deposit_id&GC=n");}



?>