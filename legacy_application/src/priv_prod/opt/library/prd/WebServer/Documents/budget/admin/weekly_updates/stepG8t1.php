<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

/*
$start_date=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);
if($fiscal_year=='1617'){$begin_date='20160701';}
if($fiscal_year=='1718'){$begin_date='20170701';}
if($fiscal_year=='1819'){$begin_date='20180701';}
if($fiscal_year=='1920'){$begin_date='20190701';}
if($fiscal_year=='2021'){$begin_date='20200701';}
if($fiscal_year=='2122'){$begin_date='20210701';}
if($fiscal_year=='2223'){$begin_date='20220701';}
if($fiscal_year=='2324'){$begin_date='20230701';}
if($fiscal_year=='2425'){$begin_date='20240701';}

//echo "begin_date=$begin_date";
//echo "<br />"; 
//echo "<br />end_date2=$end_date2<br />";  exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
*/


//echo "submit1=$submit1";echo "submit2=$submit2";exit;

/*
if($part2 != 'y')
{
include("warehouse_billings_backup.php");
}
*/

$first_date=$first_day_of_fyear;
$last_date=$last_day_of_fyear;


//if($part2 == 'y')
//{
/*	
echo "<br />Line38 OK<br />";  //exit;	
echo "<br />first_date=$first_date<br />";
echo "<br />last_date=$last_date<br />"; 
exit;
*/


$query1="delete from budget.warehouse_billings_2
where f_year='$fiscal_year' ; ";

//echo "<br />query1=$query1<br />";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");




$query2="insert into budget.warehouse_billings_2
(invoicenum,old_center,productnum_0405,price,quantity,acct,post_date,f_year)
select invoice_number,center,product_number,price,quantity,account,processed_date,'$fiscal_year'
from ware.park_order
where invoice_number != ''
and processed_date >= '$first_date' and processed_date <= '$last_date' ;
";

//echo "<br />query2=$query2<br />";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="insert into budget.warehouse_billings_2
(invoicenum,old_center,productnum_0405,price,quantity,acct,post_date,f_year)
select invoice_number,'12802802',product_number,-price,quantity,account,processed_date,'$fiscal_year'
from ware.park_order
where invoice_number != ''
and processed_date >= '$first_date' and processed_date <= '$last_date'  ;
";

//echo "<br />query3=$query3<br />";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


//echo "<br />Line76<br />";  //exit;



$query4="update budget.warehouse_billings_2,budget.center
set warehouse_billings_2.new_center=center.new_center
where warehouse_billings_2.old_center=center.old_center
and warehouse_billings_2.f_year='$fiscal_year' ;

";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");



$query5="update budget.warehouse_billings_2
set center=new_center
where f_year='$fiscal_year' ; 

";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");


$query6="update budget.warehouse_billings_2
set post_date=replace(post_date,'-','')
where f_year='$fiscal_year' ;

";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");



$query7="update budget.warehouse_billings_2,ware.base_inventory
set budget.warehouse_billings_2.productname=ware.base_inventory.product_title
where budget.warehouse_billings_2.productnum_0405=ware.base_inventory.product_number
and budget.warehouse_billings_2.f_year='$fiscal_year'
and budget.warehouse_billings_2.productname='' ;

";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");


$query8="update budget.warehouse_billings_2
set pricexquantity=price*quantity
where f_year='$fiscal_year'
and pricexquantity='0.00' ;

";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");



$query9="update budget.warehouse_billings_2
set invoice_new=concat('invoice#',' ',invoicenum,' ','(',' ',productname,')',' ',quantity,' ','@',' ',price)
where 1 and f_year='$fiscal_year' and invoice_new='' ; ";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");



/*
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

*/


//}

?>