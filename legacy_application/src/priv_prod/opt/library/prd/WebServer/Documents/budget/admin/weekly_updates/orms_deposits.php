<?php

session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];


extract($_REQUEST);
//echo "tempid=$tempid";
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "park=$park<br />";
//echo "collection_start_date=$collection_start_date<br />";
//echo "collection_end_date=$collection_end_date<br />";
//echo "search=$search<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

include("../../../budget/~f_year.php");

$table="prdr";

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

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

include("../../../budget/menu1314.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menus2.php");
//exit;

//include ("widget1.php");
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
include("widget_orms_deposits.php");


$query5a="SELECT  DISTINCT (park) AS 'parkcode'
FROM prdr
where 1 
ORDER BY parkcode";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a. $query5a");
while ($row5a=mysqli_fetch_array($result5a))
	{
	$tnArray[]=$row5a['parkcode'];
	}


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";




echo "<html lang=\"en\">
<head>
<meta charset=\"utf-8\" />
<title>jQuery UI Datepicker - Default functionality</title>
<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "<br />";

echo "<table border=5 cellspacing=5>";

echo "<form method='post' autocomplete='off' action='orms_deposits.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th>";
	   echo "<th><font color='brown'>Collection<br /> Start Date</font></th>";
	   echo "<th><font color='brown'>Collection<br /> End Date</font></th>";
	  // echo "<th><font color='brown'>Add Record</font></th>"; 
	   
	   
	   echo "</tr>";
   
	   echo "<tr bgcolor='$table_bg2'>";
	   //echo "<td><input name='park' type='text' size='15' id='park'></td>"; 
	   echo "<td><select name=\"park\"><option></option>"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
//if($player_view_menu==$con){$s="selected";}else{$s="value";}
//if($park==$con){$s="selected";}else{$s="value";}
		//echo "<option $s='$con'>$tnArray[$n]\n";
		echo "<option>$tnArray[$n]\n";
       }
   echo "</select></td>"; 
	   //echo "<td><input name='center' type='text' size='15' id='center'></td>"; 
	  
   echo "<td><input name='collection_start_date' type='text' id='datepicker2' size='15'></td>"; 
   echo "<td><input name='collection_end_date' type='text' id='datepicker3' size='15'></td>"; 
	   //echo "<td><input name='bo_receipt_date' type='text' id='datepicker4' size='15'></td>"; 
	  // echo "<input type='hidden' name='user_name' value='$myusername' />";
                 
      // echo "<td><input type='submit' name='submit' value='submit' ></td>";
	  
             
	 
            echo "<td><input type=submit name=search submit value=search></td>
			  </tr>";

	  echo "</table>";
	  

echo "</form>";	  

if($search=="search")
{
$query5c="
SELECT prdr.park,prdr.center,center_taxes.taxcenter,prdr.collect_location,prdr.ncas_account,prdr.account_name, sum(prdr.account_amount ) AS 'account_amount'
FROM `prdr`
left join center_taxes on prdr.center=center_taxes.center
WHERE 1
AND park='$park'
AND trans_date >= '$collection_start_date'
AND trans_date <= '$collection_end_date'
GROUP BY park,collect_location,ncas_account
";

echo "query5c=$query5c";exit;

$result5c = mysqli_query($connection, $query5c) or die ("Couldn't execute query 5c.  $query5c");
$num5c=mysqli_num_rows($result5c);

}


//echo "park=$park<br />";
//echo "collection_start_date=$collection_start_date<br />";
//echo "collection_end_date=$collection_end_date<br />";
//echo "search=$search<br />";


	  

echo "</html>";

?>



















	














