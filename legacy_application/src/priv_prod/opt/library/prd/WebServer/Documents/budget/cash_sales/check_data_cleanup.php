<?php


//echo "<br />Hello Line 4: check_data_cleanup.php<br />"; exit;

// remove asterisk character (*) in Field=payor
$query2a="update crs_tdrr_division_deposits_checklist set payor=replace(payor,'*',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2a=$query2a<br />"; exit;


$result2a=mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a. $query2a");
 
// remove comma character (,) in Field=payor
$query2b="update crs_tdrr_division_deposits_checklist set payor=replace(payor,',',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2b=$query2b<br />"; exit;

$result2b=mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b. $query2b");
 
// remove apostrophe character (') in Field=payor
$query2c="update crs_tdrr_division_deposits_checklist set payor=replace(payor,'\'','') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2c=$query2c<br />"; exit;

$result2c=mysqli_query($connection, $query2c) or die ("Couldn't execute query 2c. $query2c");

/*
// remove Ampersand character (&) in Field=payor
$query2d="update crs_tdrr_division_deposits_checklist set payor=replace(payor,'&',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2d=$query2d<br />"; exit;

$result2d=mysqli_query($connection, $query2d) or die ("Couldn't execute query 2d. $query2d");
*/


 
// remove asterisk character (*) in Field=payor_bank
$query2e="update crs_tdrr_division_deposits_checklist set payor_bank=replace(payor_bank,'*',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2e=$query2e<br />"; exit;


$result2e=mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e. $query2e");

 
// remove comma character (,) in Field=payor_bank
$query2f="update crs_tdrr_division_deposits_checklist set payor_bank=replace(payor_bank,',',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2f=$query2f<br />"; exit;

$result2f=mysqli_query($connection, $query2f) or die ("Couldn't execute query 2f. $query2f");
 

// remove apostrophe character (') in Field=payor_bank
$query2g="update crs_tdrr_division_deposits_checklist set payor_bank=replace(payor_bank,'\'','') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2g=$query2g<br />"; exit;

$result2g=mysqli_query($connection, $query2g) or die ("Couldn't execute query 2g. $query2g"); 
 
 
// remove Ampersand character (&) in Field=payor_bank
/*
$query2h="update crs_tdrr_division_deposits_checklist set payor_bank=replace(payor_bank,'&',' ') where budget_office='y' and delrec='n' and bo_deposit_complete='n' ";

//echo "<br />query2h=$query2h<br />"; exit;

$result2h=mysqli_query($connection, $query2h) or die ("Couldn't execute query 2h. $query2h");
*/
 
// create Field=check_name (concatenation of Fields).  This Field is used in check drop-down when Heide enters form data for CRJ
$query2j="update crs_tdrr_division_deposits_checklist set check_name=concat('ck',checknum,'_',payor,'_',amount,'_',payor_bank,'_','id','*',id) where budget_office='y' and bo_deposit_complete='n' and delrec='n' ";

//echo "<br />query2j=$query2j<br />"; exit;

$result2j=mysqli_query($connection, $query2j) or die ("Couldn't execute query 2j. $query2j"); 
 
 
// Edits Field=check_name (replaces all spaces with hyphens).  This Field is used in check drop-down when Heide enters form data for CRJ
$query2k="update crs_tdrr_division_deposits_checklist set check_name=replace(check_name,' ','-') where budget_office='y' and bo_deposit_complete='n' and delrec='n' ";

//echo "<br />query2k=$query2k<br />"; exit;

$result2k=mysqli_query($connection, $query2k) or die ("Couldn't execute query 2k. $query2k");
 
 
 
 
 
 
?>