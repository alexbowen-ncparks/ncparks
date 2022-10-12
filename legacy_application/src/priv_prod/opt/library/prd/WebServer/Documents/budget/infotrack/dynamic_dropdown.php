<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="project_articles";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from projects_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Articles</title>";

include ("css/test_style.php");


echo "</head>";
include("widget1.php");






$menuArray0=array("Home Page"=>"projects/documents_menu.php","Budget Forum"=>"/budget/forum.php?m=1","Chart of Accounts"=>"/budget/coa.php","Invoices"=>"/budget/menu.php?m=invoices","PARK BUDGETS"=>"/budget/a/park_budget_menu.php", "Park Projects"=>"/budget/b/park_project_balances.php?m=1","Purchase Orders"=>"/budget/c/XTND_po_encumbrances.php?center=$centerS&submit=Find","Transactions Posted"=>"/budget/exp_rev_query.php?m=trans_post","Transactions Unposted"=>"/budget/c/transactions_unposted.php?m=trans_unpost","PCARD "=>"/budget/acs/pcard_recon_menu.php?m=pcard",
"Pre-approval for purchases"=>"/budget/aDiv/park_purchase_request_menu.php?submit=Submit",
"Budget History"=>"/budget/aDiv/budget_history.php","Vendor Payments"=>"/budget/portal.php?dbTable=xtnd_vendor_payments","Loss Prevention"=>"/budget/loss_prevent/staff_form.php");


echo "<td><form><select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>CID Main Menu</option>";$s="value";
foreach($menuArray0 as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";

 echo "</html>";  
   ?>