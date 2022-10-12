<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


//if($center_code != ''){$where_park=" and park='$center_code'";}

//if($month_number == ''){$month_number='07' ;}

echo "f_year=$f_year<br />";
echo "fyear=$fyear<br />";



$query21="truncate cvip_small_purchases; ";

$result21 = mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");


$query22="insert into cvip_small_purchases
(`ncas_center`,`ncas_account`,`ncas_invoice_date`,`datesql`,`ncas_invoice_number`,`vendor_name`,`vendor_number`,`group_number`,`comments`,`ncas_invoice_amount`,`ncas_po_number`,`source`)

SELECT ncas_center,ncas_account, ncas_invoice_date,datesql, ncas_invoice_number,vendor_name,vendor_number,group_number,comments,SUM( ncas_invoice_amount ),ncas_po_number ,'cdcs'
FROM cid_vendor_invoice_payments
WHERE datesql >=  '20140701'
and datesql <= '20150630'
AND ncas_center LIKE  '1280%'
group by id; ";

echo "query22=$query22<br /><br />";

$result22 = mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");


$query23="insert into cvip_small_purchases
(`ncas_center`,`ncas_account`,`ncas_invoice_date`,`datesql`,`ncas_invoice_number`,`vendor_name`,`comments`,`ncas_invoice_amount`,`source`)

SELECT center, ncasnum, trans_date,transdate_new, transid_new, vendor_name,item_purchased, SUM(amount ),'pcard'
FROM pcard_unreconciled
WHERE transdate_new >=  '20140701'
and transdate_new <= '20150630'
AND center LIKE  '1280%'
group by id ; ";

echo "query23=$query23<br /><br />";

$result23 = mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");


$query24="UPDATE cvip_small_purchases
SET datesql = REPLACE(datesql, '-', '')
WHERE 1; " ;

$result24 = mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");



$query25="update cvip_small_purchases
set datesql2=datesql
where 1; ";

$result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");



$query26="update cvip_small_purchases,coa_murphy
set cvip_small_purchases.account_category=coa_murphy.line_description,
cvip_small_purchases.budget_group=coa_murphy.budget_group
where cvip_small_purchases.ncas_account=coa_murphy.account; ";

$result26 = mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26");


$query26a="update cvip_small_purchases
set pcard_yn='y'
where source='pcard' ; ";

$result26a = mysqli_query($connection, $query26a) or die ("Couldn't execute query 26a.  $query26a");


$query26b="update cvip_small_purchases
           set comments=replace(comments,'\"','') ";

$result26b = mysqli_query($connection, $query26b) or die ("Couldn't execute query 26b.  $query26b");







$query27="update cvip_small_purchases
set valid='n'
where ncas_po_number != ''; ";

$result27 = mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27");


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

$result28 = mysqli_query($connection, $query28) or die ("Couldn't execute query 28.  $query28");


$query29="update cvip_small_purchases
set valid='n'
where account_category='revenues_other' and budget_group != 'pfr_expenses' ; ";

$result29 = mysqli_query($connection, $query29) or die ("Couldn't execute query 29.  $query29");


$query29a="update cvip_small_purchases
set valid='n'
where (ncas_account='531631' or ncas_account='531632' or ncas_account='531639' or ncas_account='532170') ";

$result29a = mysqli_query($connection, $query29a) or die ("Couldn't execute query 29a.  $query29a");


$query29b="update cvip_small_purchases
set valid='n'
where
(vendor_number='300712287'
 or vendor_number='30-0712287'
 or vendor_number='566000967'
 or vendor_number='56-6000967'
 or vendor_number='561130957'
 or vendor_number='56-1130957' 
 ) ";

$result29b = mysqli_query($connection, $query29b) or die ("Couldn't execute query 29b.  $query29b");


$query29c="update cvip_small_purchases
set valid='n'
where (ncas_account='532840' or ncas_account='532840001' or ncas_account='532840002' or ncas_account='532840003'
       or ncas_account='533800015' or ncas_account='533800016' or ncas_account='533800019' or ncas_account='533800029') ";

$result29c = mysqli_query($connection, $query29c) or die ("Couldn't execute query 29c.  $query29c");


$query29d="update cvip_small_purchases
set valid='n'
where
(ncas_account='532911' or ncas_account='532912' or ncas_account='532919' or ncas_account='532930'
       or ncas_account='532942' or ncas_account='532521' or ncas_account='532512' or ncas_account='532110'
	   or ncas_account='532120' or ncas_account='532133' or ncas_account='532140' or ncas_account='532143'
	   or ncas_account='532145' or ncas_account='532170' or ncas_account='532170001' or ncas_account='532170002'
	   or ncas_account='5321700019' or ncas_account='5321700021' or ncas_account='532181900'
) ";

$result29d = mysqli_query($connection, $query29d) or die ("Couldn't execute query 29d.  $query29d");



$query29e="update cvip_small_purchases
set valid='n'
where
(ncas_account like '535%') ";

$result29e = mysqli_query($connection, $query29e) or die ("Couldn't execute query 29e.  $query29e");


$query30="update cvip_small_purchases
set `month_number`=mid(`datesql`,5,2) 
where 1 ; ";

$result30 = mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");


$query31="update cvip_small_purchases
set `year_number`=mid(`datesql`,1,4) 
where 1 ;  ";

$result31 = mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");


$query32="update cvip_small_purchases
set month_name='july'
where month_number='07'; ";

$result32 = mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");


$query33="update cvip_small_purchases
set month_name='august'
where month_number='08'; ";

$result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

$query34="update cvip_small_purchases
set month_name='september'
where month_number='09'; ";

$result34 = mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34");

$query35="update cvip_small_purchases
set month_name='october'
where month_number='10';  ";

$result35 = mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");

$query36="update cvip_small_purchases
set month_name='november'
where month_number='11'; ";

$result36 = mysqli_query($connection, $query36) or die ("Couldn't execute query 36.  $query36");


$query37="update cvip_small_purchases
set month_name='december'
where month_number='12'; ";

$result37 = mysqli_query($connection, $query37) or die ("Couldn't execute query 37.  $query37");


$query38="update cvip_small_purchases
set month_name='january'
where month_number='01'; ";

$result38 = mysqli_query($connection, $query38) or die ("Couldn't execute query 38.  $query38");

$query39="update cvip_small_purchases
set month_name='february'
where month_number='02'; ";

$result39 = mysqli_query($connection, $query39) or die ("Couldn't execute query 39.  $query39");


$query40="update cvip_small_purchases
set month_name='march'
where month_number='03'; ";

$result40 = mysqli_query($connection, $query40) or die ("Couldn't execute query 40.  $query40");

$query41="update cvip_small_purchases
set month_name='april'
where month_number='04'; ";

$result41 = mysqli_query($connection, $query41) or die ("Couldn't execute query 41.  $query41");


$query42="update cvip_small_purchases
set month_name='may'
where month_number='05'; ";

$result42 = mysqli_query($connection, $query42) or die ("Couldn't execute query 42.  $query42");


$query43="update cvip_small_purchases
set month_name='june'
where month_number='06'; ";

$result43 = mysqli_query($connection, $query43) or die ("Couldn't execute query 43.  $query43");


$query44="update cvip_small_purchases,coa
set cvip_small_purchases.account_description=coa.park_acct_desc
where cvip_small_purchases.ncas_account=coa.ncasnum; ";

$result44 = mysqli_query($connection, $query44) or die ("Couldn't execute query 44.  $query44");


$query45="update cvip_small_purchases,center
set cvip_small_purchases.park=center.parkcode
where cvip_small_purchases.ncas_center=center.center; ";

$result45 = mysqli_query($connection, $query45) or die ("Couldn't execute query 45.  $query45");


$query45a="update cvip_small_purchases,center
set cvip_small_purchases.district=center.dist
where cvip_small_purchases.ncas_center=center.center; ";

$result45a = mysqli_query($connection, $query45a) or die ("Couldn't execute query 45a.  $query45a");








//echo "<table><tr><th>$month_total</th></table><br />";

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


if($rep != 'spreadsheet')
{

include("../../budget/menu1314.php");
include ("small_purchases_header2a.php");
if($month_number == ''){exit;}


if($level =='5')
{

$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 ";
}






if($level=='2' and $concession_location=='EADI')
{

$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 and district='east'
		 ";
}


if($level=='2' and $concession_location=='NODI')
{

$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 and district='north'
		 ";
}


if($level=='2' and $concession_location=='SODI')
{

$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 and district='south'
		 ";
}



if($level=='2' and $concession_location=='WEDI')
{

$query1="select sum(ncas_invoice_amount) as 'month_total'
         from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y' 
		 and district='west'
		 ";
}


		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
$month_total2=number_format($month_total,2);

if($level =='5')
{

$query5="
select receive_date2,ncas_invoice_date as 'invoice_date',ncas_invoice_number as 'invoice_trans_id',vendor_name,park,comments,account_description,ncas_invoice_amount as 'invoice_amount',pcard_yn,correction_enterprises_yn,monthly_total from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
         order by vendor_name,datesql2
";


echo "query5=$query5";
}


if($level=='2' and $concession_location=='EADI')
{

$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
		 and district='east'
         order by park,vendor_name,datesql2 ";
echo "query5=$query5";

}



if($level=='2' and $concession_location=='NODI')
{

$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
		 and district='north'
         order by park,vendor_name,datesql2 ";
echo "query5=$query5";

}


if($level=='2' and $concession_location=='SODI')
{

$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
		 and district='south'
         order by park,vendor_name,datesql2 ";
echo "query5=$query5";

}



if($level=='2' and $concession_location=='WEDI')
{

$query5="select * from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
		 and district='west'
         order by park,vendor_name,datesql2 ";
echo "query5=$query5";

}




$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
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
			 
if($level=='5')
{			 
$spreadsheet_icon="<a href='small_purchases_report2a.php?rep=spreadsheet&f_year=$f_year&month_number=$month_number' target='_blank'><img height='50' width='50' src='/budget/infotrack/icon_photos/csv1.png' alt='reports icon' title='spreadsheet download'></img>";
echo "<table><tr><td>$spreadsheet_icon</td></tr></table>";
}


echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Received</font></th>
       <th align=left><font color=brown>Invoice Date</font></th>
       <th align=left><font color=brown>Invoice#</font></th>
       <th align=left><font color=brown>Vendor</font></th>
       <th align=left><font color=blue>Park</font></th>
       <th align=left><font color=blue>Description of Items #1</font></th>
       <th align=left><font color=brown>Description of Items #2</font></th>
       <th align=left><font color=brown>Amount</font></th>
       <th align=left><font color=brown>Pcard Purchase (y/n)</font></th>
       <th align=left><font color=brown>Correction Enterprise Waiver Needed (y/n)</font></th>
       <th align=left><font color=brown>Monthly Total</font></th>
          ";
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){

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
     echo "<td>$receive_date2</td>
	       <td>$invoice_date</td>	
           <td>$invoice_trans_id</td>		   
           <td>$vendor_name</td>		   
           <td>$park</td>		   
           <td>$comments</td>		   
           <td>$account_description</td>		   
           <td>$invoice_amount</td>		   
           <td>$pcard_yn</td>		   
           <td>$correction_enterprises_yn</td>		   
           <td>$monthly_total</td>		   
          		   
           ";	
		   
		   
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
//echo "spreadsheet output";
$output = "";

/*
$query14="
select admin_num,concat("'",pcard_num,"'") as 'pcard_num',concat("'",transid_new,"'") as 'transid_new', id from pcard_unreconciled where admin_num='ADMN' and transdate_new >= '20141207' and transdate_new <= '20141222' order by transdate_new";
*/



$query14="
select receive_date2 as 'received',ncas_invoice_date as 'invoice date',ncas_invoice_number as 'invoice#',vendor_name as 'vendor',park,comments as 'description of items1',account_description as 'description of items2',ncas_invoice_amount as 'amount',pcard_yn as 'pcard purchase y/n',correction_enterprises_yn as 'correction enterprises waiver needed y/n',monthly_total as 'monthly total' from cvip_small_purchases
		 where 1
		 and f_year='$f_year'
		 and month_number='$month_number'
		 and valid = 'y'
         order by vendor_name,datesql2
";




//echo "query14=$query14<br />";//exit;

$result14 =mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


$columns_total = mysql_num_fields($result14);
//echo "columns_total=$columns_total<br />"; //exit;
// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
$heading = mysql_field_name($result14, $i);
$output .= '"'.$heading.'",';
}
$output .="\n";



// Get Records from the table

while ($row = mysqli_fetch_array($result14)) {
for ($i = 0; $i < $columns_total; $i++) {
/*
if($i==2 or $i==4)
{
$output .='"'."'".$row["$i"]."'".'",';
}
else
*/
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


 


























	














