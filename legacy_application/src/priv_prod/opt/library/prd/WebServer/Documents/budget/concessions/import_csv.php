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
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//date_default_timezone_set('America/New_York');

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
        mysqli_query($connection, "delete from crs_tdrr where center='$center'") or die(mysqli_error()); 

		
      
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
$sql="INSERT INTO crs_tdrr 
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
       
		
		
$query1="delete from crs_tdrr where revenue_location_name='' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="delete from crs_tdrr where revenue_location_name='end date:' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from crs_tdrr where revenue_location_name='revenue location name' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update crs_tdrr set ncas_account=mid(account_id,11,9) where 1";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update crs_tdrr,center_taxes set crs_tdrr.taxcenter=center_taxes.taxcenter
         where crs_tdrr.center=center_taxes.center";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update crs_tdrr
         set ncas_account='000437995',account_name='over_short'
		 where ncas_account='000200000' ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="update crs_tdrr
         set deposit_id=concat(deposit_id,'GiftCard')
		 where ncas_account='000218110' ";

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


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
header("location: bank_deposits_menu.php?menu_id=a&menu_selected=y&step=2");

?>	