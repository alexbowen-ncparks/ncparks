<?php
session_start();
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

include("../../../budget/~f_year.php");
$query5="SELECT distinct parkcode as 'parkcode'
FROM crj_centers
where 1 
ORDER BY parkcode";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
while ($row5=mysqli_fetch_array($result5))
	{
	$tnArray[]=$row5['parkcode'];
	}

//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";
echo "<table><form action='parks_menu1.php' method='post' target='_blank'>";
echo "<tr>";
// Menu 000
echo "<td>Player: <select name=\"player\">"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
if($player_view_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$tnArray[$n]\n";
       }
   echo "</select></td>";   
  echo "<td><input type='submit' name='submit' value='Submit'></td>";
  echo "</tr>";
  echo "<input type='hidden' name='ck_budS' value='$ck_budS'>"; 
  
  
  echo "</form>"; 
 
echo "</table>"; 

?>