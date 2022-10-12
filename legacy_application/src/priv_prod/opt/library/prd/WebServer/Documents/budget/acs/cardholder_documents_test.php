<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
$menu='VDocu';

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");




echo "<html>";
echo "<head>";


echo "</head>";
$menu='VCard';
include ("../../budget/menu1415_v1.php");
//include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>Cardholder Documents</font></i></H1>";

//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";


include("pcard_new_menu1.php");
echo "<br />";




$header_var_admin="$admin";


if($submit==""){exit;}
//if($submit=="reset"){exit;}

if($admin != ""){$where1=" and admin = '$admin' ";}

if($level>2)
{
$query3g="select 
admin,last_name,first_name,position_number,employee_number,job_title,affirmation_abundance,photo_location,location,act_id,card_number,comments,justification,document_location,document_location_final,id
from pcard_users 
where 1 and act_id='y' $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}		  
$result3g = mysqli_query($connection, $query3g) or die ("Couldn't execute query 3g.  $query3g");		  
		  
$record_count=mysqli_num_rows($result3g);
/*
echo "<svg width=\"200\" height=\"50\" xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\">
<rect x=\"0\" y=\"0\" width=\"600\" height=\"200\" fill=\"green\"/>
 <text x=\"80\" y=\"160\" fill=\"white\" font-size=\"250\">$job_title</text></svg>";
*/

echo "<table border=1 align='center'>";
 
echo "<tr>"; 

  
  echo " <th><font color=blue>Admin</font></th>"; 
 echo " <th><font color=blue>Last Name</font></th>"; 
 echo " <th><font color=blue>First Name</font></th>";
 echo " <th><font color=blue>Employee#</font></th>";
 echo " <th><font color=blue>Position#</font></th>";
 echo " <th><font color=blue>Job Title</font></th>";
 echo " <th><font color=blue>CardType</font></th>";
 echo " <th><font color=blue>Active</font></th>";
 echo " <th><font color=blue>Card Number</font></th>";
 //echo " <th><font color=blue>Comments</font></th>";
 echo " <th><font color=blue>Justification</font></th>";
   echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";


while ($row3g=mysqli_fetch_array($result3g)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3g);

$job_title="<svg width=\"350\" height=\"50\" xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\">
<rect x=\"0\" y=\"0\" width=\"350\" height=\"50\" fill=\"green\"/>
 <text x=\"20\" y=\"40\" fill=\"white\" font-size=\"25\">$job_title</text></svg>";



if($location=='1656'){$location="reg";}
if($location=='1669'){$location="ci";}


 echo "<tr bgcolor='$bgc'>";  
echo  "<td align='center'>$admin";
/*
if($position_number != '')
{
echo "<br /><img height='75' width='75' src='$photo_location' alt='picture of green check mark'></img>";
}
*/
echo "</td>";
echo  "<td align='center'>$last_name</td>";
echo  "<td align='center'>$first_name</td>";
echo  "<td align='center'>$employee_number</td>";
echo  "<td align='center'>$position_number</td>";
echo  "<td align='center'>$job_title</td>";
echo  "<td align='center'>$location</td>";
echo  "<td align='center'>$act_id</td>";
echo  "<td align='center'>$card_number</td>";
//echo  "<td>$comments</td>";
echo  "<td align='center'>$justification</td>";


echo "</tr>";
//$document='';
}
echo "</table>";

echo "</html>";
?>

























