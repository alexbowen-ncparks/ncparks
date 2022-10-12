<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "hello";exit;


echo "<html>";
echo "<head>";
echo "<title>Help-Fee Period</title>";

echo "</head>";
echo "<body>";
echo "
      <p><font color='brown' size='5'><b><i>Fee Period</i></b></font> <font color='black'>represents </font><font color='red'> Months Collected.</font> <br /><br />
<font color='red'>3 examples:</font><ul> 
<li>Park collects monies from Concessionaire for 1 Month due under Contract (June 2017)
    Park enters Fee Period as: <font color='blue'>jun2017</font></li>
<li>Park collects monies from Concessionaire for 3 Months due under Contract (April 2017 thru June 2017)
    Park enters Fee Period as:<font color='blue'>apr2017-jun2017</font></li>
<li>Park collects monies from Concessionaire for 12 Months due under Contract (July 2016 thru June 2017)
    Park enters Fee Period as:<font color='blue'>jul2016-jun2017</font></li>
</ul>

</p>";




?>

























