<?php

// ini_set('display_errors',1);

// echo "<pre>";print_r($_REQUEST);echo "</pre>"; // exit;

session_start();

// echo "<pre>";print_r($_SESSION);echo "</pre>"; // exit;

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];

// echo $tempid;

extract($_REQUEST);

$end_date = str_replace("-","",$end_date);

// echo $end_date; // exit;
// echo "<pre>";print_r($_REQUEST);echo "</pre>"; // exit;

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");       // connection parameters
mysqli_select_db($connection, $database);                         // database
include("../../../../include/activity.php");                      // database connection parameters

// echo "<br />fiscal_year = $fiscal_year<br />"; // exit;

$query0 = "DELETE FROM bd725_dpr_account_detail
            WHERE f_year = '$fiscal_year'
         ";
// echo "<br />query0 = $query0<br />"; // exit; 
mysqli_query($connection, $query0)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query0:<br />$query0<br />");
// echo "<br />Line 30<br />"; // exit;

$query = "INSERT INTO bd725_dpr_account_detail(center,
                                                account,
                                                account_description,
                                                cash_type,
                                                ytd,
                                                ptd,
                                                f_year
                                             )
         SELECT fund,
               account,
               account_descript,
               cash_type,
               SUM(ytd),
               SUM(ptd),
               '$fiscal_year' 
         FROM bd725_dpr
         WHERE dpr = 'y'
            AND (ytd != '0.00' OR ptd != '0.00')
            AND f_year = '$fiscal_year' 
            GROUP BY id
         ";     
// echo "<br />query = $query<br />"; //exit;          
                         
mysqli_query($connection, $query)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query:<br />$query<br />");

$query1 = "UPDATE bd725_dpr_account_detail,
                  coa
            SET bd725_dpr_account_detail.acct_cat = coa.acct_cat
            WHERE bd725_dpr_account_detail.account = coa.ncasnum
         ";
// echo "<br />query1 = $query1<br />"; // exit;              
mysqli_query($connection, $query1)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query1:<br />$query1<br />");

$query2 = "UPDATE bd725_dpr_account_detail,
                  coa
            SET bd725_dpr_account_detail.acct_transfer = 'y'
            WHERE bd725_dpr_account_detail.account = coa.ncasnum
               AND coa.ci_transfer = 'y'
         ";               
// echo "<br />query2=$query2<br />"; // exit;
mysqli_query($connection, $query2)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br />$query2<br />");

$query3 = "UPDATE bd725_dpr_account_detail
            SET fund_account = 'y'
            WHERE (acct_cat = 'fun' OR acct_cat = 'rev')
         ";
// echo "<br />query3 = $query3<br />"; // exit;
mysqli_query($connection, $query3)
            OR DIE ("<br />In File: " . __FILE__ . "<br/ >On Line: " . __LINE__ . "<br />Couldn't execute query3:<br />$query3<br />");

$query23a = "UPDATE budget.project_steps_detail
            SET status = 'complete'
            WHERE project_category = '$project_category'
               AND project_name = '$project_name'
               AND step_group = '$step_group'
               AND step_num = '$step_num'
            ";             
mysqli_query($connection, $query23a)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query23a:<br />$query23a<br />");

/*
$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
                 and step_group='$step_group'  and status='pending' "; 
$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");
$num24=mysqli_num_rows($result24);
if($num24==0)
{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
*/
//// mysql_close();

/*
if($num24==0)
{header("location: main.php?project_category=$project_category&project_name=$project_name ");}
if($num24!=0)
// {echo "num24 not equal to zero";}
*/

{header("location: naspd_annual.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&f_year=$fiscal_year&report_type=form");}
 ?>