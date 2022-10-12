<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";  exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "$report_date<br />";exit;



//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
include ("../../budget/menu1415_v1.php");

$query1="SELECT parkcode,account_number,count(id) as 'record_count' FROM `energy1` WHERE ncas_account='532210' AND `valid_account` LIKE 'n' AND `f_year`='$f_year' group by parkcode,account_number";
echo "<br />query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);
echo "<table>";
echo "<tr>";
echo "<td>Total Accounts: $num1</td>";
echo "<td>Total Records: $num3</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
echo "<table border=1>";

echo 

"<tr>"; 
       
  echo "<th align=left><font color=brown>parkcode</font></th>
       <th align=left><font color=brown>account_number</font></th>
	   <th align=left><font color=brown>record_count</font></th>   ";
      
       	   
	   
	   
	   
       
  
       
              
echo "</tr>";


while ($row1=mysqli_fetch_array($result1)){


extract($row1);






if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

      
          

 
  echo "   <td><a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=cdcs&valid_account=n&center_code=$parkcode'>$parkcode</a></td>
           <td>$account_number</td>		   
           <td>$record_count</td>";		   
           
              
           
echo "</tr>";




}


 echo "</table>";
 
 echo "</body></html>";



?>
