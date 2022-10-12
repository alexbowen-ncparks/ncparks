<?php

session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}


$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo "tempid=$tempid";
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//$crj_prepared_by=$_SESSION['budget']['acsName'];
if($concession_center== '12802953'){$concession_center='12802751' ;}
//if($tempid=='adams_s' and $concession_location='CRMO'){echo "Stacey Adams";}
//echo "concession_location=$concession_location";//exit;
//echo "postitle=$posTitle";exit;

//$crj_prepared_by=@$_SESSION['budget']['acsName'];


/*
	$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
*/	
	

extract($_REQUEST);

$deposit_id_first4 = substr($deposit_id, 0, 4);



//echo "deposit_id_first4=$deposit_id_first4<br />";

//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "tempID=$tempID<br />";
//echo "tempid=$tempid<br />";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

/*
if($tempid=='Kalish1629')
{
$approved_by_user=$tempid;
$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	//$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname as Nname_approver,Fname as Fname_approver,Lname as Lname_approver From empinfo where tempID='$approved_by_user'";
	//echo "sql=$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname_approver){$Fname_approver=$Nname_approver;}
	$approved_by=$Fname_approver." ".$Lname_approver;
}
*/




//echo "approved_by=$approved_by";
$database="budget";
//$db="budget";
//echo "<br />Hello Line 81<br />";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

if($deposit_id_first4=='ADMI')
{
$query0="select budget_code as 'budget_code_multiple' from crs_tdrr_division_history_parks
		  where deposit_id='$deposit_id'
          group by budget_code		  ";

$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query 0. $query0");
$num0=mysqli_num_rows($result0);	

if($num0>1 and $show_crj != 'y')
{
echo "<table border='1' align='center'>";
echo "<tr><td><font color='red' size='6'>$num0 CRJ's for Deposit ID: $deposit_id</font></td></tr>";
echo "</table>";
echo "<br />";
echo "<table border='1' align='center'>";
echo "<tr><td><font color='blue' size='6'>Budget Code</font></td></tr>";
while ($row0=mysqli_fetch_array($result0))
{
extract($row0);	
echo "<tr><td><font color='green' size='6'>$budget_code_multiple</font></td><td><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&dncr=$dncr&GC=$GC&budget_codeS=$budget_code_multiple&show_crj=y' target='_blank'>View Journal</a></tr>";	
	
}	
echo "</table>";	
exit;	
	
}

if($num0==1 and $show_crj != 'y')
{
$query1a="select budget_code as 'admi_bc'
          from crs_tdrr_division_history_parks
		  where deposit_id='$deposit_id' ";

$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");

$row1a=mysqli_fetch_array($result1a);

extract($row1a);

$admi_1bc='yes';
	
}


}

// Added on 2/2/19
if($deposit_id_first4=='ADMI')
{
$query1="select document_location as 'admi_document'
          from crs_tdrr_division_deposits
		  where orms_deposit_id='$deposit_id' ";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

//echo "<br />admi_document=$admi_document";
}	











$table="crs_tdrr_division_history_parks";

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

$deposit_id_GC=$deposit_id.'GiftCard';
//echo "deposit_id_GC=$deposit_id_GC<br />";
$query11="SELECT count( deposit_id ) as 'deposits'
FROM crs_tdrr_division_history_parks
WHERE deposit_id='$deposit_id'
and ncas_account='000218110'
";
/*
if($deposit_id='77416234')
{
echo "query11=$query11";
}
*/
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
$row11=mysqli_fetch_array($result11);

extract($row11);

$deposits=mysqli_num_rows($result11);

//echo "<br />Line 197: deposits=$deposits<br />";


$query11a="update crs_tdrr_division_history_parks,center
          set crs_tdrr_division_history_parks.center_parkcode=center.parkcode
		  where crs_tdrr_division_history_parks.center=center.new_center
		  and crs_tdrr_division_history_parks.admi='y'
		  and crs_tdrr_division_history_parks.center_parkcode='' ";


$result11a = mysqli_query($connection, $query11a) or die ("Couldn't execute query 11a.  $query11a");		  
		  

$query11a1="update crs_tdrr_division_history_parks,center
          set crs_tdrr_division_history_parks.center_parkcode=center.parkcode
		  where crs_tdrr_division_history_parks.old_center=center.old_center
		  and crs_tdrr_division_history_parks.admi='n'
		  and crs_tdrr_division_history_parks.center_parkcode='' ";


$result11a1 = mysqli_query($connection, $query11a1) or die ("Couldn't execute query 11a1.  $query11a1");

		  
/*
if($deposit_id='77416234')
{
echo "query11=$query11";
}
*/




echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
//include("../../../budget/menu1314.php");
//include("../../../budget/menu1314_no_header.php");
include ("test_style.php");

echo "</head>";

//include ("widget2.php");
//include("../../budget/menus2.php");
//include("widget1.php");
if($dncr==''){$dncr='y';}
if($GC=='n'){$shade_deposit_id="class=cartRow";}
if($GC=='y'){$shade_deposit_id_GC="class=cartRow";}

if($GC=='n'){$GCN="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($GC=='y'){$GCY="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($GC=='n' and $dncr=='n'){$budcode='14300';}
if($GC=='n' and $dncr=='y'){$budcode='14800';}
if($GC=='y' and $dncr=='n'){$budcode='24309';}
if($GC=='y' and $dncr=='y'){$budcode='24820';}

//added on 2/11/19 for ADMI CRJ's with multiple Budget Codes
if($GC=='n' and $dncr=='y' and $show_crj=='y'){$budcode=$budget_codeS;}
if($GC=='n' and $dncr=='y' and $admi_1bc=='yes'){$budcode=$admi_bc;}

//echo "<br />Line 237: budcode=$budcode<br />";
/*
else{$budcode='24309';}
if($GC=='n' and $dncr=='y'){$budcode='14800';}else{$budcode='24814';}
*/

/*
if($deposits=='1')
{echo "<table><tr><th>Your Deposit included Gift Card Sales. 2 Cash Receipts Journals must be printed & submitted to Controllers Office. Please Contact DPR Budget Office with questions. Thanks</th></tr></table> ";}
*/

//$deposit_id_GC='';
 
 //if($GC=='y'){$deposit_id2=$deposit_id.'GiftCard';}
 //if($GC=='n'){$deposit_id2=$deposit_id;}

/*
$query12a="SELECT max(deposit_date_new) as 'deposit_date_new_header'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$deposit_id2'
 and deposit_transaction='y'
 ";
 
$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");

$row12a=mysqli_fetch_array($result12a);
extract($row12a);//brings back number of records paid by check
//echo "check count=$ck_count";
$deposit_date_new_header2=date('m-d-y', strtotime($deposit_date_new_header));
*/

$query12a="SELECT controllers_deposit_id,bank_deposit_date,cashier,manager,manager_date,checks,document_location,document_location_old,park as 'crj_park',cashier_overshort_comment,manager_overshort_comment,fs_approver_overshort_comment,accountant_comment,id,dncr_gift_edit
 from crs_tdrr_division_deposits
 WHERE 1 and orms_deposit_id='$deposit_id'
 
  ";

//echo "query12a=$query12a<br />"; 


$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");

$row12a=mysqli_fetch_array($result12a);
extract($row12a);//brings back number of records paid by check

$query12a1="select county,tax_rate_total
            from center_taxes
			where parkcode='$crj_park' ";


$result12a1 = mysqli_query($connection, $query12a1) or die ("Couldn't execute query 12a1.  $query12a1");

$row12a1=mysqli_fetch_array($result12a1);
extract($row12a1);//brings back number of records paid by check

//echo "county=$county<br /><br />";
//echo "tax_rate_total=$tax_rate_total<br /><br />";

/*
echo "cashier_comment=$cashier_overshort_comment<br />manager_comment=$manager_overshort_comment<br />budget_office_comment=$fs_approver_overshort_comment<br />";
*/
//echo "check count=$ck_count";

if($cashier_overshort_comment=='' and $manager_overshort_comment=='' and $fs_approver_overshort_comment=='' and $accountant_comment==''){$overshort_comments='NO';}else{$overshort_comments='YES';}
//echo "overshort_comments=$overshort_comments<br />";
//bank deposit_date
if($bank_deposit_date != '0000-00-00')
{
$bank_deposit_date2=date('m-d-Y', strtotime($bank_deposit_date));
}
else
{
$bank_deposit_date2=$bank_deposit_date;
}  

//manager_approver_date
if($manager_date != '0000-00-00')
{
$manager_date2=date('m-d-Y', strtotime($manager_date));
}
else
{
$manager_date2="";
}  


//Query to bring back the Web Store Adjustment
// If Deposit includes Sales for Product ID:  72652 (Webstore-Event Sales), then those Sales need to be taken away from Park
// and Credited to the Web Store Center:  1680507

$query12a2="select sum(amount) as 'webstore_adjustment'
            from crs_tdrr_division_history_parks
			WHERE deposit_id='$deposit_id'
            and product_id='72652'
            and ncas_account='434150004'			";


$result12a2 = mysqli_query($connection, $query12a2) or die ("Couldn't execute query 12a2.  $query12a2");

$row12a2=mysqli_fetch_array($result12a2);
extract($row12a2);


$query12a3="select sum(amount) as 'vendor_fee_adjustment'
            from crs_tdrr_division_history_parks
			WHERE deposit_id='$deposit_id'
            and ncas_account='435900001'			";


$result12a3 = mysqli_query($connection, $query12a3) or die ("Couldn't execute query 12a3.  $query12a3");

$row12a3=mysqli_fetch_array($result12a3);
extract($row12a3);
if($vendor_fee_adjustment and $deposit_id=='243571880')
{

$vendor_fee_435900001=number_format($vendor_fee_adjustment*.83333,2);
$vendor_fee_000437990=number_format($vendor_fee_adjustment*.16667,2);
if($deposit_id=='243571880')
{
echo "<br />vendor_fee_adjustment=$vendor_fee_adjustment<br />";
echo "<br />vendor_fee_435900001=$vendor_fee_435900001<br />";
echo "<br />vendor_fee_000437990=$vendor_fee_000437990<br />";
}
}





/*
if($webstore_adjustment)
{
echo "webstore_adjustment=$webstore_adjustment<br />";
}
*/

//echo "bank_deposit_date=$bank_deposit_date<br />";
//echo "controllers_deposit_id=$controllers_deposit_id<br />";

include ("crj_header_final.php");

 if($beacnum=='60032793')
 {
 $pid='72';
 include("../../../budget/infotrack/slide_toggle_procedures_module2_abstract.php");
 }


//echo "deposits=$deposits";
 {echo "<br />";  echo "<table align='center'><tr><th><a href='/budget/menu1314.php'>
 <img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home'></img></a></th><th>
 <a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'>
 <img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></a></th><th>Cash Receipts Journal (2.14)- ORMS Deposit ID</th><td>$GCN <a href=crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&GC=n&dncr=$dncr><font $shade_deposit_id>$deposit_id</font></a>";
echo "<br /><a href='crs_deposit_transactions.php?deposit_id=$deposit_id' style='text-decoration:none;' target='_blank'>trans detail</a>";
if($deposit_id_first4=='ADMI'){echo "<br /><a href='/budget/cash_sales/bank_deposit_step2_reload_deposit_slip.php?deposit_id=$deposit_id'>Re-Load Deposit Slip</a>";}
 echo "</td>";
 //changed from if($deposits==1) on 6/26/14
// if($deposit_id=='259397586')
	
//echo "<br />dncr_gift_edit=$dncr_gift_edit<br />";
 if($dncr_gift_edit=='y')
{
$bank_deposit_date3=str_replace('-','',$bank_deposit_date);	 
//echo "<br />bank_deposit_date3=$bank_deposit_date3<br />";
//if($bank_deposit_date3 > '20200110')
//{	
//echo "<br />Line 423: bank_deposit_date=$bank_deposit_date<br />";
//}
$deposits=0;
if($bank_deposit_date3 <= '20200121'){$GC='n';}
//$GC='n';	
if($bank_deposit_date3 >= '20200122')
{	
$query12a4="SELECT count( deposit_id ) as 'deposits'
FROM crs_tdrr_division_history_parks
WHERE deposit_id='$deposit_id'
and ncas_account='000218110'
";

//echo "<br />query12a4=$query12a4<br />";

$result12a4 = mysqli_query($connection, $query12a4) or die ("Couldn't execute query 12a4.  $query12a4");
$row12a4=mysqli_fetch_array($result12a4);

extract($row12a4);
//if($deposits>=1 and ){$GC='y';}
//echo "<br />Line 446: deposits=$deposits<br />";
//echo "<br />Line 447: GC=$GC<br />";
}



 
 //echo "<br />deposits=$deposits<br />";
 //echo "<br />crj_park=$crj_park<br />";

 }
//echo "<br />Line 458: deposits=$deposits<br />";
 if($deposits>=1){echo "<td>$GCY<a href=crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&GC=y&dncr=$dncr><font $shade_deposit_id_GC>$deposit_id_GC</font></a></td>";}
 "</tr></table>";}
 
 //$deposit_id_GC='';
 
 //if($GC=='y'){$deposit_id2=$deposit_id.'GiftCard';}
 //if($GC=='n'){$deposit_id2=$deposit_id;}

 {
 if($GC=='n') 
 { 
 if($deposit_id_first4 != 'ADMI')
 {
if($dncr_gift_edit=='y')
{
//echo "<br />bank_deposit_date=$bank_deposit_date<br />";	
//echo "<br />bank_deposit_date2=$bank_deposit_date2<br />";	
if($bank_deposit_date3 <= '20200121')
{	
 $query12="SELECT crs_tdrr_division_history_parks.center,center.parkcode,taxcenter,ncas_account,account_name,taxable,sum(amount) as 'amount' from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.old_center=center.old_center
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 group by center,ncas_account
 order by center,ncas_account";
}

if($bank_deposit_date3 >= '20200122')
{
$query12="SELECT crs_tdrr_division_history_parks.center,center.parkcode,taxcenter,ncas_account,account_name,taxable,sum(amount) as 'amount' from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.old_center=center.old_center
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and crs_tdrr_division_history_parks.ncas_account != '000218110'
 group by center,ncas_account
 order by center,ncas_account";
}


 }
 
 
 if($dncr_gift_edit!='y')
{
 $query12="SELECT crs_tdrr_division_history_parks.center,center.parkcode,taxcenter,ncas_account,account_name,taxable,sum(amount) as 'amount' from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.old_center=center.old_center
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and crs_tdrr_division_history_parks.ncas_account != '000218110'
 group by center,ncas_account
 order by center,ncas_account";
 }
 
 
 
//echo "<br />Line 516: query12=$query12<br />";
 
 
 
 }
 if($deposit_id_first4 == 'ADMI')
 {
if($dncr_gift_edit=='y' and $show_crj=='y')
{	 
 $query12="SELECT crs_tdrr_division_history_parks.center,
 crs_tdrr_division_history_parks.center_parkcode as 'parkcode',
 crs_tdrr_division_history_parks.taxcenter,
 crs_tdrr_division_history_parks.ncas_account,
 crs_tdrr_division_history_parks.account_name,
  crs_tdrr_division_history_parks.company as 'company_line',
 coa.taxable,
 sum(amount) as 'amount' 
 from crs_tdrr_division_history_parks
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and budget_code=$budget_codeS
 and deposit_transaction='y'
 group by center,company_line,ncas_account
 order by center,company_line,ncas_account";
 
}


if($dncr_gift_edit=='y' and $show_crj!='y')
{	 
 $query12="SELECT crs_tdrr_division_history_parks.center,
 crs_tdrr_division_history_parks.center_parkcode as 'parkcode',
 crs_tdrr_division_history_parks.taxcenter,
 crs_tdrr_division_history_parks.ncas_account,
 crs_tdrr_division_history_parks.account_name,
  crs_tdrr_division_history_parks.company as 'company_line',
 coa.taxable,
 sum(amount) as 'amount' 
 from crs_tdrr_division_history_parks
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 group by center,company_line,ncas_account
 order by center,company_line,ncas_account";
 
}





//echo "<br />query12=$query12<br />";








if($dncr_gift_edit!='y')
{	 
 $query12="SELECT crs_tdrr_division_history_parks.center,
 crs_tdrr_division_history_parks.center_parkcode as 'parkcode',
 crs_tdrr_division_history_parks.taxcenter,
 crs_tdrr_division_history_parks.ncas_account,
 crs_tdrr_division_history_parks.account_name,
 coa.taxable,
 sum(amount) as 'amount' 
 from crs_tdrr_division_history_parks
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and crs_tdrr_division_history_parks.ncas_account != '000218110'
 group by center,ncas_account
 order by center,ncas_account";
 
}










 }
  
 }
 if($GC=='y') 
 { 
 $query12="SELECT crs_tdrr_division_history_parks.center,
 center.parkcode,
 taxcenter,
 ncas_account,
 account_name,
 taxable,
 sum(amount) as 'amount'
 from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.old_center=center.old_center
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and crs_tdrr_division_history_parks.ncas_account='000218110'
 group by center,ncas_account
 order by center,ncas_account";
 }
 
 
//echo "query12=$query12";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);	
 
 
 
 $query12c="SELECT sum(amount) as 'taxable_fuel'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and ncas_account='434140003'
 and product_id='8423'
 ";
 
$result12c = mysqli_query($connection, $query12c) or die ("Couldn't execute query 12c.  $query12c");

$row12c=mysqli_fetch_array($result12c);
extract($row12c);//brings back number of records paid by check
if($taxable_fuel==''){$taxable_fuel=0.00;}
//echo "taxable_fuel=$taxable_fuel<br /><br />"; 
 
 
 $query12d="SELECT sum(amount) as 'untaxable_fuel'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and ncas_account='434140003'
 and product_id='8424'
 ";
 
$result12d = mysqli_query($connection, $query12d) or die ("Couldn't execute query 12d.  $query12d");

$row12d=mysqli_fetch_array($result12d);
extract($row12d);//brings back number of records paid by check


if($untaxable_fuel==''){$untaxable_fuel=0.00;}
 
//echo "untaxable_fuel=$untaxable_fuel<br /><br />"; 
 
 
 
 $query12e="SELECT sum(amount) as 'taxable_other'
 from crs_tdrr_division_history_parks
 left join coa on crs_tdrr_division_history_parks.ncas_account=coa.ncasnum2
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 and taxable='y'
 and ncas_account!='434140003'
 ";
 
$result12e = mysqli_query($connection, $query12e) or die ("Couldn't execute query 12e.  $query12e");

$row12e=mysqli_fetch_array($result12e);
extract($row12e);//brings back number of records paid by check
 
//echo "taxable_other=$taxable_other<br /><br />"; 
 
 
 
 
 if($taxable_fuel > 0){$fuel_tax_footnote='*** Only Diesel Sales of '.$taxable_fuel.' are taxable';}
 //echo "fuel_tax_footnote=$fuel_tax_footnote<br />";
 
 
 if($taxable_other > 0){$other_tax_footnote='****Sales are taxable';}
 //echo "other_tax_footnote=$other_tax_footnote<br />";
 
 
 
 /*
 $query_ck="SELECT count(payment_type) as 'ck_count'
            from crs_tdrr_division_history_parks
            where deposit_id='$deposit_id2'
            and	payment_type='per chq' ";

$result_ck = mysqli_query($connection, $query_ck) or die ("Couldn't execute query ck.  $query_ck");

$row_ck=mysqli_fetch_array($result_ck);
extract($row_ck);//brings back number of records paid by check
//echo "check count=$ck_count";
if($ck_count > 0){$check='yes';} else {$check='no';}
*/

$query12b="SELECT min(transdate_new) as 'mindate_footer',max(transdate_new) as 'maxdate_footer'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check
//echo "check count=$ck_count";
$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;

 
 
 $query13="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id2'
			and deposit_transaction='y'
			 ";
//echo "query13=$query13";			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);
 
 
$query14="SELECT sum(amount) as 'total_debits' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id2'
			and amount < '0'
            and deposit_transaction='y' ";
			
 $result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);
 $row14=mysqli_fetch_array($result14);
 extract($row14);
 $total_debits=number_format($total_debits,2);
 
 $query15="SELECT sum(amount) as 'total_credits' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id2'
			and amount >= '0' 
			and deposit_transaction='y' ";
			
 $result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
 $num15=mysqli_num_rows($result15);
 $row15=mysqli_fetch_array($result15);
 extract($row15);
 $total_credits=number_format($total_credits,2); 
 
 
 
 
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
echo "<table border=1 align='center'>";

echo 

"<tr> 
       <th>Line#</th>
       <th>Park</th>
       <th>Company</th>
       <th>Account</th>
       <th>Center</th>
       <th>Amount</th>
       <th>Debit/Credit</th>
       <th>Line Description</th>
       <th>Acct Rule</th>
              
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
$var_total_credit="";
$var_total_debit="";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	//if($ncas_account=='000211940'){$center=$taxcenter;}
	//if($ncas_account=='000211940'){$account_name=$account_name.'for new hanover county at 7.00%';}
	if($ncas_account=='000211940'){$account_name='sales tax ('.$county.' county '.$tax_rate_total.' %)';}
	//if($taxable=='y' and $ncas_account!='000211940'){$account_name='***'.$account_name;}
	if($taxable=='y' and $ncas_account != '434140003' and $ncas_account != '000434390'){$account_name='****'.$account_name;}
	if($taxable=='y' and $ncas_account == '434140003' and $taxable_fuel > 0){$account_name='***'.$account_name;}
	if($taxable=='y' and $ncas_account == '000434390' and $parkcode=='FOMA'){$account_name='***'.$account_name;}
	
	if($amount < '0')
		{
		$var_total_debit+=$amount;
		$sign="debit";
		}
		else
		{
		$var_total_credit+=$amount;
		$sign="credit";
		}
		
    if($ncas_account=='434150004'){$amount=$amount-$webstore_adjustment;}	
	$amount=number_format($amount,2);
	if($crj_park != 'MEMO')
	{
	if($ncas_account=='000218110'){$center="2235";}
	}
	
	//if($crj_park == 'MEMO')
	{
	//if($ncas_account=='000218110'){$center="1680504"; $ncas_account="434390005";}
	  if($ncas_account=='000218110'){$center="2235";}
	}
	
	
	
	
	if($ncas_account=='435900001' and $dncr=='n'){$center="12802751";}
	if($ncas_account=='435900001' and $dncr=='y'){$center="1680504";}	
	if($ncas_account=='435900001' and $deposit_id=='243571880'){$amount=$vendor_fee_435900001;}	
	if($ncas_account=='000200000'){$ncas_account="";}
	if($ncas_account=='000300000'){$ncas_account=""; $account_name="Raleigh Refund by Check";}
	//if($center=='2235'){$company='1602';} else {$company='1601';}
	if($center=='2235' and $dncr=='n'){$company="1602";}
	if($center=='2235' and $dncr=='y'){$company="4602";}	
	if($center!='2235' and $dncr=='n'){$company="1601";}
	if($center!='2235' and $dncr=='y'){$company="4601";}
	
	
	if($deposit_id_first4 == 'ADMI'){$company=$company_line;}
	
	// not all Deposits will have a webstore adjustment, but if deposit has a webstore adjustment ($webstore_adjustment), it will be backed
	// out of the Park total for Account 434150004 (PFR Revenues-Other)  and a New Line will be added to the bottom of the CRJ 
	// for WebStore Center: 1680507
	
	  //if($ncas_account=='434150004'){$amount=$amount-$webstore_adjustment;}
	

	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
	if($sign=="debit"){$sto="<strong>(";$stc=")</strong>";}else{$sto="";$stc="";}
	if($amount != '0.00')
		{
		@$rank=$rank+1;

		echo 

		"<tr$t> 
					<td>$rank</td>
					<td>$parkcode</td>			
					<td>$company</td>
					<td>$ncas_account</td>
					<td>$center</td>
					<td>$sto $amount $stc</td>
					<td>$sto $sign $stc</td>
					<td>$account_name</td>
					<td></td>             
		   
		</tr>";


		}
		
	
	}
if($webstore_adjustment)
{	
@$rank=$rank+1;	
echo "<tr bgcolor='yellow'><td><font color='red'>$rank</font></td><td><font color='red'>WEBS</font></td><td><font color='red'>4601</font></td><td><font color='red'>434150004</font></td><td><font color='red' size='6'>1680507</font></td><td><font color='red'>$webstore_adjustment</font></td><td><font color='red'>credit</font></td><td><font color='red'>***PFR Revenues-Other</font></td><td></td></tr>";
}	
//$vendor_fee_435900001=number_format($vendor_fee_adjustment*.83333,2);
//$vendor_fee_000437990=number_format($vendor_fee_adjustment*.16667,2);

if($vendor_fee_adjustment and $deposit_id=='243571880')
{
	
@$rank=$rank+1;	
echo "<tr bgcolor='yellow'><td><font color='red'>$rank</font></td><td><font color='red'>$parkcode</font></td><td><font color='red'>4601</font></td><td><font color='red'>000437990</font></td><td><font color='red' size='6'>1680504</font></td><td><font color='red'>$vendor_fee_000437990</font></td><td><font color='red'>credit</font></td><td><font color='red'>***Miscellaneous Revenues ($vendor_fee_adjustment x .166667)</font></td><td></td></tr>";
}	


$grand_total=$var_total_credit+$var_total_debit;

$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);
$grand_total=number_format($grand_total,2);



while ($row13=mysqli_fetch_array($result13)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row13);
//2 lines below commented out on 2/8/14 TBASS
//$total_amount=number_format($total_amount,2);
//if($total_amount < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
}
/*
echo "<tr$t><form> 
            <td colspan='2'>Checks:<select name='checks_included'>
  <option value=''></option>
  <option value='yes'>YES</option>
  <option value='no'>NO</option>
  </select></td><td colspan='3'>Revenue Collection Period:<br /><input type='text' name='collection_period' value='' size='45'><br /><br /></td>
		    <td></td>
		    <td></td>
		    <td></td>          
</tr>";
*/
if($checks=='y'){$checks="YES";}
if($checks=='n'){$checks="NO";}

echo "<tr$t><form>";
if($checks=='NO')
{
echo "<td colspan='2'><font color='red'>Checks: $checks</font>";

if($document_location_old)
{
echo "<br /><br /><a href='$document_location_old' target='_blank' style='text-decoration:none;'>Deposit Slip</a>";
}
else
{
	
if($deposit_id_first4=='ADMI'){echo "<br /><br /><a href='$admi_document' target='_blank'>Deposit Slip</a>";}	
if($deposit_id_first4!='ADMI'){echo "<br /><br /><a href='bank_deposit_slip.php?id=$id' target='_blank' style='text-decoration:none;'>Deposit Slip</a>";}
if($overshort_comments=='NO')
{
if($beacnum=='60032781' or $beacnum=='60036015'){echo "<br />Comments: <a href='overshort_comments.php?id=$id' target='_blank'>$overshort_comments</a>";}
if($beacnum!='60032781' and $beacnum!='60036015'){echo "<br />Comments: $overshort_comments";}
}


if($overshort_comments=='YES'){echo "<br />Comments: <a href='overshort_comments.php?id=$id' target='_blank'>$overshort_comments</a>";}
 echo "</td>";
}
}  
 if($checks=='YES')
{

if($document_location_old)
{

echo "<td colspan='2'><font color='red'>Checks:</font><a href='$document_location_old' target='_blank' style='text-decoration:none;'>YES</a>";
}
else
{
if($deposit_id_first4=='ADMI'){echo "<td colspan='2'><font color='red'>Checks:</font><a href='check_listing_admin.php?id=$id' target='_blank' style='text-decoration:none;'>YES</a>";}
if($deposit_id_first4!='ADMI'){echo "<td colspan='2'><font color='red'>Checks:</font><a href='check_listing.php?id=$id' target='_blank' style='text-decoration:none;'>YES</a>";}
}

if($document_location_old)

{
echo "<br /><br /><a href='$document_location_old' target='_blank' style='text-decoration:none;'>Deposit Slip</a>";


  echo "</td>";

}
else
{
	
if($deposit_id_first4=='ADMI'){echo "<br /><br /><a href='$admi_document' target='_blank'>Deposit Slip</a>";}
if($deposit_id_first4!='ADMI'){echo "<br /><br /><a href='bank_deposit_slip.php?id=$id' target='_blank' style='text-decoration:none;'>Deposit Slip</a>";}

if($overshort_comments=='NO')
{
//echo "<br />Comments: $overshort_comments";

if($beacnum=='60032781' or $beacnum=='60036015'){echo "<br />Comments: <a href='overshort_comments.php?id=$id' target='_blank'>$overshort_comments</a>";}
if($beacnum!='60032781' and $beacnum!='60036015'){echo "<br />Comments: $overshort_comments";}

}
if($overshort_comments=='YES'){echo "<br />Comments: <a href='overshort_comments.php?id=$id' target='_blank' style='text-decoration:none;'>$overshort_comments </a>";}
  echo "</td>";
}

  
} 
  
  
  
  
 echo "<td colspan='3'><font color='red'>Revenue Collection Period:</font><br /><input type='text' name='collection_period' value='$revenue_collection_period' size='45'><br />
		    <td>Total Debits<br />Total Credits<br /><br />Grand Total</td>
		    <td>$var_total_debit<br />$var_total_credit<br /><br />$grand_total</td>
		    <td><table><tr><td>$fuel_tax_footnote</td></tr><tr><td>$other_tax_footnote</td></tr></table></td>          
</tr>";



$var_total_credit=number_format($var_total_credit,2);
$var_total_debit=number_format($var_total_debit,2);
//echo "tempID=$tempID<br />";
//echo "tempid=$tempid<br />";
//echo "cashier=$cashier<br />";
//echo "manager=$manager<br />";

$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "cashier=$cashier<br />";
if($cashier=='Deaton1222' and $parkcode=='GRMO'){$cashier="Siler1222";}
//echo "cashier=$cashier<br />";
if($cashier)
{
	$sql = "SELECT Nname,Fname,Lname,phone From empinfo where tempID='$cashier'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
	
echo "sql=$sql";
	if($Lname=='')
	{
	$sql = "SELECT Fname,Lname From nondpr where tempID='$cashier'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$crj_prepared_by=$Fname." ".$Lname;
	}
	
}



if($cashier=='adams_s' and $parkcode=='CRMO'){$crj_prepared_by="Stacey Adams";}
if($cashier=='taub_j' and $parkcode=='FALA'){$crj_prepared_by="Judy Taub";}
if($cashier=='sigmon' and $parkcode=='SOMO'){$crj_prepared_by="Allendria Sigmon";}
if($cashier=='wagner9210' and $parkcode=='LAWA'){$crj_prepared_by="Paula Wagner";}
if($cashier=='Eaves9964' and $parkcode=='CRMO'){$crj_prepared_by="Christina Eaves";}
if($cashier=='Williams9358' and $parkcode=='FOFI'){$crj_prepared_by="Gina Williams";}
if($cashier=='Schliebener' and $parkcode=='CACR'){$crj_prepared_by="Jessica Schliebener";}
if($cashier=='Harmon_RARO' and $parkcode=='RARO'){$crj_prepared_by="Elizabeth Harmon";}
if($cashier=='Rumble2030'){$crj_prepared_by="Heide Rumble";}



if($manager)

{
$sql2 = "SELECT Nname,Fname,Lname,phone From divper.empinfo where tempID='$manager'";
	$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query2. $sql2");
	$num2=mysqli_num_rows($result2);
	$row2=mysqli_fetch_array($result2);
if($num2 == 0)
	{
$sql2 = "SELECT first_name as 'Fname',last_name as 'Lname',nick_name as 'Nname' From budget.cash_handling_roles where tempid='$manager' limit 1";
	$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query2. $sql2");
	$num2=mysqli_num_rows($result2);
	$row2=mysqli_fetch_array($result2);		
	}
	
	extract($row2);	
	if($Nname){$Fname=$Nname;}
	if($num2 != 0){$crj_approved_by=$Fname." ".$Lname;} else {$crj_approved_by="missing";}

}	
//echo "sql=$sql<br />";
//echo "crj_approved_by=$crj_approved_by<br />";

/*
if($manager=='kendrick1234')
{	
echo "sql2=$sql2<br />";
echo "crj_approved_by=$crj_approved_by<br />";
echo "crj_approved_by_num=$num2<br />";
echo "manager=$manager<br />";
}
*/

$database="photos";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
	$sql3 = "SELECT link as 'cashier_signature' From signature where personID='$cashier'";
	//echo "sql3=$sql3<br />";
	$result3 = mysqli_query($connection, $sql3) or die ("Couldn't execute query3. $sql3");
	$row3=mysqli_fetch_array($result3);
	extract($row3);
	
//$cashier_sig1="/photos/".$cashier_signature;	
$cashier_sig1="/divper/".$cashier_signature;	
//$cashier_sig1="/budget/".$cashier_signature;
//echo "cashier_sig1=$cashier_sig1<br />";


$sql4 = "SELECT link as 'manager_signature' From signature where personID='$manager'";
	//echo "sql4=$sql4<br />";
	$result4 = mysqli_query($connection, $sql4) or die ("Couldn't execute query4. $sql4");
	$row4=mysqli_fetch_array($result4);
	extract($row4);
	
if($manager_signature=='')
{
$manager_sig1='';
}
else
{	
//$manager_sig1="/photos/".$manager_signature;
$manager_sig1="/divper/".$manager_signature;
//$manager_sig1="/budget/".$manager_signature;
}
//echo "manager_sig1=$manager_sig1<br />";


$database="dpr_system";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql5="select ophone from dprunit where parkcode='$crj_park' ";    //$crj_park comes from line 167
$result5 = mysqli_query($connection, $sql5) or die ("Couldn't execute query5. $sql5");
$row5=mysqli_fetch_array($result5);
extract($row5);

if($cashier=='Rumble2030'){$ophone='(919) 707-9315';}
/*
echo "<tr><td colspan='2'><font color='red'>Prepared by:</font><br /><br />Approved by:<br /><br />Entered by</td><td colspan='3'><input type='text' name='entered_by' value='$crj_prepared_by' size='20'><font color='red'>Phone#</font><input type='text' name='entered_by' value='$phone' size='15'><br /><br /><input type='text' name='approved_by' value='$approved_by' size='20'>Date:<input type='text' name='approved_date' value='$deposit_date_new_header2' size='15'><br /><br /><input type='text' name='entered_by' value='' size='20' readonly='readonly'>Date:______________</td></form>";
*/

echo "<tr><td colspan='6'><font color='red'><table><tr><td>Prepared by:</font></td><td>$crj_prepared_by<br /><img height='40' width='200' src='$cashier_sig1' ></img></td><td><font color='red'>Phone#</font>$ophone</td></tr><tr><td><font color='red'>Approved by:</font></td><td>$crj_approved_by<br />";

if($manager_sig1)
{
echo "<img height='40' width='200' src='$manager_sig1' ></img>";
}

echo "</td><td><font color='red'>Date:</font>$manager_date2</td></tr><tr><td>Entered by</td><td><input type='text' name='entered_by' value='' size='20' readonly='readonly'></td><td>Date:______________</td></form></tr>";

//<img height='50' width='200' src='$cashier_sig1' ></img>

//echo "<td>Total Debits</td><td>$var_total_debit</td></tr>";


include("../../../budget/~f_year.php");



/*
echo "<tr></tr><tr></tr><tr></tr>";
echo "<tr></tr><tr></tr><tr></tr>";

*/
//echo "<tr></tr><tr></tr><tr></tr>";
//echo "<tr></tr><tr></tr><tr></tr>";
/*
echo "<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total Credits</td>
		   <td>$var_total_credit</td>
           
</tr>";
*/
/*
echo "<tr></tr><tr></tr><tr></tr>";
echo 

"<tr$t> 
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>$var_total_credit</td>
		    <td>Total Credits</td>
		   
           
</tr>";

*/




 echo "</table>";
 
// echo "document_location=$document_location";//exit;
 
//echo "<object data='$document_location' type='application/pdf' width='100%' height='100%'>";
 
 
//include($document_location);
  
//include("check_listing.php");

/*
 echo "<table>
 <tr><td>";
 echo "<img height='1000' width='1000' src='$document_location'></img>";
 echo "</td>";
 echo "</tr>";
 echo "</table>";
*/
 
/*
  echo "<table>
 <tr><td>";
 echo "<img height='1000' width='1000' src='/budget/admin/crj_updates/documents_bank_deposits/bank_deposit_slip.png'></img>";
 echo "</td>";
 echo "</tr>";
 echo "</table>";
*/
//echo "Query12=$query12"; 
 
 }
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














