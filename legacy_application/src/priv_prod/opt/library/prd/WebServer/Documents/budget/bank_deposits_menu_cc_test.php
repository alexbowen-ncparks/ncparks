<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "postitle=$posTitle";exit;


extract($_REQUEST);
//if($step != '1'){echo "<pre>";print_r($_REQUEST);"</pre>";}//exit;
//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



$table="bank_deposits_menu";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

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
echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";
include("../../budget/menu1314.php");
//include("../../budget/menus2.php");


//include ("widget2.php");

//include("widget1.php");

//NOTE: This File has numerous INCLUDES (read below)
// "Credit Card transaction data" is provided periodically to the DPR "Administrator of Cash Receipts Journals". (Budget Office-Heide Rumble) via CSV File.
 // The CSV data always includes a small number of transactions without a valid ncas account number
 // The original WebPage for Uploading the CSV File takes place in /budget/concessions/bank_deposits_menu_cc_test.php  (if $step=1)
      // This WebPage has several INCLUDES (step1, step1a, step2, step3, step4, step6). 
	  //These are the Steps "Administrator" must perform to 1) bring CSV Data into MoneyCounts 2)Cleanup data 3)Add additional field data
	  //Step 1 has a task to complete (ie. Upload CSV File).  Once complete, the remaining steps (1a,2,3,4,6) (with their own INCLUDE Files) are performed
	  //After each Step is performed, the "Administrator" is returned to File: /budget/concessions/bank_deposits_menu_cc_test.php  (step=2,step=3,etc..)
	  // Each Step has it's own INCLUDE File.

echo "<br />";

 if($step=='1')
 {
include("bank_deposits_cc_fyear.php"); 
 {echo "<br />";
  echo "<table align='center'><tr><th>Step1: Upload ORMS CSV File</th></tr></table><br />";}
 
 {include("import_csv_form_cc.php");}
 if($beacnum=='60032793')
 {
 //$pid='71';
 //include("../../budget/infotrack/slide_toggle_procedures_module2_abstract.php");
include("/opt/library/prd/WebServer/Documents/budget/slide_toggle_procedures_programmer.php");
 }
 {include("bank_deposits_menu_cc_report_listing.php");}
 
 }
 
 if($step=='1daily')
 {
include("bank_deposits_cc_fyear.php"); 
echo "<br />";	 
include("depositid_cc_daily.php"); 
 
 
 }
 
 
 
 
 
 
 
 
 if($step=='1a')
 
 {include ("bank_deposits_menu_cc_test_mod1a.php");} 
 
 
 if($step=='2')
 
 {include ("bank_deposits_menu_cc_test_mod2.php");} 
 
  
 if($step=='3')
 
 {include ("bank_deposits_menu_cc_test_mod3.php");} 
 
 if($step=='4')
 
 {include ("bank_deposits_menu_cc_test_mod4.php");}  
 
 if($step=='6')
 

 {include ("bank_deposits_menu_cc_test_mod6.php");} 
 
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














