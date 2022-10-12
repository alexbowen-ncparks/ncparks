<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}


extract($_REQUEST);
session_start();
//echo "<pre>";print_r($_SERVER);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$tempID=$_SESSION['budget']['tempID'];
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database



include("../../../include/auth.inc");

include("../../../include/activity.php");

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

		//print_r($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$concession_location=$_SESSION['budget']['select'];
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];

$menu_new='MAppr';
include ("../../budget/menu1415_v1.php");
//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";


echo "<br />";

include("pcard_new_menu1.php");






$sql = "SELECT * From pcard_unreconciled where admin_num='fala' and report_date='20170518'
order by last_name,first_name";

//echo "Line 139: $sql";



$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);


echo "<table cellpadding='5' align='center'>";


echo "<tr><td><font color='red'>$num Cards</font></td></tr>";
echo "<tr><th>admin</th><th>location</th><th>center</th><th>cardholder</th><th>CardNum</th><th>vendor</th><th>amount</th></tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
//$parkcode=strtoupper($parkcode);
//$last_name=strtoupper($last_name);
$first_name=strtoupper($first_name);
//$admin=strtoupper($admin);
//$monthly_limit=number_format($monthly_limit,2);

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//if($location=="1669" and $rep==""){$tr=" bgcolor='goldenrod'";}
//if($location=="1656" and $rep==""){$tr=" bgcolor='coral'";}
$td="";
if($act_id=="y" and $rep==""){$td=" bgcolor='lime'";}
if($act_id=="n" and $rep==""){$td=" bgcolor='coral'";}
if($location=="1656" and $rep==""){$loc_text="reg";}
if($location=="1669" and $rep==""){$loc_text="ci";}


echo "<tr$t><td>$admin</td><td>$location</td><td>$center</td><td>$cardholder</td><td>$pcard_num</td><td>$vendor_name</td><td>$amount</td>";


echo "</tr>";

}
 echo "</table>"; 
$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	
 
if($manager_count==1)
{	
echo "<table>";
echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='cash_month' value='$cash_month'>
<input type='hidden' name='record_count' value='$num12'>";
echo "<input type='submit' name='submit' value='Submit'>";

echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
}




echo "</body></html>";
?>