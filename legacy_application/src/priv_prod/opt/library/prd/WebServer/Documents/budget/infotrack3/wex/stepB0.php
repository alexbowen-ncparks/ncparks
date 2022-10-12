<?php

/*
Purpose: WEX reset

   Files sourced from this file:
   - /include/iConnect.inc
   - /include/activity.php
   - /Documents/budget/infotrack3/wex/step_group.php
   -

   Databases queried from this file:
   - budget
   - 

   Tables queried from this file:
   - wex_import
   - wex_detail
   - wex_report
   - project_steps_detail
   - 

   Front-end (instructions) found on/in:
     'budget/wex/infotrack3/stepgroup.php'

*/

// ini_set('display_errors',1);

/*
   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   // exit;
*/

session_start();

/*
   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
   // exit;
*/

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];

// echo $tempid;

extract($_REQUEST);

$end_date = str_replace("-","",$end_date);

/*
   echo $end_date;
   // exit;

   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   // exit;
*/

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");       // connection parameters

mysqli_select_db($connection, $database);                         // database

include("../../../../include/activity.php");                      // database connection parameters

/* clears the wex_import file for any extraneous data from tables through end */
$query = "TRUNCATE TABLE wex_import";
mysqli_query($connection, $query) 
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " .  __LINE__ . "<br />Couldn't execute query:<br /> $query <br />");

$query1 = "DELETE FROM wex_detail
            WHERE valid = 'n'
         ";
mysqli_query($connection, $query1)
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query1:<br /> $query1 <br />");

$query2 = "DELETE FROM wex_report
            WHERE valid = 'n'
         "; 
mysqli_query($connection, $query2)
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br /> $query2 <br />");

 /* end of table clean up */

$query3 = "UPDATE project_steps_detail
            SET status = 'pending'
            WHERE project_name = 'wex_bill'
         "; 
mysqli_query($connection, $query3)
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query3:<br /> $query3 <br />");

$query23a = "UPDATE budget.project_steps_detail
            SET status = 'complete'
            WHERE project_category = '$project_category'
               AND project_name = '$project_name'
               AND step_group = '$step_group'
               AND step_num = '$step_num'
            ";
mysqli_query($connection, $query23a)
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query23a:<br /> $query23a <br />");

//// mysql_close();

{
   header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");
}

?>




















