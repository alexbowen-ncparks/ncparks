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

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

/*

$rc_total=array_sum($rc_amount);
*/


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

/*
$query11a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");
		  
$row11a=mysqli_fetch_array($result11a);

extract($row11a);

if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  



if($cashier_count==1)
{

$checknum0=$checknum[0]; //echo "checknum0=$checknum0<br />";
$payor0=$payor[0]; //echo "payor0=$payor0<br />";
$payor_bank0=$payor_bank[0]; //echo "payor0=$payor0<br />";
//echo "payor_bank0=$payor_bank0<br />";exit;
$ck_amount0=$ck_amount[0]; //echo "ck_amount0=$ck_amount0<br />";
$description0=$description[0]; //echo "description0=$description0<br />";

$ck_count=count($checknum); //echo "ck_count=$ck_count<br />";//exit;



$source_table="crs_tdrr_division_deposits";



if($rcf=='y')//{echo "rcf=y";}else {echo "rcf not equal y";} exit;
{echo "Contact Tony P Bass";exit;}


$query11a1="select cashier,controllers_deposit_id from crs_tdrr_division_deposits
            where orms_deposit_id='$orms_deposit_id' ";	 

$result11a1 = mysqli_query($connection, $query11a1) or die ("Couldn't execute query 11a1.  $query11a1");
		  
$row11a1=mysqli_fetch_array($result11a1);

extract($row11a1);

if($controllers_deposit_id != '')
{

$cashier2=substr($cashier,0,-4);

echo "<font color='brown' size='5'><b>Oops! Cashier Form for Bank Deposit# $controllers_deposit_id already completed by $cashier2 </b></font><br />";exit;
}

if($bank_deposit_date==""){echo "<font color='brown' size='5'><b>Bank Deposit Date Missing<br /><br />Click the BACK button on your Browser to enter Bank Deposit Date</b></font><br />";exit;}

define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];

$document_format2=substr($document, -3);

if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}

if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

if($format_ok=='n'){echo "<font color='brown' size='5'><b>Filetype is NOT in JPG Format. Please Upload a JPG File. <br /><br />Please hit back button on Browser to Upload JPG File</b></font>";exit;}



if($checks=='yes' and $checknum0==''){echo "<font color='brown' size='5'><b> Please fill out check listing</b></font>";exit;}



if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval missing<br /><br />Click the BACK button on your Browser to enter Cashier Approval</b></font><br />";exit;}





$entered_by=$tempid;

$cashier=$entered_by;








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


if($current_fyear_count == 0){$controllers_next=$first_fyear_deposit;}


if($current_fyear_count != 0)

{
$query11b="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$concession_location'
and f_year='$current_fyear' ";




$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b");
$row11b=mysqli_fetch_array($result11b);
extract($row11b);

$controllers_next=$controllers_max+1;



}

*/
echo "record_count=$record_count<br />";//exit;
echo "parkcode=$parkcode<br />";
if($cashier_approved=='y')
{
$query1="update cash_imprest_location_counts  SET";
for($j=0;$j<$record_count;$j++){
$query2=$query1;

$system_entry_date=date("Ymd");
$cashier=$tempid;
$cashier_amount2=$cashier_amount[$j];
$cashier_amount2=str_replace(",","",$cashier_amount2);
$cashier_amount2=str_replace("$","",$cashier_amount2);
$query2.=" cashier_amount='$cashier_amount2',";
	$query2.=" cashier='$cashier',";
	$query2.=" cashier_date='$system_entry_date' ";
	$query2.=" where id='$id[$j]' ";
//echo "query2=$query2<br />";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}

$query3="select sum(cashier_amount) as 'cashier_amount_total'
from cash_imprest_location_counts
where fyear='$fyear'
and cash_month='$cash_month'
and park='$concession_location'  ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
echo "query3=$query3<br />";
$row3=mysqli_fetch_array($result3);
extract($row3);

$query4="update cash_imprest_count_detail
         set cashier='$cashier',cashier_amount='$cashier_amount_total',cashier_date='$system_entry_date'
		 where park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");		 
		 
echo "query4=$query4<br />";		 
}



if($manager_approved=='y')
{
$query1="update cash_imprest_location_counts  SET";
for($j=0;$j<$record_count;$j++){
$query2=$query1;

$system_entry_date=date("Ymd");
$manager=$tempid;
$manager_amount2=$manager_amount[$j];
$manager_amount2=str_replace(",","",$manager_amount2);
$manager_amount2=str_replace("$","",$manager_amount2);
$query2.=" manager_amount='$manager_amount2',";
	$query2.=" manager='$manager',";
	$query2.=" manager_date='$system_entry_date' ";
	$query2.=" where id='$id[$j]' ";
//echo "query2=$query2<br />";
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}

$query3="select sum(manager_amount) as 'manager_amount_total'
from cash_imprest_location_counts
where fyear='$fyear'
and cash_month='$cash_month'
and park='$concession_location'  ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);

$query4="update cash_imprest_count_detail
         set manager='$manager',manager_amount='$manager_amount_total',manager_date='$system_entry_date'
		 where park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");	

       

}


$query4aa="update cash_imprest_count_detail,cash_imprest_authorized
           set cash_imprest_count_detail.authorized_amount=cash_imprest_authorized.grand_total
		   where cash_imprest_count_detail.park=cash_imprest_authorized.park
		   and cash_imprest_count_detail.fyear=cash_imprest_authorized.fyear         
           and cash_imprest_count_detail. park='$concession_location'
		   and cash_imprest_count_detail.fyear='$fyear' 
		   and cash_imprest_count_detail.cash_month='$cash_month'  ";
		   
		   
//echo "query4aa=$query4aa<br />";exit;		   
		 
//$result4aa = mysqli_query($connection, $query4aa) or die ("Couldn't execute query 4aa.  $query4aa");	



$query4a="update cash_imprest_count_detail
          set player_match='n',score='0.00',player_match_amount='0.00',player_match_date='0000-00-00'
          where park='$concession_location' and fyear='$fyear' and cash_month='$cash_month'  ";
		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");	

//echo "query4a=$query4a<br />";exit;	

$query5="update cash_imprest_count_detail
         set player_match='y',player_match_date='$system_entry_date',player_match_amount='$manager_amount_total'
		 where cashier != '' and manager != '' and cashier_amount != '0' and manager_amount != '0' and cashier_amount=manager_amount
		 and park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
	 
		 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");


$query5a="update cash_imprest_count_detail
         set authorized_match='y'
		 where cashier != '' and manager != '' and cashier_amount != '0' and manager_amount != '0'
		 and cashier_amount=manager_amount
		 and cashier_amount=authorized_amount
		 and park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
	 
//echo "query5a=$query5a<br />";exit;		 
$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");









$query6="select player_match_date from cash_imprest_count_detail
         where park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$row6=mysqli_fetch_array($result6);
extract($row6);

echo "player_match_date=$player_match_date<br />";

if($player_match_date=='0000-00-00'){$score='0.00';}

if($player_match_date != '0000-00-00')

{
$query7="select score from cash_imprest_count_scoring
         where fyear='$fyear' and cash_month='$cash_month' and start_date <= '$player_match_date'
		 and end_date >= '$player_match_date' ";

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


$row7=mysqli_fetch_array($result7);
extract($row7);

if($score==''){$score='50.00';}


}
$query8="update cash_imprest_count_detail
         set score='$score'
         where park='$concession_location' and fyear='$fyear' and cash_month='$cash_month' ";
		 
		 
$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");		

$query8a = "SELECT sum(score)/count(id) as 'mission_score'
from cash_imprest_count_detail
WHERE 1
and fyear='$fyear'
and valid='y'
and park='$concession_location' ";

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");


$row8a=mysqli_fetch_array($result8a);
extract($row8a);




$query9="update mission_scores
         set percomp='$mission_score'
         where playstation='$concession_location' and gid='10' ";
		 
		 
$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

echo "query8=$query8<br />";

echo "update successful<br />";




/*		 
$query3="update crs_tdrr_division_deposits
         set controllers_deposit_id='$controllers_next',
		 bank_deposit_date='$bank_deposit_date',
		 cashier='$tempid',
		 cashier_date='$system_entry_date'
		 where orms_deposit_id='$orms_deposit_id' ; ";		 
		 
		 


mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");




$query4="select id 
         from crs_tdrr_division_deposits
         where controllers_deposit_id='$controllers_next'
         and f_year='$current_fyear'  ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);




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



}
*/
{header("location: cash_imprest_count2.php ");}



?>