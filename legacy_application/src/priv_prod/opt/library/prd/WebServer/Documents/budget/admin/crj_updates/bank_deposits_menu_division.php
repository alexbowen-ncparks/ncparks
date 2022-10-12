<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);

//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


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
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include("../../../budget/menu1314.php");
//include("menu1314_cash_receipts.php");
//include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


 //if($history=='10yr'){include("budget_group_ten_yr_history.php");}
 if($step==''){$step='1';}
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='1')
 {
 
 /*
 {echo "<br />";
  echo "<table><tr><th>NEW Report<br />Step1: Upload ORMS CSV File-(a)Browse for File on your Desktop (b)click: Upload CSV File</th></tr></table><br />";}
 */
if($beacnum=='60032793')
{
{echo "<table><tr><th>Step1: Upload ORMS CSV File-(a)Browse for File on your Desktop (b)click: Upload CSV File</th></tr></table><br />";}
}
  
  
 if($beacnum=='60032793')
 {
 {include("import_csv_form_division.php");}
 }
 //{include("crs_deposits_crj_listing2_division.php");}
 {include("crs_deposits_crj_listing2_division.php");}
 
 }
 /*
 if($menu_selected=='y' and $menu_id=='a' and $step=='2')
 {
 {echo "<br />";  echo "<table><tr><th>Step2: Select ORMS Deposit ID#</th></tr></table>";}
  
 {
 $query11="SELECT deposit_id,sum(amount) as 'amount'
            from crs_tdrr_
			WHERE center='$concession_center'
			and deposit_id != ''
			group by deposit_id ";
			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 
 
echo "<br />";

if($num11a >= '1')
{
echo "<font color='brown' size='5'><b>$message_line1</b></font>";echo "<br />";
echo "<br />";
echo "<font color='brown' size='5'><b>$message_line2</b></font>";echo "<br />";
echo "<br />";
}
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>ORMS Deposit ID#</font></th>
       <th align=left><font color=brown>Amount</font></th>
       
              
</tr>";


while ($row11=mysqli_fetch_array($result11)){


extract($row11);


if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   <td><a href='bank_deposits_menu.php?menu_id=a&menu_selected=y&step=3&deposit_id=$deposit_id'>$deposit_id</a></td>  
		    <td>$amount</td>
		                      
    
       
              
           
</tr>";




}

 echo "</table>";
 

 
 }
 
 }
 */
 
 /*
 if($menu_selected=='y' and $menu_id=='a' and $step=='3')
 
 
 {
 $deposit_id = substr($deposit_id, 0, 8);
 $deposit_id_GC = $deposit_id.'GiftCard';
 
 $query11a="delete from crs_tdrr_history
            where deposit_id='$deposit_id' ";
			
 $result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a ");
 
 $query11b="delete from crs_tdrr_history
              where deposit_id='$deposit_id_GC' ";
			
$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b ");
 
 
 
 
 

$query11c="insert into crs_tdrr_history(transaction_date,revenue_location_id,revenue_location_name,transaction_location_id,transaction_location_name,payment_type,product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter)
select
transaction_date,revenue_location_id,revenue_location_name,transaction_location_id,transaction_location_name,payment_type,product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter
from crs_tdrr where deposit_id='$deposit_id'
";
 
$result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c ");


$query11d="update crs_tdrr_history set deposit_id=concat(deposit_id,'GiftCard')
           where deposit_id='$deposit_id' and ncas_account='000218110'"; 

$result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d ");





 
 
 
 echo "<table><tr><td><font color='red'>Update Successful</font> <a href='crs_deposits_crj_reports.php?deposit_id=$deposit_id&GC=n'>View Report</a></td></tr></table>";
 
}
*/
//header("location: crs_deposits_crj_reports.php?deposit_id=$deposit_id" );


?>



















	














