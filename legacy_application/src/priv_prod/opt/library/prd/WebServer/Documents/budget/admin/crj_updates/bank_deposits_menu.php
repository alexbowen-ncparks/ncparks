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
if($concession_center== '12802953'){$concession_center='12802751' ;}
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
include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

if($menu_selected== 'y')
{$where2= " and menu_id='$menu_id' ";}


if($level>1)

{

$query5="SELECT *
FROM $table
WHERE 1 $where2
order by menu_option
 ";
//echo "query5=$query5";exit;
}

if($level==1) 

{

$query5="SELECT *
FROM $table
WHERE 1  $where2
order by menu_option
 ";

}


$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";

//if($menu_selected!='y')
//{
//echo "<h2 ALIGN=left><font color=brown>Menu Options:$num5</font></h2>";
if($menu_selected != 'y')
{

echo "<table border=1>";

echo 

"<tr> 
       
       <th align=left><font color=brown>Menu Option</font></th>
       
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   
		  
		   <td>$menu_option</td>		   
		   <td><a href='bank_deposits_menu.php?menu_id=$menu_id&menu_selected=y' >Select</a></td>
		   
                    
      
           
              
           
</tr>";




}

 echo "</table>";
 }
 //}
 
 
 //if($history=='10yr'){include("budget_group_ten_yr_history.php");}
 if($step==''){$step='1';}
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='1')
 {
 
 /*
 {echo "<br />";
  echo "<table><tr><th>NEW Report<br />Step1: Upload ORMS CSV File-(a)Browse for File on your Desktop (b)click: Upload CSV File</th></tr></table><br />";}
 */
/*
{echo "<table><tr><th>Step1: Upload ORMS CSV File-(a)Browse for File on your Desktop (b)click: Upload CSV File</th></tr></table><br />";}






 
  
  
  
 
 {include("import_csv_form.php");}
 */
 
echo "<table><tr><th>CRS Parks no longer need to upload the transaction detail revenue report. <br />Raleigh Financial Services Group uploads this report by 10:00AM on the day following the CRS Deposit.<br /> To view Online Cash Receipts Journals, go to Home Page & click on Bank Deposits</th></tr></table>"; 


 {include("crs_deposits_crj_listing2.php");}
 
 }
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='2')
 {
 {echo "<br />";  echo "<table><tr><th>Step2: Select ORMS Deposit ID#</th></tr></table>";}
  
 {
 $query11="SELECT deposit_id,sum(amount) as 'amount'
            from crs_tdrr
			WHERE center='$concession_center'
			and deposit_id != ''
			group by deposit_id ";
			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 
 /*
 $query11a="SELECT deposit_id
            from crs_tdrr
			WHERE center='$concession_center'
			and deposit_id like '%Gift%' ";
			
 $result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a ");
 $num11a=mysqli_num_rows($result11a); 
 if($num11a >= '1'){$message_line1="Your Deposit included Gift Card Sales. A 2nd Cash Receipts Journal for Gift Card Sales (see below) must be printed & submitted to Controllers Office.  ";}
 if($num11a >= '1'){$message_line2="Please Contact DPR Budget Office with questions. Thanks ";}
*/                

// echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
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

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
		   <td><a href='bank_deposits_menu.php?menu_id=a&menu_selected=y&step=3&deposit_id=$deposit_id'>$deposit_id</a></td>  
		    <td>$amount</td>
		                      
    
       
              
           
</tr>";




}

 echo "</table>";
 
//echo "Query11=$query11"; 
 
 }
 
 }
 if($menu_selected=='y' and $menu_id=='a' and $step=='3')
 //{echo "Step3";}
 
 {
 $deposit_id = substr($deposit_id, 0, 8);
 $deposit_id_GC = $deposit_id.'GiftCard';
 //echo "deposit_id=$deposit_id<br />deposit_id_GC=$deposit_id_GC";exit;
 $query11a="delete from crs_tdrr_history
            where deposit_id='$deposit_id' ";
			
 $result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a ");
 
 $query11b="delete from crs_tdrr_history
              where deposit_id='$deposit_id_GC' ";
			
$result11b = mysqli_query($connection, $query11b) or die ("Couldn't execute query 11b.  $query11b ");
 
 
 
 
 //$query11b="insert into crs_tdrr_history select * from crs_tdrr where deposit_id='$deposit_id' ";

$query11c="insert into crs_tdrr_history(transaction_date,revenue_location_id,revenue_location_name,transaction_location_id,transaction_location_name,payment_type,product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter)
select
transaction_date,revenue_location_id,revenue_location_name,transaction_location_id,transaction_location_name,payment_type,product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter
from crs_tdrr where deposit_id='$deposit_id'
";
 
$result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c ");


$query11d="update crs_tdrr_history set deposit_id=concat(deposit_id,'GiftCard')
           where deposit_id='$deposit_id' and ncas_account='000218110'"; 

$result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d ");


/*
$query11d="insert into crs_tdrr_history(transaction_date,revenue_location_id,revenue_location_name,   transaction_location_id,transaction_location_name,payment_type,product_id,product_name,amount,account_id, account_name,batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter)
select transaction_date,revenue_location_id,revenue_location_name,transaction_location_id,       transaction_location_name,payment_type,product_id,product_name,amount,account_id,account_name, 
batch_deposit_date,batch_id,deposit_id,revenue_note,center,ncas_account,taxcenter 
from crs_tdrr where deposit_id='$deposit_id_GC' "; 


$result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d ");
*/
/* 
$query11c=
"update crs_tdrr_history
 set 
 batch_deposit_date2=lpad(batch_deposit_date,10,0)
 where 1 ";
			
 $result11c = mysqli_query($connection, $query11c) or die ("Couldn't execute query 11c.  $query11c "); 
 
 
 $query11d=
"update crs_tdrr_history
 set bdd_new=concat(mid(batch_deposit_date2,7,4),mid(batch_deposit_date2,1,2),mid(batch_deposit_date2,4,2))
 where 1 ";
			
 $result11d = mysqli_query($connection, $query11d) or die ("Couldn't execute query 11d.  $query11d ");
*/

 
 //header("location: bank_deposits_menu.php?menu_id=a&menu_selected=y");
 //header("location: crs_deposits_crj_reports.php?deposit_id=$deposit_id" );
 
 echo "<table><tr><td><font color='red'>Update Successful</font> <a href='crs_deposits_crj_reports.php?deposit_id=$deposit_id&GC=n'>View Report</a></td></tr></table>";
 
}
//header("location: crs_deposits_crj_reports.php?deposit_id=$deposit_id" );


?>



















	














