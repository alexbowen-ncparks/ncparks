<?php

session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


extract($_REQUEST);
$tempid2=$tempid;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

if($admin==""){echo "<font color='brown' size='5'><b>Admin# missing<br /><br />Click the BACK button on your Browser to enter Admin#</b></font><br />";exit;}

if($location==""){echo "<font color='brown' size='5'><b>Location missing<br /><br />Click the BACK button on your Browser to enter Location</b></font><br />";exit;}


if($employee_number==""){echo "<font color='brown' size='5'><b>Employee Number missing<br /><br />Click the BACK button on your Browser to enter Employee Number</b></font><br />";exit;}


if($position_number==""){echo "<font color='brown' size='5'><b>Position Number missing<br /><br />Click the BACK button on your Browser to enter Position Number</b></font><br />";exit;}

/*
if($card_type==""){echo "<font color='brown' size='5'><b>Card Type missing<br /><br />Click the BACK button on your Browser to enter Card Type</b></font><br />";exit;}
*/
//echo "<br />Line33<br />";
//exit;


$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "cashier=$cashier<br />";

	$sql = "SELECT postitle as 'pcard_postitle' from position where beacon_num='$position_number' ";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	
	
if($showSQL=1){echo "sql=$sql";}

if($showSQL=1){echo "<br />pcard_postitle=$pcard_postitle<br />";} //exit;



$sql = "SELECT fname,mname,lname,suffix,tempid as employee_tempid from empinfo where beaconid='$employee_number' ";
//$sql = "SELECT fname,mname,lname,suffix from empinfo where beaconid='$employee_number' ";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);

$fname=strtoupper($fname);	
$mname=strtoupper($mname);	
$lname=strtoupper($lname);	
$suffix=strtoupper($suffix);	
if($showSQL=1)
{	
echo "<br />sql=$sql<br />";

echo "<br />fname=$fname<br />"; 
echo "<br />mname=$mname<br />"; 
echo "<br />lname=$lname<br />"; 
echo "<br />suffix=$suffix<br />"; 
}


$sql = "SELECT budget as 'budget_level' from emplist where tempid='$employee_tempid' ";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
if($showSQL=1)
{
echo "<br />sql=$sql<br />";
echo "<br />budget_level=$budget_level<br />";

echo "<br />Line 81<br />"; //exit;
}


if($budget_level==0)
{
$sql = "update emplist set budget='1' where tempid='$employee_tempid' ";
if($showSQL=1){	echo "<br />Line 87=$sql<br />";} //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	
}


//exit;
$database="dpr_system";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "cashier=$cashier<br />";

$unit=$admin;
if($unit=='ADMI' or $unit=='ADMN' or $unit=='DEDE' or $unit=='NARA'){$unit='ARCH';}

	$sql = "SELECT ophone from dprunit where parkcode='$unit' ";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	
if($showSQL=1)
{	
echo "<br>sql=$sql<br />";

echo "<br />ophone=$ophone<br />";
echo "Line 111"; //exit;
}

/*
if($card_type=='reg'){$location='1656';}
if($card_type=='capital_improvement'){$location='1669';}
*/


$source_table="pcard_users";


/*
if($label==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($comments2==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
*/

/*
define('PROJECTS_UPLOADPATH','pcard_documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}
*/

$entered_by=$tempid2; echo "<br />entered_by=$entered_by<br />";

$sed=date("Ymd"); echo "<br />sed=$sed<br />";

$database="budget";
//$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

if($location=='1656' and $admin != 'ADMN' and $admin != 'ADMI' and $admin != 'DEDE' and $admin != 'NARA')
{
$sql = "SELECT new_center as 'pcard_center'
        from center where parkcode='$admin'
        and new_fund='1680'		";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
if($showSQL=1){echo "<br />Line 155 sql=$sql<br />";}

if(($pcard_postitle=='Park Superintendent' or $pcard_postitle=='park superintendent')
and 
(
($admin=='eadi' or $admin=='EADI' or $admin=='core' or $admin=='CORE')
or
($admin=='sodi' or $admin=='SODI' or $admin=='pire' or $admin=='PIRE')
or
($admin=='wedi' or $admin=='WEDI' or $admin=='more' or $admin=='MORE')
)
)
{
$pcard_center=$center;
}	





	
}	

if($pcard_center==''){$pcard_center='none';}
if($showSQL=1)
{
echo "<br />pcard_center=$pcard_center<br />";
echo "Line 160<br />"; //exit;
}

/*
$query1="insert ignore into $source_table
set admin='$admin',employee_number='$employee_number',position_number='$position_number',job_title='$pcard_postitle',employee_tempid='$employee_tempid',student_id='$employee_tempid',phone_number='$ophone',last_name='$lname',first_name='$fname',middle_initial='$mname',suffix='$suffix',justification='$justification',location='$location',entered_by='$entered_by',cashier='$tempid2',cashier_date='$system_entry_date',act_id='p',center='$pcard_center'
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/

//NOTE: Query below only Updates Pcard Users for INFO which was extracted from other Databases (divper,etc.)

$lname2=str_replace("'","",$lname);

$query1="update pcard_users
set job_title='$pcard_postitle',phone_number='$ophone',last_name='$lname2',first_name='$fname',middle_initial='$mname',suffix='$suffix',fs_approver='$entered_by',fs_approver_date='$sed',center='$pcard_center' where id='$id'
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

if($showSQL=1){echo "<br />Line 178<br />";} //exit;



//echo "<br />admin=$admin<br />";  exit;



/*

$query1a="insert ignore into players(player) values('$employee_tempid')";     

mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");


$query1b="insert ignore into position_report_users 
set beacnum='$position_number',downloaded='y',report_id='293' ";   

mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
*/



/*
$query3="select max(id) as 'maxid'
         from $source_table where 1 ; ";

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
//echo $target; exit;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target; exit;

$target2="/budget/acs/".$target ;

$query="update pcard_users set document_location='$target2'
where id='$maxid' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");
*/




//echo "<font color='red' size='5'>update successful</font>";
//echo "<H3 ALIGN=left><A href='pcard_request1.php?edit=y&report_type=reports'>Return to PCARD Request</A></H3>";


?>