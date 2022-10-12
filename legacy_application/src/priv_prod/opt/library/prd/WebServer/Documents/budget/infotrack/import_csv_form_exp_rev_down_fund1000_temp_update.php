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
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
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
        mysqli_query($connection, "TRUNCATE TABLE `exp_rev_down_fund1000_temp` ") or die(mysqli_error()); 
		//mysqli_query($connection, "ALTER TABLE `crs_tdrr_cc` DROP INDEX `center` ") or die(mysqli_error());
		//mysqli_query($connection, "ALTER TABLE `crs_tdrr_cc` DROP INDEX `ncas_account` ") or die(mysqli_error());
		
		
		
		

		
      
        while (($data = fgetcsv($handle, 10000, ',')) !== FALSE) {  
      
            //Access field data in $data array ex.  
            $center = $data[0];  
            $fund = $data[1];  
            $acctdate = $data[2];  
            $invoice = $data[3];  
            $pe = $data[4];  
            $description = $data[5];  
            $debit = $data[6];  
            $credit = $data[7];  
            $sys = $data[8];  
           
			//$product_name=mysqli_real_escape_string($product_name);
			//$amount = $data[8]; 
			//$amount=str_replace("$","",$amount);
             
           
            
      
//Use data to insert into db  
$sql="INSERT INTO exp_rev_down_fund1000_temp 
 set `center`='$center', `fund`='$fund', 
 `acctdate`='$acctdate',`invoice`='$invoice',`pe`='$pe',`description`='$description',`debit`='$debit',`credit`='$credit',`sys`='$sys' ";  
 
            mysqli_query($connection, $sql) or (mysqli_query($connection, "ROLLBACK") and die(mysqli_error() . " - $sql"));  
        }  
      
	  


 mysqli_query($connection, "COMMIT");  
 mysqli_query($connection, "SET AUTOCOMMIT=1");  


header("location: import_csv_form_exp_rev_down_fund1000_temp.php?upload=y");

?>	