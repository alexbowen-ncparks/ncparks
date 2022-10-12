<?php

/*
   Files sourced from this file:
   - /include/iConnect.inc
   - /include/activity.php
   - /Documents/budget/wex_upload_cs1.php

   Databases queried from this file:
   - budget
   - 

   Tables queried from this file:
   - project_steps_detail
   - 
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

/*
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

//$status = 'complete';
IF ($status == '')
{
   $query30 = "UPDATE budget.project_steps_detail
               SET status = 'complete' 
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
                  AND step_group = '$step_group'
                  AND step_num = '$step_num'
            ";
   mysqli_query($connection, $query30)
      OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query30: <br /> $query30 <br />");

   /*
      $query31 = "SELECT *
                  FROM project_steps_detail
                  WHERE project_category = '$project_category'
                     AND project_name = '$project_name'
                     AND step_group = '$step_group'
                     AND status = 'pending'
               "; 
      $result31 = mysqli_query($connection, $query31)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query31:<br /> $query31<br />");
      $num31 = mysqli_num_rows($result31);

      echo "pending_items = $num4";
      // exit;

      IF ($num4 == 0)
      {
         echo "done"
      };

      IF ($num4 != 0)
      {
         echo "$num4 pending items"
      };
      // exit;
   
      IF ($num31 == 0)
      {
         $query32 = "UPDATE project_steps
                     SET status = 'complete'
                     WHERE project_category = '$project_category'
                        AND project_name = '$project_name'
                        AND step_group = '$step_group'
                  ";
         mysqli_query($connection, $query32)
            OR DIE ("" . "<br />Couldn't execute query32:<br /> $query32<br />");
      }

      //// mysql_close();
   */

   {
      header("location: /budget/wex_upload_cs1.php");
   }
}
 
?>