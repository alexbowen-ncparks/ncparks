<?php
//echo "hello world";
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$center=$_SESSION['budget']['centerSess'];
if($center== '12802953'){$center='12802751' ;}
//echo "center=$center";exit;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//date_default_timezone_set('America/New_York');

$date=date("Ymd");
$system_entry_date=date("Ymd");
$date2=time();


  //database connect info here  
  
// echo "<br />host=$host";//exit;
  
//if(isset($_FILES['csv_file'])){echo "csvfile is set";}
      
    //check for file upload  
	
define('PROJECTS_UPLOADPATH','documents_orms_deposits/');
$csv_file=$_FILES['csv_file']['name'];	
//echo "<br />csv_file=$csv_file";//exit;
$target=PROJECTS_UPLOADPATH.$csv_file;
//echo "<br />target=$target";//exit;
move_uploaded_file($_FILES['csv_file']['tmp_name'], $target);
//echo "<br />upload_successful";//exit;
$file_path=$target;
//echo "<br />filepath=$file_path";//exit;	
	

        //open the csv file for reading  
        $handle = fopen($file_path, 'r');  
        print_r(fgetcsv($handle));
        //turn off autocommit and delete the product table  
        mysql_query("SET AUTOCOMMIT=0");  
        mysql_query("BEGIN");  
        //mysql_query("TRUNCATE TABLE crs_tdrr") or die(mysql_error()); 
        mysql_query("truncate crs_tdrr_division") or die(mysql_error()); 

		
      
        while (($data = fgetcsv($handle, 3000, ',')) !== FALSE) {  
      
            //Access field data in $data array ex.  
            $transaction_date = $data[0];  
            $revenue_location_id = $data[1];  
            $revenue_location_name = $data[2];  
            $transaction_location_id = $data[3];  
            $transaction_location_name = $data[4];  
            $payment_type = $data[5];  
            $product_id = $data[6];  
            $product_name = $data[7];
            $product_name=mysql_real_escape_string($product_name);			
            $amount = $data[8];  
            $amount=str_replace("$","",$amount);
            $amount=str_replace(",","",$amount);
            $amount=str_replace("(","-",$amount);
            $amount=str_replace(")","",$amount);
            $account_id = $data[9];  
            $account_name = $data[10];  
            $batch_deposit_date = $data[11];  
            $batch_id = $data[12];  
            $deposit_id = $data[13];  
            $revenue_note = $data[14];  
           
            
      
//Use data to insert into db  
$sql="INSERT INTO crs_tdrr_division 
 set `transaction_date`='$transaction_date', `revenue_location_id`='$revenue_location_id', 
 `revenue_location_name`='$revenue_location_name',`transaction_location_id`='$transaction_location_id',
 `transaction_location_name`='$transaction_location_name',`payment_type`='$payment_type',
 `product_id`='$product_id',`product_name`='$product_name',`amount`='$amount',
 `account_id`='$account_id',`account_name`='$account_name',
 `batch_deposit_date`='$batch_deposit_date',`batch_id`='$batch_id',`deposit_id`='$deposit_id',
 `revenue_note`='$revenue_note',`center`='$center' ";  
 
            mysql_query($sql) or (mysql_query("ROLLBACK") and die(mysql_error() . " - $sql"));  
        }  
      
        //commit the data to the database  
       


$queryA="delete from crs_tdrr_division where payment_type='mc' ";

$resultA = mysql_query($queryA) or die ("Couldn't execute query A.  $queryA");


$queryB="delete from crs_tdrr_division where payment_type='visa' ";

$resultB = mysql_query($queryB) or die ("Couldn't execute query B.  $queryB");


$queryC="delete from crs_tdrr_division where payment_type like '%north carolina%' ";

$resultC = mysql_query($queryC) or die ("Couldn't execute query C.  $queryC");
 
		
$query1="delete from crs_tdrr_division where revenue_location_name='' ";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from crs_tdrr_division where revenue_location_name='end date:' ";

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from crs_tdrr_division where revenue_location_name='revenue location name' ";

$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");


$query3a="update crs_tdrr_division set center=transaction_location_id where 1";

$result3a = mysql_query($query3a) or die ("Couldn't execute query 3a.  $query3a");


$query4="update crs_tdrr_division set ncas_account=mid(account_id,11,9) where 1";

$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

$query5="update crs_tdrr_division,center_taxes set crs_tdrr_division.taxcenter=center_taxes.taxcenter
         where crs_tdrr_division.center=center_taxes.center";

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

$query6="update crs_tdrr_division
         set ncas_account='000437995',account_name='over_short'
		 where ncas_account='000200000' ";

$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

$query6a="update crs_tdrr_division
         set ncas_account='000218110',account_name='Gift Card'
		 where ncas_account='000300000' and product_id='7050'  ";

$result6a = mysql_query($query6a) or die ("Couldn't execute query 6a.  $query6a");


$query6b="update crs_tdrr_division set account_name='Gift Card' where ncas_account='000218110'";

$result6b = mysql_query($query6b) or die ("Couldn't execute query 6b.  $query6b");

$query6c="update crs_tdrr_division
set transdate_new=concat(mid(transaction_date,7,4),mid(transaction_date,1,2),mid(transaction_date,4,2))
where 1";

$result6c = mysql_query($query6c) or die ("Couldn't execute query 6c.  $query6c");

$query6d="SELECT max(transdate_new)as 'report_date' from crs_tdrr_division where 1 ";

$result6d = mysql_query($query6d) or die ("Couldn't execute query 6d.  $query6d");

$row6d=mysql_fetch_array($result6d);
extract($row6d);

$query6e="TRUNCATE TABLE `crs_tdrr_division_history`";

$result6e = mysql_query($query6e) or die ("Couldn't execute query 6e.  $query6e");

$query6f="insert into crs_tdrr_division_history(transaction_date,revenue_location_id,
revenue_location_name,transaction_location_id,transaction_location_name,payment_type,
product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,
deposit_id,revenue_note,center,ncas_account,taxcenter,transdate_new)
select
transaction_date,revenue_location_id,
revenue_location_name,transaction_location_id,transaction_location_name,payment_type,
product_id,product_name,amount,account_id,account_name,batch_deposit_date,batch_id,
deposit_id,revenue_note,center,ncas_account,taxcenter,transdate_new
from crs_tdrr_division where 1";


$result6f = mysql_query($query6f) or die ("Couldn't execute query 6f.  $query6f");

$query10d="update `crs_tdrr_division_history` 
set deposit_date_new=concat(mid(batch_deposit_date,7,4),mid(batch_deposit_date,1,2),mid(batch_deposit_date,4,2))
where 1"; 

$result10d = mysql_query($query10d) or die ("Couldn't execute query 10d.  $query10d ");

/*
$query11d="update crs_tdrr_division_history set deposit_id=concat(deposit_id,'GiftCard')
           where ncas_account='000218110'"; 

$result11d = mysql_query($query11d) or die ("Couldn't execute query 11d.  $query11d ");
*/

$query12d="update crs_tdrr_division_history,calendar_2014
           set crs_tdrr_division_history.transdate_day=calendar_2014.day
		   where crs_tdrr_division_history.transdate_new=calendar_2014.date2"; 

$result12d = mysql_query($query12d) or die ("Couldn't execute query 12d.  $query12d ");


$query13d="update crs_tdrr_division_history,calendar_2014
           set crs_tdrr_division_history.deposit_date_day=calendar_2014.day
		   where crs_tdrr_division_history.deposit_date_new=calendar_2014.date2"; 

$result13d = mysql_query($query13d) or die ("Couldn't execute query 13d.  $query13d ");


$query14d="update crs_tdrr_division_history
           set deposit_id='none'
		   where deposit_id='' "; 

$result14d = mysql_query($query14d) or die ("Couldn't execute query 14d.  $query14d ");


$query15d="update crs_tdrr_division_history
           set deposit_transaction='n'
		   where transdate_new > deposit_date_new
		   and deposit_date_new != '0000-00-00'
		   and ncas_account != '000437995'"; 

$result15d = mysql_query($query15d) or die ("Couldn't execute query 15d.  $query15d ");

//echo "line 214"; exit;


$query15e="delete from crs_tdrr_division_deposits
           where trans_table='n' "; 

$result15e = mysql_query($query15e) or die ("Couldn't execute query 15e.  $query15e ");



$query16d="insert ignore into crs_tdrr_division_deposits
(center,orms_deposit_id,orms_start_date,orms_end_date,orms_deposit_date,orms_deposit_amount,download_date)
select center,deposit_id,min(transdate_new),max(transdate_new),deposit_date_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history
where 1
and deposit_transaction = 'y'
and deposit_id != 'none'
group by deposit_id "; 

$result16d = mysql_query($query16d) or die ("Couldn't execute query 16d.  $query16d ");



$query16d1="insert ignore into crs_tdrr_division_adjustments
(center,orms_deposit_id,orms_deposit_date,orms_adjustments,orms_adjust_date,
 orms_adjust_amount,download_date)
select center,deposit_id,deposit_date_new,count(id),transdate_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history
where 1
and deposit_transaction = 'n'
and deposit_id != 'none'
group by deposit_id,transdate_new "; 

$result16d1 = mysql_query($query16d1) or die ("Couldn't execute query 16d1.  $query16d1 ");





$query16e="update crs_tdrr_division_deposits
           set days_elapsed=datediff(download_date,orms_deposit_date)
           where 1 "; 

$result16e = mysql_query($query16e) or die ("Couldn't execute query 16e.  $query16e ");



$query17d="update crs_tdrr_division_deposits,center
           set crs_tdrr_division_deposits.park=center.parkcode
		   where crs_tdrr_division_deposits.center=center.center "; 

$result17d = mysql_query($query17d) or die ("Couldn't execute query 17d.  $query17d ");


$query17e="insert into crs_tdrr_division_history_parks(
transaction_date,
revenue_location_id,
revenue_location_name,
transaction_location_id,
transaction_location_name,
payment_type,
product_id,
product_name,
amount,
account_id,
account_name,
batch_deposit_date,
batch_id,
deposit_id,
revenue_note,
center,
ncas_account,
taxcenter,
transdate_new,
deposit_date_new,
transdate_day,
deposit_date_day,
deposit_transaction)

SELECT crs_tdrr_division_history.transaction_date,
crs_tdrr_division_history.revenue_location_id,
crs_tdrr_division_history.revenue_location_name,
crs_tdrr_division_history.transaction_location_id,
crs_tdrr_division_history.transaction_location_name,
crs_tdrr_division_history.payment_type,
crs_tdrr_division_history.product_id,
crs_tdrr_division_history.product_name,
crs_tdrr_division_history.amount,
crs_tdrr_division_history.account_id,
crs_tdrr_division_history.account_name,
crs_tdrr_division_history.batch_deposit_date,
crs_tdrr_division_history.batch_id,
crs_tdrr_division_history.deposit_id,
crs_tdrr_division_history.revenue_note,
crs_tdrr_division_history.center,
crs_tdrr_division_history.ncas_account,
crs_tdrr_division_history.taxcenter,
crs_tdrr_division_history.transdate_new,
crs_tdrr_division_history.deposit_date_new,
crs_tdrr_division_history.transdate_day,
crs_tdrr_division_history.deposit_date_day,
crs_tdrr_division_history.deposit_transaction
FROM crs_tdrr_division_deposits
LEFT JOIN crs_tdrr_division_history ON crs_tdrr_division_deposits.orms_deposit_id = crs_tdrr_division_history.deposit_id
WHERE 1
AND crs_tdrr_division_deposits.trans_table = 'n'
AND crs_tdrr_division_history.deposit_transaction = 'y'
AND crs_tdrr_division_history.deposit_id != 'none'
AND crs_tdrr_division_deposits.days_elapsed > '0' "; 

$result17e = mysql_query($query17e) or die ("Couldn't execute query 17e.  $query17e ");


$query17e1="insert ignore into crs_tdrr_division_deposits_checks(center,orms_deposit_id,check_count)
SELECT center, deposit_id AS 'orms_deposit_id', count( id )
FROM `crs_tdrr_division_history_parks`
WHERE 1
AND
(payment_type = 'mon ord'
OR payment_type = 'per chq'
OR payment_type = 'cert chq'
)
GROUP BY center, orms_deposit_id "; 

$result17e1 = mysql_query($query17e1) or die ("Couldn't execute query 17e1.  $query17e1 ");



$query17e2="update crs_tdrr_division_deposits,crs_tdrr_division_deposits_checks
            set crs_tdrr_division_deposits.checks='y'
			where crs_tdrr_division_deposits.orms_deposit_id=
			crs_tdrr_division_deposits_checks.orms_deposit_id "; 

$result17e2 = mysql_query($query17e2) or die ("Couldn't execute query 17e2.  $query17e2 ");




$query17f="update crs_tdrr_division_deposits
set trans_table='y'
where crs_tdrr_division_deposits.trans_table='n'
and days_elapsed > '0' "; 



$result17f = mysql_query($query17f) or die ("Couldn't execute query 17f.  $query17f ");


$query17g="update crs_tdrr_division_deposits
set f_year='1314'
where orms_deposit_date >= '20130702'
and orms_deposit_date <= '20140630'
and f_year=''
"; 

$result17g = mysql_query($query17g) or die ("Couldn't execute query 17g.  $query17g ");

// changed 2nd date from 20150630 to 20150701 (Bass-6/29/15)


$query17h="update crs_tdrr_division_deposits
set f_year='1415'
where orms_deposit_date >= '20140701'
and orms_deposit_date <= '20150701'
and f_year=''
"; 

$result17h = mysql_query($query17h) or die ("Couldn't execute query 17h.  $query17h ");



$query17i="update crs_tdrr_division_deposits
set f_year='1516'
where orms_deposit_date >= '20150702'
and orms_deposit_date <= '20160701'
and f_year=''
"; 

$result17i = mysql_query($query17i) or die ("Couldn't execute query 17i.  $query17i ");








 mysql_query("COMMIT");  
 mysql_query("SET AUTOCOMMIT=1");  

//echo "report_date=$report_date";exit;


/*
echo "<br />";
echo "query1=$query1<br />";
echo "query2=$query2<br />";
echo "query3=$query3<br />";
echo "query4=$query4<br />";
*/




//$row1=mysql_fetch_array($result1);
//extract($row1);//brings back max (end_date) as $end_date	
		
		
      
        //delete csv file  
        //unlink($file_path);  
   

//echo "</br>goodbye world";	

/*
$query23a="update project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysql_query($query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysql_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysql_query($query25) or die ("Couldn't execute query 25.  $query25");}
mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)
*/	
header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y&step=1");

?>	