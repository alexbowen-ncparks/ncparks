<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$system_entry_date=date("Ymd");




$query1="update fuel_tank_usage_detail SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;
//$checknum2=addslashes($checknum[$j]);
//if($checknum2==''){continue;}
$driver_name2=addslashes($driver_name[$j]);
//$payor_bank2=addslashes($payor_bank[$j]);
//$description2=addslashes($description[$j]);
//$amount2=$amount[$j];
//$amount2=str_replace(",","",$amount2);
//$amount2=str_replace("$","",$amount2);
	$query2.=" usage_day='$dayofmonth[$j]',";
	$query2.=" tag_num='$taglist[$j]',";
	//$query2.=" vehicle_num='$vehicle_num[$j]',";
	$query2.=" gallons='$gallons[$j]',";
	$query2.=" driver_name='$driver_name2'";
	$query2.=" where id='$id[$j]'";
		

$result=mysql_query($query2) or die ("Couldn't execute query 2. $query2");
}	
$query3="delete from fuel_tank_usage_detail
         where tag_num='' and gallons='0.00' and driver_name=''
         and park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month'		 ";
$result3=mysql_query($query3) or die ("Couldn't execute query 3. $query3");



$query4="update fuel_tank_usage_detail,center
         set fuel_tank_usage_detail.center=center.center
		 where fuel_tank_usage_detail.park=center.parkcode
		 and fuel_tank_usage_detail.park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month'	
          ";
$result4=mysql_query($query4) or die ("Couldn't execute query 4. $query4");

if($cash_month=='july'){$cash_month_number='01';$cash_month_number2='07';}
if($cash_month=='august'){$cash_month_number='02';$cash_month_number2='08';}
if($cash_month=='september'){$cash_month_number='03';$cash_month_number2='09';}
if($cash_month=='october'){$cash_month_number='04';$cash_month_number2='10';}
if($cash_month=='november'){$cash_month_number='05';$cash_month_number2='11';}
if($cash_month=='december'){$cash_month_number='06';$cash_month_number2='12';}
if($cash_month=='january'){$cash_month_number='07';$cash_month_number2='01';}
if($cash_month=='february'){$cash_month_number='08';$cash_month_number2='02';}
if($cash_month=='march'){$cash_month_number='09';$cash_month_number2='03';}
if($cash_month=='april'){$cash_month_number='10';$cash_month_number2='04';}
if($cash_month=='may'){$cash_month_number='11';$cash_month_number2='05';}
if($cash_month=='june'){$cash_month_number='12';$cash_month_number2='06';}


$query5="update budget.fuel_tank_usage_detail
         set cash_month_number='$cash_month_number',cash_month_number2='$cash_month_number2'
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month'	
          ";
		  
		  
//echo "query5=$query5<br />"; exit;


		  
$result5=mysql_query($query5) or die ("Couldn't execute query 5. $query5");



$query6="update budget.fuel_tank_usage_detail,fuel.mfm
         set budget.fuel_tank_usage_detail.vehicle_num=fuel.mfm.vehicle,
		 budget.fuel_tank_usage_detail.vehicle_location=fuel.mfm.park_or_section
		 where budget.fuel_tank_usage_detail.tag_num=fuel.mfm.license_plate
		 and budget.fuel_tank_usage_detail.park='$parkcode' and budget.fuel_tank_usage_detail.cash_month_calyear='$cash_month_calyear'
		 and budget.fuel_tank_usage_detail.cash_month='$cash_month'	
          ";
		  
		  
//echo "query6=$query6<br />"; exit;
		  
$result6=mysql_query($query6) or die ("Couldn't execute query 6. $query6");




$query6a="update budget.fuel_tank_usage_detail
         set budget.fuel_tank_usage_detail.vehicle_num='65933'
		 where budget.fuel_tank_usage_detail.tag_num='pk4396'
		 and budget.fuel_tank_usage_detail.park='$parkcode' and budget.fuel_tank_usage_detail.cash_month_calyear='$cash_month_calyear'
		 and budget.fuel_tank_usage_detail.cash_month='$cash_month'	
          ";
		  
		  
//echo "query6=$query6<br />"; exit;
		  
$result6a=mysql_query($query6a) or die ("Couldn't execute query 6a. $query6a");



$query6b="update budget.fuel_tank_usage_detail
         set budget.fuel_tank_usage_detail.vehicle_num='220267'
		 where budget.fuel_tank_usage_detail.tag_num='pj8274'
		 and budget.fuel_tank_usage_detail.park='$parkcode' and budget.fuel_tank_usage_detail.cash_month_calyear='$cash_month_calyear'
		 and budget.fuel_tank_usage_detail.cash_month='$cash_month'	
          ";
		  
		  
//echo "query6=$query6<br />"; exit;
		  
$result6b=mysql_query($query6b) or die ("Couldn't execute query 6b. $query6b");











$query7="update budget.fuel_tank_usage_detail
      	 set usage_date=concat(mid(cash_month_calyear,1,4),mid(cash_month_number2,1,2),mid(usage_day,1,2))
		 where budget.fuel_tank_usage_detail.park='$parkcode' and budget.fuel_tank_usage_detail.cash_month_calyear='$cash_month_calyear'
		 and budget.fuel_tank_usage_detail.cash_month='$cash_month'	
          ";
		  
		  
//echo "query7=$query7<br />"; exit;



		  
$result7=mysql_query($query7) or die ("Couldn't execute query 7. $query7");



$query8="update budget.fuel_tank_usage_detail
      	 set budget.fuel_tank_usage_detail.cashier='$tempid',budget.fuel_tank_usage_detail.cashier_date='$system_entry_date'
		 where budget.fuel_tank_usage_detail.park='$parkcode' and budget.fuel_tank_usage_detail.cash_month_calyear='$cash_month_calyear'
		 and budget.fuel_tank_usage_detail.cash_month='$cash_month'	
          ";
		  
		  
//echo "query8=$query8<br />"; exit;



		  
$result8=mysql_query($query8) or die ("Couldn't execute query 8. $query8");



$query9="select sum(gallons) as 'gallons_total'
          from budget.fuel_tank_usage_detail
		  where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' ";	 

$result9 = mysql_query($query9) or die ("Couldn't execute query 9.  $query9");
		  
$row9=mysql_fetch_array($result9);

extract($row9);


$query10="update budget.fuel_tank_usage
         set reimbursement_gallons='$gallons_total'   
		 where park='$parkcode' and cash_month_calyear='$cash_month_calyear' and cash_month='$cash_month' ";	 

$result10 = mysql_query($query10) or die ("Couldn't execute query 10.  $query10");


//echo "Update Successful<br />"; exit;



header("location: page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear");


 
 ?>




















