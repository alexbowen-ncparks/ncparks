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
//$monthly_cost2=str_replace(",","",$monthly_cost);
//$monthly_cost2=str_replace("$","",$monthly_cost2);

//$yearly_cost2=str_replace(",","",$yearly_cost);
//$yearly_cost2=str_replace("$","",$yearly_cost2);

//$po_original_total=str_replace(",","",$po_original_total);
//$po_original_total=str_replace("$","",$po_original_total);

//echo "monthly_cost=$monthly_cost";
//echo "yearly_cost=$yearly_cost";  //exit;

//$ncas_center=str_replace("-","",$ncas_center);



//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
if($record_search=='search'){include("fixed_assets_fas_lookup.php"); exit;}

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$form_return="<form method='post' action='fixed_assets1.php'>
<input type='hidden' name='park' value='$park'>
<input type='hidden' name='fas_num' value='$fas_num'>
<input type='hidden' name='fas_description' value='$fas_description'>
<input type='hidden' name='payment_source' value='$payment_source'>
<input type='hidden' name='source_id' value='$source_id'>
<input type='hidden' name='menu_fa' value='fa1'>
<input type='hidden' name='submit' value='Submit'>
<input type='submit' name='submit2' value='Return to Form'></form>";


if($park=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}
if($payment_source=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

if($source_id=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	



define('PROJECTS_UPLOADPATH','fa_documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";
echo "$form_return";
exit;}

//echo "<br />Line 84<br />";  exit;

//$entered_by=substr($tempid,0,-4);

$system_entry_date=date("Ymd");




$query1="insert into fixed_assets
set park='$park',fas_num='$fas_num',fas_description='$fas_description',payment_source='$payment_source',source_id='$source_id',entered_by='$tempid',sed='$system_entry_date'  ";

//echo "query1=$query1<br /><br />";

$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");

//$row1=mysqli_fetch_array($result1);

//extract($row1);


$query2="SELECT max(id) as 'maxid'
         from fixed_assets
         where 1 ";

//echo "query2=$query2<br /><br />";

$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);

echo "<br />Line 117 maxid=$maxid<br />"; // exit;


//define('PROJECTS_UPLOADPATH','documents/');
$source_table="fixed_assets";
$doc_mod=$document;
$document=$source_table."_".$maxid;//echo $document;//exit;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
$target=PROJECTS_UPLOADPATH.$document;
//echo $target; exit;
//echo "$form_return"; exit;
move_uploaded_file($_FILES['document']['tmp_name'], $target);
//echo $target; exit;

$target2="/budget/acs/".$target ;

$query3="update fixed_assets set document_location='$target2'
where id='$maxid' ";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");


header("location: fixed_assets1.php?menu_fa=fa1&type=add&id=$maxid");


?>