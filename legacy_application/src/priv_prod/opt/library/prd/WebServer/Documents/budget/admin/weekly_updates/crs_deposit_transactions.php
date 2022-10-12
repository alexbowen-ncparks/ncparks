<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

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
include ("test_style.php");

include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

echo "<br />";





//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";







$query5="SELECT crs_tdrr_division_history_parks.transaction_location_name AS  'park', crs_tdrr_division_deposits.controllers_deposit_id AS  'bank_deposit', crs_tdrr_division_deposits.orms_deposit_id AS  'crs_deposit_id', crs_tdrr_division_history_parks.transaction_date, crs_tdrr_division_history_parks.payment_type, crs_tdrr_division_history_parks.amount, crs_tdrr_division_history_parks.account_name, crs_tdrr_division_history_parks.ncas_account
FROM crs_tdrr_division_deposits
LEFT JOIN crs_tdrr_division_history_parks ON crs_tdrr_division_deposits.orms_deposit_id = crs_tdrr_division_history_parks.deposit_id
WHERE crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' ";

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

$query6="SELECT sum(crs_tdrr_division_history_parks.amount) as 'total'
FROM crs_tdrr_division_history_parks
WHERE crs_tdrr_division_history_parks.deposit_id='$deposit_id'";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	




$query6a="SELECT sum(crs_tdrr_division_history_parks.amount) as 'cash_total'
FROM crs_tdrr_division_history_parks
WHERE crs_tdrr_division_history_parks.deposit_id='$deposit_id'
and payment_type='cash' ";
		 
$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$row6a=mysqli_fetch_array($result6a);
extract($row6a);








echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
echo "<table><tr><td><font color='red'>Records: $num5</font></td></tr></table>";

echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  //echo "<th align=left><font color=brown>Fyear</font></th>";
 echo "<th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>Bank Deposit</font></th>
       <th align=left><font color=brown>CRS Deposit</font></th>
       <th align=left><font color=brown>Transaction Date</font></th>
       <th align=left><font color=brown>Payment Type</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Account Name</font></th>
       <th align=left><font color=brown>NCAS Account</font></th>";
      
       	   
	   
	   
	   
       
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




//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
     //echo "<td>$f_year</td>";
     echo "<td>$park</td>		   
           <td>$bank_deposit</td>		   
           <td>$crs_deposit_id</td>		   
           <td>$transaction_date</td>		   
           <td>$payment_type</td>	           		   
           <td>$amount</td>		   
           <td>$account_name</td>		   
           <td>$ncas_account</td>";		   
             
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
      
           
              
           
echo "</tr>";




}
//if($level>1)
//{


while ($row6=mysqli_fetch_array($result6)){





extract($row6);

$total=number_format($total,2);
//$amount_2751T=number_format($amount_2751T,2);
//$amount_1000T=number_format($amount_1000T,2);
//$grand_total=number_format($grand_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	

           <td>$total</td> 
		   <td></td>
		   <td></td>
           
         
           
           

           		  

</tr>";



}
echo "<tr><td></td><td></td><td></td><td></td><td>Cash Total</td> <td>$cash_total</td><td></td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td></td><td>Non-Cash Total</td> <td>$noncash_total</td><td></td><td></td></tr>";
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














