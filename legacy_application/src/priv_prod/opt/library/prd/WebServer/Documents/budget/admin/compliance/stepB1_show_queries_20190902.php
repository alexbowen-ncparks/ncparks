<?php
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
if($compliance_month==''){echo "compliance_month missing"; exit;}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//$status='complete';

$compliance_calyear1='20'.substr($compliance_fyear,0,2);
$compliance_calyear2='20'.substr($compliance_fyear,2,2);

$compliance_fyear_prior=(substr($compliance_fyear,0,2)-1).(substr($compliance_fyear,2,2)-1);



echo "<br />compliance_calyear1=$compliance_calyear1<br />";
echo "<br />compliance_calyear2=$compliance_calyear2<br />";
echo "<br />compliance_fyear_prior=$compliance_fyear_prior<br />";

//exit;




///compliance_month=july
if($compliance_month=='july'){$compliance_month_prior='june'; $compliance_month_number='1'; $compliance_month_prior_number='12';}
if($compliance_month=='july'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}

     //added 2/20/18

if($compliance_month=='july'){$compliance_month_prior2='may'; $compliance_month_prior2_number='11';}
if($compliance_month=='july'){$compliance_month_prior2_calyear=$compliance_calyear2;}



///compliance_month=august
if($compliance_month=='august'){$compliance_month_prior='july'; $compliance_month_number='2'; $compliance_month_prior_number='1';}
if($compliance_month=='august'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}

     //added 2/20/18

if($compliance_month=='august'){$compliance_month_prior2='june';  $compliance_month_prior2_number='12';}
if($compliance_month=='august'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=september
if($compliance_month=='september'){$compliance_month_prior='august'; $compliance_month_number='3'; $compliance_month_prior_number='2';}
if($compliance_month=='september'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}


     //added 2/20/18

if($compliance_month=='september'){$compliance_month_prior2='july';  $compliance_month_prior2_number='1';}
if($compliance_month=='september'){$compliance_month_prior2_calyear=$compliance_calyear2;}



///compliance_month=october
if($compliance_month=='october'){$compliance_month_prior='september'; $compliance_month_number='4'; $compliance_month_prior_number='3';}
if($compliance_month=='october'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}


     //added 2/20/18

if($compliance_month=='october'){$compliance_month_prior2='august';  $compliance_month_prior2_number='2';}
if($compliance_month=='october'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=november
if($compliance_month=='november'){$compliance_month_prior='october'; $compliance_month_number='5'; $compliance_month_prior_number='4';}
if($compliance_month=='november'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}


     //added 2/20/18

if($compliance_month=='november'){$compliance_month_prior2='september';  $compliance_month_prior2_number='3';}
if($compliance_month=='november'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=december
if($compliance_month=='december'){$compliance_month_prior='november'; $compliance_month_number='6'; $compliance_month_prior_number='5';}
if($compliance_month=='december'){$compliance_month_calyear=$compliance_calyear1; $compliance_month_prior_calyear=$compliance_calyear2;}


     //added 2/20/18

if($compliance_month=='december'){$compliance_month_prior2='october';  $compliance_month_prior2_number='4';}
if($compliance_month=='december'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=january
if($compliance_month=='january'){$compliance_month_prior='december'; $compliance_month_number='7'; $compliance_month_prior_number='6';}
if($compliance_month=='january'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear1;}


     //added 2/20/18

if($compliance_month=='january'){$compliance_month_prior2='november';  $compliance_month_prior2_number='5';}
if($compliance_month=='january'){$compliance_month_prior2_calyear=$compliance_calyear1;}

///compliance_month=february
if($compliance_month=='february'){$compliance_month_prior='january'; $compliance_month_number='8'; $compliance_month_prior_number='7';}
if($compliance_month=='february'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear2;}


     //added 2/20/18

if($compliance_month=='february'){$compliance_month_prior2='december';  $compliance_month_prior2_number='6';}
if($compliance_month=='february'){$compliance_month_prior2_calyear=$compliance_calyear1;}


///compliance_month=march
if($compliance_month=='march'){$compliance_month_prior='february'; $compliance_month_number='9'; $compliance_month_prior_number='8';}
if($compliance_month=='march'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear2;}


    //added 2/20/18

if($compliance_month=='march'){$compliance_month_prior2='january';  $compliance_month_prior2_number='7';}
if($compliance_month=='march'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=april
if($compliance_month=='april'){$compliance_month_prior='march'; $compliance_month_number='10'; $compliance_month_prior_number='9';}
if($compliance_month=='april'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear2;}


    //added 2/20/18

if($compliance_month=='april'){$compliance_month_prior2='february';  $compliance_month_prior2_number='8';}
if($compliance_month=='april'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=may
if($compliance_month=='may'){$compliance_month_prior='april'; $compliance_month_number='11'; $compliance_month_prior_number='10';}
if($compliance_month=='may'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear2;}

    //added 2/20/18

if($compliance_month=='may'){$compliance_month_prior2='march';  $compliance_month_prior2_number='9';}
if($compliance_month=='may'){$compliance_month_prior2_calyear=$compliance_calyear2;}


///compliance_month=june
if($compliance_month=='june'){$compliance_month_prior='may'; $compliance_month_number='12'; $compliance_month_prior_number='11';}
if($compliance_month=='june'){$compliance_month_calyear=$compliance_calyear2; $compliance_month_prior_calyear=$compliance_calyear2;}


    //added 2/20/18

if($compliance_month=='june'){$compliance_month_prior2='april';  $compliance_month_prior2_number='10';}
if($compliance_month=='june'){$compliance_month_prior2_calyear=$compliance_calyear2;}




echo "<br />compliance_fyear=$compliance_fyear<br />";
echo "<br />compliance_month=$compliance_month<br />";
echo "<br />compliance_month_number=$compliance_month_number<br />";
echo "<br />compliance_month_calyear=$compliance_month_calyear<br />";
echo "<br />compliance_month_prior=$compliance_month_prior<br />";
echo "<br />compliance_month_prior_number=$compliance_month_prior_number<br />";
echo "<br />compliance_month_prior_calyear=$compliance_month_prior_calyear<br />";

    //added 2/20/18

echo "<br />compliance_month_prior2=$compliance_month_prior2<br />";
echo "<br />compliance_month_prior2_number=$compliance_month_prior2_number<br />";
echo "<br />compliance_month_prior2_calyear=$compliance_month_prior2_calyear<br />";	
	
	
	

//exit;






//Queries to update TABLES for "Cash Imprest Count" TASK (gid10)
//TABLES:  1) cash_imprest_counts  2)cash_imprest_count_detail  


$query30="insert into cash_imprest_location_counts(location_id,park,center,location,fyear,cash_month,cash_month_number,cash_month_calyear)
          select id,park,center,sales_location,'$compliance_fyear','$compliance_month','$compliance_month_number','$compliance_month_calyear'
		  from cash_imprest_worksheet where valid='y' " ;
		  
echo "<br />query30=$query30<br />";		  
////mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");


$query31="insert into cash_imprest_count_detail(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month','$compliance_month_number','$compliance_month_calyear'
		  from center where fund='1280' and actcenteryn='y' and stateparkyn='y'  " ;

echo "<br />query31=$query31<br />";		  
////mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");
//exit;

$query32="update cash_imprest_count_detail set valid='y' where fyear='$compliance_fyear' and cash_month_number='$compliance_month_number' ";

echo "<br />query32=$query32<br />";
////mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");



//Queries to update TABLES for "PCI Compliance" TASK (gid16)
//TABLE:  1) concessions_pci_compliance  


$query33="insert into concessions_pci_compliance(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month','$compliance_month_number','$compliance_month_calyear'
          from center_taxes 
          where crs='y' ; ";

echo "<br />query33=$query33<br />";
////mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

//exit;

$query34="update concessions_pci_compliance set valid='y' where fyear='$compliance_fyear' and cash_month_number='$compliance_month_number'; ";

echo "<br />query34=$query34<br />";
////mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34");

//exit;

//Queries to update TABLES for "Park Fuel Usage" TASK (gid13)
//TABLE:  1) fuel_tank_usage  


	
if($compliance_month == 'july')
{
$query35="insert into fuel_tank_usage(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear_prior','$compliance_month_prior','$compliance_month_prior_number','$compliance_month_calyear'
          from center 
          where fuel_tank='y' ";

echo "<br />query35=$query35<br />";
//mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");	
}	


if($compliance_month == 'august' or $compliance_month == 'september' or $compliance_month == 'october' or $compliance_month == 'november' or $compliance_month == 'december' )
{
$query35="insert into fuel_tank_usage(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month_prior','$compliance_month_prior_number','$compliance_month_calyear'
          from center 
          where fuel_tank='y' ";

echo "<br />query35=$query35<br />";
//mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");	
}	


if($compliance_month == 'january')
{
$query35="insert into fuel_tank_usage(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month_prior','$compliance_month_prior_number','$compliance_month_prior_calyear'
          from center 
          where fuel_tank='y' ";

echo "<br />query35=$query35<br />";
//mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");	
}	



if($compliance_month == 'february' or $compliance_month == 'march' or $compliance_month == 'april' or $compliance_month == 'may' or $compliance_month == 'june')
{
$query35="insert into fuel_tank_usage(park,center,fyear,cash_month,cash_month_number,cash_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month_prior','$compliance_month_prior_number','$compliance_month_calyear'
          from center 
          where fuel_tank='y' ";

echo "<br />query35=$query35<br />";
//mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");	
}	


//exit;



if($compliance_month != 'july')
{
$query36="update fuel_tank_usage set valid='y' where fyear='$compliance_fyear' and cash_month_number='$compliance_month_prior_number'; ";

echo "<br />query36=$query36<br />";
//mysqli_query($connection, $query36) or die ("Couldn't execute query 36.  $query36");
}

if($compliance_month == 'july')
{
$query36="update fuel_tank_usage set valid='y' where fyear='$compliance_fyear_prior' and cash_month_number='$compliance_month_prior_number'; ";

echo "<br />query36=$query36<br />";
//mysqli_query($connection, $query36) or die ("Couldn't execute query 36.  $query36");
}

//exit;




//Queries to update TABLES for "WEX Fuel Card" TASK (gid18)
//TABLE:  1) wex_vehicle_compliance  




//SELECT distinct(center_code) FROM `wex_detail` WHERE `wex_fyear` LIKE '1718' AND `calyear` LIKE '2018' AND `month` LIKE 'january' ORDER BY `wex_detail`.`center_code` ASC

if($compliance_month == 'july' or $compliance_month == 'august')
{
$query35a="insert into wex_vehicle_compliance(park,center,wex_fyear,wex_month,wex_month_number,wex_month_calyear)
          select parkcode,new_center,'$compliance_fyear_prior','$compliance_month_prior2','$compliance_month_prior2_number','$compliance_calyear1'
          from center 
          where wex_active='y' ";

echo "<br />query35a=$query35a<br />";
//mysqli_query($connection, $query35a) or die ("Couldn't execute query 35a.  $query35a");	
}	


if($compliance_month == 'september' or $compliance_month == 'october' or $compliance_month == 'november' or $compliance_month == 'december' or $compliance_month == 'january' or $compliance_month == 'february')
{
$query35a="insert into wex_vehicle_compliance(park,center,wex_fyear,wex_month,wex_month_number,wex_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month_prior2','$compliance_month_prior2_number','$compliance_calyear1'
          from center 
          where wex_active='y' ";

echo "<br />query35a=$query35a<br />";
//mysqli_query($connection, $query35a) or die ("Couldn't execute query 35a.  $query35a");	
}	


if($compliance_month == 'march' or $compliance_month == 'april' or $compliance_month == 'may' or $compliance_month == 'june')
{
$query35a="insert into wex_vehicle_compliance(park,center,wex_fyear,wex_month,wex_month_number,wex_month_calyear)
          select parkcode,new_center,'$compliance_fyear','$compliance_month_prior2','$compliance_month_prior2_number','$compliance_calyear2'
          from center 
          where wex_active='y' ";

echo "<br />query35a=$query35a<br />";
//mysqli_query($connection, $query35a) or die ("Couldn't execute query 35a.  $query35a");	
}	




//exit;

	
if($compliance_month == 'july' or $compliance_month == 'august')
{
$query36a="update wex_vehicle_compliance 
          set valid='y' where wex_fyear='$compliance_fyear_prior' and wex_month_number='$compliance_month_prior2_number'; ";

echo "<br />query36a=$query36a<br />";
//mysqli_query($connection, $query36a) or die ("Couldn't execute query 36a.  $query36a");
}

//echo "<br />Line 328<br />"; exit;


if($compliance_month != 'july' and $compliance_month != 'august')
{
$query36a="update wex_vehicle_compliance set valid='y' where wex_fyear='$compliance_fyear' and wex_month_number='$compliance_month_prior2_number'; ";

echo "<br />query36a=$query36a<br />";
//mysqli_query($connection, $query36a) or die ("Couldn't execute query 36a.  $query36a");
}


exit;







$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

////echo "<br />query23a=$query23a<br />";


////echo "<br />Line 197: Update Successful<br />"; 



echo "<table align='center'><tr><td><a href='step_group.php?report_type=form&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month'>Return to Monthly Compliance Tasks</a></td></tr></table>";

//exit;



 ?>