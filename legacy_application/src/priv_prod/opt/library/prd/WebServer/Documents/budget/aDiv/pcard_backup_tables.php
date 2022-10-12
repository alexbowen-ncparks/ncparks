<?php

//echo "PHP File table1_backup.php";  //exit;

//ini_set('display_errors',1);
//echo "<br />Hello pcard_backup_tables.php<br />";
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
include("/opt/library/prd/WebServer/include/activity.php"); // connection parameters

$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];

$start_date=str_replace("-","",$start_date);
$end_date=str_replace('-','',$end_date);

// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here!  ex. $today_date="20220614";
$today_date=date("Ymd");

//$db="budget_$today_date";

//if($mark_complete != 'y')
//{
////////*
$query0="update table_menu2 set backup='n'
         where project_category='fms' and project_name='pcard_updates' and project_group='E' ";
//echo "Line 33<br />query=$query0<br />"; //exit;
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);//brings back max (end_date) as $end_date

$query="select count(id) as 'tables_count' from table_menu2
        where project_category='fms' and project_name='pcard_updates' and project_group='E' ";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
extract($row);//brings back max (end_date) as $end_date

echo "<table border='1' align='center'>";
echo "<tr><td colspan='3'>TABLES backed up: $tables_count</td></tr>";
echo "<tr><td>database</td><td>table</td><td>record_count</td></tr>";

for($j=0;$j<$tables_count;$j++){

        $query="SELECT table_name,backup,id FROM `table_menu2`
                WHERE  project_category='fms' and project_name='pcard_updates' and project_group='E' and backup='n' 
        	    order by table_name limit 1";
        //echo "Line 33<br />query=$query<br />"; //exit;
        $result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
        $row=mysqli_fetch_array($result);
        extract($row);//brings back max (end_date) as $end_date


        //exit;


        $db="$today_date";
        //$ta1="crs_tdrr_division_deposits";
        $ta1=$table_name;

        // character count for "create table"=12
        $len1=strlen("create table");

        //table character count (counts Table name + 4 spaces) //  (4 spaces represent the DASH and SPACE on Left and Right Side of Table name) 
        $len2=strlen($ta1)+4;

        $len3=$len1+$len2;


        $ct=date("His");

        $query1="show create table $ta1";
        ////echo "<br />query1=$query1<br /><br />";

        //exit;
        $result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
        $row1=mysqli_fetch_array($result1);
        //print_r($row1[1]);  exit;
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

        /*
        $query2a="select count(*) as 'record_count' from `budget_daily_backup`.`$db$ta1$ct` ";

        $result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a ");
        $row2a=mysqli_fetch_array($result2a);
        extract($row2a);//brings back max (end_date) as $end_date


        echo "<tr><td>budget_daily_backup</td><td>$db$ta1$ct</td><td>$record_count</td></tr>";
        */


        $query2="update table_menu2 set backup='y' where id='$id' ";
        $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");
        $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");
        $row2=mysqli_fetch_array($result2);
        extract($row2);//brings back max (end_date) as $end_date

}


{header("location: pcard_weekly_reports.php?new_rep_add=y");}


?>