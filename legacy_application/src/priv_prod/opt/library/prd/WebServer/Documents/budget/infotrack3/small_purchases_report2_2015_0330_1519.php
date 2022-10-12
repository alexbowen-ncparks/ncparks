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

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


//if($center_code != ''){$where_park=" and park='$center_code'";}

//if($month_number == ''){$month_number='07' ;}


$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);
$month_total2=number_format($month_total,2);
//echo "<table><tr><th>$month_total</th></table><br />";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;


include("../../budget/menu1314.php");
include ("small_purchases_header1.php");
if($month_number == ''){exit;}

$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
         order by park,datesql2 ";
echo "query5=$query5";



$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);
echo "<table><tr><th>$num5 Records</th></tr><tr><th>$month_total2</th></tr></table><br />";
echo "<table><tr><th>Excludes following Expenditures</th></tr>
             <tr><td>1)Purchase Orders</td></tr>
			 <tr><td>2)fuel_highway</td></tr>
			 <tr><td> 3)fuel_nonhighway</td></tr>
			 <tr><td> 4)payroll </td></tr>
			 <tr><td>5)training/travel</td></tr>
             <tr><td>6)Utilities</td></tr>
             <tr><td>7)Telecommunications</td></tr>
			 </table><br />";

echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Month</font></th>
       <th align=left><font color=brown>Center</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Account</font></th>
       <th align=left><font color=brown>Invoice Date</font></th>
       <th align=left><font color=brown>Invoice/transID</font></th>
       <th align=left><font color=brown>Vendor Name</font></th>
       <th align=left><font color=brown>Comments</font></th>
       <th align=left><font color=brown>Invoice Amount</font></th>
       <th align=left><font color=brown>Account Category</font></th>
       <th align=left><font color=brown>Source</font></th>
       <th align=left><font color=brown>ID</font></th>      ";
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
//$amount_park=number_format($amount_park,2);
///$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
$ncas_invoice_amount=number_format($ncas_invoice_amount,2);


if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo "<tr$t>";

       //echo "<td>$category</td>";
     echo "<td>$f_year</td>
	       <td>$month_name</td>	
           <td>$ncas_center</td>		   
           <td>$park</td>		   
           <td>$ncas_account</td>		   
           <td>$ncas_invoice_date</td>		   
           <td>$ncas_invoice_number</td>		   
           <td>$vendor_name</td>		   
           <td>$comments</td>		   
           <td>$ncas_invoice_amount</td>		   
           <td>$account_category</td>		   
           <td>$source</td>
           <td>$id</td>";	
		   
		   
	echo "</tr>";

	}	 


		   
        
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














