<?php

/*
   Files linked from this file:
   - /include/iConnect.inc
   - /include/activity.php
   - /Documents/budget/admin/step_group.php

   Databases used from this file:
   - budget

   Tables used in this file:
   - crs_tdrr_division_deposits
   - cash_handling_crs_depositors
   - project_steps_detail

   Arrays used in this file:
   - 

*/


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

// echo "<br />$tempid<br />";

extract($_REQUEST);

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");       // connection parameters

mysqli_select_db($connection, $database);                         // database

include("../../../../include/activity.php");                      // database connection parameters

/*
   echo "submit1 = $submit1";
   echo "submit2 = $submit2";
   //exit;
*/

/*
   echo "<pre>";
   print_r($_REQUEST);
   "</pre>";
   // exit;
*/

$query1 = "UPDATE crs_tdrr_division_deposits
            SET
         ";

$query1a = "INSERT IGNORE INTO cash_handling_crs_depositors
            SET
         ";

for ($j = 0; $j < $num_lines; $j++)
{
   $query2 = $query1;
   $query2 .= " orms_depositor_lname = '$orms_depositor_lname[$j]'";  
   // $query2 .= " orms_deposit_amount2='$orms_deposit_amount2[$j]'";   
   $query2 .= " where id = '$id[$j]'";  

   // echo "query2 = $query2 <br /><br />";
   // exit;

   $result2 = mysqli_query($connection, $query2)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br /> $query2<br />");

   IF ($orms_depositor[$j] != '')
   {
      $query2a = $query1a;
      $query2a .= " park = '$park[$j]',";  
      $query2a .= " tempid = '$orms_depositor[$j]',";  
      $query2a .= " first_name = '$orms_depositor_fname[$j]',";    
      $query2a .= " last_name = '$orms_depositor_lname[$j]'"; 

      // echo "query2a = $query2a <br /><br />";
      // exit;     

      $result2a = mysqli_query($connection, $query2a)
               OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2a:<br /> $query2a <br />");
   }
}

// echo "Line: " . __LINE__ . " END<br />";
// exit;

$query3 = "UPDATE budget.crs_tdrr_division_deposits,
                  budget.cash_handling_crs_depositors
            SET crs_tdrr_division_deposits.orms_depositor = cash_handling_crs_depositors.tempid
            WHERE crs_tdrr_division_deposits.orms_depositor = ''
               AND crs_tdrr_division_deposits.park = cash_handling_crs_depositors.park
               AND crs_tdrr_division_deposits.orms_depositor_lname = cash_handling_crs_depositors.last_name
         ";
$result3 = mysqli_query($connection, $query3)
         OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query3:<br /> $query3<br /> ");

// echo "Query3 successful<br />";
// exit;

$query4 = "UPDATE budget.project_steps_detail
            SET status = 'complete' 
            WHERE project_category = '$project_category'
               AND project_name = '$project_name'
               AND step_group = '$step_group'
               AND step_num = '$step_num'
         ";
mysqli_query($connection, $query4)
OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query4:<br /> $query4 <br />");

header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");
 
?>

