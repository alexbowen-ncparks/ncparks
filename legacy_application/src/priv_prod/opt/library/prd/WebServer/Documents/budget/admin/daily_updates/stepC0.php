<?php

/*
   Files linked from this file
   - /include/iConnect.inc
   - /include/activity.php
   - /budget/admin/daily_updates/table##_backup.php            // where table1_backup.php - table26_backup.php
   - /budget/admin/daily_updates/stepC0.php
   - /budget/admin/daily_updates/ste_group.php
*/

/*
   Databases used in this file
   - budget
*/

/*
   Tables used in this file
   - project_steps_detail
*/

/*
   ARRAYs used in this File
   - 
*/

/* ****************************************************************************************************************************** */

// ini_set('display_errors',1);

/*
   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   // EXIT;
*/

session_start();

/*
   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
   // EXIT;
*/

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];

// echo $tempid;
extract($_REQUEST);

$end_date = str_replace("-","",$end_date);
// echo $end_date;
// EXIT;

/*
   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   // EXIT;
*/

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");       // connection parameters

mysqli_select_db($connection, $database);                         // database

include("../../../../include/activity.php");                      // database connection parameters

IF ($mark_complete != 'y')
{
   include("table1_backup.php");                // crs_tdrr_division_deposits
   include("table2_backup.php");                // crs_tdrr_division_adjustments
   include("table3_backup.php");                // crs_tdrr_division_history
   include("table4_backup.php");                // crs_tdrr_division_history_parks
   include("table5_backup.php");                // crs_tdrr_division_history_parks_adjustments
   include("table6_backup.php");                // crs_tdrr_division_deposits_checklist
   include("table7_backup.php");                // crs_deposits
   include("table8_backup.php");                // crs_deposits_detail
   include("table9_backup.php");                // cash_trans
   include("table10_backup.php");               // cash_deposits
   include("table11_backup.php");               // cash_undeposited
   include("table12_backup.php");               // cash_summary
   include("table13_backup.php");               // crs_tdrr_division_deposits_checks
   include("table14_backup.php");               // mission_headlines
   include("table15_backup.php");               // mission_scores
   include("table16_backup.php");               // purchase_approval_report_dates
   include("table17_backup.php");               // infotrack_projects_community_com
   include("table18_backup.php");               // cash_imprest_count_detail
   include("table19_backup.php");               // cash_imprest_locations_count
   include("table20_backup.php");               // cash_imprest_worksheet
   include("table21_backup.php");               // crs_tdrr_division_history_parks_manual
   include("table22_backup.php");               // crs_tdrr_division_deposits_manual
   include("table23_backup.php");               // crs_deposit_counts
   include("table24_backup.php");               // crs_deposit_counts
   include("table25_backup.php");               // crs_deposit_counts
   include("table26_backup.php");               // crs_deposit_counts

   echo "<table align='center' border='1'>
            <tr>
               <td>
                  <font color='red'>Table Backups Successful</font>
               </td>
            </tr>
         </table>
         <br />
         <table align='center' border='1'>
            <tr>
               <td align='center'>
                  <font color='brown'>Database</font>
               </td>
               <td align='center'>
                  <font color='brown'>TABLE</font>
               </td>
               <td align='center'>
                  <font color='brown'>RECORDS</font>
               </td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta1$ct</td>
               <td>$record_count1</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta2$ct</td>
               <td>$record_count2</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta3$ct</td>
               <td>$record_count3</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta4$ct</td>
               <td>$record_count4</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta5$ct</td>
               <td>$record_count5</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta6$ct</td>
               <td>$record_count6</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta7$ct</td>
               <td>$record_count7</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta8$ct</td>
               <td>$record_count8</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta9$ct</td>
               <td>$record_count9</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta10$ct</td>
               <td>$record_count10</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta11$ct</td>
               <td>$record_count11</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta12$ct</td>
               <td>$record_count12</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta13$ct</td>
               <td>$record_count13</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta14$ct</td>
               <td>$record_count14</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta15$ct</td>
               <td>$record_count15</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta16$ct</td>
               <td>$record_count16</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta17$ct</td>
               <td>$record_count17</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta18$ct</td>
               <td>$record_count18</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta19$ct</td>
               <td>$record_count19</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta20$ct</td>
               <td>$record_count20</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta21$ct</td>
               <td>$record_count21</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta22$ct</td>
               <td>$record_count22</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta23$ct</td>
               <td>$record_count23</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta24$ct</td>
               <td>$record_count24</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta25$ct</td>
               <td>$record_count25</td>
            </tr>
            <tr>
               <td>budget_daily_backup</td>
               <td>$db$ta26$ct</td>
               <td>$record_count26</td>
            </tr>
            <tr>
               <td colspan='3'>
                  <a href='stepC0.php?mark_complete=y&project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date'>Mark Complete
                  </a>
               </td>
            </tr>
         </table>";
   EXIT;
}

IF ($mark_complete == 'y')
{
   $query23a = "UPDATE budget.project_steps_detail
               SET status = 'complete'
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
                  AND step_group = '$step_group'
                  AND step_num = '$step_num'
               ";
   mysqli_query($connection, $query23a)
   OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query23a:<br /> $query23a<br />");
   // echo "<br />query23a = $query23a<br />";
   // EXIT;

   echo "<br />";
   echo "<table align='center' border='1'>
            <tr>
               <td>
                  <a href='step_group.php?fyear=&report_type=form&reset=y'>Return to Monthly Compliance Updates
                  </a>
               </td>
            </tr>
         </table>
      ";

   {header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
}

?>