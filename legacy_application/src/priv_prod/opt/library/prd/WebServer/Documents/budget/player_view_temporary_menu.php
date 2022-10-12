<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}




$database2="divper";
////mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");
echo "Money Counts";

/*
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/

$query5="SELECT nondpr.tempID as 'player_temp'
FROM nondpr
where 1 and budget > '0'
ORDER BY nondpr.tempID";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
while ($row5=mysqli_fetch_array($result5))
	{
	$tnArray[]=$row5['player2'];
	}

//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";
echo "<table><form action='player_view_temporary.php' method='post' target='_blank'>";
echo "<tr>";
// Menu 000
echo "<td>Player(Temporary): <select name=\"player_temp\">"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
//if($player_view_menu==$con){$s="selected";}else{$s="value";}
$s="value";

		echo "<option $s='$con'>$tnArray[$n]</option>\n";
       }
   echo "</select></td>";   
  echo "<td><input type='submit' name='submit' value='Submit'></td>";
  echo "</tr>";
  echo "<input type='hidden' name='ck_budS' value='$ck_budS'>"; 
  
  
  echo "</form>"; 
 
echo "</table>"; 

?>