<?php

//echo "PHP File table1_backup.php";  //exit;


/////$start_date=$_REQUEST['start_date'];
/////$end_date=$_REQUEST['end_date'];

/////$start_date=str_replace("-","",$start_date);
/////$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";
$db="$today_date";
$ta1="warehouse_billings_2";

// character count for "create table"=12
$len1=strlen("create table");

//table character count (counts Table name + 4 spaces) //  (4 spaces represent the DASH and SPACE on Left and Right Side of Table name) 
$len2=strlen($ta1)+4;

$len3=$len1+$len2;

////echo "<br /><br />len1=$len1<br /><br />";
////echo "<br /><br />len2=$len2<br /><br />";
////echo "<br /><br />len3=$len3<br /><br />";


$ct=date("His");

$query1="show create table $ta1";
////echo "<br />query1=$query1<br /><br />";

//exit;
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
////print_r($row1[1]);
////echo "<br /><br />";
$table_create=$row1[1];
$len1_output=substr($table_create,0,$len1);
////echo "<br /><br />len1_output=$len1_output<br /><br />";

$table_create2=substr($table_create,$len3);
$table_create3b = substr($table_create2, 0, strpos($table_create2, "ENGINE"));
$table_create3a = "CREATE TABLE "."`"."budget_daily_backup"."`"."."."`".$db.$ta1.$ct."`"." ";
$table_create3c = " ENGINE=MyISAM DEFAULT CHARSET=latin1";
$table_create3 = $table_create3a.$table_create3b.$table_create3c;



$query2="$table_create3";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

//echo "<br />Line 73: Update Successful<br />";

$query2=" INSERT INTO `budget_daily_backup`.`$db$ta1$ct`
SELECT *
FROM `budget`.`$ta1` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


echo "<br />Line 82: Update Successful<br />";



$query2a="select count(*) as 'record_count1' from `budget_daily_backup`.`$db$ta1$ct` ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a ");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);//brings back max (end_date) as $end_date


echo "<table align='center' border='1'><tr><td><font color='red'>Table Backups Successful</font></td></tr></table>";
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>Database</font></td><td align='center'><font color='brown'>TABLE</font></td><td align='center'><font color='brown'>RECORDS</font></td></tr>";
echo "<tr><td>budget_daily_backup</td><td>$db$ta1$ct</td><td>$record_count1</td></tr>";
echo "</table>";

echo "<table align='center' border='1'><tr><td><a href='stepG8t1.php?part2=y&project_category=$project_category&project_name=$project_name&step_num=$step_num&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date'>Part 2 (Update warehouse_billings2)</a></td></tr></table>";
exit;



?>