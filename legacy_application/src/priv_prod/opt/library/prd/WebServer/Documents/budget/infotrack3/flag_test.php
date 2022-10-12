<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}



$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

$query5="SELECT *
FROM flags_test
WHERE 1 
and team='somo'
";
echo "<br />query5=$query5<br />";

$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
echo "<table border=1>";

echo "<tr>"; 
//echo "<th>fid</font></th>";
//echo "<th>team</font></th>";
//echo "<th>referee</font></th>";
echo "<th>flag</font></th>";
//echo "<th>pid</font></th>";
//echo "<th>player</font></th>";
echo "<th>pinit</font></th>";
//echo "<th>pintime</font></th>";
//echo "<th>pid2</font></th>";
//echo "<th>player2</font></th>";
echo "<th>pinit</font></th>";
//echo "<th>pintime2</font></th>";


       
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);

echo "<tr>";
//echo "<th>$fid</font></th>";
//echo "<th>$team</font></th>";
//echo "<th>$referee</font></th>";
echo "<th>$flag</font></th>";
//echo "<th>$pid</font></th>";
//echo "<th>$player</font></th>";
echo "<th>$player<br /><br />$pinit</font></th>";
//echo "<th>$pintime</font></th>";
//echo "<th>$pid2</font></th>";
//echo "<th>$player2</font></th>";
echo "<th>$player2<br /><br />$pinit2</font></th>";
//echo "<th>$pintime2</font></th>";

echo "</tr>";
}
echo "</table>";


//echo "<br />";
echo "</html>";
?>