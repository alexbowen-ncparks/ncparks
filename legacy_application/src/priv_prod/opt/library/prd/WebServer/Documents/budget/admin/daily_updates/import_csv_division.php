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




//echo "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";   //exit;


$upload_date=str_replace("-","",$upload_date);
$upload_date2=strtotime("$upload_date");
$upload_yesterday=($upload_date2-60*60*24);
$upload_yesterday2=date("Ymd", $upload_yesterday);
$effective_date=$upload_yesterday2;

//$effective_date='20170312';

//echo "upload_date=$upload_date<br /><br />";
//echo "effective_date=$effective_date<br /><br />";  exit;






$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//date_default_timezone_set('America/New_York');

$date=date("Ymd");
$system_entry_date=date("Ymd");
$date2=time();

if($upload_verified != 'y')
{
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
        mysqli_query($connection, "SET AUTOCOMMIT=0");  
        mysqli_query($connection, "BEGIN");  
        //mysqli_query($connection, "TRUNCATE TABLE crs_tdrr") or die(mysqli_error()); 
        mysqli_query($connection, "truncate crs_tdrr_division") or die(mysqli_error()); 

		
      
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
            $product_name=mysqli_real_escape_string($product_name);			
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
 
            mysqli_query($connection, $sql) or (mysqli_query($connection, "ROLLBACK") and die(mysqli_error() . " - $sql"));  
        }  
      
        //commit the data to the database  
  
 $cabe_query="update crs_tdrr_division 
              set revenue_location_id='12802806',transaction_location_id='12802806'
			  where transaction_location_id='554960' ";
   
$cabe_result = mysqli_query($connection, $cabe_query) or die ("Couldn't execute cabe_query.  $cabe_query");


   
  
//echo "update successful line 126<br /><br />"; exit;
 


$queryA="delete from crs_tdrr_division where payment_type='mc' ";

$resultA = mysqli_query($connection, $queryA) or die ("Couldn't execute query A.  $queryA");


$queryB="delete from crs_tdrr_division where payment_type='visa' ";

$resultB = mysqli_query($connection, $queryB) or die ("Couldn't execute query B.  $queryB");


$queryC="delete from crs_tdrr_division where payment_type like '%north carolina%' ";

$resultC = mysqli_query($connection, $queryC) or die ("Couldn't execute query C.  $queryC");
 
$queryD="delete from crs_tdrr_division where payment_type='disc' ";

$resultD = mysqli_query($connection, $queryD) or die ("Couldn't execute query D.  $queryD");
 
 
 
		
$query1="delete from crs_tdrr_division where revenue_location_name='' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from crs_tdrr_division where revenue_location_name='end date:' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from crs_tdrr_division where revenue_location_name='revenue location name' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query3a="update crs_tdrr_division set center=transaction_location_id where 1";

$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");


$query4="update crs_tdrr_division set ncas_account=mid(account_id,11,9) where 1";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update crs_tdrr_division,center_taxes set crs_tdrr_division.taxcenter=center_taxes.taxcenter
         where crs_tdrr_division.center=center_taxes.center";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update crs_tdrr_division
         set ncas_account='000437995',account_name='over_short'
		 where ncas_account='000200000' ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query6a="update crs_tdrr_division
         set ncas_account='000218110',account_name='Gift Card'
		 where ncas_account='000300000' and product_id='7050'  ";

$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");


$query6b="update crs_tdrr_division set account_name='Gift Card' where ncas_account='000218110'";

$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");

$query6c="update crs_tdrr_division
set transdate_new=concat(mid(transaction_date,7,4),mid(transaction_date,1,2),mid(transaction_date,4,2))
where 1";

$result6c = mysqli_query($connection, $query6c) or die ("Couldn't execute query 6c.  $query6c");  


$query6c1="update crs_tdrr_division
set depositdate_new=concat(mid(batch_deposit_date,7,4),mid(batch_deposit_date,1,2),mid(batch_deposit_date,4,2))
where 1";

$result6c1 = mysqli_query($connection, $query6c1) or die ("Couldn't execute query 6c1.  $query6c1"); 


$query6c2="update crs_tdrr_division
set batch_deposit_date='',deposit_id=''
where depositdate_new > '$effective_date' ";

$result6c2 = mysqli_query($connection, $query6c2) or die ("Couldn't execute query 6c2.  $query6c2");

echo "<br /><br />query6c2=$query6c2<br /><br />";


$query6c3="update crs_tdrr_division
set depositdate_new='0000-00-00'
where depositdate_new > '$effective_date' ";

$result6c3 = mysqli_query($connection, $query6c3) or die ("Couldn't execute query 6c3.  $query6c3");

echo "<br /><br />query6c3=$query6c3<br /><br />";


$query6c4="delete from crs_tdrr_division where transdate_new > '$effective_date' ";

$result6c4 = mysqli_query($connection, $query6c4) or die ("Couldn't execute query 6c4.  $query6c4");

echo "<br /><br />query6c4=$query6c4<br /><br />";


echo "Update Successful <br /><br />";

$query6c5="select count(id) as 'upload_count',sum(amount) as 'upload_amount' from crs_tdrr_division where 1";

$result6c5 = mysqli_query($connection, $query6c5) or die ("Couldn't execute query 6c5.  $query6c5");
$row6c5=mysqli_fetch_array($result6c5);
extract($row6c5);
echo "<br /><br />query6c5=$query6c5<br /><br />";

echo "<table><tr><td>Upload Count: $upload_count <br />Upload Amount: $upload_amount<br /><a href='import_csv_division.php?project_category=fms&project_name=daily_updates&step_group=C&step_num=1&upload_date=$upload_date&upload_verified=y'>Upload OK</a></td></tr></table>";

exit;
}
if($upload_verified == 'y')
{
//echo "<br />upload_verified=$upload_verified<br />";
//exit;

$query6d="SELECT max(transdate_new)as 'report_date' from crs_tdrr_division where 1 ";

$result6d = mysqli_query($connection, $query6d) or die ("Couldn't execute query 6d.  $query6d");

$row6d=mysqli_fetch_array($result6d);
extract($row6d);

$query6e="TRUNCATE TABLE `crs_tdrr_division_history`";

$result6e = mysqli_query($connection, $query6e) or die ("Couldn't execute query 6e.  $query6e");

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


$result6f = mysqli_query($connection, $query6f) or die ("Couldn't execute query 6f.  $query6f");

$query10d="update `crs_tdrr_division_history` 
set deposit_date_new=concat(mid(batch_deposit_date,7,4),mid(batch_deposit_date,1,2),mid(batch_deposit_date,4,2))
where 1"; 

$result10d = mysqli_query($connection, $query10d) or die ("Couldn't execute query 10d.  $query10d ");



$query12d="update crs_tdrr_division_history,calendar_2014
           set crs_tdrr_division_history.transdate_day=calendar_2014.day
		   where crs_tdrr_division_history.transdate_new=calendar_2014.date2"; 

$result12d = mysqli_query($connection, $query12d) or die ("Couldn't execute query 12d.  $query12d ");


$query13d="update crs_tdrr_division_history,calendar_2014
           set crs_tdrr_division_history.deposit_date_day=calendar_2014.day
		   where crs_tdrr_division_history.deposit_date_new=calendar_2014.date2"; 

$result13d = mysqli_query($connection, $query13d) or die ("Couldn't execute query 13d.  $query13d ");


$query14d="update crs_tdrr_division_history
           set deposit_id='none'
		   where deposit_id='' "; 

$result14d = mysqli_query($connection, $query14d) or die ("Couldn't execute query 14d.  $query14d ");


$query15d="update crs_tdrr_division_history
           set deposit_transaction='n'
		   where transdate_new > deposit_date_new
		   and deposit_date_new != '0000-00-00'
		   and ncas_account != '000437995'"; 

$result15d = mysqli_query($connection, $query15d) or die ("Couldn't execute query 15d.  $query15d ");

//echo "line 214"; exit;


$query15e="delete from crs_tdrr_division_deposits
           where trans_table='n' "; 

$result15e = mysqli_query($connection, $query15e) or die ("Couldn't execute query 15e.  $query15e ");



$query16d="insert ignore into crs_tdrr_division_deposits
(center,orms_deposit_id,orms_start_date,orms_end_date,orms_deposit_date,orms_deposit_amount,download_date)
select center,deposit_id,min(transdate_new),max(transdate_new),deposit_date_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history
where 1
and deposit_transaction = 'y'
and deposit_id != 'none'
group by deposit_id "; 

$result16d = mysqli_query($connection, $query16d) or die ("Couldn't execute query 16d.  $query16d ");



$query16d1="insert ignore into crs_tdrr_division_adjustments
(center,orms_deposit_id,orms_deposit_date,orms_adjustments,orms_adjust_date,
 orms_adjust_amount,download_date)
select center,deposit_id,deposit_date_new,count(id),transdate_new,sum(amount),'$system_entry_date'
from crs_tdrr_division_history
where 1
and deposit_transaction = 'n'
and deposit_id != 'none'
group by deposit_id,transdate_new "; 

$result16d1 = mysqli_query($connection, $query16d1) or die ("Couldn't execute query 16d1.  $query16d1 ");





$query16e="update crs_tdrr_division_deposits
           set days_elapsed=datediff(download_date,orms_deposit_date)
           where 1 "; 

$result16e = mysqli_query($connection, $query16e) or die ("Couldn't execute query 16e.  $query16e ");



$query17d="update crs_tdrr_division_deposits,center
           set crs_tdrr_division_deposits.park=center.parkcode
		   where crs_tdrr_division_deposits.center=center.center "; 

$result17d = mysqli_query($connection, $query17d) or die ("Couldn't execute query 17d.  $query17d ");


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

$result17e = mysqli_query($connection, $query17e) or die ("Couldn't execute query 17e.  $query17e ");


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

$result17e1 = mysqli_query($connection, $query17e1) or die ("Couldn't execute query 17e1.  $query17e1 ");



$query17e2="update crs_tdrr_division_deposits,crs_tdrr_division_deposits_checks
            set crs_tdrr_division_deposits.checks='y'
			where crs_tdrr_division_deposits.orms_deposit_id=
			crs_tdrr_division_deposits_checks.orms_deposit_id "; 

$result17e2 = mysqli_query($connection, $query17e2) or die ("Couldn't execute query 17e2.  $query17e2 ");




$query17f="update crs_tdrr_division_deposits
set trans_table='y'
where crs_tdrr_division_deposits.trans_table='n'
and days_elapsed > '0' "; 



$result17f = mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f.  $query17f ");

/*
$query17g="update crs_tdrr_division_deposits
set f_year='1314'
where orms_deposit_date >= '20130702'
and orms_deposit_date <= '20140630'
and f_year=''
"; 

$result17g = mysqli_query($connection, $query17g) or die ("Couldn't execute query 17g.  $query17g ");

// changed 2nd date from 20150630 to 20150701 (Bass-6/29/15)


$query17h="update crs_tdrr_division_deposits
set f_year='1415'
where orms_deposit_date >= '20140701'
and orms_deposit_date <= '20150701'
and f_year=''
"; 

$result17h = mysqli_query($connection, $query17h) or die ("Couldn't execute query 17h.  $query17h ");



$query17i="update crs_tdrr_division_deposits
set f_year='1516'
where orms_deposit_date >= '20150702'
and orms_deposit_date <= '20160630'
and f_year=''
"; 

$result17i = mysqli_query($connection, $query17i) or die ("Couldn't execute query 17i.  $query17i ");



$query17j="update crs_tdrr_division_deposits
set f_year='1617'
where orms_deposit_date >= '20160701'
and orms_deposit_date <= '20170630'
and f_year=''
"; 

$result17j = mysqli_query($connection, $query17j) or die ("Couldn't execute query 17j.  $query17j ");


$query17k="update crs_tdrr_division_deposits
set f_year='1718'
where orms_deposit_date >= '20170701'
and orms_deposit_date <= '20180629'
and f_year=''
"; 

$result17k = mysqli_query($connection, $query17k) or die ("Couldn't execute query 17k.  $query17k ");



$query17m="update crs_tdrr_division_deposits
set f_year='1819'
where orms_deposit_date >= '20180630'
and orms_deposit_date <= '20190628'
and f_year=''
"; 

$result17m = mysqli_query($connection, $query17m) or die ("Couldn't execute query 17m.  $query17m ");

*/

/*
$query17p="update crs_tdrr_division_deposits
set f_year='1920'
where orms_deposit_date >= '20190629'
and orms_deposit_date <= '20200630'
and f_year=''
"; 
*/


/*
$query17p="update crs_tdrr_division_deposits
set f_year='1920'
where orms_deposit_date >= '20190629'
and orms_deposit_date <= '20200630'
";

$result17p = mysqli_query($connection, $query17p) or die ("Couldn't execute query 17p.  $query17p ");
*/


// 06/21/20 changed method for establishing value for crs_tdrr_division_deposits.f_year  (TBASS)

$query17p="update crs_tdrr_division_deposits,fiscal_year
set crs_tdrr_division_deposits.f_year=fiscal_year.report_year
where crs_tdrr_division_deposits.orms_deposit_date >= fiscal_year.deposit_date_start
and crs_tdrr_division_deposits.orms_deposit_date <= fiscal_year.deposit_date_end
and crs_tdrr_division_deposits.f_year='' ";

$result17p = mysqli_query($connection, $query17p) or die ("Couldn't execute query 17p.  $query17p ");




 mysqli_query($connection, "COMMIT");  
 mysqli_query($connection, "SET AUTOCOMMIT=1");  


$query18="insert into crs_tdrr_division_history
          (crs,transdate_new,amount,deposit_transaction,ncas_account,deposit_id,deposit_date_new,center,taxcenter)
		  select 'n',transdate_new,amount,'y',ncas_account,manual_deposit_id,deposit_date_new,center,taxcenter
		  from crs_tdrr_division_history_parks_manual
		  where deposit_transaction='y' and transdate_new <= '$effective_date'
          and concession_location != 'admi'  ";

//echo "<br /><br />query18=$query18<br /><br />";

$result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18 ");



$query18a="insert into crs_tdrr_division_history
          (crs,transdate_new,amount,deposit_transaction,ncas_account,deposit_id,deposit_date_new,center,taxcenter)
		  select 'n',transdate_new,amount,'y',ncas_account,'none',deposit_date_new,center,taxcenter
		  from crs_tdrr_division_history_parks_manual
		  where deposit_transaction='n' and transdate_new <= '$effective_date'
          and concession_location != 'admi'
          and amount != '0.00'		  ";

//echo "<br /><br />query18a=$query18a<br /><br />";

$result18a = mysqli_query($connection, $query18a) or die ("Couldn't execute query 18a.  $query18a ");



$query18b="update crs_tdrr_division_history
           set deposit_date_new='0000-00-00',deposit_id='none'
           where deposit_date_new > '$effective_date'
           and crs='n'  ";

//echo "<br /><br />query18b=$query18b<br /><br />";

$result18b = mysqli_query($connection, $query18b) or die ("Couldn't execute query 18b.  $query18b ");


// added on 10/31/17  CORRECTIONS to download

$query18c="delete from crs_tdrr_division_history
           where transdate_new='20171018'
		   and center='12802852'
		   and deposit_id='none' ";

//echo "<br /><br />query18b=$query18b<br /><br />";

$result18c = mysqli_query($connection, $query18c) or die ("Couldn't execute query 18c.  $query18c ");


$query18d="delete from crs_tdrr_division_history
           where transdate_new='20171017'
		   and center='12802904'
		   and deposit_id='none' ";

//echo "<br /><br />query18b=$query18b<br /><br />";

$result18d = mysqli_query($connection, $query18d) or die ("Couldn't execute query 18d.  $query18d ");

$query18e="update crs_tdrr_division_history set record_id=concat(center,'_',ncas_account,'_',amount,'_',transdate_new) where 1";

echo "<br /><br />query18e=$query18e<br /><br />";

$result18e = mysqli_query($connection, $query18e) or die ("Couldn't execute query 18e.  $query18e ");


$query18f = "select record_id from crs_tdrr_division_history_adjust where 1 order by id";

echo "<br />Line 637: query18f=$query18f<br />";

$result18f = mysqli_query($connection, $query18f) or die ("Couldn't execute query18f.  $query18f ");


while($row18f = mysqli_fetch_array($result18f)){
extract($row18f);

$query18g="update crs_tdrr_division_history set valid_record='n' where record_id='$record_id' and deposit_id='none' and valid_record='y' limit 1 ";
echo "<br /><br />query18g=$query18g<br /><br />";


$result18g = mysqli_query($connection, $query18g) or die ("Couldn't execute query18g.  $query18g ");


}// end 




{$query25="update project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();
/*
if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)
*/

}	

//echo "Line 670";
//exit;

header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");

?>	