<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
/*
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
*/
extract($_REQUEST);
//if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


//$query="SELECT word from music2 where 1 ";
$query="SELECT concat(comments,'<br />',photo_locate2) as 'word' from mission_icon_photos2 where slideshow_yn='y' ";


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while ($row=mysqli_fetch_assoc($result))
{
    $column[] = $row['word'];
//Edited - added semicolon at the End of line.1st and 4th(prev) line

}

//echo "<pre>"; print_r($column); echo "</pre>";  //exit;

echo $column[array_rand($column)];
//echo "<img src='$thumb[$a]' width='100'>";


echo "<html>";
?>




 


























	














