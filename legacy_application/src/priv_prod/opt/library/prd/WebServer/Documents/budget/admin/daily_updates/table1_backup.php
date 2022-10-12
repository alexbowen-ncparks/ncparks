<?php

/*
   Files linked from this file:
   - 
*/

/*
   Databases used in this file:
   - budget_daily_backup
*/

/*
   Tables used in this file:
   - crs_tdrr_division_deposits
   - {date("Ymd")}crs_tdrr_division_deposits{date("His")}
*/

/*
   Arrays used in this file:
   - 
*/

/* **************************************************************************************************************************** */

// echo "PHP File table1_backup.php"; 
// EXIT;

$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$start_date = str_replace("-","",$start_date);
$end_date = str_replace('-','',$end_date);
$today_date = date("Ymd");
// $db = "budget_$today_date";
$db = "$today_date";
$ta1 = "crs_tdrr_division_deposits";
// character count for "create table"=12
$len1 = strlen("create table");
// table character count (counts Table name + 4 spaces)
// (4 spaces represent the DASH and SPACE on Left and Right Side of Table name) 
$len2 = strlen($ta1) + 4;
$len3 = $len1 + $len2;
// echo "<br /><br />len1 = $len1<br /><br />";
// echo "<br /><br />len2 = $len2<br /><br />";
// echo "<br /><br />len3 = $len3<br /><br />";
$ct = date("His");

$query1 = "SHOW CREATE TABLE $ta1";
// echo "<br />query1 = $query1<br /><br />";
// EXIT;
$result1 = mysqli_query($connection, $query1)
            OR
            DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query1:<br /> $query1<br />");
$row1 = mysqli_fetch_array($result1);
// print_r($row1[1]);
// echo "<br /><br />";
$table_create = $row1[1];

$len1_output = substr($table_create,0,$len1);
// echo "<br /><br />len1_output = $len1_output<br /><br />";
$table_create2 = substr($table_create,$len3);
$table_create3b = substr($table_create2, 0, strpos($table_create2, "ENGINE"));
$table_create3a = "CREATE TABLE " . "`" . "budget_daily_backup" . "`" . "." . "`" . $db . $ta1 . $ct . "`" . " ";
$table_create3c = " ENGINE=MyISAM DEFAULT CHARSET=latin1";
$table_create3 = $table_create3a . $table_create3b . $table_create3c;
// $table_create3 = substr($greeting, 0, strpos($greeting, "="));

// echo "<br />table_create2 = $table_create2<br />";
// echo "<br />table_create3a = $table_create3a<br />";
// echo "<br />table_create3b = $table_create3b<br />";
// echo "<br />table_create3 = $table_create3<br />";
// extract($row1);                                          // Brings back MAX(end_date) AS $end_date
// echo "<br />table = $table<br />"; 

// $greeting = "ENGINES=MyISAM";
// echo "<br />greeting = $greeting<br />";

// $greeting2 = substr($greeting, 0, strpos($greeting, "="));
// $engine = strpos($greeting,"=");
// echo "<br />engine = $engine<br />";

// $greeting2 = rtrim($greeting,"ENGINE ");
// echo "<br />greeting2 = $greeting2<br />";

$query2 = "$table_create3";
$result2 = mysqli_query($connection, $query2)
         OR 
         DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br /> $query2<br />");
//echo "<br />Line " . __LINE__ . ": Update Successful<br />";

$query2 = " INSERT INTO `budget_daily_backup`.`$db$ta1$ct`
         SELECT *
         FROM `budget`.`$ta1` ;
      ";
$result2 = mysqli_query($connection, $query2)
         OR 
         DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br /> $query2<br />");

// echo "<br />Line " . __LINE__ . ": Update Successful<br />";
// EXIT;

/*
   $query1 = "CREATE TABLE `budget_daily_backup`.`$db$ta1$ct` 
            (
               `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
               `location_id` int(10) NOT NULL,
               `park` varchar(4) NOT NULL,
               `center` varchar(15) NOT NULL,
               `new_center` varchar(15) NOT NULL,
               `old_center` varchar(15) NOT NULL,
               `location` varchar(100) NOT NULL,
               `fyear` varchar(4) NOT NULL,
               `cash_month` varchar(30) NOT NULL,
               `cash_month_number` int(3) NOT NULL,
               `cash_month_calyear` varchar(4) NOT NULL,
               `cash_amount` decimal(12,2) NOT NULL,
               `cashier` varchar(50) NOT NULL,
               `cashier_amount` decimal(12,2) NOT NULL,
               `cashier_date` date NOT NULL,
               `manager` varchar(50) NOT NULL,
               `manager_amount` decimal(12,2) NOT NULL,
               `manager_date` date NOT NULL,
               PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ";
*/

/*
   // The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
   $result1 = mysqli_query($connection, $query1)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query1:<br />  $query1<br />");

   $query2 = "INSERT INTO `budget_daily_backup`.`$db$ta1$ct`
               SELECT *
               FROM `budget`.`$ta1` ;";
   $result2 = mysqli_query($connection, $query2)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br /> $query2<br />");
*/

$query2a = "SELECT COUNT(*) AS 'record_count1'
            FROM `budget_daily_backup`.`$db$ta1$ct`
      ";
$result2a = mysqli_query($connection, $query2a)
            OR 
            DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2a:<br /> $query2a<br />");
$row2a = mysqli_fetch_array($result2a);
extract($row2a);                            // Brings back MAX(end_date) AS $end_date
// EXIT;

?>