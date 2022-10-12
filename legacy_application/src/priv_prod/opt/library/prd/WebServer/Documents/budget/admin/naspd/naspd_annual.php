<?php

session_start();

IF (!$_SESSION["budget"]["tempID"])
{
   echo "access denied";
   exit;
   
   // header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file = $_SERVER['SCRIPT_NAME'];
$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempID = $_SESSION['budget']['tempID'];
$beacnum = $_SESSION['budget']['beacon_num'];
$concession_location = $_SESSION['budget']['select'];
$concession_center = $_SESSION['budget']['centerSess'];

extract($_REQUEST);


// echo "<pre>";print_r($_SERVER);"</pre>"; //exit;
// echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
// echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
// echo "<br />$active_file<br />";
// echo "<br />fiscal year: $f_year<br />";
// echo "<br />reset: $reset<br />";

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database);    // database

include("../../../../include/activity.php");    // database connection parameters
// include("../budget/~f_year.php");
// $fyear = "2021";
// $f_year = "2021";
// echo "<br />f_year=$f_year<br />";
// echo "<br />fyear=$fyear<br />";

// include("../../budget/~f_year.php");

IF ($reset == 'yes')
{
    $query9 = "UPDATE project_steps_detail
               SET status = 'pending'
               WHERE project_category = 'fms'
                  AND project_name = 'naspd_annual'
                  AND step_group = 'b'
               ";
   echo "query9 = $query9<br />";
   $result9 = mysqli_query($connection, $query9)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query9:<br />$query9<br />");
}

$table = "rbh_multiyear_concession_fees3";

$query10 = "SELECT body_bgcolor,
                  table_bgcolor,
                  table_bgcolor2
            FROM concessions_customformat
            ";
// echo "query10 = $query10<br />";
$result10 = mysqli_query($connection, $query10)
         OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query10:<br />$query10<br />");
$row10 = mysqli_fetch_array($result10);
extract($row10);

$body_bg = $body_bgcolor;
$table_bg = $table_bgcolor;
$table_bg2 = $table_bgcolor2;

// echo "<br />body_bg: $body_bg<br />";
// echo "<br />table_bg: $table_bg<br />";
// echo "<br />table_bg2: $table_bg2<br />";

$query11 = "SELECT filegroup
            FROM concessions_filegroup
            WHERE filename = '$active_file'
            ";
$result11 = mysqli_query($connection, $query11)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query11:<br />$query11<br />");
$row11 = mysqli_fetch_array($result11);
extract($row11);

// include("../../../budget/menus2.php");
// include("menu1314_cash_receipts.php");
include("../../../budget/menu1314.php");
// include ("naspd_annual_widget1.php");
// include ("naspd_annual_widget2.php");
// include ("vm_report_menu_v2.php");
// include ("vm_widget2_v2.php");
// include("park_posted_transactions_report_menu.php");
// include("widget1.php");
include("fyear_head_naspd_annual2.php");

$f_year = $py1;
/*
$query3="select f_year,py3 from fiscal_year where report_year='$f_year' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (start_date) as $start_date
*/

// echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1><br />";

echo "<style>
         td {
            padding: 7px;
            }
         th {
            padding: 7px;
            }
      </style>
      ";

$project_name = 'naspd_annual_2';
// $report_type = 'reports';

IF ($report_type == 'form')
{
   $report_form = "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
}

IF ($report_type == 'reports')
{
   $report_reports = "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
}

IF ($report_type == 'reports6')
{
   $report_reports6 = "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
}

/*
echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>$project_name</font></th><th><a href='naspd_annual.php?f_year=$f_year&report_type=reports'>Table 5</a><br />$report_reports </th><th><a href='naspd_annual.php?f_year=$f_year&report_type=reports6'>Table 6</a><br />$report_reports6 </th><th><a href='naspd_annual.php?f_year=$f_year&report_type=form&reset=y'>Form</a><br />$report_form</th></tr></table>";
*/

echo "<br />
         <table align='center' border='1' align='left'>
            <tr>
               <th>
                  <font color='brown'>
                     $project_name
                  </font>
               </th>
               <th>
                  <a href='naspd_annual.php?f_year=$f_year&report_type=reports'>
                     Table 5
                  </a>
                  <br />
                     $report_reports 
               </th>
               <th>
                  <a href='../../../budget/portal.php?dbTable=bd725_naspd6' target='_blank'>
                     Table 6
                  </a>
                  <br />
                     $report_reports6 
               </th>
               <th>
                  <a href='naspd_annual.php?f_year=$f_year&report_type=form'>
                     $f_year Form
                  </a>
                  <br />
                     $report_form
               </th>
            </tr>
         </table>
      <br />
      ";

// echo "<br />report_type = $report_type <br />";

IF ($report_type == 'form')
{
   $project_category = 'fms';  
   $project_name = 'naspd_annual';
   $step_group = 'b';

   include("fyear_head_naspd_annual2.php");

   echo "f_year = $f_year
         <br />
         py1 = $py1
         <br />
         ";

   // include("fyear_head_naspd_annual.php");      // database connection parameters
   echo "<br />";
        
   $query3 = "SELECT *,
                  from_unixtime(time_complete) AS 'time_complete2'
               FROM project_steps_detail
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
                  AND step_group = '$step_group'
               ORDER BY step_num ASC
               ";
    // The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
    $result3 = mysqli_query($connection, $query3)
            OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query3:<br />  $query3<br />");
    $num3 = mysqli_num_rows($result3);  
    echo "<br />query3 = $query3<br />";    
    
    IF ($f_year == $py1)
      {
         echo "<table align='center'>
               <tr>
                  <td>
                     <a href='naspd_annual.php?report_type=form&reset=yes'>
                        <img height='50' width='85' src='/budget/infotrack/icon_photos/mission_icon_photos_202.png' alt='picture of green check mark'>
                        </img>
                     </a>
                  </td>
               </tr>
            </table>
            ";
      }
        
    echo "<table align='center' border=1>
            <tr> 
               <td align='center'><font color='brown'>StepNum</font></td>
               <td align='center'><font color='brown'>StepName</font></td>
               <td align='center'><font color=red>Action</font></td>
            </tr>
         ";

    // The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
   while ($row3 = mysqli_fetch_array($result3))
   {   
      // The extract function automatically creates individual variables from the array $row
      // These individual variables are the names of the fields queried from MySQL
      // $rank=@$rank+1;
      extract($row3);
      // $rank=$rank+1;

      //echo $status;
      //$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
      //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
      //if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
        
      IF ($status == 'complete')
      {
         $t = " bgcolor='#95e965'";
      }
      else
      {
         $t = " bgcolor='#B4CDCD'";
      }
      // echo "t = $t<br />";
      IF ($status == 'complete')
      {
         $fcolor1 = 'red';
      }
      else
      {
         $fcolor1 = 'black';
      } 
      // if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
      // echo $status;
      echo "<tr$t>";   
      // echo "<td>$rank</td>";   
      echo "<td align='center'>
               $step_num
            </td>
            <td>
               $step_name
            </td>
            <td>
               <form method='post' action='step$step_group$step_num.php'>
                  <input type='hidden' name='fiscal_year' value='$f_year'>    
                  <input type='hidden' name='project_category' value='$project_category'>     
                  <input type='hidden' name='project_name' value='$project_name'>     
                  <input type='hidden' name='start_date' value='$start_date'>     
                  <input type='hidden' name='end_date' value='$end_date'>     
                  <input type='hidden' name='step_group' value='$step_group'>     
                  <input type='hidden' name='step_num' value='$step_num'>     
                  <input type='hidden' name='step' value='$step'>     
                  <input type='hidden' name='step_name' value='$step_name'>       
                  <input type='hidden' name='link' value='$link'>     
                  <input type='submit' name='submit1' value='Execute'>
               </form>
            </td>
            </tr>";
        }

   echo "</table>";
}

IF ($report_type == 'reports')
{
   include("fyear_head_naspd_annual2.php");     //database connection parameters
   
   echo "<br />";
   // exit;
   // echo "<br />f_year = $f_year<br />";
   // echo "<br />fyear = $fyear<br />";
   // exit;

   $naspd_table = 5;

   // echo "<br />naspd_table=$naspd_table<br />";

   IF ($naspd_table = 5)
   {
      $query5 = "SELECT comment_internal
                  FROM naspd_comments
                  WHERE f_year = '$f_year'
                  ";
      $result5 = mysqli_query($connection, $query5)
               OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5:<br />  $query5<br />");
      $row5 = mysqli_fetch_array($result5);
      extract($row5);
   
      $query5a1 = "SELECT SUM(debit - credit) AS 'amount1'
                  FROM exp_rev
                     LEFT JOIN coa
                        ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND coa.cash_type = 'disburse'
                     AND exp_rev.acct != '5381ag' 
                  ";
      // echo "<br />query5a1 = $query5a1<br />";
      $result5a1 = mysqli_query($connection, $query5a1)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5a1:<br />  $query5a1<br />");
      $row5a1 = mysqli_fetch_array($result5a1);
      extract($row5a1);

      $query5a2 = "SELECT SUM(credit - debit) AS 'amount2'
                     FROM exp_rev
                        LEFT JOIN coa
                           ON exp_rev.acct = coa.ncasnum
                     WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                        AND exp_rev.f_year = '$f_year'
                        AND coa.naspd_funding_source = 'park_generated_revenues'
                  ";
      $result5a2 = mysqli_query($connection, $query5a2)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5a2:<br />  $query5a2<br />");
      $row5a2 = mysqli_fetch_array($result5a2);
      extract($row5a2);

      $query5a3 = "SELECT SUM(debit - credit) AS 'amount3'
                  FROM exp_rev
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND exp_rev.acct != '5381ag'
                  ";
      $result5a3 = mysqli_query($connection, $query5a3)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5a3:<br />$query5a3<br />");
      $row5a3 = mysqli_fetch_array($result5a3);
      extract($row5a3);

      $query5a3a = "SELECT SUM(credit - debit) AS 'amount3a'
                     FROM exp_rev
                        LEFT JOIN coa
                           ON exp_rev.acct = coa.ncasnum
                     WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                        AND exp_rev.f_year = '$f_year'
                        AND coa.naspd_funding_source = 'federal_funds'
                     ";
      $result5a3a = mysqli_query($connection, $query5a3a)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5a3a:<br />$query5a3a<br />");
      $row5a3a = mysqli_fetch_array($result5a3a);
      extract($row5a3a);

      $query5a4 = "SELECT SUM(credit - debit) AS 'amount4'
                  FROM exp_rev
                     LEFT JOIN coa
                        ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND (coa.budget_group = 'par3'
                           OR coa.ncasnum = '438923'
                           OR coa.naspd_funding_source = 'other_sources'
                        )
                  ";
      $result5a4 = mysqli_query($connection, $query5a4)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5a4:<br />$query5a4<br />");
      $row5a4 = mysqli_fetch_array($result5a4);
      extract($row5a4);

      /*
      $query5a5="select sum(credit-debit) as 'amount4'
      from exp_rev
      left join coa on exp_rev.acct=coa.ncasnum
      where exp_rev.fund='1280'
      and exp_rev.f_year='$f_year'
      and coa.budget_group='par3';";
               
      $result5a5 = mysqli_query($connection, $query5a5) or die ("Couldn't execute query 5a5.  $query5a5");
      $row5a5=mysqli_fetch_array($result5a4);
      extract($row5a5);
      */

      echo "<br />";

      echo "<table align='center'>
               <tr>
                  <td bgcolor='#FFE4E1'>
                     Table 5: Financing
                  </td>
               </tr>
               <tr>
                  <td bgcolor='#FFE4E1'>
                     Table 5a: Operating Expenditures
                  </td>
               </tr>
            </table>
            <br />
            ";

      echo "<table border=1 align='center'>
               <tr>
                  <th>
                     Line Item
                  </th>
                  <th>
                  Amount
                  </font>
                  </th>
               </tr>
            ";
      
      $amount5 = $amount2 + $amount3 + $amount3a + $amount4;
      $amount1 = number_format($amount1,2);
      $amount2 = number_format($amount2,2);
      $amount3 = number_format($amount3,2);
      $amount3a = number_format($amount3a,2);
      $amount4 = number_format($amount4,2);

      IF ($c == '')
      {
         $t = " bgcolor='$table_bg2'";
         $c = 1;
      }
      ELSE
      {
         $t = '';
         $c = '';
      }

      $amount5=number_format($amount5,2);

      echo "<tr>
               <td>
                  operating expenditures
               </td>
               <td>
                  $amount1
               </td>
            </tr>
            ";          
      echo "<tr>
               <td>
                  park generated revenues
               </td>
               <td>
                  $amount2
               </td>
            </tr>
            ";         
      echo "<tr>
               <td>
                  general fund
               </td>
               <td>
                  $amount3
               </td>
            </tr>
            ";        
      echo "<tr>
               <td>
                  federal funds
               </td>
               <td>
                  $amount3a
               </td>
            </tr>
            ";          
      echo "<tr>
               <td>
                  other sources
               </td>
               <td>
                  $amount4
               </td>
            </tr>
            ";           
      echo "<tr>
               <td>
                  total funds
               </td>
               <td>
                  $amount5
               </td>
            </tr>
            ";

      IF ($f_year != '1819' AND $f_year != '1920')
      {   
         echo "<tr>
                  <td>
                     Notes
                  </td>
                  <td>
                     Other Sources includes: 
                     <br />
                     Carry forward Funds of $amount4 
                     <br />
                     from Prior Year
                  </td>
               </tr>
               ";
      }

      IF ($f_year == '1819')
      {
         echo "<tr>
                  <td>
                     Notes
                  </td>
                  <td>
                     Other Sources includes: 
                     <br />
                     Carry forward Funds of $1,087,003.00 
                     <br />
                     PARTF Funds of $368,465.55
                  </td>
               </tr>
               ";      
      }

      IF ($f_year == '1920')
      {
         echo "<tr>
                  <td>
                     Notes
                  </td>
                  <td>
                     Other Sources includes: 
                     <br />
                     Carry forward Funds of $2,765,235.04 
                     <br />
                     Other Funds of $3,807,617.42
                  </td>
               </tr>
               ";
      }

      echo "</table>
            <br />
            <br />
            <br />
            ";
      // echo "<br /><br />";
      
      $query5e1 = "SELECT SUM(credit - debit) AS 'amount6'
                  FROM exp_rev
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND (exp_rev.acct = '435700' OR exp_rev.acct = '435700006')
                  ";
      $result5e1 = mysqli_query($connection, $query5e1)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e1:<br />$query5e1<br />");
      $row5e1 = mysqli_fetch_array($result5e1);
      extract($row5e1);

      $query5e2 = "SELECT SUM(credit - debit) AS 'amount7'
                  FROM exp_rev
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND exp_rev.acct = '434410003'
                  ";
      $result5e2 = mysqli_query($connection, $query5e2)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e2:<br />$query5e2<br />");
      $row5e2 = mysqli_fetch_array($result5e2);
      extract($row5e2);

      $query5e3 = "SELECT SUM(credit - debit) AS 'amount8'
                  FROM exp_rev
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND exp_rev.acct = '434410004'
                  ";
      $result5e3 = mysqli_query($connection, $query5e3)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e3:<br ?>$query5e3<br />");
      $row5e3 = mysqli_fetch_array($result5e3);
      extract($row5e3);

      $query5e4 = "SELECT SUM(credit - debit) AS 'amount9'
                  FROM exp_rev
                     LEFT JOIN coa
                        ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund= '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND coa.budget_group = 'pfr_revenues'
                  ";
      $result5e4 = mysqli_query($connection, $query5e4)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e4:<br />$query5e4<br />");
      $row5e4 = mysqli_fetch_array($result5e4);
      extract($row5e4);

      $query5e5 = "SELECT SUM(credit - debit) AS 'amount10'
                  FROM exp_rev
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND exp_rev.acct = '434390'
                  ";
      $result5e5 = mysqli_query($connection, $query5e5)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e5:<br />$query5e5<br />");
      $row5e5 = mysqli_fetch_array($result5e5);
      extract($row5e5);

      $query5e6 = "SELECT SUM(credit - debit) AS 'park_gen_revs_total'
                  FROM exp_rev
                     LEFT JOIN coa
                        ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND coa.naspd_funding_source = 'park_generated_revenues'
                  ";
      $result5e6 = mysqli_query($connection, $query5e6)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e6:<br />$query5e6<br />");
      $row5e6 = mysqli_fetch_array($result5e6);
      extract($row5e6);

      $revenue_other = $park_gen_revs_total - $amount10 - $amount9 - $amount8 - $amount7 - $amount6;
      $revenue_other = number_format($revenue_other,2);
      $park_gen_revs_total = number_format($park_gen_revs_total,2);
      
      echo "<table align='center'>
               <tr>
                  <td bgcolor='#FFE4E1'>
                     Table 5e: Park Generated Revenue by Type
                  </td>
               </tr>
            </table>
            <br />
            ";
      echo "<table border=1 align='center'>
               <tr>
                  <th>
                     Line Item
                  </th>
                  <th>
                     Amount
                  </font>
                  </th>
               </tr>
            ";
      
      // $amount5 = $amount2 + $amount3 + $amount4;
      $amount6 = number_format($amount6,2);
      $amount7 = number_format($amount7,2);
      $amount8 = number_format($amount8,2);
      $amount9 = number_format($amount9,2);
      $amount10 = number_format($amount10,2);

      IF ($c == '')
      {
         $t = " bgcolor='$table_bg2'";
         $c = 1;
      }
      ELSE
      {
         $t = '';
         $c = '';
      }

      echo "<tr>
               <td>
                  entrance fees
               </td>
               <td>
                  $amount6
               </td>
            </tr>
            <tr>
               <td>
                  camping fees
               </td>
               <td>
                  $amount7
               </td>
            </tr>
            <tr>
               <td>
                  cabin/cottage rentals
               </td>
               <td>
                  $amount8
               </td>
            </tr>
            <tr>
               <td>
                  concession operations
               </td>
               <td>
                  $amount9
               </td>
            </tr>
            <tr>
               <td>
                  beach/pool operations
               </td>
               <td>
                  $amount10
               </td>
            </tr>
            <tr>
               <td>
                  all other operations
               </td>
               <td>
                  $revenue_other
               </td>
            </tr>
            <tr>
               <td>
                  total park generated revenue
               </td>
               <td>
                  $park_gen_revs_total
               </td>
            </tr>
         </table>
         <br />
         <br />
         <br />
         ";

      $query5e7 = "SELECT coa.naspd_funding_source,
                           coa.naspd_revenue_type,
                           coa.park_acct_desc AS 'account_description',
                           exp_rev.acct,
                           SUM(exp_rev.credit-exp_rev.debit) AS 'amount'
                  FROM exp_rev
                        LEFT JOIN coa
                           ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                        AND exp_rev.f_year = '$f_year'
                        AND coa.naspd_funding_source != ''
                        AND coa.naspd_revenue_type != ''
                  GROUP BY naspd_funding_source,
                           naspd_revenue_type,
                           exp_rev.acct
                  ORDER BY naspd_funding_source,
                           naspd_revenue_type,
                           exp_rev.acct;
                  ";
      // echo "query5e7 = $query5e7";
      $result5e7 = mysqli_query($connection, $query5e7)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e7:<br />$query5e7<br />");
      $num5e7 = mysqli_num_rows($result5e7);
      // $row5e7 = mysqli_fetch_array($result5e7);
      // extract($row5e7);
      echo "<table align='center'><tr><td bgcolor='#FFE4E1'>
               DPR Comments (INTERNAL Use ONLY)
               </td>
               </tr>
            </table>
            <br />
            <table align='center'>
               <tr>
                  <form method='post' action='naspd_annual.php' name='form3' >
                     <td>
                        <textarea name= 'comment_internal' rows='10' cols='100' id='input3' readonly='readonly' >
                           $comment_internal
                        </textarea>
                     </td>";            
      //echo "<td><input type=submit name=submit value=Run_Query></td>";
      //echo "<input type='hidden' name='tempID' value='$tempID'>";      
      //echo "<input type='hidden' name='concession_location' value='$concession_location'>";    
            echo "</form>
               </tr>
            </table>
            <br />
            <br />
            <table align='center'><tr><td bgcolor='#FFE4E1'>
               DPR (Fund 1280) Receipts by NCAS Account (INTERNAL Use ONLY)
               </td>
               </tr>
            </table>
            <br />
            <table align='center'>
               <tr>
                  <th>
                     $num5e7 Records
                  </th>
               </tr>
            </table>
            <br />
            <table border=1 align='center'>
               <tr>
                  <th>
                     NCAS Account#
                  </th>
                  <th>
                     NCAS
                     <br />
                      Account Description
                  </th>
                  <th>
                     NASPD 
                     <br />
                     Funding Source
                  </th>
                  <th>
                     NASPD
                     <br />
                      Park Generated
                      <br />
                      Revenue Type
                  </th>
                  <th>
                     Amount
                  </th>
               </tr>
            ";

      while ($row5e7 = mysqli_fetch_array($result5e7))
      {
         extract($row5e7);
         // $park_acct_desc=strtolower($park_acct_desc);
         // $park_acct_desc=str_replace('_',' ',$park_acct_desc);
         $account_description = str_replace('_',' ',$account_description);
         $account_description = strtolower($account_description);
         $naspd_funding_source = str_replace('_',' ',$naspd_funding_source);
         $naspd_revenue_type = str_replace('_',' ',$naspd_revenue_type);
         $amount = number_format($amount,2);
         //$py_actual=number_format($py_actual,2);
         //$difference=number_format($difference,2);

         if ($c == '')
         {
            $t = " bgcolor='$table_bg2' ";
            $c = 1;
         }
         else
         {
            $t = '';
            $c = '';
         }

         echo "<tr$t>
                  <td>
                     $acct
                  </td>
                  <td>
                     $account_description
                  </td>
                  <td>
                     $naspd_funding_source
                  </td>
                  <td>
                     $naspd_revenue_type
                  </td>
                  <td>
                     $amount
                  </td>
               </tr>
            ";
      }

      $query5e8 = "SELECT SUM(exp_rev.credit - exp_rev.debit) AS 'total_amount'
                  FROM exp_rev
                     LEFT JOIN coa
                        ON exp_rev.acct = coa.ncasnum
                  WHERE (exp_rev.fund = '1280' OR exp_rev.fund = '1680')
                     AND exp_rev.f_year = '$f_year'
                     AND coa.naspd_revenue_type != ''
                  ";
      $result5e8 = mysqli_query($connection, $query5e8)
                  OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query5e8:<br />$query5e8<br />");
      $row5e8 = mysqli_fetch_array($result5e8);
      extract($row5e8);
      
      $total_amount = number_format($total_amount,2);
      
      echo "<tr>
               <td>
               </td>
               <td>
               </td>
               <td>
               </td>
               <td>
                  Total
               </td>
               <td>
                  $total_amount
               </td>
            </tr>
         </table>
         ";
   }
}

IF ($report_type == 'reports6')
{
   include("fyear_head_naspd_annual2.php");     // database connection parameters

   echo "<br />";
   // echo "<table align='center'><tr><td>Table 6 pending</td></tr></table>";

   include("reports6.php");         // database connection parameters
}

?>