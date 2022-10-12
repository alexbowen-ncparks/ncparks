<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));
//if($tempID=='McGrath9695'){echo "hello $posTitle Nora Coffey";} else {echo "hello world";}


//if($tempID=='Robinson8024' and $concession_location=='STMO'){$posTitle='park superintendent';}
if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}


//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

if($posTitle=='park superintendent'){$pasu_role='y';}


extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

/*
if($tempID=='Church9564')
{
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//if($mode==''){$mode='report';}
//echo "mode=$mode";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

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
//$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
echo "<br />";
/*
if($beacnum=='60033162') //tara gallagher
{
include ("concessions_pci_menu.php");
}
*/
//if($level==1 or $beacnum=='60036015'){include ("park_deposits_report_menu_v3.php");}



//include ("park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v2_test.php");
//include ("park_posted_deposits_widget1_v2_test.php");
//include ("park_posted_deposits_widget2_v2_test.php");


//include ("cash_imprest_count_widget1.php");
//include ("cash_imprest_count_widget2.php");

if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

/*
echo "<br /><table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'></b>Cash Imprest </font>(Monthly)-<font color='green'>$center_location</font></b></th></tr></table>";
*/
$query8a="select text_code from svg_graphics where id='2'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	

echo "<br /><table align='center'><tr><th>$text_code <br />Monthly Compliance</font></b></th></tr></table>";





//include("concessions_pci_instructions.php");
//echo "<br />";
//include ("page1_fsg_fyear_module.php");
include ("concessions_pci_admin_fyear.php");
//echo "<br />";
//include ("page1_fsg_fyear_months.php");
include ("concessions_pci_admin_fyear_months.php");
//line 180 comment out (bass-6/29/15)
//if($tempID=='Wagner9210' or $tempid=='Hall2051' or $tempid=='Dodd3454' or $tempid=='Bass3278')

//{include ("page1_fsg_report.php");}
//include ("cash_imprest_count_fyear_module.php");


//$score='10';
//echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";

//include ("cash_imprest_count2_report.php");


//include ("cash_imprest_count2_report_test.php");




?>



	














