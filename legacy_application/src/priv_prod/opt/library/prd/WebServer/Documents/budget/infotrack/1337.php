<?php
//echo "hello world";exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];
$position=$_SESSION['budget']['beacon_num'];
$comment='y';
$add_comment='y';
$folder='community';
$cash_plan='y';
$pid='25';
//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//doc_id1=daily sales report
//doc_location1 is the document location for daily sales report


$query_chp_docs="select chp_id,document_location as 'doc_location1',id as 'chpd1_id' from cash_handling_plan_docs where chp_id='$pid' and doc_id='1' ";

//echo $query4a;echo "<br />";		 
$result_chp_docs = mysqli_query($connection, $query_chp_docs) or die ("Couldn't execute query query_chp_docs.  $query_chp_docs");
//$num4a=mysqli_num_rows($result4a);
$row_chp_docs=mysqli_fetch_array($result_chp_docs);
extract($row_chp_docs);

//doc_id2=Sales Locations
//doc_location2 is the document location for sales locations
/*
$query_chp_docs2="select chp_id,document_location as 'doc_location2',id as 'chpd2_id' from cash_handling_plan_docs where chp_id='$pid' and doc_id='2' ";
*/
$query_chp_docs2="select chp_id,document_location as 'doc_location2',id as 'chpd2_id' from cash_handling_plan_docs where park='$pcode' and doc_id='2' ";

echo "$query_chp_docs2<br />";		 
$result_chp_docs2 = mysqli_query($connection, $query_chp_docs2) or die ("Couldn't execute query query_chp_docs2.  $query_chp_docs2");
//$num4a=mysqli_num_rows($result4a);
$row_chp_docs2=mysqli_fetch_array($result_chp_docs2);
extract($row_chp_docs2);


//Graphic for Sales Locations
if($doc_location1==''){$doc_location1_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";}
if($doc_location1 != ''){$doc_location1_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

//Graphic for Daily Sales Reports
if($doc_location2==''){$doc_location2_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of x mark'></img>";}
if($doc_location2!=''){$doc_location2_graphic="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}




//echo "doc_location1=$doc_location1<br />doc_location2=$doc_location2<br />";
//echo "doc_location1_graphic=$doc_location1_graphic<br />doc_location2_graphic=$doc_location2_graphic<br />";

echo "<table border='1'>";
echo "<tr>";
echo "<td align='center'><font color='brown'>Sales Locations $doc_location2_graphic<br /> (ALL)<br /></font><a href='$doc_location2' target='_blank'>Download</a></td></tr></table>";

?>

