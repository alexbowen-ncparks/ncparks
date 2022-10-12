<?php

session_start();

if (!$_SESSION["budget"]["tempID"])
{
    echo "access denied";
    exit;
    //  header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file = $_SERVER['SCRIPT_NAME'];
$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempID = $_SESSION['budget']['tempID'];
$beacnum = $_SESSION['budget']['beacon_num'];
$concession_location = $_SESSION['budget']['select'];
$concession_center = $_SESSION['budget']['centerSess'];

$system_entry_date = date("Ymd");
$system_entry_date2 = date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow = date('l',strtotime($system_entry_date));

extract($_REQUEST);

//  echo "<pre>";
//        print_r($_SESSION);
//  echo "</pre>";
//  exit;

//  echo "<pre>";
//        print_r($_REQUEST);
//  echo "</pre>";
//  exit;

if (@$f_year == "")
{
     include("../../~f_year.php");
}

//  echo "f_year = $f_year";

$database = "budget";
$db = "budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database

include("../../../include/activity.php");// database connection parameters
//  include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$query10 = "SELECT body_bgcolor,
                    table_bgcolor,
                    table_bgcolor2
            FROM concessions_customformat
            ";

//  echo "query10 = $query10<br />";

$result10 = mysqli_query($connection, $query10)
            OR 
            DIE ("Couldn't execute query10 on Line " . __LINE__ . ":<br /> $query10");
$row10 = mysqli_fetch_array($result10);
extract($row10);

$body_bg = $body_bgcolor;
$table_bg = $table_bgcolor;
$table_bg2 = $table_bgcolor2;

$query11 = "SELECT filegroup
            FROM concessions_filegroup
            WHERE filename = '$active_file'
            ";
$result11 = mysqli_query($connection, $query11)
            OR
            DIE ("Couldn't execute query11 on Line " . __LINE__ . ":<br /> $query11");
$row11 = mysqli_fetch_array($result11);
extract($row11);

include("../../../budget/menu1415_v1.php");

echo "<br />";

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

//  echo "query2 = $query2 <br />";
//  exit;         
$result2 = mysqli_query($connection, $query2)
            OR 
            DIE ("Couldn't execute query2 on Line " . __LINE__ . ":<br />  $query2");
$row2 = mysqli_fetch_array($result2);
extract($row2);

$center_location = str_replace("_", " ", $center_desc);

echo "<br />
        <table align='center'>
            <tr>
                <th>
                    Monthly Compliance <br />
                    Deadlines
                </th>
            </tr>
        </table>
    ";

//  include("concessions_pci_instructions.php");
//  include("concessions_pci_instructions.php");
//  echo "<br />";

include ("monthly_compliance_fyear.php");

include ("monthly_compliance_fyear_months.php");

//  echo "<br />Line " __LINE__;
//  echo ": <br /> compliance_fyear = $compliance_fyear <br />";
//  echo "<br />Line " __LINE__ ;
//  echo ": <br /> compliance_month = $compliance_month <br />";

if ($compliance_fyear != '' AND $compliance_month != '')
{
    include("monthly_compliance_update.php");
}

?>