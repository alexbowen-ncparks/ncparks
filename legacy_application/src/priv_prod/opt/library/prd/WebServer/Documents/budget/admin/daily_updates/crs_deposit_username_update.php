<?php

/*
   Files linked from this file:
   - /include/iConnect.inc
   - /include/activity.php
   - /Documents/budget/menu1314.php
   - /Documents/budget/admin/dialy updates/crs_deposit_username_update2.php
*/

/*
   Databases used from this file:
   - budget
   - 
*/

/*
   Tables used from this file:
   - crs_tdrr_division_deposits
*/

/*
   Arrays used in this file
   - 
*/


session_start();


/*   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
  //  exit;
*/

/*
   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   // exit;
*/

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];

// echo $tempid;

extract($_REQUEST);

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");       // connection parameters

mysqli_select_db($connection, $database);                         // database

include("../../../../include/activity.php");                      // database connection parameters
include("../../../budget/menu1314.php");

/*   echo "<pre>";
   print_r($_SESSION);
   echo "</pre>";
    exit;  */



echo "
      <style>

         table{background-color: white; font-color: blue; font-size: 15;}
         TH{font-family: Arial; font-size: 15pt;}
         TD{font-family: Arial; font-size: 15pt;}
         input{style=font-family: Arial; font-size:14.0pt}
         input:read-only{background-color: yellow;}
         .normal{background-color:#B4CDCD;}
         .highlight{background-color:#ff0000;} 
      </style>

      <script type=\"text/javascript\">
         function onRow(rowID)
         {
            var row=document.getElementById(rowID);
            var curr=row.className;
            
            IF (curr.indexOf(\"normal\")>=0)
               row.className=\"highlight\";
            ELSE
               row.className=\"normal\";
         }
      </script>
      ";

$query1 = "SELECT park,
                  center,
                  orms_deposit_id,
                  orms_depositor_lname,
                  cashier AS 'cashier2',
                  manager AS 'manager2',
                  orms_depositor_fname,
                  orms_depositor,
                  id
            FROM crs_tdrr_division_deposits
            WHERE orms_depositor = ''
               AND trans_table = 'y'
            ORDER BY park
         ";
// echo "query1 = $query1<br />";
$result1 = mysqli_query($connection, $query1)
         OR DIE ("<br />In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query1:<br />$query1<br />");
$num_lines = mysqli_num_rows($result1);

echo "<br />
      <br />
      <br />
      <table align='center'>
         <tr>
            <th>Enter CRS Deposit info below</th>
         </tr>
      </table>
      <br />
      <table border='1' align='center'>";

// $row = mysqli_fetch_array($result);

echo "<tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time

// $c = 1;

echo "<th align='left'>
         <font color='brown'>park</font>
      </th>
   "; 
/*
   echo "<th align='left'>
            <font color='brown'>center</font>
         </th>
         <th align='left'>
            <font color='brown'>ParkName</font>
         </th>";
*/
echo "<th align='left'>
         <font color='brown'>crs deposit id</font>
      </th>
      <th align='left'>
         <font color='brown'>crs depositor<br />
            last name</font>
      </th>
   "; 
/*
   echo "<th align='left'>
            <font color='brown'>crs deposit amount</font>
         </th>
         <th align='left'>
            <font color='brown'>cashier</font>
         </th>
         <th align='left'>
            <font color='brown'>manager</font>
         </th>
         <th align='left'>
            <font color='brown'>id</font>
         </th
      >"; 
*/
echo "</tr>
         <form method='post' autocomplete='off' action='crs_deposit_username_update2.php' autocomplete='off'>
      ";

while ($row1 = mysqli_fetch_array($result1))
{
   extract($row1);
   
   $amount_adj =- $amount;
   IF ($c == '')
   {
      $t = " bgcolor='$table_bg2' ";
      $c = 1;
   }
   ELSE
   {
      $t = '';
      $c = '';
   }

   $id2 = $id;

   echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">
            <td>$park</td>
         ";   
   /*
      echo "<td>
               <a href='' target='_blank'>$center</a>
            </td>
            <td>
               <input type='text' name='orms_deposit_id[]' value='$orms_deposit_id' size='10' readonly='readonly'>
            </td>
         ";
   */
   echo "<td align='center'>$orms_deposit_id</td>
         <td>
            <input type='text' name='orms_depositor_lname[]' value='$orms_depositor_lname' size='15' autocomplete='off' >
         </td>
      ";
   // IF ($orms_depositor_lname != '')
   {
      IF ($orms_depositor_lname != '')
      {
         echo "<td>first name<br />
                  <input type='text' name='orms_depositor_fname[]' value='$orms_depositor_fname' size='15'>
               </td>
            ";
      }
      
      IF ($orms_depositor_lname == '')
      {
         echo "<td><input type='text' name='orms_depositor_fname[]' value='$orms_depositor_fname' size='15' readonly='readonly'>
               </td>";
      }
         
      IF ($orms_depositor_lname != '')
      {
         echo "<td>tempid<br />
                  <input type='text' name='orms_depositor[]' value='$orms_depositor' size='15'>
               </td>
            ";
      }
      
      IF ($orms_depositor_lname == '')
      {
         echo "<td>
                  <input type='text' name='orms_depositor[]' value='$orms_depositor' size='15' readonly='readonly'>
               </td>
            ";
      }
               
      /*
         echo "<td>tempid<br />
                  <input type='text' name='orms_depositor[]' value='$orms_depositor' size='15'>
               </td>
            ";
      */
   }
   
   /*
      echo "<td> <input type='hidden' name='orms_deposit_amount2[]' value='$orms_deposit_amount2' size='25' >
            </td>
            <td>
               <input type='hidden' name='cashier2[]' value='$cashier2' size='25' >
            </td>
            <td>
               <input type='hidden' name='manager2[]' value='$manager2' size='25' >
            </td>
         ";
   */
   
   echo "<td>
            <input type='hidden' name='park[]' value='$park'></td>
         <td>
            <input type='text' name='id[]' value='$id' readonly='readonly' size='5'>
         </td>
         </tr>
      ";
}

echo "<tr>
         <td colspan='15' align='right'>
            <input type='submit' name='submit2' value='Update'>
         </td>
      </tr>
   ";

/*
   echo "<input type='hidden' name='upload_date' value='$upload_date'>
         <input type='hidden' name='fiscal_year' value='$fiscal_year'>
      ";
*/

echo "<input type='hidden' name='num_lines' value='$num_lines'>
      <input type='hidden' name='fiscal_year' value='$fiscal_year'>
      <input type='hidden' name='project_category' value='$project_category'>
      <input type='hidden' name='project_name' value='$project_name'>
      <input type='hidden' name='step_group' value='$step_group'>
      <input type='hidden' name='step' value='$step'>
      <input type='hidden' name='step_num' value='$step_num'>
      </form>
      </table>
   ";

/*
   echo "<input type='hidden' name='fiscal_year' value='$f_year'>
         <input type='hidden' name='num6' value='$num5'>
      ";
*/

?>
