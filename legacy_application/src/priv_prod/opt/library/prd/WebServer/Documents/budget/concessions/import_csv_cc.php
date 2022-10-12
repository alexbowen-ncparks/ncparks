<?php
//echo "hello world";
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//$center=$_SESSION['budget']['centerSess'];
//if($center== '12802953'){$center='12802751' ;}
//echo "center=$center";exit;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

$date=date("Ymd");
$system_entry_date=date("Ymd");
$date2=time();


  //database connect info here  
  
// echo "<br />host=$host";//exit;
  
//if(isset($_FILES['csv_file'])){echo "csvfile is set";}
      
    //check for file upload  
	
define('PROJECTS_UPLOADPATH','documents/');
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
        mysqli_query($connection, "TRUNCATE TABLE `crs_tdrr_cc` ") or die(mysqli_error()); 
		mysqli_query($connection, "ALTER TABLE `crs_tdrr_cc` DROP INDEX `center` ") or die(mysqli_error());
		mysqli_query($connection, "ALTER TABLE `crs_tdrr_cc` DROP INDEX `ncas_account` ") or die(mysqli_error());
		
		
		
		

		
      
        while (($data = fgetcsv($handle, 10000, ',')) !== FALSE) {  
      
            //Access field data in $data array ex.  
            $transaction_date = $data[0];  
            $revenue_location_id = $data[1];  
            $revenue_location_name = $data[2];  
            $payment_type = $data[3]; 
			$amount = $data[4]; 
			$amount=str_replace("$","",$amount);
            $amount=str_replace(",","",$amount);
            $amount=str_replace("(","-",$amount);
            $amount=str_replace(")","",$amount);
			$revenue_type=$data[5];
			$company_type=$data[6];
			$revenue_code=$data[7];
			$account_name = $data[8];  
            $batch_deposit_date = $data[9];  
            $batch_id = $data[10];  
            $deposit_id = $data[11];  
            $revenue_note = $data[12];  
           
            
      
//Use data to insert into db  
$sql="INSERT INTO crs_tdrr_cc 
 set `transaction_date`='$transaction_date', `revenue_location_id`='$revenue_location_id', 
 `revenue_location_name`='$revenue_location_name',`payment_type`='$payment_type',
 `amount`='$amount',`revenue_type`='$revenue_type',`company_type`='$company_type',
 `revenue_code`='$revenue_code',`account_name`='$account_name',`batch_deposit_date`='$batch_deposit_date',`batch_id`='$batch_id',`deposit_id`='$deposit_id',
 `revenue_note`='$revenue_note',`entry_type`='activess' ";  
 
            mysqli_query($connection, $sql) or (mysqli_query($connection, "ROLLBACK") and die(mysqli_error() . " - $sql"));  
        }  
      
        //commit the data to the database  
       
$query0="delete
FROM  `crs_tdrr_cc` 
WHERE mid( transaction_date, 3, 1  )  !=  '/' ";	   
	   
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");	 


$query1="update `crs_tdrr_cc` 
set center=revenue_location_id
where 1 "; 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	 
	   

	   
		
/*		
$query1="delete from crs_tdrr_cc where revenue_location_name='' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from crs_tdrr_cc where revenue_location_name='end date:' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from crs_tdrr_cc where revenue_location_name='revenue location name' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

*/
$query4="update crs_tdrr_cc set ncas_account=revenue_code where 1";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update crs_tdrr_cc,center_taxes set crs_tdrr_cc.taxcenter=center_taxes.taxcenter
         where crs_tdrr_cc.center=center_taxes.center";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="delete from crs_tdrr_cc where amount='0' ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update crs_tdrr_cc,center set crs_tdrr_cc.parkcode=center.parkcode
         where crs_tdrr_cc.center=center.center";

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="update crs_tdrr_cc
         set center='12802751',
		 parkcode='ADMI'     
         where ncas_account='435900001' ";

$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update crs_tdrr_cc,crs_tdrr_cc_accounts
         set crs_tdrr_cc.rank=crs_tdrr_cc_accounts.rank
		 where crs_tdrr_cc.ncas_account=crs_tdrr_cc_accounts.ncas_account ";		 

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="update crs_tdrr_cc,center_taxes
set crs_tdrr_cc.county=center_taxes.county,
crs_tdrr_cc.taxrate=center_taxes.tax_rate_total
where crs_tdrr_cc.center=center_taxes.center
and crs_tdrr_cc.ncas_account='000211940';
";		 

$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update crs_tdrr_cc
set tax_note=concat(account_name,' (',county,' @ ',taxrate,')')
where 1 and crs_tdrr_cc.ncas_account='000211940' ;
";		 

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="ALTER TABLE `crs_tdrr_cc` ADD INDEX ( `center` ) 
";		 

$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="ALTER TABLE `crs_tdrr_cc` ADD INDEX ( `ncas_account` ) 
";		 

$result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

$query14="update crs_tdrr_cc
set ncas_account2=trim(leading '0' from ncas_account)
";		 

$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");

$query15="update crs_tdrr_cc,report_budget_history_multiyear2
set crs_tdrr_cc.py_total=report_budget_history_multiyear2.py1_amount
where crs_tdrr_cc.center=report_budget_history_multiyear2.center
and crs_tdrr_cc.ncas_account2=report_budget_history_multiyear2.account;
";		 

$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$query16="update crs_tdrr_cc
set validated='n'
where py_total='0'
and ncas_account != '000211940'
and ncas_account != '000218110'
and ncas_account != '000300000';
";		 

$result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");




 mysqli_query($connection, "COMMIT");  
 mysqli_query($connection, "SET AUTOCOMMIT=1");  




/*
echo "<br />";
echo "query1=$query1<br />";
echo "query2=$query2<br />";
echo "query3=$query3<br />";
echo "query4=$query4<br />";
*/




//$row1=mysqli_fetch_array($result1);
//extract($row1);//brings back max (end_date) as $end_date	
		
		
      
        //delete csv file  
        //unlink($file_path);  
   

//echo "</br>goodbye world";	

/*
$query23a="update project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)
*/	
header("location: bank_deposits_menu_cc.php?menu_id=a&menu_selected=y&step=2");

?>	