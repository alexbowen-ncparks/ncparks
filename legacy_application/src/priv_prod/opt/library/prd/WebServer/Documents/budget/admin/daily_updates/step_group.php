<?php

/*
Files linked from this file
- /include/iConnect.inc
- /include/activity.php
- /budget/menu1314.php
- /budget/admin/welcome.php
- /budget/admin/daily_updates/step_group.php
- {only found in comments Line 282} /budget/admin/weekly_updates/main.php
- /budget/admin/daily_updates/add_step.php
- /budget/infotrack/scoring/score_daily_updates.php
- /budget/infotrack/charts/bright_idea_chart.php
- /budget/admin/daily_updates/ {step$step_group$step_num.php}     variables change the name of the file
- /budget/admin/daily_updates/status_change
- /budget/admin/daily_updates/edit_record.php
- /budget/admin/daily_updates/edit_record_delete_verify.php
- /budget/admin/daily_updates/edit_record_duplicate.php
*/

/*
Databases used in this file
- budget
*/

/*
Tables used in this file
- project_steps
- project_steps_details
- infotrack_customformat
*/

/*
ARRAYs used in this File
- 
*/

/* ******************************************************************************************************************* */

/*
   echo "<pre>";
      print_r($_REQUEST);
   echo "</pre>";
//  EXIT;
*/

session_start();

IF (!$_SESSION["budget"]["tempID"])
{
   echo "access denied";
   EXIT;
}

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];

extract($_REQUEST);

/*
   echo "<pre>";
         print_r($_REQUEST);
   echo "</pre>";
   // EXIT;
*/

/*
   echo "<pre>";
         print_r($_SESSION);
   echo "</pre>";
   // EXIT;
*/

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");     //  connection parameters
mysqli_select_db($connection, $database);                       //  database
include("../../../../include/activity.php");                    //  database connection parameters

IF ($reset == 'y')
{
   //  echo "<br />Write re-set query<br /><br />";

   $query1 = "UPDATE project_steps
               SET status_previous = status
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
            ";
   //  echo "<br />query1 = $query1<br /><br />";
   $result1 = mysqli_query($connection, $query1)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query1: <br />$query1<br />");

   $query1a = "UPDATE project_steps_detail
               SET status_previous = status
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
            ";
   //  echo "<br />query1a = $query1a<br /><br />";
   $result1a = mysqli_query($connection, $query1a)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query1a: <br />$query1a<br />");

   $query1b = "UPDATE project_steps
               SET status = 'pending'
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
            ";
   //  echo "<br />query1b = $query1b<br /><br />";       
   $result1b = mysqli_query($connection, $query1b)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query1b: <br />$query1b<br />");
   
   $query1c = "UPDATE project_steps_detail
               SET status = 'pending'
               WHERE project_category = '$project_category'
                  AND project_name = '$project_name'
            ";
   //  echo "<br />query1c = $query1c<br /><br />";
   $result1c = mysqli_query($connection, $query1c)
               OR
               DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query1c: <br />$query1c<br />");

   /*
      $result2 = mysqli_query($connection, $query2)
                  OR
                  DIE ("Couldn't execute query2 on Line 89:<br />  $query2");
   */
   //  $row2 = mysqli_fetch_array($result2);
   //  extract($row2);                                   //  brings back MAX(start_date) AS $start_date
}

$query1 = "SELECT highlight_color
            FROM infotrack_customformat
            WHERE user_id = '$tempid'
         "; 
  //echo "<br />query1 = $query1<br />";
$result1 = mysqli_query($connection, $query1)
            OR
            DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query1: <br />$query1<br />");
$row1 = mysqli_fetch_array($result1);
extract($row1);

//  echo "<br />highlight_color = $highlight_color";
//  EXIT;                                                //  brings back MAX(end_date) AS $end_date
//  echo "<br />username = $username";


/*   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
   // EXIT;

*/

//  $project_category = $_REQUEST['project_category'];
//  $project_name = $_REQUEST['project_name'];

//  echo $project_category;
//  echo $project_name;

//  $table1 = "weekly_updates";
//  $table2 = "project_notes2";

//  mysql_connect($host,$username,$password);
/*
   @mysql_select_db($database)
   OR
   DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Unable to select database: $database<br />");
*/

include("../../../budget/menu1314.php");

echo "<html>
      <head>
         <script language='JavaScript'>

            function confirmLink()
            {
               bConfirm = confirm('Are you sure you want to Start Over?')
               return (bConfirm);
            }
         </script>
      </head>
   ";
//  echo "<body bgcolor=>";
/*
   echo "<H3 ALIGN=CENTER >
            <A href=welcome.php>Return HOME</A>
         </H3>
      ";
*/


IF (!isset($step))
{
   $step = "";
}

IF ($step_group == 'A')
{
   $step = 'Backups';
}

/*
   echo "<H2 ALIGN=LEFT >
         <font color=brown>
            <i>$project_name-StepGroup $step_group-$step</i>
         </font>
      </H2>
      ";
*/
echo "<br />";
/*
   echo "<table align='center'>
            <tr>
               <th>
                  <i>$project_name - StepGroup</i><br />
                  <i>$step_group - $step</i>
               </th>
            </tr>
         </table>
      ";
*/
/*
   echo "<table align='center'>
            <tr>
               <th>
                  <font size='5'>$project_name($step_group - $step)</font>
               </th>
            </tr>
         </table>
      ";
*/

/*  CHANGED 2/5/18
   echo "<table align='center'>
            <tr>
               <th>
                  <img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'>
                  </img>
                  <font color='brown' size='5'>Cash Handling<br /><br />
                     Administrator Daily Update ($step)</b>
                  </font>
               </th>
            </tr>
         </table>
         <br />
         <br />
      ";
*/

echo "<table align='center'>
      <tr>
         <th>
            <img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'>
            </img>
         </th>
         <th>
            <font color='brown' size='5'>Cash Handling<br />
               Administrator Daily Update</b>
            </font>
         </th>
         <th>
            <a href=\"step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&reset=y\" onClick='return confirmLink()'>
               <img height='75' width='75' src='/budget/infotrack/icon_photos/mission_icon_photos_204.jpg' alt='picture of bank'>
               </img>
            </a>
         </th>
         </td>
      </tr>
   </table>
   ";
// echo "<br /><br />";

/*
   echo "<h2 ALIGN=center>
            <font size=4>
            <b>
               <a href=\"/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates\">
                  Return Weekly Updates-HOME
               </a>
            </b>
            </font>
         </h2>
      ";
*/

echo "<br />";

/*
   echo "<form align='center'>
            <font size=5>
            fiscal_year:
            <input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>
            <br />";
            start_date:&nbsp;
            <input name='start_date' type='text' value='$start_date' readonly='readonly'>
            <br />
            end_date:&nbsp;&nbsp;&nbsp;
            <input name='end_date' type='text' value='$end_date' readonly='readonly'>
            today_date:
            <input name='today_date' type='text' value= date('Y-m-d') readonly='readonly'>
            </font>
         </form>
         <br />
      ";
*/

echo "<br />
      <table align='center'>
         <tr>
            <td>
               <form method='post' action='add_step.php'>
                  <input type='hidden' name='fiscal_year' value='$fiscal_year'>       
                  <input type='hidden' name='project_category' value=\"$project_category\">       
                  <input type='hidden' name='project_name' value='$project_name'>     
                  <input type='hidden' name='start_date' value='$start_date'>     
                  <input type='hidden' name='end_date' value='$end_date'>     
                  <input type='hidden' name='step_group' value='$step_group'>     
                  <input type='hidden' name='step' value='$step'>     
                  <input type='submit' name='submit' value='Add_Step'>
               </form>
            </td>
         </tr>
       </table>
       <br />
      ";    

$query3 = "SELECT *,
                  FROM_UNIXTIME(time_complete) AS 'time_complete2'
            FROM project_steps_detail
            WHERE project_category = '$project_category'
               AND project_name = '$project_name'
               AND step_group = '$step_group'
            ORDER BY step_num ASC
         ";

// echo "<br />query3 = $query3<br />";

//  The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3)
         OR
         DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute step_group query3:<br />$query3<br />");
$num3 = mysqli_num_rows($result3);
// mysql_close();

/*
   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
   // EXIT;
*/

echo "<table align='center'>
      <tr>
         <td><font color='red'><b>Counter: $num3</b></font>
         </td>
         <td> ";
            include("../../infotrack/scoring/score_daily_updates.php");
            include("../../infotrack/charts/bright_idea_chart.php");
      
       echo "</td>
      </tr>
      </table>


      <table border=1 align='center'>
      <tr>
         <th>StepNum</th>
         <th>StepName</th>
         <th>
            <font color=red>Action</font>
         </th>
      ";
/*
   echo " <th
            <font color=red>TimeStart</font>
         </th>
         <th>
            <font color=red>TimeEnd</font>
         </th>  
         <th>
            <font color=red>TimeElapsed</font>
         </th>
         ";
*/
echo "<th>
         <font color=red>Record</font>
      </th>";
	  /*
echo "<th>
         <font color=red>Edit</font>
      </th>
      <th>
         <font color=red>Delete Record</font>
      </th>
      <th>
         <font color=red>Duplicate Record</font>
      </th>";
*/	  
	  
      
echo "</tr>
   ";

//  The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
WHILE ($row3 = mysqli_fetch_array($result3))
{
   //  The extract function automatically creates individual variables from the array $row
   //  These individual variables are the names of the fields queried from MySQL
   
   $rank = @$rank + 1;
   
   extract($row3);
   
   //  $rank = $rank + 1;
   //  echo $status;
   $rand = array("0",
                  "1",
                  "2",
                  "3",
                  "4",
                  "5",
                  "6",
                  "7",
                  "8",
                  "9",
                  "a",
                  "b",
                  "c",
                  "d",
                  "e",
                  "f"
               );
   $color = "#" . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)] . $rand[rand(0,15)];
   /*
      IF ($c == '')
      {
         $t = " bgcolor='#B4CDCD'";
         $c = 1;
      }
      ELSE
      {
         $t = '';
         $c = '';
      }
   */

      /* 2022-04-01: CCOOPER - troubleshoot color change for status (Heidi likes it, so I'm leaving it)  */
      echo "step: $step_group$step_num | status: $status </br>";

   IF ($status == 'complete')
   {
      $t = " bgcolor='$highlight_color'";
   }
   ELSE
   {
      $t = " bgcolor='#B4CDCD'";
   }

   IF ($status == 'complete')
   {
      $fcolor1 = 'red';
   }
   ELSE
   {
      $fcolor1 = 'black';
   }   
   /*
      IF ($status == 'complete')
      {
         $bgc = 'yellow'";
      }
      ELSE
      {
         $bgc = '#B4CDCD';
      }
   */

   $array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png",
                  "/budget/infotrack/icon_photos/mission_icon_success_5.png",
                  "/budget/infotrack/icon_photos/mission_icon_success_8.png",
                  "/budget/infotrack/icon_photos/mission_icon_success_10.png"
               );
   $k = array_rand($array);
   $photo_location = $array[$k];
   $photo_location2 = "<img src='$photo_location' height='50' width='50'>";
   //  echo $status;

   echo "<tr$t>";
   /*
      echo "<td>
            $rank
         </td>
         ";
   */
   echo "<td align='center'>
            $step_num
         </td>
         <td>
            $step_name
         </td>
         <td>
            <form method='post' action='step$step_group$step_num.php'>
               <input type='hidden' name='fiscal_year' value='$fiscal_year'>
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
         <td>
            <form method='post' action='status_change.php'>
               <input type='hidden' name='status' value='$status'>
               <input type='hidden' name='fiscal_year' value='$fiscal_year'>
               <input type='hidden' name='project_category' value='$project_category'>
               <input type='hidden' name='project_name' value='$project_name'>
               <input type='hidden' name='start_date' value='$start_date'>
               <input type='hidden' name='end_date' value='$end_date'>
               <input type='hidden' name='step_group' value='$step_group'>
               <input type='hidden' name='step_num' value='$step_num'>
               <input type='hidden' name='step' value='$step'>
               <input type='hidden' name='step_name' value='$step_name'>
               <input type='submit' name='submit2' value='change_status'>
            </form>
         </td>";

/*		 
 echo "<td>
            <form method='post' action='edit_record.php'>
               <input type='hidden' name='fiscal_year' value='$fiscal_year'>
               <input type='hidden' name='project_category' value='$project_category'>
               <input type='hidden' name='project_name' value='$project_name'>
               <input type='hidden' name='start_date' value='$start_date'>
               <input type='hidden' name='end_date' value='$end_date'>
               <input type='hidden' name='step_group' value='$step_group'>
               <input type='hidden' name='step_num' value='$step_num'>
               <input type='hidden' name='step' value='$step'>
               <input type='hidden' name='step_name' value='$step_name'>
               <input type='hidden' name='cid' value='$cid'>
               <input type='submit' name='submit2' value='Edit'>
            </form>
         </td>
         <td>
            <form method='post' action='edit_record_delete_verify.php'>
               <input type='hidden' name='cid' value='$cid'>
               <input type='hidden' name='fiscal_year' value='$fiscal_year'>
               <input type='hidden' name='project_category' value='$project_category'>
               <input type='hidden' name='project_name' value='$project_name'>
               <input type='hidden' name='start_date' value='$start_date'>
               <input type='hidden' name='end_date' value='$end_date'>
               <input type='hidden' name='step_group' value='$step_group'>
               <input type='hidden' name='step' value='$step'>
               <input type='submit' name='submit' value='DeleteRecord-$cid'>
            </form>
         </td>
         <td>
            <form method='post' action='edit_record_duplicate.php'>
               <input type='hidden' name='cid' value='$cid'>
               <input type='hidden' name='fiscal_year' value='$fiscal_year'>
               <input type='hidden' name='project_category' value='$project_category'>
               <input type='hidden' name='project_name' value='$project_name'>
               <input type='hidden' name='start_date' value='$start_date'>
               <input type='hidden' name='end_date' value='$end_date'>
               <input type='hidden' name='step_group' value='$step_group'>
               <input type='hidden' name='step' value='$step'>
               <input type='hidden' name='link' value='$link'>
               <input type='hidden' name='weblink' value='$weblink'>
               <input type='hidden' name='status' value='$status'>
               <input type='submit' name='submit' value='DuplicateRecord-$cid'>
            </form>
         </td>";
*/		 
/*
   IF ($status == 'complete')
   {
      echo "<td>
               $photo_location2
            </td>
         ";
   }                    
*/   
   echo "</tr>";
}

echo "</table>

</body>

</html>";

?>
