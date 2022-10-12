<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


if($concession_location=='ADM'){$concession_location='ADMI';}

$system_entry_date=date("Ymd");


extract($_REQUEST);

$edit='y';
//$deposit_id='162074958';
//$deposit_id='28240001';


//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

include ("../../../budget/menu1415_v1.php");
echo "<br />";

echo "concession_center=$concession_center<br /><br />";
echo "concession_location=$concession_location<br /><br />";
echo "edit=$edit<br /><br />";

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");
//echo "f_year=$f_year";
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
include ("test_style_trans_detail_manual.php");

//include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

//echo "<br />";

$query1="SELECT park as 'parkcode' from crs_tdrr_division_deposits
         where orms_deposit_id='$deposit_id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
/*
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
*/
 
//echo "<br /><br /><br />";
//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
$query4="SELECT controllers_deposit_id as 'bank_deposit_number',bank_deposit_date,orms_deposit_date
FROM crs_tdrr_division_deposits
WHERE orms_deposit_id='$deposit_id'";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
//echo "bank_deposit_number=$bank_deposit_number<br />";

$query12b="SELECT min(transdate_new) as 'mindate_footer',max(transdate_new) as 'maxdate_footer'
 from crs_tdrr_division_history_parks_manual
 WHERE 1 and concession_location='$concession_location'
 and deposit_transaction='n'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check
//echo "check count=$ck_count";
$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;


$query5="SELECT transdate_new as 'transaction_date',payment_type,amount,account_name,ncas_account
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
order by transaction_date,payment_type,ncas_account asc ";

/*
if($level==1) 

{

$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by park,vendor ";

}
*/

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



//echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";

/*
$query6="SELECT sum(crs_tdrr_division_history_parks.amount) as 'total'
FROM crs_tdrr_division_history_parks
WHERE crs_tdrr_division_history_parks.deposit_id='$deposit_id'";
*/	

$query6="SELECT sum(amount) as 'total'
from crs_tdrr_division_history_parks_manual
where concession_location='$concession_location'
and deposit_transaction='n' 
 ";





	
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);
extract($row6);

$total=number_format($total,2);
//$num6=mysqli_num_rows($result6);	

$query6a="SELECT sum(amount) as 'cash_total'
from crs_tdrr_division_history_parks_manual
where payment_type='cash'
and concession_location='$concession_location'
and deposit_transaction='n'
";
		 
//$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$row6a=mysqli_fetch_array($result6a);
extract($row6a);



$cash_total=number_format($cash_total,2);


$query6b="SELECT sum(amount) as 'noncash_total'
from crs_tdrr_division_history_parks_manual
where payment_type != 'cash'
and concession_location='$concession_location'
and deposit_transaction='n' ";
		 
$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");

$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");

$row6b=mysqli_fetch_array($result6b);
extract($row6b);

$noncash_total=number_format($noncash_total,2);


echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
/*
echo "<table>
 <tr bgcolor='cornsilk'><th>ORMS Deposit $orms_deposit_id</th></tr><tr><th><font color='red' size='5'>Deposit# $bank_deposit_number on $bank_deposit_date2</font><br /><font color='red'>Collected $revenue_collection_period</font></th></tr></table>";
*/

/*
include ("../../../budget/menu1415_v1.php");
echo "<br />";
*/



echo "<table align='center'><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><br /><font color='brown' size='5'><b>Daily Report of Cash & Check Sales </b></font></th></tr></table>";
echo "<br /><br />";
/*
echo "<table align='center'><tr><td><font color='red' size='5'>Bank Deposit $bank_deposit_number</font><br />Deposit Date $bank_deposit_date2";
echo"<br /><br />Collected $revenue_collection_period<br />CRS Deposit $deposit_id<br />Records: $num5";




echo "</td></tr></table>";
*/






echo "<br />";



 // 6/1/15:  Budget Officer Tammy Dodd,  Accountant Tony Bass
 echo "<br />";
 
 /*
 if($beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='crs_deposit_transactions.php?deposit_id=$deposit_id&edit=y'>Transaction Detail Report (Manual Adjustments)</a></td></tr></table>";
 }
 */
 
 
if($edit!='y')
 {
echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>Fyear</font></th>";
 //echo "<th align=left><font color=brown>Park</font></th>";
//echo "<th align=left><font color=brown>Bank Deposit</font></th>";
 // echo "<th align=left><font color=brown>CRS Deposit</font></th>";
 echo "<th align=left><font color=brown>Transaction Date</font></th>
       <th align=left><font color=brown>Payment Type</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th class='wrapping' align=left><font color=brown>Account Name</font></th>
       <th align=left><font color=brown>NCAS Account</font></th>  ";
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$amount=number_format($amount,2);
//$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
//$amount_total=number_format($amount_total,2);

if($ncas_account=='435900001'){$account_name="CRS Vendor Fees";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     //echo "<td>$f_year</td>";
  //   echo "<td>$park</td>";		   
     //echo "<td>$bank_deposit</td>";		   
     //echo "<td>$crs_deposit_id</td>";		   
      echo "<td>$transaction_date</td>		   
           <td>$payment_type</td>	           		   
           <td>$amount</td>		   
           <td class='wrapping'>$account_name</td>		   
           <td>$ncas_account</td>  
           ";		   
             
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
      
           
              
           
echo "</tr>";




}
//if($level>1)
//{

/*
while ($row6=mysqli_fetch_array($result6)){





extract($row6);
*/

//$amount_2751T=number_format($amount_2751T,2);
//$amount_1000T=number_format($amount_1000T,2);
//$grand_total=number_format($grand_total,2);

//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}






//}
echo "<tr><td></td><td>Cash Total</td> <td>$cash_total</td><td></td><td></td></tr>";
echo "<tr><td></td><td>Non-Cash Total</td> <td>$noncash_total</td><td></td><td></td></tr>";
echo "<tr><td></td><td>Grand Total</td> <td>$total</td><td></td><td></td></tr>";






//}












 echo "</table>";
 }
 
 if($edit == 'y')
 {
 
 echo "<table align='center' >";
 echo  "<form method='post' autocomplete='off' action='transaction_detail_manual_update2.php'>";
 echo "<tr><th>Payment Type</th><th>Amount</th>";
 if($level > 3){echo "<th>NCAS Center</th>";}
 echo "<th>NCAS Account</th></tr>";
 for($j=0;$j<10;$j++){

 echo "<tr>";
 //echo "<td><input type='text' name='transaction_date[]'></td>";    
// echo "<td><input type='text' name='payment_type[]'></td>";   
 echo "<td>";
 echo "<select name='payment_type[]'>";
 echo "<option></option><option value='cash'>Cash</option><option value='check'>Check</option><option value='money order'>Money Order</option>";
 echo "</select>";
 echo "</td>";   
 echo "<td><input type='text' name='amount[]'></td>"; 
if($level > 3){echo "<td><input type='text' name='center2[]'></td>";} 
 echo "<td><input type='text' name='ncas_account[]'></td>";    
 //echo "<td><input type='text' name='ncas_account[]'></td>";    
// echo "<td><textarea rows='2' cols='40' name='account_name[]'></textarea></td>";    
 //echo "<td><textarea rows='4' cols='50' name='comments[]' ></td>";    
 
 echo "</tr>";
}

/*
echo "<tr><td colspan='8' align='right'>Comments/Justification<br /><textarea rows='6' cols='50' name='comments' ></textarea><input type='submit' name='submit2' value='Update'></td></tr>";
*/

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";	

//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";	

//echo "<input type='hidden' name='deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='bank_deposit_date' value='$bank_deposit_date'>";
//echo "<input type='hidden' name='orms_deposit_date' value='$orms_deposit_date'>";
//echo "<input type='hidden' name='center' value='$center'>";
 echo "</form>";
 
 
 
 
 
 
 
 
 
 
 
echo "</table>"; 

 echo "<br />";
 
 $today_date=date('m-d-y', strtotime($system_entry_date));
 /*
 if($num5=='0')
 {
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total collected for $today_date thru $today_date</font><font color='red'> ($num5 records)</font></td></tr></table>";
 }
 */
 
//echo "<table class='report' border=1 align='center'>";
//echo "<br />";
  
 
 
 if($num5!='0')
 {
 
 echo "<table align='center'>
 <tr bgcolor='cornsilk'><td><font color='blue'>$total collected from $revenue_collection_period</font><font color='red'> ($num5 records)</font></td></tr></table>";

}


if($num5!='0')
 {


echo "<table class='report' border=1 align='center'>";
echo "<br />";


echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>Fyear</font></th>";
 //echo "<th align=left><font color=brown>Park</font></th>";
//echo "<th align=left><font color=brown>Bank Deposit</font></th>";
 // echo "<th align=left><font color=brown>CRS Deposit</font></th>";
 echo "<th align=left><font color=brown>Transaction Date</font></th>
       <th align=left><font color=brown>Payment Type</font></th>
       <th align=left><font color=brown>Amount</font></th>";
	   if($level > 3){echo "<th align=left><font color=brown>Center</font></th>";} 	   
     echo "<th class='wrapping' align=left><font color=brown>Account Name</font></th>
           <th align=left><font color=brown>NCAS Account</font></th>";
	   /*
 echo "<th align=left><font color=brown>Source</font></th>
       <th class='wrapping' align=left><font color=brown>Budget Office Comments</font></th>";
      */
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$amount=number_format($amount,2);
//$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
//$amount_total=number_format($amount_total,2);
$transaction_date2=date('m-d-y', strtotime($transaction_date));
if($ncas_account=='435900001'){$account_name="CRS Vendor Fees";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     //echo "<td>$f_year</td>";
  //   echo "<td>$park</td>";		   
     //echo "<td>$bank_deposit</td>";		   
     //echo "<td>$crs_deposit_id</td>";		   
      echo "<td>$transaction_date2</td>		   
           <td>$payment_type</td>	           		   
           <td>$amount</td>";	
		 if($level > 3){echo "<td>$amount</td>";}	  
        echo "<td class='wrapping'>$account_name</td>		   
           <td>$ncas_account</td>";
		   /*
       echo "<td>$source</td>  
           <td class='wrapping'>$fs_comments</td>";		   
             */
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
      
           
              
           
echo "</tr>";




}
//if($level>1)
//{

/*
while ($row6=mysqli_fetch_array($result6)){





extract($row6);
*/

//$amount_2751T=number_format($amount_2751T,2);
//$amount_1000T=number_format($amount_1000T,2);
//$grand_total=number_format($grand_total,2);

//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}






//}
/*
echo "<tr><td></td><td>Cash Total</td> <td>$cash_total</td><td></td><td></td></tr>";
echo "<tr><td></td><td>Non-Cash Total</td> <td>$noncash_total</td><td></td><td></td></tr>";
echo "<tr><td></td><td>Grand Total</td> <td>$total</td><td></td><td></td></tr>";

*/




//}












 echo "</table>";
 }
 
 }
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














