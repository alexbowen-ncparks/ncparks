<?php

//echo "PHP File table1_backup.php";  //exit;


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";
$db="$today_date";
$ta3="fuel_tank_usage";
$ct=date("His");


$query1=" CREATE TABLE `budget_daily_backup`.`$db$ta3$ct` 
(
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `park` varchar(10) NOT NULL,
 `center` varchar(15) NOT NULL,
 `fyear` varchar(4) NOT NULL,
 `cash_month` varchar(15) NOT NULL,
 `cash_month_number` int(3) NOT NULL,
 `cash_month_calyear` varchar(4) NOT NULL,
 `cashier` varchar(50) NOT NULL,
 `cashier_amount` decimal(12,2) NOT NULL,
 `reimbursement_gallons` decimal(12,4) NOT NULL,
 `reimbursement_rate` decimal(12,4) NOT NULL,
 `document_location` varchar(200) NOT NULL,
 `cashier_date` date NOT NULL,
 `manager` varchar(50) NOT NULL,
 `manager_date` date NOT NULL,
 `score` decimal(12,2) NOT NULL,
 `valid` char(1) NOT NULL DEFAULT 'n',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1

";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2=" INSERT INTO `budget_daily_backup`.`$db$ta3$ct`
SELECT *
FROM `budget`.`$ta3` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query2a="select count(*) as 'record_count3' from `budget_daily_backup`.`$db$ta3$ct` ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a ");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);//brings back max (end_date) as $end_date
/*
echo "<table align='center' border='1'><tr><td><font color='red'>Table Backups Successful</font></td></tr></table>";
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>Database</font></td><td align='center'><font color='brown'>TABLE</font></td><td align='center'><font color='brown'>RECORDS</font></td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta1$ct</td><td>$record_count1</td></tr>";
*/

//exit;



?>