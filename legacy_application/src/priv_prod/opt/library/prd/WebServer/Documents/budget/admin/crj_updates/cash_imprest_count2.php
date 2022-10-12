<?php

session_start();

if (!$_SESSION["budget"]["tempID"])
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
$system_entry_date = date("Ymd");
$system_entry_date2 = date('m-d-y',strtotime($system_entry_date));
$system_entry_date_dow = date('l',strtotime($system_entry_date));

/**
* if($tempID=='LeFebvre0725'){echo "hello $posTitle Vicky LeFebvre. ";} else {echo "hello world";}
* echo "<br />cashier=$cashier<br />";
**/

if ($tempID == 'Robinson8024' AND $concession_location == 'STMO')
{
     $posTitle = 'park superintendent';
}

if ($tempID == 'Buchanan1806' AND $concession_location == 'LAWA')
{
     $posTitle = 'park superintendent';
}

if ($tempID == 'Cooke2603' AND $concession_location == 'CRMO')
{
     $posTitle = 'park superintendent';
}

if ($tempID == 'Turner2317' AND $concession_location == 'MEMI')
{
     $posTitle = 'park superintendent';
}

/**
* updated - jgcarter commented out on 20211214; tempID was not locatable in system
* if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
* updated - jgcarter commented out on 20211214; tempID was not locatable in system
* if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
* updated - jgcarter commented out on 20211214; tempID has park location as MEMI, and viewable parks incldue SACR
* if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
* updated - jgcarter commented out on 20211214; tempID was not locatable in system
*  if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
* updated - jgcarter commented out on 20211214; tempID and position are this if statement; must have been for an interum use
* if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
* updated - jgcarter commented out on 20211214; tempID was not locatable in system
* if($tempID=='Murvine6406' and $concession_location=='MOMO'){$posTitle='park superintendent';}

* echo "$tempID=$posTitle=$concession_location";
**/

if ($posTitle == 'park superintendent')
{
     $pasu_role = 'y';
}
else
{
     $pasu_role = 'n';
}


/**
* if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
* if ($posTitle == 'park superintendent'){$pasu_role = 'y';}
* echo "<br />Line 39: tempid=$tempid<br />";
**/

extract($_REQUEST);

/**
* echo "$report_date<br />";exit;
* echo $concession_location;
* echo "<pre>";print_r($_SERVER);"</pre>";
* exit;
**/

if ($beacnum == '60032793')
{
     /**
     * echo "<pre>";
     *         print_r($_REQUEST);
     *        "</pre>";
     *exit;
     * */
}


/**
* if($tempID=='Church9564'){echo "<pre>";print_r($_SESSION);"</pre>";
* exit;}
* echo "<pre>";print_r($_SESSION);"</pre>";
* exit;
**/

if (@$f_year == "")
{
     include("../../~f_year.php");
}

/**
* echo "f_year=$f_year";
* echo "<pre>";print_r($_REQUEST);"</pre>";
* exit;
* echo "<pre>";print_r($_SESSION);"</pre>";
* exit;
* if($mode==''){$mode='report';}
* echo "mode=$mode";
**/

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc");      // connection parameters

mysqli_select_db($connection, $database);                        // database

include("../../../../include/activity.php");                     // database connection parameters
// include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

/**
* $fyear='1516';
* echo "fyear=$fyear<br /><br />";
* if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}

* if($level=='5' and $tempID !='Dodd3454')
* {echo "beacon_number:$beacnum";
* echo "<br />";
* echo "concession_location:$concession_location";
* echo "<br />";
* echo "concession_center:$concession_center";
* echo "<br />";
* }
**/

$table = "rbh_multiyear_concession_fees3";

/**
* $query="SELECT count(id) as 'manager_count'
* from cash_handling_roles
* WHERE tempid='$tempID'
* and role='manager' ";
* echo "query=$query<br />";
* $result=mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
* $row=mysqli_fetch_array($result);
* extract($row);
* if($manager_count!=0){$posTitle='park superintendent';}
**/

$query10 = "SELECT body_bgcolor,
                    table_bgcolor,
                    table_bgcolor2
          FROM concessions_customformat
          ";
//echo "query10=$query10<br />";
$result10 = mysqli_query($connection, $query10)
          OR DIE ("In File: " . __FILE__ . "<br /> On Line: " . __LINE__ . "<br />Couldn't execute query10:<br /> $query10");
$row10 = mysqli_fetch_array($result10);
extract($row10);

$body_bg = $body_bgcolor;
$table_bg = $table_bgcolor;
$table_bg2 = $table_bgcolor2;

/**
* echo "body_bg:$body_bg";
* echo "<br />";
* echo "table_bg:$table_bg";
* echo "<br />";
* echo "table_bg2:$table_bg2";
**/

$query11 = "SELECT filegroup
          FROM concessions_filegroup
          WHERE filename = '$active_file'
          ";
$result11 = mysqli_query($connection, $query11)
          OR DIE ("In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query11:<br /> $query11");
$row11 = mysqli_fetch_array($result11);
extract($row11);

/**
* echo "<br />";
* echo $filegroup;
* echo "<html>";
* echo "<head>
* <title>Concessions</title>";
* include ("test_style.php");
* include ("test_style.php");
* echo "</head>";
**/

/*
* include("../../../budget/menus2.php");
* include("menu1314_cash_receipts.php");
* echo "<br />Line 156: tempid=$tempid<br />";
* include("../../../budget/menu1314.php");
*/
include("../../../budget/menu1415_v1.php");

// echo "<br />Line 158: tempid=$tempid<br />";
echo "<br />";

// DPR budget office Processing assistants' position numbers

$BO_beacnum_array = array('60036015',
                        '60032997',
                        '60032791',
                        '60033242',
                        '65032827'
                         );

// if ($level == 1 OR in_array($beacnum, $BO_beacnum_array)
if ($level == 1
     OR $beacnum == '60036015'
     OR $beacnum == '60032997'
     OR $beacnum == '60032791'
     OR $beacnum == '60033242'
     OR $beacnum == '65032827'
     )
{
     include("park_deposits_report_menu_v3.php");
}

/**
if ($level == 1 OR $beacnum == '60036015')
{
     include("park_deposits_report_menu_v3.php");
}
**/

/**
* include ("park_deposits_report_menu_v3.php");
* include ("park_deposits_report_menu_v2_test.php");
* include ("park_posted_deposits_widget1_v2_test.php");
* include ("park_posted_deposits_widget2_v2_test.php");
* include ("cash_imprest_count_widget1.php");
* include ("cash_imprest_count_widget2.php");
**/

if ($park != '')
{
     $parkcode = $park;
}

if ($park == '')
{
     $parkcode = $concession_location;
}

$query2 = "SELECT center_desc,
               center
          FROM center
          WHERE parkcode = '$parkcode'
          ";  

/**
* echo "query2=$query2<br />";
* exit;          
*/

$result2 = mysqli_query($connection, $query2)
          OR DIE ("In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query2:<br />  $query2");
$row2 = mysqli_fetch_array($result2);
extract($row2);

$center_location = str_replace("_", " ", $center_desc);

// echo "<br />Line 183: tempid=$tempid<br />";

echo "<br />
     <table>
          <tr>
               <th>
                    <img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'>
                    </img>
                    <font color='brown'>
                         </b>
                              Cash Imprest 
                    </font>
                         (Monthly)-
                    <font color='green'>
                         $center_location
                    </font>
                         </b>
               </th>
          </tr>
     </table>
     ";

include("../../../budget/infotrack/slide_toggle_procedures_module2_pid62.php");
include ("cash_imprest_count_fyear_module.php");

/**
* $score='10';
* echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
**/

include ("cash_imprest_count2_report.php");
// include ("cash_imprest_count2_report_test.php");

?>
