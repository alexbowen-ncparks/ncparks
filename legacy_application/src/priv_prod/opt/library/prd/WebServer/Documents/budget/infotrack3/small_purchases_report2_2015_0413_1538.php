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


$query21="truncate cvip_small_purchases; ";

$result21 = mysql_query($query21) or die ("Couldn't execute query 21.  $query21");


$query22="insert into cvip_small_purchases
(`ncas_center`,`ncas_account`,`ncas_invoice_date`,`datesql`,`ncas_invoice_number`,`vendor_name`,`comments`,`ncas_invoice_amount`,`ncas_po_number`,`source`)

SELECT ncas_center, ncas_account, ncas_invoice_date, datesql, ncas_invoice_number, vendor_name, comments, SUM( ncas_invoice_amount ),ncas_po_number ,'cdcs'
FROM cid_vendor_invoice_payments
WHERE datesql >=  '20140701'
and datesql <= '20150630'
AND ncas_center LIKE  '1280%'
group by id; ";

$result22 = mysql_query($query22) or die ("Couldn't execute query 22.  $query22");


$query23="insert into cvip_small_purchases
(`ncas_center`,`ncas_account`,`ncas_invoice_date`,`datesql`,`ncas_invoice_number`,`vendor_name`,`comments`,`ncas_invoice_amount`,`source`)

SELECT center, ncasnum, trans_date,transdate_new, transid_new, vendor_name,item_purchased, SUM(amount ),'pcard'
FROM pcard_unreconciled
WHERE transdate_new >=  '20140701'
and transdate_new <= '20150630'
AND center LIKE  '1280%'
group by id ; ";

$result23 = mysql_query($query23) or die ("Couldn't execute query 23.  $query23");


$query24="UPDATE cvip_small_purchases
SET datesql = REPLACE(datesql, '-', '')
WHERE 1; " ;

$result24 = mysql_query($query24) or die ("Couldn't execute query 24.  $query24");



$query25="update cvip_small_purchases
set datesql2=datesql
where 1; ";

$result25 = mysql_query($query25) or die ("Couldn't execute query 25.  $query25");



$query26="update cvip_small_purchases,coa_murphy
set cvip_small_purchases.account_category=coa_murphy.line_description,
cvip_small_purchases.budget_group=coa_murphy.budget_group
where cvip_small_purchases.ncas_account=coa_murphy.account; ";

$result26 = mysql_query($query26) or die ("Couldn't execute query 26.  $query26");



$query27="update cvip_small_purchases
set valid='n'
where ncas_po_number != ''; ";

$result27 = mysql_query($query27) or die ("Couldn't execute query 27.  $query27");


$query28="update cvip_small_purchases
set valid='n'
where 
(account_category='fuel_highway'
or account_category='fuel_highway'
or account_category='fuel_nonhighway'
or account_category='revenues_camping_cabin'
or account_category='temporary_payroll'
or account_category='training_travel'
or account_category='utilities'
or account_category='telecom'
); ";

$result28 = mysql_query($query28) or die ("Couldn't execute query 28.  $query28");


$query29="update cvip_small_purchases
set valid='n'
where account_category='revenues_other' and budget_group != 'pfr_expenses' ; ";

$result29 = mysql_query($query29) or die ("Couldn't execute query 29.  $query29");


$query29a="update cvip_small_purchases
set valid='n'
where (ncas_account='531631' or ncas_account='531632' or ncas_account='531639' or ncas_account='532170') ";

$result29a = mysql_query($query29a) or die ("Couldn't execute query 29a.  $query29a");






$query30="update cvip_small_purchases
set `month_number`=mid(`datesql`,5,2) 
where 1 ; ";

$result30 = mysql_query($query30) or die ("Couldn't execute query 30.  $query30");


$query31="update cvip_small_purchases
set `year_number`=mid(`datesql`,1,4) 
where 1 ;  ";

$result31 = mysql_query($query31) or die ("Couldn't execute query 31.  $query31");


$query32="update cvip_small_purchases
set month_name='july'
where month_number='07'; ";

$result32 = mysql_query($query32) or die ("Couldn't execute query 32.  $query32");


$query33="update cvip_small_purchases
set month_name='august'
where month_number='08'; ";

$result33 = mysql_query($query33) or die ("Couldn't execute query 33.  $query33");

$query34="update cvip_small_purchases
set month_name='september'
where month_number='09'; ";

$result34 = mysql_query($query34) or die ("Couldn't execute query 34.  $query34");

$query35="update cvip_small_purchases
set month_name='october'
where month_number='10';  ";

$result35 = mysql_query($query35) or die ("Couldn't execute query 35.  $query35");

$query36="update cvip_small_purchases
set month_name='november'
where month_number='11'; ";

$result36 = mysql_query($query36) or die ("Couldn't execute query 36.  $query36");


$query37="update cvip_small_purchases
set month_name='december'
where month_number='12'; ";

$result37 = mysql_query($query37) or die ("Couldn't execute query 37.  $query37");


$query38="update cvip_small_purchases
set month_name='january'
where month_number='01'; ";

$result38 = mysql_query($query38) or die ("Couldn't execute query 38.  $query38");

$query39="update cvip_small_purchases
set month_name='february'
where month_number='02'; ";

$result39 = mysql_query($query39) or die ("Couldn't execute query 39.  $query39");


$query40="update cvip_small_purchases
set month_name='march'
where month_number='03'; ";

$result40 = mysql_query($query40) or die ("Couldn't execute query 40.  $query40");

$query41="update cvip_small_purchases
set month_name='april'
where month_number='04'; ";

$result41 = mysql_query($query41) or die ("Couldn't execute query 41.  $query41");


$query42="update cvip_small_purchases
set month_name='may'
where month_number='05'; ";

$result42 = mysql_query($query42) or die ("Couldn't execute query 42.  $query42");


$query43="update cvip_small_purchases
set month_name='june'
where month_number='06'; ";

$result43 = mysql_query($query43) or die ("Couldn't execute query 43.  $query43");


$query44="update cvip_small_purchases,coa
set cvip_small_purchases.account_description=coa.park_acct_desc
where cvip_small_purchases.ncas_account=coa.ncasnum; ";

$result44 = mysql_query($query44) or die ("Couldn't execute query 44.  $query44");


$query45="update cvip_small_purchases,center
set cvip_small_purchases.park=center.parkcode
where cvip_small_purchases.ncas_center=center.center; ";

$result45 = mysql_query($query45) or die ("Couldn't execute query 45.  $query45");




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


if($rep != 'spreadsheet')
{

include("../../budget/menu1314.php");
include ("small_purchases_header1.php");
if($month_number == ''){exit;}



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



$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
         order by park,vendor_name,datesql2 ";
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
$spreadsheet_icon="<a href='small_purchases_report2.php?rep=spreadsheet&f_year=$f_year&month_number=$month_number' target='_blank'><img height='50' width='50' src='/budget/infotrack/icon_photos/csv1.png' alt='reports icon' title='spreadsheet download'></img>";
echo "<table><tr><td>$spreadsheet_icon</td></tr></table>";
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

}
 
if($rep == 'spreadsheet')
{
echo "spreadsheet output";
$output = "";

/*
$query14="
select admin_num,concat("'",pcard_num,"'") as 'pcard_num',concat("'",transid_new,"'") as 'transid_new', id from pcard_unreconciled where admin_num='ADMN' and transdate_new >= '20141207' and transdate_new <= '20141222' order by transdate_new";
*/


$query14="
select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
         order by park,vendor_name,datesql2
";




echo "query14=$query14<br />";exit;

$result14 =mysql_query($query14) or die ("Couldn't execute query 14.  $query14");


$columns_total = mysql_num_fields($result14);

// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
$heading = mysql_field_name($result14, $i);
$output .= '"'.$heading.'",';
}
$output .="\n";



// Get Records from the table

while ($row = mysql_fetch_array($result14)) {
for ($i = 0; $i < $columns_total; $i++) {
if($i==2 or $i==4)
{
$output .='"'."'".$row["$i"]."'".'",';
}
else
{
$output .='"'.$row["$i"].'",';
}


}
$output .="\n";
}



// Download the file

$filename = "myFile.csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;

}


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














