<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$concession_center_new=$_SESSION['budget']['centerSess_new'];
//if($beacnum=='60033048'){echo "tony as mary"; exit;}
//echo "Line 17 failed"; exit;
extract($_REQUEST);
//if($beacnum=='60036015')
//{
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//$orms_deposit_first4=substr($manual_deposit_id,0,4);
//echo "<br />orms_deposit_first4=$orms_deposit_first4";
//exit;
//}

if($concession_location=='ADM'){$concession_location='ADMI';}

//echo "concession_location=$concession_location<br /><br />";

//echo "tempid=$tempid<br /><br />";
//echo "level=$level<br /><br />";
//echo "concession_center=$concession_center<br /><br />";
//echo "concession_location=$concession_location<br /><br />"; exit;


//echo "hello<br /><br />";

//echo $tempid;
//extract($_REQUEST);

$ck_total=array_sum($ck_amount);
/*
if($beacnum=='60033048')
{
echo "ck_total=$ck_total<br />"; 
}
*/


$ck_total=number_format($ck_total,2);
/*
if($beacnum=='60033048')
{
echo "ck_total=$ck_total<br />"; //exit;
}
*/

$total_check=number_format($total_check,2);
/*
if($beacnum=='60033048')
{
echo "total_check=$total_check<br />"; //exit;
}
*/

/*
if($beacnum=='60033048')
{
if($total_check==$ck_total){echo "hari ok";}
if($total_check!=$ck_total){echo "hari error";}
exit;
}
*/


//if($total_check!=$ck_total){echo "Out of Balance";} else {echo "Balanced";}
// Heide Rumble  (For Budget Office Users, the Checks were 
if($beacnum != '60036015')
{
if($total_check!=$ck_total)
{echo "<font color='brown' size='5'>Checks Listed do not total $total_check. Please hit Back Button on Browser and Re-Enter Checks. Thanks!</font>"; exit;} 
}
//else 
//{echo "Checks Listed total $total_check.  Thanks!"; exit;} 
/*
if($beacnum=='60036015')
{
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
}
*/

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "num14=$num14<br /><br />";
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;



$system_entry_date=date("Ymd");

if($beacnum=='60036015')
{
	
if($bank_depnum==""){echo "<font color='brown' size='5'><b>Bank Deposit# missing<br /><br />Click the BACK button on your Browser to enter Bank Deposit#</b></font><br />";exit;}	
	
	
define('PROJECTS_UPLOADPATH','documents_bank_deposits/');
$document=$_FILES['document']['name'];
//echo "document=$document<br />";
$document_format2=substr($document, -3);
//echo "document_format2=$document_format2<br />";
//if($document_format2=='jpg' or $document_format2=='JPG'){$format_ok='y';} else {$format_ok='n';}
//echo "format_ok=$format_ok";
//exit;


if($document==""){echo "<font color='brown' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";exit;}

}

if($cashier_approved==""){echo "<font color='brown' size='5'><b>Cashier Approval missing<br /><br />Click the BACK button on your Browser to enter Cashier Approval</b></font><br />";exit;}

if($beacnum=='60036015')
{
//echo "Line 127: All Inputs Received<br />"; exit;
}
/*
$query4="select id 
         from crs_tdrr_division_deposits
         where controllers_deposit_id='$controllers_next'
         and f_year='$current_fyear'  ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);

//echo "id=$id<br />"; exit;



$doc_mod=$document;

$document=$source_table."_".$id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);


$query5="update crs_tdrr_division_deposits set document_location='$target'
where id='$id' ";
mysqli_query($connection, $query5) or die ("Error updating Database $query5");

*/


//}










$query0="insert into crs_tdrr_division_history_parks_manual
         set product_name='over_short',
		 amount='$oob',
		 pretax_amount='$oob',
		 manual_deposit_id='$manual_deposit_id',
		 center='$concession_center',
		 new_center='$concession_center_new',
		 ncas_account='000437995',
		 account_name='over_short',
		 transdate_new='$system_entry_date',
		 concession_location='$concession_location',
		 cashier='$tempid',
		 comment='$comment',
		 sed='$system_entry_date' ";
		  
		  
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

//echo "Update Successful<br />";  exit;


$query0a="update crs_tdrr_division_history_parks_manual,center
         set crs_tdrr_division_history_parks_manual.center=center.old_center
		 where crs_tdrr_division_history_parks_manual.center=center.new_center
		 and crs_tdrr_division_history_parks_manual.manual_deposit_id='$manual_deposit_id'
         and crs_tdrr_division_history_parks_manual.center != '' ";
		 
echo "query0a=$query0a<br />";		 

$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");







$query1="update crs_tdrr_division_history_parks_manual
         set depositor='$tempid',deposit_date_new='$system_entry_date',deposit_transaction='y'
         where manual_deposit_id='$manual_deposit_id'  ";
		 
echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query1a="delete from crs_tdrr_division_history_parks_manual
          where manual_deposit_id='$manual_deposit_id' 
		  and amount='0.00' ";
		 
echo "query1a=$query1a<br />";		 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");





$query2="update crs_tdrr_division_deposits_manual
         set deposit_complete='y'
         where manual_deposit_id='$manual_deposit_id'  ";
		 
echo "query2=$query2<br />";		 

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//echo "Update Successful<br /><br />"; exit;

$query16d="insert into crs_tdrr_division_deposits
(crs,center,new_center,old_center,orms_deposit_id,orms_start_date,orms_end_date,orms_deposit_date,orms_deposit_amount,download_date)
select 'n',new_center,new_center,center,manual_deposit_id,min(transdate_new),max(transdate_new),deposit_date_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history_parks_manual
where manual_deposit_id='$manual_deposit_id' "; 

$result16d = mysqli_query($connection, $query16d) or die ("Couldn't execute query 16d.  $query16d ");







$query17d="update crs_tdrr_division_deposits,center
           set crs_tdrr_division_deposits.park=center.parkcode
		   where crs_tdrr_division_deposits.new_center=center.new_center 
		   and crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id' "; 


		   
$result17d = mysqli_query($connection, $query17d) or die ("Couldn't execute query 17d.  $query17d ");



$orms_deposit_first4=substr($manual_deposit_id,0,4);
if($beacnum=='60036015' and $orms_deposit_first4=='ADMI')
{	
$query17da="update crs_tdrr_division_deposits
           set crs_tdrr_division_deposits.park='admi'
		   where crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id' "; 


		   
$result17da = mysqli_query($connection, $query17da) or die ("Couldn't execute query 17da.  $query17da ");
}






//added on 12/15/15

$query16e="update crs_tdrr_division_deposits
           set old_center='12802751',center='1680504',new_center='1680504'
		   where park='admi' "; 

$result16e = mysqli_query($connection, $query16e) or die ("Couldn't execute query 16e.  $query16e ");

//end of 12/15/15 edit






$query17d1="update crs_tdrr_division_deposits
           set orms_depositor='$tempid'
		   where orms_deposit_id='$manual_deposit_id' "; 


		   
$result17d1 = mysqli_query($connection, $query17d1) or die ("Couldn't execute query 17d1.  $query17d1 ");

if($beacnum=='60036015')
{
	
$query4="select id 
         from crs_tdrr_division_deposits
         where orms_deposit_id='$manual_deposit_id' ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);

//echo "id=$id<br />"; exit;

$source_table="crs_tdrr_division_deposits";

$doc_mod=$document;

$document=$source_table."_".$id;//echo $document;//exit;

$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;

$target=PROJECTS_UPLOADPATH.$document;
move_uploaded_file($_FILES['document']['tmp_name'], $target);

$target2="/budget/cash_sales/";
$target3=$target2.$target;
$query5="update crs_tdrr_division_deposits set document_location='$target3'
where id='$id' ";
mysqli_query($connection, $query5) or die ("Error updating Database $query5");	
	
	
	
$query17d2="update crs_tdrr_division_deposits
           set cashier='$tempid',
		   cashier_date='$system_entry_date',
		   controllers_deposit_id='$bank_depnum'
		   where orms_deposit_id='$manual_deposit_id' "; 


		   
$result17d2 = mysqli_query($connection, $query17d2) or die ("Couldn't execute query 17d2.  $query17d2 ");




echo "Line 340: Update Successful";



}


if($beacnum!='60036015')
{
$ck_count=21;
if($total_check > 0)
{
$query1="insert into crs_tdrr_division_deposits_checklist  SET";
for($j=0;$j<$ck_count;$j++){
$query2=$query1;
$checknum2=($checknum[$j]);
if($checknum2==''){continue;}
$payor2=($payor[$j]);
$payor_bank2=($payor_bank[$j]);
$ck_amount2=$ck_amount[$j];
$ck_amount2=str_replace(",","",$ck_amount2);
$ck_amount2=str_replace("$","",$ck_amount2);
$description2=($description[$j]);

	$query2.=" orms_deposit_id='$manual_deposit_id',";
	$query2.=" controllers_deposit_id='$bank_depnum',";
	//$query2.=" bank_deposit_date='$bank_deposit_date',";
	$query2.=" system_entry_date='$system_entry_date',";
	//$query2.=" f_year='$current_fyear',";
	$query2.=" checknum='$checknum2',";
	$query2.=" payor='$payor2',";
	$query2.=" payor_bank='$payor_bank2',";
	$query2.=" amount='$ck_amount2',";
	$query2.=" cashier='$tempid',";
	$query2.=" description='$description2'";
			

$result=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	
}

}








//echo "Update Successful<br /><br />"; exit;


$query17e="insert into crs_tdrr_division_history_parks(
dncr, 
crs,  
payment_type, 
product_name, 
amount,  
account_name, 
deposit_id,  
center,  
new_center,  
old_center,  
ncas_account,  
taxcenter,  
transdate_new,  
deposit_date_new, 
deposit_transaction,  
source  
)

SELECT
'y',
'n',
payment_type,
product_name,
pretax_amount,
account_name,
manual_deposit_id,
new_center,
new_center,
center,
ncas_account,
taxcenter,
transdate_new,
deposit_date_new,
deposit_transaction,
'mc'
FROM crs_tdrr_division_history_parks_manual
WHERE manual_deposit_id='$manual_deposit_id' "; 


echo "query17e=$query17e<br />"; //exit;

$result17e = mysqli_query($connection, $query17e) or die ("Couldn't execute query 17e.  $query17e ");




$query17f="insert into crs_tdrr_division_history_parks(
dncr, 
crs,  
payment_type, 
product_name, 
amount,  
account_name, 
deposit_id,  
center,  
new_center,  
old_center,  
ncas_account,  
taxcenter,  
transdate_new,  
deposit_date_new, 
deposit_transaction,  
source 
)

SELECT
'y',
'n',
payment_type,
product_name,
sales_tax,
'sales tax payable',
manual_deposit_id,
new_center,
new_center,
center,
'000211940',
taxcenter,
transdate_new,
deposit_date_new,
deposit_transaction,
'mc'
FROM crs_tdrr_division_history_parks_manual
WHERE manual_deposit_id='$manual_deposit_id'
and account_taxable='y' "; 


echo "query17f=$query17f<br />"; //exit;

$result17f = mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f.  $query17f ");

//echo "Update Successful<br />"; exit;
$query17g="update crs_tdrr_division_history_parks
           set transaction_date=concat(mid(transdate_new,6,2),'/',mid(transdate_new,9,2),'/',mid(transdate_new,1,4))
		   where deposit_id='$manual_deposit_id' ";
		   
		   
		   
$result17g = mysqli_query($connection, $query17g) or die ("Couldn't execute query 17g.  $query17g ");		   
		   
		   
$query17h="update crs_tdrr_division_history_parks
           set payment_type='per chq'
		   where payment_type='check'
		   and deposit_id='$manual_deposit_id' ";
		   
		   
		   
$result17h = mysqli_query($connection, $query17h) or die ("Couldn't execute query 17h.  $query17h ");			

//added on 12/15/15		
		   

$query17h1="update crs_tdrr_division_history_parks
            set admi='y'
			where deposit_id like 'admi%' ";
		   
		   
		   
$result17h1 = mysqli_query($connection, $query17h1) or die ("Couldn't execute query 17h1.  $query17h1 ");			   
		   
/*	   
$query17h2="update crs_tdrr_division_history_parks,center
            set crs_tdrr_division_history_parks.center=center.new_center,
			crs_tdrr_division_history_parks.new_center=center.new_center
			where crs_tdrr_division_history_parks.old_center=center.old_center
			and crs_tdrr_division_history_parks.admi='y'  ";
		   
		   
		   
$result17h2 = mysqli_query($connection, $query17h2) or die ("Couldn't execute query 17h2.  $query17h2 ");		

*/	   
		   
		   

$query17h3="update crs_tdrr_division_history_parks
            set old_center='12802751'
			where admi='y' and deposit_id='$manual_deposit_id' ";
		   
		   
		   
$result17h3 = mysqli_query($connection, $query17h3) or die ("Couldn't execute query 17h3.  $query17h3 ");	



//end of 12/15/15 edit
	
$query17h4="update crs_tdrr_division_history_parks,center
            set crs_tdrr_division_history_parks.company=center.new_company,
            crs_tdrr_division_history_parks.budget_code=center.new_budcode
			where crs_tdrr_division_history_parks.center=center.new_center
			and crs_tdrr_division_history_parks.deposit_id='$manual_deposit_id'
			and crs_tdrr_division_history_parks.admi='y'
			and crs_tdrr_division_history_parks.company=''
			and crs_tdrr_division_history_parks.budget_code=''	";
		   
		   
		   
$result17h4 = mysqli_query($connection, $query17h4) or die ("Couldn't execute query 17h4.  $query17h4 ");	






	

$query17e1="insert ignore into crs_tdrr_division_deposits_checks(center,orms_deposit_id,check_count)
SELECT center, deposit_id AS 'orms_deposit_id', count( id )
FROM `crs_tdrr_division_history_parks`
WHERE 1
AND
(payment_type = 'mon ord'
OR payment_type = 'per chq'
OR payment_type = 'cert chq'
or payment_type = 'check'
)
and deposit_id='$manual_deposit_id'
GROUP BY center, orms_deposit_id "; 

$result17e1 = mysqli_query($connection, $query17e1) or die ("Couldn't execute query 17e1.  $query17e1 ");



$query17e2="update crs_tdrr_division_deposits,crs_tdrr_division_deposits_checks
            set crs_tdrr_division_deposits.checks='y'
			where crs_tdrr_division_deposits.orms_deposit_id=
			crs_tdrr_division_deposits_checks.orms_deposit_id
            and crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id'	"; 

$result17e2 = mysqli_query($connection, $query17e2) or die ("Couldn't execute query 17e2.  $query17e2 ");




$query17f="update crs_tdrr_division_deposits
set trans_table='y'
where crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id' ";


//and days_elapsed > '0' "; 



$result17f = mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f.  $query17f ");


/*
$query17i="update crs_tdrr_division_deposits
set f_year='1516'
where orms_deposit_date >= '20150702'
and orms_deposit_date <= '20160630'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i = mysqli_query($connection, $query17i) or die ("Couldn't execute query 17i.  $query17i ");



$query17i2="update crs_tdrr_division_deposits
set f_year='1617'
where orms_deposit_date >= '20160701'
and orms_deposit_date <= '20170630'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i2 = mysqli_query($connection, $query17i2) or die ("Couldn't execute query 17i2.  $query17i2 ");


$query17i3="update crs_tdrr_division_deposits
set f_year='1718'
where orms_deposit_date >= '20170701'
and orms_deposit_date <= '20180630'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i3 = mysqli_query($connection, $query17i3) or die ("Couldn't execute query 17i3.  $query17i3 ");


$query17i4="update crs_tdrr_division_deposits
set f_year='1819'
where orms_deposit_date >= '20180701'
and orms_deposit_date <= '20190628'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i4 = mysqli_query($connection, $query17i4) or die ("Couldn't execute query 17i4.  $query17i4 ");



$query17i5="update crs_tdrr_division_deposits
set f_year='1920'
where orms_deposit_date >= '20190629'
and orms_deposit_date <= '20200630'
and orms_deposit_id='$manual_deposit_id'
and f_year=''
"; 

$result17i5 = mysqli_query($connection, $query17i5) or die ("Couldn't execute query 17i5.  $query17i5 ");
*/


$query17i5="update crs_tdrr_division_deposits,fiscal_year
set crs_tdrr_division_deposits.f_year=fiscal_year.report_year
where crs_tdrr_division_deposits.orms_deposit_date >= fiscal_year.deposit_date_start
and crs_tdrr_division_deposits.orms_deposit_date <= fiscal_year.deposit_date_end
and crs_tdrr_division_deposits.orms_deposit_id='$manual_deposit_id'
and crs_tdrr_division_deposits.f_year='' ";

$result17i5 = mysqli_query($connection, $query17i5) or die ("Couldn't execute query 17i5.  $query17i5 ");





/*
$query17j="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
set crs_tdrr_division_deposits_checklist.f_year=crs_tdrr_division_deposits.f_year
where crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
and crs_tdrr_division_deposits_checklist.orms_deposit_id='$manual_deposit_id'
and crs_tdrr_division_deposits_checklist.f_year=''
"; 
*/
/*
$query17j="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
set
crs_tdrr_division_deposits_checklist.f_year=crs_tdrr_division_deposits.f_year,
crs_tdrr_division_deposits_checklist.controllers_deposit_id=crs_tdrr_division_deposits.controllers_deposit_id,
crs_tdrr_division_deposits_checklist.bank_deposit_date=crs_tdrr_division_deposits.bank_deposit_date
where crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
and crs_tdrr_division_deposits_checklist.orms_deposit_id='$manual_deposit_id' ";



$result17j = mysqli_query($connection, $query17j) or die ("Couldn't execute query 17j.  $query17j ");
*/


$query17j1="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
set
crs_tdrr_division_deposits_checklist.f_year=crs_tdrr_division_deposits.f_year
where crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
and crs_tdrr_division_deposits_checklist.orms_deposit_id='$manual_deposit_id'
and crs_tdrr_division_deposits_checklist.f_year='' ";



$result17j1 = mysqli_query($connection, $query17j1) or die ("Couldn't execute query 17j1.  $query17j1 ");


$query17j2="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
set
crs_tdrr_division_deposits_checklist.controllers_deposit_id=crs_tdrr_division_deposits.controllers_deposit_id
where crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
and crs_tdrr_division_deposits_checklist.orms_deposit_id='$manual_deposit_id'
and crs_tdrr_division_deposits_checklist.controllers_deposit_id='' ";



$result17j2 = mysqli_query($connection, $query17j2) or die ("Couldn't execute query 17j2.  $query17j2 ");


$query17j3="update crs_tdrr_division_deposits_checklist,crs_tdrr_division_deposits
set
crs_tdrr_division_deposits_checklist.bank_deposit_date=crs_tdrr_division_deposits.bank_deposit_date
where crs_tdrr_division_deposits_checklist.orms_deposit_id=crs_tdrr_division_deposits.orms_deposit_id
and crs_tdrr_division_deposits_checklist.orms_deposit_id='$manual_deposit_id'
and crs_tdrr_division_deposits_checklist.bank_deposit_date='0000-00-00' ";



$result17j3 = mysqli_query($connection, $query17j3) or die ("Couldn't execute query 17j3.  $query17j3 ");





$query17k="update crs_tdrr_division_deposits_checklist
           set bo_deposit_complete='y'
           where orms_deposit_id='$manual_deposit_id'
           and budget_office='y'  ";



$result17k = mysqli_query($connection, $query17k) or die ("Couldn't execute query 17k.  $query17k ");


$query17m="update crs_tdrr_division_deposits
           set bank_deposit_date=orms_deposit_date
		   where park='admi'
		   and bank_deposit_date='0000-00-00' ";



$result17m = mysqli_query($connection, $query17m) or die ("Couldn't execute query 17m.  $query17m ");




echo "OK<br />";

header("location: page2_form.php?step=2&edit=y&depid=$manual_deposit_id&depamt=$deposit_amount");



 
 ?>




















