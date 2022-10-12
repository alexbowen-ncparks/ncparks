<?php
//echo "hello world";
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
date_default_timezone_set('America/New_York');

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
        mysql_query("SET AUTOCOMMIT=0");  
        mysql_query("BEGIN");  
        mysql_query("TRUNCATE TABLE crs_tdrr") or die(mysql_error());  
      
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {  
      
            //Access field data in $data array ex.  
            $transaction_date = $data[0];  
            $revenue_location_id = $data[1];  
            $revenue_location_name = $data[2];  
            $transaction_location_id = $data[3];  
            $transaction_location_name = $data[4];  
            $payment_type = $data[5];  
            $product_id = $data[6];  
            $product_name = $data[7];  
            $amount = $data[8];  
            $amount=str_replace("$","",$amount);
            $amount=str_replace(",","",$amount);
            $account_id = $data[9];  
            $account_name = $data[10];  
            $batch_deposit_date = $data[11];  
            $batch_id = $data[12];  
            $deposit_id = $data[13];  
            $revenue_note = $data[14];  
           
            
      
//Use data to insert into db  
$sql="INSERT INTO crs_tdrr 
 set `transaction_date`='$transaction_date', `revenue_location_id`='$revenue_location_id', 
 `revenue_location_name`='$revenue_location_name',`transaction_location_id`='$transaction_location_id',
 `transaction_location_name`='$transaction_location_name',`payment_type`='$payment_type',
 `product_id`='$product_id',`product_name`='$product_name',`amount`='$amount',
 `account_id`='$account_id',`account_name`='$account_name',
 `batch_deposit_date`='$batch_deposit_date',`batch_id`='$batch_id',`deposit_id`='$deposit_id',
 `revenue_note`='$revenue_note' ";  
 
            mysql_query($sql) or (mysql_query("ROLLBACK") and die(mysql_error() . " - $sql"));  
        }  
      
        //commit the data to the database  
        mysql_query("COMMIT");  
        mysql_query("SET AUTOCOMMIT=1");  
      
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

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}
*/	
?>	