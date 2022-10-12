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
$tempid2=$tempid;
if($card_type=='reg'){$monthly_limit='10000';}
if($card_type=='ci'){$monthly_limit='25000';}

if($card_type=='reg'){$location='1656';}
if($card_type=='ci'){$location='1669';}

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
/*
if($beacnum=='60095523')
{
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
}
*/
//if($beacnum!='60095523')
//{
if($employee_number==""){echo "<font color='brown' size='5'><b>Employee Number missing<br /><br />Click the BACK button on your Browser to enter Employee Number</b></font><br />";exit;}


if($position_number==""){echo "<font color='brown' size='5'><b>Position Number missing<br /><br />Click the BACK button on your Browser to enter Position Number</b></font><br />";exit;}


if($card_type==""){echo "<font color='brown' size='5'><b>Card Type missing<br /><br />Click the BACK button on your Browser to enter Card Type</b></font><br />";exit;}


$employee_number=str_pad($employee_number,8,"0",STR_PAD_LEFT);
$employee_number2=substr($employee_number,2,6);
$employee_number3=substr($employee_number,1,7);
//echo "<br />employee_number=$employee_number<br />"; //exit;
//echo "<br />employee_number2=$employee_number2<br />"; //exit;
//echo "<br />employee_number3=$employee_number3<br />"; //exit;
//}
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

/*
if($beacnum=='60095523')
{
$query1="select beacon_num,emid from emplist where tempid = '$tempid_name' ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

$arr = explode("*", $tempid_name, 2);
$pcard_tempid = $arr[0];
$pcard_beacon_num = $arr[1];

//$pcard_beacon_num=substr($tempid_name,strpos($tempid_name,"*")+1);

echo "<br />pcard_tempid=$pcard_tempid<br />";
echo "<br />pcard_beacon_num=$pcard_beacon_num<br />";
//echo "<br />query1=$query1<br />";
//echo "<br />beacon_num=$beacon_num<br />";
//echo "<br />emid=$emid<br />";
exit;





}		 
*/

//if($beacnum!='60095523')
{
$query1="select count(emid) as 'empinfo_count' from empinfo where (beaconid='$employee_number' or beaconid='$employee_number2' or beaconid='$employee_number3')
         and tempid != 'kahl4593' ";
	 //2 records for this beaconid (1 as autumn kahl and 1 as autumn hamm)






//echo "<br />query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query1. $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
//if($employee_number=='01939095' or $employee_number2=='939095' or $employee_number3=='1939095'){$empinfo_count='1';} //autumn kahl
//echo "<br />Line 45: empinfo_count=$empinfo_count<br />"; exit;

if($empinfo_count==0){echo "<font color='brown' size='5'><b>Employee Number is NOT in the Division Personnel Database<br /><br />Please verify Employee# in Division Personnel Database and Re-enter Form info</b></font><br />";exit;}	

if($empinfo_count==1)
{
$query2 = "SELECT fname,mname,lname,suffix,tempid as 'employee_tempid' from empinfo where (beaconid='$employee_number' or beaconid='$employee_number2' or beaconid='$employee_number3')
           and tempid != 'kahl4593' ";    //2 records for this beaconid (1 as autumn kahl and 1 as autumn hamm)
		   
//echo "<br />query2=$query2<br />";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2. $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);
//echo "<br />Line 65<br />"; exit;
$fname=strtoupper($fname);	
$mname=strtoupper($mname);	
$lname=strtoupper($lname);	
$lname2=str_replace("'","",$lname);
$suffix=strtoupper($suffix);
//echo "<br />fname=$fname<br />";
//echo "<br />mname=$mname<br />";
//echo "<br />lname=$lname<br />";
//echo "<br />lname2=$lname2<br />";
//echo "<br />suffix=$suffix<br />";
//echo "<br />employee_tempid=$employee_tempid<br />";
if($employee_tempid=='')
{
echo "<font color='brown' size='5'><b>Employee tempID is NOT in the Division Personnel Database<br /><br />Please verify Employee tempid in Division Personnel Database and Re-enter Form info
</b></font><br />";exit;
}

}

if($empinfo_count>1){echo "<font color='brown' size='5'><b>Employee Number: $employee_number is in the Division Personnel Database Multiple times<br /><br />Please Correct this Error in the Division Personnel Database and then Re-enter Form info</b></font><br />";exit;}	
}

//echo "<br />Line 81<br />"; //exit;

$query3="select count(seid) as 'position_count' from position where beacon_num='$position_number' ";
//echo "<br />Line 72 query3=$query3<br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query3. $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);
//echo "Line 88:<br />position_count=$position_count<br />";

if($position_count==0)
{
echo "<font color='brown' size='5'><b>Position Number is NOT in the Division Personnel Database<br /><br />Please verify Position# in Division Personnel Database and Re-enter Form info</b></font><br />";exit;	
}

if($position_count==1)
{
$sql = "SELECT postitle as 'pcard_postitle' from position where beacon_num='$position_number' ";
//echo "<br />Line 98 query: $sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);	
}

//echo "<br />Line 104<br />"; //exit;
	

$sql = "SELECT budget as 'budget_level' from emplist where tempid='$employee_tempid' ";
//echo "<br />Line 108 query: $sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);	
$row=mysqli_fetch_array($result);
extract($row);
//echo "<br />Line 113: budget_level=$budget_level<br />";
if($num==0)
{
echo "<font color='brown' size='5'><b>Employee tempid is missing from Division Database<br /><br />Please verify tempid in Division Personnel Database and Re-enter Form info</b></font><br />";exit;	
}
//echo "<br />Line 118<br />"; //exit;
if($num==1 and $budget_level==0)
{
$sql = "update divper.emplist set budget='1' where tempid='$employee_tempid' ";
//echo "<br />Line 122: query=$sql<br />"; //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

//$database="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

$sql = "insert ignore into budget.cash_handling_roles
        set park='$admin',tempid='$employee_tempid',beacnum='$position_number',first_name='$fname',last_name='$lname2',role='pcard',myreports_only='y' ";
//echo "<br />Line 130=$sql<br />"; //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

	
}
//echo "<br />Line 135<br />";  //exit;

//exit;
$database="dpr_system";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "cashier=$cashier<br />";

$unit=$admin;
if($unit=='ADMI' or $unit=='ADMN' or $unit=='DEDE' or $unit=='NARA'){$unit='ARCH';}

$sql = "SELECT ophone from dprunit where parkcode='$unit' ";
//echo "<br />Line 147 query=$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);
//echo "<br />ophone=$ophone<br />";	
	
//echo "Line 153: sql=$sql";

//echo "<br />ophone=$ophone<br />"; //exit;



if($card_type=='reg'){$location='1656';}
if($card_type=='capital_improvement'){$location='1669';}

//echo "<br />card_type=$card_type<br />";	
//echo "<br />location=$location<br />";	
$source_table="pcard_users";


/*
if($label==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($center==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($comments2==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
*/


define('PROJECTS_UPLOADPATH','pcard_documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}


$entered_by=substr($tempid2,0,-4);

$system_entry_date=date("Ymd");

$database="budget";
$db="budget";
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
//echo "<br />Line 196: query=$sql<br />";		
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	
}	
//echo "<br />Line 108 sql=$sql<br />";
if($pcard_center==''){$pcard_center='none';}
//echo "<br />Line 203: pcard_center=$pcard_center<br />";
//echo "Line 111<br />"; 
//exit;

$query1="insert ignore into $source_table
set admin='$admin',employee_number='$employee_number',position_number='$position_number',job_title='$pcard_postitle',employee_tempid='$employee_tempid',student_id='$employee_tempid',phone_number='$ophone',last_name='$lname2',first_name='$fname',middle_initial='$mname',suffix='$suffix',justification='$justification',location='$location',entered_by='$entered_by',cashier='$tempid2',cashier_date='$system_entry_date',act_id='p',center='$pcard_center',monthly_limit='$monthly_limit'
";

//echo "<br />Line 211: query1=$query1<br />";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="insert ignore into players(player) values('$employee_tempid')";     
//echo "<br />Line 216: query1a=$query1a<br />";
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");


$query1b="insert ignore into position_report_users 
set beacnum='$position_number',downloaded='y',report_id='293' ";  

//echo "<br />Line 223: query1b=$query1b<br />";

mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");


$query3="select max(id) as 'maxid'
         from $source_table where 1 ; ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
		  
$row3=mysqli_fetch_array($result3);

extract($row3);
//echo "<br />maxid=$maxid<br />";
//if($source=="cdcs"){$source_table="cid_vendor_invoice_payments";}
/*
echo "source_table=$source_table<br />";
echo "source_id=$source_id<br />";
echo "location=$location<br />";
echo "center=$center<br />";
echo "account=$account<br />";
echo "calyear=$calyear<br />";
*/
//exit;

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

//$project_note_id=$_POST['project_note_id'];

$doc_mod=$document;
//$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;//exit;
//$document="pcard_unreconciled".$source_id;
$document=$source_table."_".$maxid;//echo $document;//exit;
//echo "<br />";
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
//echo $document;//exit;
//echo "<br />";
//echo "<pre>";print_r($ext);echo "</pre>";exit;

//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);

//echo $document;
//echo "<br />";
//$target=PROJECTS_UPLOADPATH.$myusername."_".$date."_".$message_note_id."_".$document;
$target=PROJECTS_UPLOADPATH.$document;
//echo $target; exit;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
// echo "upload_successful";
//echo $target; exit;

$target2="/budget/acs/".$target ;

$query="update pcard_users set document_location='$target2'
where id='$maxid' ";

//echo "<br />Line 286: query=$query<br />";
mysqli_query($connection, $query) or die ("Error updating Database $query");

echo "<font color='red' size='5'>update successful</font>";
//echo "<H3 ALIGN=left><A href='pcard_request1.php?edit=y&report_type=reports'>Return to PCARD Request</A></H3>";
echo "<H3 ALIGN=left><A href='pcard_request4.php'>Return to PCARD Request</A></H3>";

?>