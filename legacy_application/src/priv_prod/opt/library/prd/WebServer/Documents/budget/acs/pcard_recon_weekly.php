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
/*
$query1="SELECT report_date as 'report_date',id from pcard_report_dates where active='y' order by id desc LIMIT 1 ";
		 
echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
echo "<br />report_date=$report_date<br />";
echo "<br />id=$id<br />";
$report_date2=str_replace("-","",$report_date);
//$report_date="05/18/17";
*/

$sql = "SELECT cardholder,pcard_num,vendor_name,item_purchased,amount From pcard_unreconciled where admin_num='$admin_num' and report_date='$report_date'
order by last_name,first_name";

//echo "Line 89: $sql";



$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
//echo "<br />num=$num<br />";
echo "<br />";



//echo "<tr><td colspan='4'><font color='red'><a href='pcard_recon_approval.php?report_id=$id'></a>Report Date: $report_date</font></td></tr>";
//echo "<tr><td colspan='4'><font color='brown'><b>$admin_num</b></font><br /><font color='red'>$report_date</font></td></tr>";


if($num==0){
	echo "<br />";
	echo "<table cellpadding='5' align='center'>";
	echo "<tr><td colspan='4'><font color='brown'><b>$admin_num</b></font><br /><font color='red'>$report_date</font></td></tr>";
	echo "<br /><table align='center'><tr><th><font color='red' class='cartRow'><b>No Purchases to reconcile for this Report Week</b></font></th></tr>";
	echo "</table>";
	exit;
 	
	        }

echo "<table cellpadding='5' align='center'>";
echo "<tr><td colspan='4'><font color='brown'><b>$admin_num</b></font><br /><font color='red'>$report_date</font></td></tr>";
echo "<tr><th>cardholder</th><th>CardNum</th><th>vendor</th><th>Item Purchased</th><th>amount</th></tr>";
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
//$td="";
//if($act_id=="y" and $rep==""){$td=" bgcolor='lime'";}
//if($act_id=="n" and $rep==""){$td=" bgcolor='coral'";}
//if($location=="1656" and $rep==""){$loc_text="reg";}
//if($location=="1669" and $rep==""){$loc_text="ci";}


echo "<tr$t><td>$cardholder</td><td>$pcard_num</td><td>$vendor_name</td><td>$item_purchased</td><td>$amount</td>";


echo "</tr>";

}
 echo "</table>"; 
 echo "<br />";
 if($app=='no'){exit;}
 if($beacnum=='60032833'){$concession_location='dede' ;} //erin lawrence
 if($beacnum=='60033160'){$concession_location='nara' ;} //brian strong
 
$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "query1b=$query1b";
	  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	
 
 //if($beacnum=='60032786' and $admin_num='WAHO'){$manager_count=1;}
 
if($manager_count==1)
{
if($app!='y')
{	

$query1b="select count(id) as 'manager_purchases' from pcard_unreconciled
          where report_date='$report_date'
		  and admin_num='$admin_num'
          and employee_tempid='$tempID'  ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "query1b=$query1b";
	  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "<br />manager_purchases=$manager_purchases<br />";
if($manager_purchases > 0)
{
	
	  
//$row1c=mysqli_fetch_array($result1c);

//extract($row1c);	
	
	
	
	
	
echo "<table align='center'><tr><td><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img><font color='brown' class='cartRow2'>Manager can not Approve own purchases. Alternate Manager must Approve. Thanks</font></td></tr></table>";



$query="select first_name,last_name from cash_handling_roles where park='$concession_location' and role='manager' and tempid != '$tempID'  ";	 

//if($beacnum=='60033148'){echo "query1b=$query1b";}	
//echo "query1b=$query1b";
	  
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
echo "<table cellpadding='5' align='center'>";


//echo "<tr><td colspan='4'><font color='red'><a href='pcard_recon_approval.php?report_id=$id'></a>Report Date: $report_date</font></td></tr>";
echo "<br />";
echo "<tr><th>Alternate Managers</tH</tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
//$parkcode=strtoupper($parkcode);
//$last_name=strtoupper($last_name);
//$first_name=strtoupper($first_name);
//$admin=strtoupper($admin);
//$monthly_limit=number_format($monthly_limit,2);

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//if($location=="1669" and $rep==""){$tr=" bgcolor='goldenrod'";}
//if($location=="1656" and $rep==""){$tr=" bgcolor='coral'";}


echo "<tr$t>";
echo "<td>$first_name $last_name</td>";


echo "</tr>";

}
 echo "</table>"; 	







exit;
	
	
	
	
	
	
}
	







echo "<form action='pcard_recon_yearly.php'>";
echo "<table align='center'>";
echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";

echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='admin_num' value='$admin_num'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='manager' value='$tempID'>";
echo "<input type='submit' name='submit' value='Submit'>";


echo "</td>";
echo"</tr>"; 
  
  
echo "</table>";
echo "</form>";
}
}




echo "</body></html>";
?>