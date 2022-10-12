<?php

//echo "PHP File table1_backup.php";  //exit;


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);
$today_date=date("Ymd");
//$db="budget_$today_date";
$db="$today_date";
$ta2="report_budget_history_inc_stmt_by_fyear";

// character count for "create table"=12
$len1=strlen("create table");

//table character count (counts Table name + 4 spaces) //  (4 spaces represent the DASH and SPACE on Left and Right Side of Table name) 
$len2=strlen($ta2)+4;

$len3=$len1+$len2;

////echo "<br /><br />len1=$len1<br /><br />";
////echo "<br /><br />len2=$len2<br /><br />";
////echo "<br /><br />len3=$len3<br /><br />";


$ct=date("His");

$query1="show create table $ta2";
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
$table_create3a = "CREATE TABLE "."`"."budget_daily_backup"."`"."."."`".$db.$ta2.$ct."`"." ";
$table_create3c = " ENGINE=MyISAM DEFAULT CHARSET=latin1";
$table_create3 = $table_create3a.$table_create3b.$table_create3c;


//$table_create3=substr($greeting, 0, strpos($greeting, "="));

//echo "<br />table_create2=$table_create2<br />";
////echo "<br />table_create3a=$table_create3a<br />";
////echo "<br />table_create3b=$table_create3b<br />";
////echo "<br />table_create3=$table_create3<br />";
//extract($row1);//brings back max (end_date) as $end_date
//echo "<br />table=$table<br />"; 

//$greeting="ENGINES=MyISAM";
//echo "<br />greeting=$greeting<br />";

//$greeting2 = substr($greeting, 0, strpos($greeting, "="));


//$engine=strpos($greeting,"=");
//echo "<br />engine=$engine<br />";
//$greeting2=rtrim($greeting,"ENGINE ");
//echo "<br />greeting2=$greeting2<br />";

$query2="$table_create3";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

echo "<br />Line 73: Update Successful<br />";

$query2=" INSERT INTO `budget_daily_backup`.`$db$ta2$ct`
SELECT *
FROM `budget`.`$ta2` ;";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


echo "<br />Line 82: Update Successful<br />";

//exit;


$query2a="select count(*) as 'record_count2' from `budget_daily_backup`.`$db$ta2$ct` ";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a ");
$row2a=mysqli_fetch_array($result2a);
extract($row2a);//brings back max (end_date) as $end_date


//exit;



?>