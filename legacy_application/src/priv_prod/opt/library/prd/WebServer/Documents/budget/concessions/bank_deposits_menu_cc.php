<?php

session_start();

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
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget2.php");

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
		   <td><a href='bank_deposits_menu_cc.php?menu_id=$menu_id&menu_selected=y' >Select</a></td>
		   
                    
      
           
              
           
</tr>";




}

 echo "</table>";
 //}
 
 
 //if($history=='10yr'){include("budget_group_ten_yr_history.php");}
 if($step==''){$step='1';}
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='1')
 {
 {echo "<br />";
  echo "<table><tr><th>Step1: Upload ORMS CSV File-(a)Browse for File on your Desktop (b)click: Upload CSV File</th></tr></table><br />";}
 
 {include("import_csv_form_cc.php");}
 
 }
 /*
 if($menu_selected=='y' and $menu_id=='a' and $step=='2')
 {
 {echo "<br />";  echo "<table><tr><th>Step2: Select ORMS Deposit ID#</th></tr></table>";}
  
 {$query11="SELECT deposit_id,sum(amount) as 'amount'
            from crs_tdrr_cc
			WHERE 1
			group by deposit_id ";
			
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

echo "Query11=$query11";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
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
		   <td><a href='bank_deposits_menu_cc.php?menu_id=a&menu_selected=y&step=3&deposit_id=$deposit_id'>$deposit_id</a></td>  
		    <td>$amount</td>
		                      
    
       
              
           
</tr>";




}

 echo "</table>";
 
//echo "Query11=$query11"; 
 
 }
 
 }
 */
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='2')
 //{echo "Step3";}
 {
 echo "<br />";  echo "<table><tr><th>Step2: Cash Receipts Journal- Enter Dates and DepositID     </th></tr></table><br />"; 
 
 
 
 echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Fyear</font></th><th><font color='brown'>Deposit Dates</font><br />example:June1-June6<br >Enter: 06010606</th><th><font color='brown'>DepositID-Controllers</font></th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='f_year' type='text' size='5' id='f_year' value='$f_year' ></td>
             <td><input name='deposit_dates' type='text' size='20' id='deposit_dates'></td> 
             <td><input name='deposit_id' type='text' size='20' id='deposit_id'></td> 
             <td><input type=submit name=record_insert submit value=add></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  
echo "<input type='hidden' name='menu_selected' value='y'>";
echo "<input type='hidden' name='menu_id' value='a'>";
echo "<input type='hidden' name='step' value='3'>";
echo "</form>";	
 
 }
 
 
 if($menu_selected=='y' and $menu_id=='a' and $step=='3')
 //{echo "Step3";}
 {
 $query11="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_cc
			WHERE 1 ";

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$row11=mysqli_fetch_array($result11);
extract($row11);//brings back max (start_date) as $start_date
$total_amount=number_format($total_amount,2);
$query13="SELECT sum(amount) as 'adjustment_total' 
            from crs_tdrr_cc
			WHERE 1 and ncas_account='000300000'
			 ";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 "); 
 $row13=mysqli_fetch_array($result13);
 $num13=mysqli_num_rows($result13);
extract($row13);
$adjustment_total=number_format($adjustment_total,2);

 {echo "<br />";  echo "<table border=1><tr><th>DepositID</th><th> $deposit_id</th></tr><tr><th> Total</th><th>$total_amount</th></tr><tr><th>Adjustments</th><th>$adjustment_total</th></table>";}
 {echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc.php'>";
  echo "<br />"; 
  echo "<table><tr><th>Step3: Pass Adjustments to 434410003-campsite rentals</th>
       <th><input type=submit name=pass_adjustments submit value=YES></th></table>";
  echo "<input type='hidden' name='menu_id' value='a'>";
  echo "<input type='hidden' name='menu_selected' value='y'>";
  echo "<input type='hidden' name='step' value='4'>";
  echo "<input type='hidden' name='deposit_id' value='$deposit_id'>";
  echo "<input type='hidden' name='deposit_dates' value='$deposit_dates'>";
  echo "</form>";}		   
  
  
 {$query12="SELECT center,parkcode,taxcenter,ncas_account,account_name,tax_note,sum(amount) as 'amount',py_total,validated 
            from crs_tdrr_cc
			WHERE 1 and ncas_account='000300000'
			group by center,ncas_account
            order by center,rank";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);	
 
 
 
 

//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Line#</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Debit/Credit</font></th>
       
      
              
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row12=mysqli_fetch_array($result12)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row12);
$amount=number_format($amount,2);
if($ncas_account=='000211940'){$center=$taxcenter;}
if($ncas_account=='000211940'){$account_name=$tax_note;}
if($amount < '0'){$sign="debit";} else {$sign="credit";}
//if($ncas_account=='000200000'){$ncas_account="";}
//if($ncas_account=='000300000'){$ncas_account="";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($amount != '0.00')
{
@$rank=$rank+1;

echo 

"<tr$t> 
		    <td>$rank</td>
		    <td>$parkcode</td>			
		    <td>$center</td>
		    <td>$amount</td>
		    <td>$sign</td>
		    		    
		    
              
           
</tr>";
}
}


//$adjustment_total=number_format($adjustment_total,2);
if($adjustment_total < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t> 
		    
		    <td></td>
		    <td></td>
		    <td>Total</td>
		    <td>$adjustment_total</td>
		    <td>$sign</td>
		   
           
</tr>";

}


 echo "</table>";
 
//echo "Query12=$query12"; 
 
 }
 
 
 
 //}
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 if($menu_selected=='y' and $menu_id=='a' and $step=='4')
 //{echo "Step3";}
 {
 
  {
 echo "<table border=1><tr><th>DepositID</th><th> $deposit_id</th></tr><tr><th>Deposit Dates</th><th>$deposit_dates</th></tr></table>";
 }
 $query14="truncate table crs_tdrr_cc_adj;";
 echo "<br />Query14=$query14";		
 $result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 
 $query15="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'000300000',-sum(amount)
		   from crs_tdrr_cc
		   where ncas_account='000300000'
		   group by center,ncas_account;";
echo "<br />Query15=$query15";			   
			
 $result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
 
 $query16="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'434410003',sum(amount)
		   from crs_tdrr_cc
		   where ncas_account='000300000'
		   group by center,ncas_account;";
		   
echo "<br />Query16=$query16";			   
			
 $result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16 ");
 
 
 $query17="update crs_tdrr_cc_adj
           set depositid_cc='$deposit_dates',
           deposit_id='$deposit_id' where 1; ";
		   
echo "<br />Query17=$query17";		   
			
 $result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17 "); 
 
 
 $query17a="update crs_tdrr_cc_adj,center_taxes
            set crs_tdrr_cc_adj.parkcode=center_taxes.parkcode
            where crs_tdrr_cc_adj.center=center_taxes.center; ";
		   
echo "<br />Query17a=$query17a";		   
			
 $result17a = mysqli_query($connection, $query17a) or die ("Couldn't execute query 17a.  $query17a ");  
 
 
 $query18="update crs_tdrr_cc
           set depositid_cc='$deposit_dates'
           where 1; ";
		   
echo "<br />Query18=$query18";		   
			
 $result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18 "); 
 

 $query19="insert into crs_tdrr_cc_all(
transaction_date,
revenue_location_id,
revenue_location_name,
payment_type,
amount,
revenue_type,
company_type,
revenue_code,
account_name,
batch_deposit_date,
batch_id,
deposit_id,
revenue_note,
center,
ncas_account,
taxcenter,
parkcode,
depositid_cc,
rank,
entry_type)
select
transaction_date,
revenue_location_id,
revenue_location_name,
payment_type,
amount,
revenue_type,
company_type,
revenue_code,
account_name,
batch_deposit_date,
batch_id,
deposit_id,
revenue_note,
center,
ncas_account,
taxcenter,
parkcode,
depositid_cc,
rank,
entry_type
from crs_tdrr_cc
where depositid_cc='$deposit_dates';
";
		   
echo "<br />Query19=$query19";		   
			
 $result19 = mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19 "); 
 
 
  $query20="insert into crs_tdrr_cc_all(
depositid_cc,
parkcode,
ncas_account,
center,
amount,
entry_type)
select
depositid_cc,
parkcode,
ncas_account,
center,
amount,'adjustment'
from crs_tdrr_cc_adj
where depositid_cc='$deposit_dates';
";
		   
echo "<br />Query20=$query20";		   
			
 $result20 = mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20 "); 
 
 
 $query21="update crs_tdrr_cc_all,center_taxes 
set crs_tdrr_cc_all.taxcenter=center_taxes.taxcenter
where crs_tdrr_cc_all.center=center_taxes.center
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
echo "<br />Query21=$query21";		   
			
 $result21 = mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21 ");
 
 $query22="update crs_tdrr_cc_all
set company_type='1601'
where entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
echo "<br />Query22=$query22";		   
			
 $result22 = mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22 ");
 
 $query23="update crs_tdrr_cc_all,crs_tdrr_cc_accounts
set crs_tdrr_cc_all.account_name=crs_tdrr_cc_accounts.account_name
where crs_tdrr_cc_all.ncas_account=crs_tdrr_cc_accounts.ncas_account
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
echo "<br />Query23=$query23";		   
			
 $result23 = mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23 ");
 
 $query24="update crs_tdrr_cc_all,crs_tdrr_cc_accounts
set crs_tdrr_cc_all.rank=crs_tdrr_cc_accounts.rank
where crs_tdrr_cc_all.ncas_account=crs_tdrr_cc_accounts.ncas_account
and entry_type='adjustment'
and depositid_cc='$deposit_dates';
";
		   
echo "<br />Query24=$query24";		   
			
 $result24 = mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24 ");
 
//echo "deposit_dates=$deposit_dates";
$deposit_ccgift=$deposit_dates.GC;
//echo "deposit_ccgift=$deposit_ccgift";
 //echo "depositid_gift=$deposit_dates.GC";
 

  $query25="update crs_tdrr_cc_all
set center='2235',
parkcode='PART',
company_type='1602',
depositid_cc='$deposit_ccgift'
where
ncas_account='000218110'
and depositid_cc='$deposit_dates';
";
		   
echo "<br />Query25=$query25";		   
			
 $result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25 ");
 
 
 
 echo "ok"; 
 
 
 
 /*
 {$query12="SELECT center,parkcode,taxcenter,ncas_account,account_name,tax_note,sum(amount) as 'amount',py_total,validated 
            from crs_tdrr_cc
			WHERE 1
			group by center,ncas_account
            order by center,rank";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);	
 
 
 $query13="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_cc
			WHERE 1
			 ";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);
 

//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Line#</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Company</font></th>
       <th align=left><font color=brown>Account</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Debit/Credit</font></th>
       <th align=left><font color=brown>Line Description</font></th>
       <th align=left><font color=brown>PY_Amount</font></th>
       <th align=left><font color=brown>Valid</font></th>
       <th align=left><font color=brown>Acct Rule</font></th>
              
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row12=mysqli_fetch_array($result12)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row12);
$amount=number_format($amount,2);
if($ncas_account=='000211940'){$center=$taxcenter;}
if($ncas_account=='000211940'){$account_name=$tax_note;}
if($amount < '0'){$sign="debit";} else {$sign="credit";}
if($ncas_account=='000200000'){$ncas_account="";}
if($ncas_account=='000300000'){$ncas_account="";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($amount != '0.00')
{
@$rank=$rank+1;

echo 

"<tr$t> 
		    <td>$rank</td>
		    <td>$parkcode</td>			
		    <td>1601</td>
		    <td>$ncas_account</td>
		    <td>$center</td>
		    <td>$amount</td>
		    <td>$sign</td>
		    <td>$account_name</td>
		    <td>$py_total</td>
		    <td>$validated</td>
		    <td></td>
		    
              
           
</tr>";
}
}

while ($row13=mysqli_fetch_array($result13)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row13);
$total_amount=number_format($total_amount,2);
if($total_amount < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total</td>
		    <td>$total_amount</td>
		    <td>$sign</td>
		   
           
</tr>";

}


 echo "</table>";
 */
//echo "Query12=$query12"; 
 
 //}
 }
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














